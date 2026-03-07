<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'reservation_id',
        'listing_id',
        'gross_amount',
        'commission_rate',
        'commission_amount',
        'cleaning_fee',
        'taxes',
        'net_amount',
        'currency',
        'status',
        'scheduled_date',
        'paid_date',
        'reference',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'commission_amount' => 'decimal:2',
            'cleaning_fee' => 'decimal:2',
            'taxes' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'scheduled_date' => 'date',
            'paid_date' => 'date',
        ];
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}
