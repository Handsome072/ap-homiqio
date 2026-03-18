<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'listing_id',
        'check_in',
        'check_out',
        'guests_count',
        'adults',
        'children',
        'infants',
        'pets',
        'nights_count',
        'price_per_night',
        'cleaning_fee',
        'service_fee',
        'status',
        'total_price',
        'currency',
        'guest_message',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'adults' => 'integer',
            'children' => 'integer',
            'infants' => 'integer',
            'pets' => 'integer',
            'nights_count' => 'integer',
            'price_per_night' => 'decimal:2',
            'cleaning_fee' => 'decimal:2',
            'service_fee' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class);
    }
}
