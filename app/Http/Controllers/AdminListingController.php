<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AdminListingController extends Controller
{
    /**
     * GET /api/admin/listings
     * Returns all listings with optional filters (for admin panel).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Listing::with(['photos', 'user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by title or ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by host (user_id)
        if ($request->filled('host_id')) {
            $query->where('user_id', $request->host_id);
        }

        $listings = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'listings' => $listings->map(fn ($listing) => $this->formatAdminListing($listing)),
        ]);
    }

    /**
     * GET /api/admin/listings/{id}
     * Returns a single listing with full details (for admin).
     */
    public function show(int $id): JsonResponse
    {
        $listing = Listing::with(['photos', 'user'])->findOrFail($id);

        return response()->json([
            'listing' => $this->formatAdminListing($listing),
        ]);
    }

    /**
     * POST /api/admin/listings/{id}/approve
     * Approve a pending listing (sets status to 'active').
     */
    public function approve(int $id): JsonResponse
    {
        $listing = Listing::findOrFail($id);

        if ($listing->status !== 'pending') {
            return response()->json([
                'message' => 'Seules les annonces en attente peuvent être approuvées.',
            ], 422);
        }

        $listing->update(['status' => 'active']);

        return response()->json([
            'message' => 'Annonce approuvée avec succès.',
            'listing' => $this->formatAdminListing($listing->load(['photos', 'user'])),
        ]);
    }

    /**
     * POST /api/admin/listings/{id}/reject
     * Reject a pending listing (sets status to 'rejected').
     */
    public function reject(Request $request, int $id): JsonResponse
    {
        $listing = Listing::findOrFail($id);

        if ($listing->status !== 'pending') {
            return response()->json([
                'message' => 'Seules les annonces en attente peuvent être refusées.',
            ], 422);
        }

        $listing->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        return response()->json([
            'message' => 'Annonce refusée.',
            'listing' => $this->formatAdminListing($listing->load(['photos', 'user'])),
        ]);
    }

    /**
     * POST /api/admin/listings/{id}/suspend
     * Suspend an active listing.
     */
    public function suspend(Request $request, int $id): JsonResponse
    {
        $listing = Listing::findOrFail($id);

        if ($listing->status !== 'active') {
            return response()->json([
                'message' => 'Seules les annonces actives peuvent être suspendues.',
            ], 422);
        }

        $listing->update([
            'status' => 'archived',
            'rejection_reason' => $request->reason,
        ]);

        return response()->json([
            'message' => 'Annonce suspendue.',
            'listing' => $this->formatAdminListing($listing->load(['photos', 'user'])),
        ]);
    }

    /**
     * DELETE /api/admin/listings/{id}
     * Delete a listing (admin).
     */
    public function destroy(int $id): JsonResponse
    {
        $listing = Listing::with('photos')->findOrFail($id);

        foreach ($listing->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        if ($listing->host_photo_path) {
            Storage::disk('public')->delete($listing->host_photo_path);
        }

        $listing->delete();

        return response()->json(['message' => 'Annonce supprimée avec succès.']);
    }

    /**
     * Format a listing for admin API response (includes host info).
     */
    private function formatAdminListing(Listing $listing): array
    {
        $user = $listing->user;

        return [
            'id'                  => $listing->id,
            'status'              => $listing->status,
            'title'               => $listing->title,
            'subtitle'            => $listing->subtitle,
            'city'                => $listing->city,
            'province'            => $listing->province,
            'country'             => $listing->country,
            'space_type'          => $listing->space_type,
            'capacity'            => $listing->capacity,
            'bathrooms'           => $listing->bathrooms,
            'base_price'          => $listing->base_price,
            'currency'            => $listing->currency,
            'cancellation_policy' => $listing->cancellation_policy,
            'reservation_mode'    => $listing->reservation_mode,
            'host_photo_url'      => $listing->host_photo_path
                ? Storage::disk('public')->url($listing->host_photo_path)
                : null,
            'photos'              => $listing->photos->map(fn ($p) => [
                'id'    => $p->id,
                'url'   => Storage::disk('public')->url($p->path),
                'order' => $p->order,
            ])->values(),
            'created_at'          => $listing->created_at,
            'updated_at'          => $listing->updated_at,
            'host' => $user ? [
                'id'         => $user->id,
                'name'       => $user->name,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
            ] : null,
            // Detail fields
            'rental_frequency'    => $listing->rental_frequency,
            'full_address'        => $listing->full_address,
            'street'              => $listing->street,
            'postal_code'         => $listing->postal_code,
            'mrc'                 => $listing->mrc,
            'county'              => $listing->county,
            'adults'              => $listing->adults,
            'bedrooms_data'       => $listing->bedrooms_data,
            'open_areas_data'     => $listing->open_areas_data,
            'amenities'           => $listing->amenities,
            'expectations'        => $listing->expectations,
            'permissions'         => $listing->permissions,
            'description'         => $listing->description,
            'about_chalet'        => $listing->about_chalet,
            'host_availability'   => $listing->host_availability,
            'neighborhood'        => $listing->neighborhood,
            'transport'           => $listing->transport,
            'other_info'          => $listing->other_info,
            'arrival_time'        => $listing->arrival_time,
            'departure_time'      => $listing->departure_time,
            'min_age'             => $listing->min_age,
            'min_stay'            => $listing->min_stay,
            'max_stay'            => $listing->max_stay,
            'arrival_days'        => $listing->arrival_days,
            'departure_days'      => $listing->departure_days,
            'weekend_price'       => $listing->weekend_price,
            'weekly_price'        => $listing->weekly_price,
            'monthly_price'       => $listing->monthly_price,
            'cleaning_fee'        => $listing->cleaning_fee,
            'security_deposit'    => $listing->security_deposit,
            'extra_guest_fee'     => $listing->extra_guest_fee,
            'pet_fee'             => $listing->pet_fee,
            'tax_registration'    => $listing->tax_registration,
            'accepted_local_laws' => $listing->accepted_local_laws,
            'wifi_speed'          => $listing->wifi_speed,
            'has_wifi'            => $listing->has_wifi,
            'checkin_method'      => $listing->checkin_method,
            'checkin_instructions' => $listing->checkin_instructions,
            'phone_number'        => $listing->phone_number,
            'country_code'        => $listing->country_code,
            'rejection_reason'    => $listing->rejection_reason ?? null,
        ];
    }
}
