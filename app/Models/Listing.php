<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'rejection_reason',
        'rental_frequency',
        'space_type',
        'full_address',
        'street',
        'city',
        'postal_code',
        'mrc',
        'county',
        'province',
        'country',
        'capacity',
        'adults',
        'bathrooms',
        'bedrooms_data',
        'open_areas_data',
        'amenities',
        'expectations',
        'permissions',
        'title',
        'subtitle',
        'description',
        'about_chalet',
        'host_availability',
        'neighborhood',
        'transport',
        'other_info',
        'reservation_mode',
        'arrival_time',
        'departure_time',
        'min_age',
        'min_stay',
        'max_stay',
        'arrival_days',
        'departure_days',
        'currency',
        'base_price',
        'weekend_price',
        'weekly_price',
        'monthly_price',
        'cleaning_fee',
        'security_deposit',
        'extra_guest_fee',
        'pet_fee',
        'cancellation_policy',
        'tax_registration',
        'taxes_included',
        'accepted_local_laws',
        'wifi_speed',
        'has_wifi',
        'checkin_method',
        'checkin_instructions',
        'phone_number',
        'country_code',
        'signature_name',
        'signed_at',
        'host_photo_path',
    ];

    protected function casts(): array
    {
        return [
            'bedrooms_data'   => 'array',
            'open_areas_data' => 'array',
            'amenities'       => 'array',
            'expectations'    => 'array',
            'permissions'     => 'array',
            'arrival_days'    => 'array',
            'departure_days'  => 'array',
            'tax_registration' => 'array',
            'taxes_included'  => 'boolean',
            'accepted_local_laws' => 'boolean',
            'has_wifi'        => 'boolean',
            'signed_at'       => 'datetime',
            'base_price'      => 'decimal:2',
            'weekend_price'   => 'decimal:2',
            'weekly_price'    => 'decimal:2',
            'monthly_price'   => 'decimal:2',
            'cleaning_fee'    => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'extra_guest_fee' => 'decimal:2',
            'pet_fee'         => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ListingPhoto::class)->orderBy('order');
    }
}
