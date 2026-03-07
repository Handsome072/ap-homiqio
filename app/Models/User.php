<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'birth_date',
        'receive_marketing',
        'email_verification_token',
        'phone',
        'phone_country_code',
        'address_street',
        'address_city',
        'address_postal_code',
        'address_country',
        'bio',
        'city',
        'profession',
        'languages_spoken',
        'interests',
        'profile_photo_url',
        'preferred_language',
        'preferred_currency',
        'timezone',
        'notification_preferences',
        'phone_verified',
        'identity_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'receive_marketing' => 'boolean',
            'languages_spoken' => 'array',
            'interests' => 'array',
            'notification_preferences' => 'array',
            'phone_verified' => 'boolean',
            'identity_verified' => 'boolean',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function reservationsAsGuest(): HasMany
    {
        return $this->hasMany(Reservation::class, 'guest_id');
    }

    public function conversationsAsHost(): HasMany
    {
        return $this->hasMany(Conversation::class, 'host_id');
    }

    public function conversationsAsGuest(): HasMany
    {
        return $this->hasMany(Conversation::class, 'guest_id');
    }
}
