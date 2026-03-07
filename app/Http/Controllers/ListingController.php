<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * GET /api/listings/public
     * Returns all active listings (no auth required).
     */
    public function publicIndex(): JsonResponse
    {
        $listings = Listing::with('photos')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'listings' => $listings->map(fn ($listing) => $this->formatListing($listing)),
        ]);
    }

    /**
     * GET /api/listings/public/{id}
     * Returns a single active listing with host info and reviews (no auth required).
     */
    public function publicShow(int $id): JsonResponse
    {
        $listing = Listing::with(['photos', 'user', 'reviews.user'])
            ->where('status', 'active')
            ->findOrFail($id);

        return response()->json([
            'listing' => $this->formatListingDetail($listing),
        ]);
    }

    /**
     * GET /api/listings
     * Returns all listings for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $listings = $request->user()
            ->listings()
            ->with('photos')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'listings' => $listings->map(fn ($listing) => $this->formatListing($listing)),
        ]);
    }

    /**
     * POST /api/listings
     * Creates a new listing with all form data + base64 photos.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'capacity'   => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
        ]);

        $user = $request->user();

        $listing = Listing::create([
            'user_id'          => $user->id,
            'status'           => 'pending',
            'rental_frequency' => $request->rental_frequency,
            'space_type'       => $request->space_type,
            'full_address'     => $request->full_address,
            'street'           => $request->street,
            'city'             => $request->city,
            'postal_code'      => $request->postal_code,
            'mrc'              => $request->mrc,
            'county'           => $request->county,
            'province'         => $request->province ?? 'QC',
            'country'          => $request->country ?? 'CA',
            'capacity'         => $request->capacity,
            'adults'           => $request->adults,
            'bathrooms'        => $request->bathrooms ?? 1,
            'bedrooms_data'    => $request->bedrooms_data,
            'open_areas_data'  => $request->open_areas_data,
            'amenities'        => $request->amenities,
            'expectations'     => $request->expectations,
            'permissions'      => $request->permissions,
            'title'            => $request->title,
            'subtitle'         => $request->subtitle,
            'description'      => $request->description,
            'about_chalet'     => $request->about_chalet,
            'host_availability'=> $request->host_availability,
            'neighborhood'     => $request->neighborhood,
            'transport'        => $request->transport,
            'other_info'       => $request->other_info,
            'reservation_mode' => $request->reservation_mode ?? 'request',
            'arrival_time'     => $request->arrival_time,
            'departure_time'   => $request->departure_time,
            'min_age'          => $request->min_age ?? 18,
            'min_stay'         => $request->min_stay,
            'max_stay'         => $request->max_stay,
            'arrival_days'     => $request->arrival_days,
            'departure_days'   => $request->departure_days,
            'currency'         => $request->currency ?? 'CAD',
            'base_price'       => $request->base_price,
            'weekend_price'    => $request->weekend_price ?: null,
            'weekly_price'     => $request->weekly_price ?: null,
            'monthly_price'    => $request->monthly_price ?: null,
            'cleaning_fee'     => $request->cleaning_fee ?? 0,
            'security_deposit' => $request->security_deposit ?? 0,
            'extra_guest_fee'  => $request->extra_guest_fee ?: null,
            'pet_fee'          => $request->pet_fee ?: null,
            'cancellation_policy' => $request->cancellation_policy,
            'tax_registration' => $request->tax_registration,
            'taxes_included'   => $request->taxes_included,
            'accepted_local_laws' => $request->accepted_local_laws ?? false,
            'wifi_speed'       => $request->wifi_speed,
            'has_wifi'         => $request->has_wifi,
            'checkin_method'   => $request->checkin_method,
            'checkin_instructions' => $request->checkin_instructions,
            'phone_number'     => $request->phone_number,
            'country_code'     => $request->country_code,
            'signature_name'   => $request->signature_name,
            'signed_at'        => $request->signed ? now() : null,
        ]);

        // Save host photo (base64)
        if ($request->host_photo) {
            $hostPhotoPath = $this->saveBase64Image(
                $request->host_photo,
                "listings/{$listing->id}/host"
            );
            $listing->update(['host_photo_path' => $hostPhotoPath]);
        }

        // Save chalet photos (array of base64)
        if ($request->chalet_photos && is_array($request->chalet_photos)) {
            foreach ($request->chalet_photos as $index => $base64Photo) {
                $photoPath = $this->saveBase64Image(
                    $base64Photo,
                    "listings/{$listing->id}"
                );
                ListingPhoto::create([
                    'listing_id' => $listing->id,
                    'path'       => $photoPath,
                    'order'      => $index,
                ]);
            }
        }

        $listing->load('photos');

        return response()->json([
            'message' => 'Annonce créée avec succès. Elle sera examinée par notre équipe.',
            'listing' => $this->formatListing($listing),
        ], 201);
    }

    /**
     * GET /api/listings/{id}
     * Returns a single listing (must belong to authenticated user).
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $listing = $request->user()->listings()->with('photos')->findOrFail($id);

        return response()->json([
            'listing' => $this->formatListing($listing),
        ]);
    }

    /**
     * PUT /api/listings/{id}
     * Updates an existing listing.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $listing = $request->user()->listings()->findOrFail($id);

        $listing->update($request->except(['host_photo', 'chalet_photos', '_method']));

        // Update host photo if provided
        if ($request->host_photo && str_starts_with($request->host_photo, 'data:')) {
            if ($listing->host_photo_path) {
                Storage::disk('public')->delete($listing->host_photo_path);
            }
            $hostPhotoPath = $this->saveBase64Image(
                $request->host_photo,
                "listings/{$listing->id}/host"
            );
            $listing->update(['host_photo_path' => $hostPhotoPath]);
        }

        $listing->load('photos');

        return response()->json([
            'message' => 'Annonce mise à jour avec succès.',
            'listing' => $this->formatListing($listing),
        ]);
    }

    /**
     * DELETE /api/listings/{id}
     * Deletes a listing and all its photos from storage.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $listing = $request->user()->listings()->with('photos')->findOrFail($id);

        // Delete all chalet photos from storage
        foreach ($listing->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        // Delete host photo from storage
        if ($listing->host_photo_path) {
            Storage::disk('public')->delete($listing->host_photo_path);
        }

        $listing->delete();

        return response()->json(['message' => 'Annonce supprimée avec succès.']);
    }

    /**
     * Decode a base64 image and save to public storage.
     * Returns the storage path.
     */
    private function saveBase64Image(string $base64Data, string $directory): string
    {
        // Strip the data:image/xxx;base64, prefix
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
        $decoded   = base64_decode($imageData);

        // Detect MIME type and set extension
        $finfo    = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($decoded);
        $ext      = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            default      => 'jpg',
        };

        $fileName = uniqid('img_', true) . '.' . $ext;
        $path     = "{$directory}/{$fileName}";

        Storage::disk('public')->put($path, $decoded);

        return $path;
    }

    /**
     * Format a listing for API response.
     */
    private function formatListing(Listing $listing): array
    {
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
                ? (str_starts_with($listing->host_photo_path, 'http') ? $listing->host_photo_path : Storage::disk('public')->url($listing->host_photo_path))
                : null,
            'photos'              => $listing->photos->map(fn ($p) => [
                'id'    => $p->id,
                'url'   => str_starts_with($p->path, 'http') ? $p->path : Storage::disk('public')->url($p->path),
                'order' => $p->order,
            ])->values(),
            'created_at'          => $listing->created_at,
            'updated_at'          => $listing->updated_at,

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
            'latitude'            => $listing->latitude,
            'longitude'           => $listing->longitude,
        ];
    }

    /**
     * Format a listing with host info and reviews for the detail page.
     */
    private function formatListingDetail(Listing $listing): array
    {
        $base = $this->formatListing($listing);

        // Host info
        $host = $listing->user;
        $hostListingIds = Listing::where('user_id', $host->id)->pluck('id');
        $hostReviewsCount = Review::whereIn('listing_id', $hostListingIds)->count();
        $hostAvgRating = Review::whereIn('listing_id', $hostListingIds)->avg('rating');

        $base['host'] = [
            'id'                => $host->id,
            'first_name'        => $host->first_name,
            'profile_photo_url' => $host->profile_photo_url
                ?? ($listing->host_photo_path
                    ? Storage::disk('public')->url($listing->host_photo_path)
                    : null),
            'profession'        => $host->profession,
            'interests'         => $host->interests,
            'languages_spoken'  => $host->languages_spoken,
            'identity_verified' => $host->identity_verified ?? false,
            'phone_verified'    => $host->phone_verified ?? false,
            'member_since'      => $host->created_at->toISOString(),
            'reviews_count'     => $hostReviewsCount,
            'average_rating'    => $hostAvgRating ? round($hostAvgRating, 2) : null,
            'response_rate'     => 92,
            'response_time'     => "dans l'heure",
        ];

        // Reviews summary
        $reviews = $listing->reviews;
        $reviewsCount = $reviews->count();
        $avgRating = $reviewsCount > 0 ? round($reviews->avg('rating'), 2) : null;

        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $reviews->filter(fn ($r) => round($r->rating) == $i)->count();
        }

        $base['reviews_summary'] = [
            'count'               => $reviewsCount,
            'average_rating'      => $avgRating,
            'cleanliness_avg'     => $reviewsCount > 0 ? round($reviews->avg('cleanliness_rating'), 1) : null,
            'accuracy_avg'        => $reviewsCount > 0 ? round($reviews->avg('accuracy_rating'), 1) : null,
            'checkin_avg'         => $reviewsCount > 0 ? round($reviews->avg('checkin_rating'), 1) : null,
            'communication_avg'   => $reviewsCount > 0 ? round($reviews->avg('communication_rating'), 1) : null,
            'location_avg'        => $reviewsCount > 0 ? round($reviews->avg('location_rating'), 1) : null,
            'value_avg'           => $reviewsCount > 0 ? round($reviews->avg('value_rating'), 1) : null,
            'rating_distribution' => $ratingDistribution,
            'is_guest_favorite'   => $avgRating !== null && $avgRating >= 4.9,
        ];

        // Latest reviews
        $latestReviews = $reviews->sortByDesc('created_at')->take(6)->values();
        $base['reviews'] = $latestReviews->map(fn ($review) => [
            'id'         => $review->id,
            'rating'     => $review->rating,
            'text'       => $review->text,
            'created_at' => $review->created_at->toISOString(),
            'user'       => [
                'first_name'        => $review->user->first_name,
                'profile_photo_url' => $review->user->profile_photo_url,
                'member_since'      => $review->user->created_at->toISOString(),
            ],
        ])->toArray();

        return $base;
    }
}
