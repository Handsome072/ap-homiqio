<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'listing_id',
        'user_id',
        'rating',
        'text',
        'cleanliness_rating',
        'accuracy_rating',
        'checkin_rating',
        'communication_rating',
        'location_rating',
        'value_rating',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'cleanliness_rating' => 'decimal:1',
        'accuracy_rating' => 'decimal:1',
        'checkin_rating' => 'decimal:1',
        'communication_rating' => 'decimal:1',
        'location_rating' => 'decimal:1',
        'value_rating' => 'decimal:1',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
