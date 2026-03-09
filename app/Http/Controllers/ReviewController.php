<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * POST /api/listings/{id}/reviews
     * Store a new review for a listing.
     */
    public function store(Request $request, int $id): JsonResponse
    {
        $listing = Listing::where('status', 'active')->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'text'   => 'required|string|max:500',
        ]);

        $review = Review::create([
            'listing_id'           => $listing->id,
            'user_id'              => $request->user()->id,
            'rating'               => $validated['rating'],
            'text'                 => $validated['text'],
            'cleanliness_rating'   => $validated['rating'],
            'accuracy_rating'      => $validated['rating'],
            'checkin_rating'       => $validated['rating'],
            'communication_rating' => $validated['rating'],
            'location_rating'      => $validated['rating'],
            'value_rating'         => $validated['rating'],
        ]);

        $review->load('user');

        return response()->json([
            'review' => [
                'id'         => $review->id,
                'rating'     => $review->rating,
                'text'       => $review->text,
                'created_at' => $review->created_at->toISOString(),
                'user'       => [
                    'first_name'        => $review->user->first_name,
                    'profile_photo_url' => $review->user->profile_photo_full_url,
                    'member_since'      => $review->user->created_at->toISOString(),
                ],
            ],
        ], 201);
    }
}
