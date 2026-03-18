<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Create a new reservation.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'listing_id'    => 'required|exists:listings,id',
            'check_in'      => 'required|date|after_or_equal:today',
            'check_out'     => 'required|date|after:check_in',
            'adults'        => 'integer|min:1',
            'children'      => 'integer|min:0',
            'infants'       => 'integer|min:0',
            'pets'          => 'integer|min:0',
            'guest_message' => 'nullable|string|max:1000',
        ]);

        $adults   = $validated['adults'] ?? 1;
        $children = $validated['children'] ?? 0;
        $infants  = $validated['infants'] ?? 0;
        $pets     = $validated['pets'] ?? 0;

        $listing = Listing::findOrFail($validated['listing_id']);
        $price   = $this->computePrice($listing, $validated['check_in'], $validated['check_out'], $adults, $children, $pets);

        $reservation = Reservation::create([
            'guest_id'        => $request->user()->id,
            'listing_id'      => $listing->id,
            'check_in'        => $validated['check_in'],
            'check_out'       => $validated['check_out'],
            'adults'          => $adults,
            'children'        => $children,
            'infants'         => $infants,
            'pets'            => $pets,
            'guests_count'    => $adults + $children,
            'nights_count'    => $price['nights'],
            'price_per_night' => $price['price_per_night'],
            'cleaning_fee'    => $price['cleaning_fee'],
            'service_fee'     => $price['service_fee'],
            'total_price'     => $price['total'],
            'currency'        => $listing->currency,
            'status'          => 'pending',
            'guest_message'   => $validated['guest_message'] ?? null,
        ]);

        $reservation->load('listing');

        return response()->json([
            'message'     => 'Réservation créée avec succès.',
            'reservation' => $reservation,
        ], 201);
    }

    /**
     * Calculate price breakdown without creating a reservation.
     */
    public function calculatePrice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'check_in'   => 'required|date|after_or_equal:today',
            'check_out'  => 'required|date|after:check_in',
            'adults'     => 'integer|min:1',
            'children'   => 'integer|min:0',
            'pets'       => 'integer|min:0',
        ]);

        $adults   = $validated['adults'] ?? 1;
        $children = $validated['children'] ?? 0;
        $pets     = $validated['pets'] ?? 0;

        $listing = Listing::findOrFail($validated['listing_id']);
        $price   = $this->computePrice($listing, $validated['check_in'], $validated['check_out'], $adults, $children, $pets);

        return response()->json([
            'currency'        => $listing->currency,
            'nights'          => $price['nights'],
            'price_per_night' => $price['price_per_night'],
            'base_total'      => $price['base_total'],
            'cleaning_fee'    => $price['cleaning_fee'],
            'extra_guest_fee' => $price['extra_guest_fee'],
            'pet_fee'         => $price['pet_fee'],
            'service_fee'     => $price['service_fee'],
            'total'           => $price['total'],
        ]);
    }

    /**
     * Check if the requested dates are available for a listing.
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'check_in'   => 'required|date',
            'check_out'  => 'required|date|after:check_in',
        ]);

        $checkIn  = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);

        $conflicting = Reservation::where('listing_id', $validated['listing_id'])
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->get(['check_in', 'check_out']);

        $conflictingDates = [];
        foreach ($conflicting as $reservation) {
            $start = Carbon::parse($reservation->check_in);
            $end   = Carbon::parse($reservation->check_out);

            // Collect each conflicting date within the requested range
            $cursor = max($start, $checkIn)->copy();
            $limit  = min($end, $checkOut);
            while ($cursor->lt($limit)) {
                $conflictingDates[] = $cursor->toDateString();
                $cursor->addDay();
            }
        }

        $conflictingDates = array_values(array_unique($conflictingDates));
        sort($conflictingDates);

        return response()->json([
            'available'        => empty($conflictingDates),
            'conflicting_dates' => $conflictingDates,
        ]);
    }

    /**
     * List reservations for the authenticated guest.
     */
    public function guestReservations(Request $request): JsonResponse
    {
        $reservations = Reservation::where('guest_id', $request->user()->id)
            ->with('listing')
            ->orderByDesc('check_in')
            ->get();

        return response()->json(['reservations' => $reservations]);
    }

    /**
     * Show a single reservation detail.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        $reservation = Reservation::with('listing')->findOrFail($id);

        if ($user->id !== $reservation->guest_id && $user->id !== $reservation->listing->user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return response()->json(['reservation' => $reservation]);
    }

    /**
     * Compute the price breakdown for a reservation.
     */
    private function computePrice(Listing $listing, string $checkIn, string $checkOut, int $adults, int $children, int $pets): array
    {
        $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));

        $pricePerNight  = (float) $listing->base_price;
        $baseTotal      = $nights * $pricePerNight;
        $cleaningFee    = (float) ($listing->cleaning_fee ?? 0);
        $extraGuestFee  = max(0, ($adults + $children) - (int) $listing->capacity) * (float) ($listing->extra_guest_fee ?? 0) * $nights;
        $petFee         = $pets > 0 ? (float) ($listing->pet_fee ?? 0) * $nights : 0;
        $serviceFee     = round($baseTotal * 0.12, 2);
        $total          = round($baseTotal + $cleaningFee + $extraGuestFee + $petFee + $serviceFee, 2);

        return [
            'nights'          => $nights,
            'price_per_night' => $pricePerNight,
            'base_total'      => $baseTotal,
            'cleaning_fee'    => $cleaningFee,
            'extra_guest_fee' => $extraGuestFee,
            'pet_fee'         => $petFee,
            'service_fee'     => $serviceFee,
            'total'           => $total,
        ];
    }
}
