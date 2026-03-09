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
        'host_status',
        'bank_verified',
        'address_verified',
        'verification_date',
        'fraud_score',
        'last_login_at',
        'last_login_ip',
        'last_login_device',
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
            'bank_verified' => 'boolean',
            'address_verified' => 'boolean',
            'verification_date' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Get the full URL for the profile photo.
     */
    public function getProfilePhotoFullUrlAttribute(): ?string
    {
        if (!$this->profile_photo_url) {
            return null;
        }

        if (str_starts_with($this->profile_photo_url, 'http')) {
            return $this->profile_photo_url;
        }

        return url($this->profile_photo_url);
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

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function adminNotes(): HasMany
    {
        return $this->hasMany(AdminNote::class);
    }

    public function hostDocuments(): HasMany
    {
        return $this->hasMany(HostDocument::class);
    }
}
