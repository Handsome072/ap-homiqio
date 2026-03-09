<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    /**
     * Get full user profile (settings + profile data).
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'user' => $this->formatUser($user),
        ]);
    }

    /**
     * Update personal information (name, email, phone, address).
     */
    public function updatePersonalInfo(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'phone_country_code' => ['nullable', 'string', 'max:5'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'address_street' => ['nullable', 'string', 'max:255'],
            'address_city' => ['nullable', 'string', 'max:255'],
            'address_postal_code' => ['nullable', 'string', 'max:20'],
            'address_country' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $user->update($validated);

        return response()->json([
            'message' => 'Informations mises à jour.',
            'user' => $this->formatUser($user->fresh()),
        ]);
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'message' => 'Le mot de passe actuel est incorrect.',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Mot de passe mis à jour.',
        ]);
    }

    /**
     * Update notification preferences.
     */
    public function updateNotifications(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'notification_preferences' => ['required', 'array'],
            'notification_preferences.reservations_email' => ['boolean'],
            'notification_preferences.reservations_sms' => ['boolean'],
            'notification_preferences.messages_email' => ['boolean'],
            'notification_preferences.messages_sms' => ['boolean'],
            'notification_preferences.reminders_email' => ['boolean'],
            'notification_preferences.reminders_sms' => ['boolean'],
            'notification_preferences.promotions_email' => ['boolean'],
            'notification_preferences.promotions_sms' => ['boolean'],
        ]);

        $user = $request->user();
        $user->update($validated);

        return response()->json([
            'message' => 'Préférences de notifications mises à jour.',
            'notification_preferences' => $user->fresh()->notification_preferences,
        ]);
    }

    /**
     * Update preferences (language, currency, timezone).
     */
    public function updatePreferences(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'preferred_language' => ['sometimes', 'string', 'max:5'],
            'preferred_currency' => ['sometimes', 'string', 'max:5'],
            'timezone' => ['sometimes', 'string', 'max:50'],
        ]);

        $user = $request->user();
        $user->update($validated);

        return response()->json([
            'message' => 'Préférences mises à jour.',
            'user' => $this->formatUser($user->fresh()),
        ]);
    }

    /**
     * Update profile (bio, city, profession, languages, interests).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bio' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'languages_spoken' => ['nullable', 'array'],
            'languages_spoken.*' => ['string', 'max:50'],
            'interests' => ['nullable', 'array'],
            'interests.*' => ['string', 'max:50'],
        ]);

        $user = $request->user();
        $user->update($validated);

        return response()->json([
            'message' => 'Profil mis à jour.',
            'user' => $this->formatUser($user->fresh()),
        ]);
    }

    /**
     * Upload profile photo.
     */
    public function uploadPhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:5120'], // 5MB max
        ]);

        $user = $request->user();

        // Delete old photo if exists
        if ($user->profile_photo_url) {
            $oldPath = str_replace('/storage/', '', $user->profile_photo_url);
            Storage::disk('public')->delete($oldPath);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->update([
            'profile_photo_url' => '/storage/' . $path,
        ]);

        return response()->json([
            'message' => 'Photo de profil mise à jour.',
            'profile_photo_url' => url('/storage/' . $path),
        ]);
    }

    /**
     * Get public profile data.
     */
    public function publicProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'profile' => [
                'first_name' => $user->first_name,
                'profile_photo_url' => $user->profile_photo_full_url,
                'bio' => $user->bio,
                'city' => $user->city,
                'profession' => $user->profession,
                'languages_spoken' => $user->languages_spoken ?? [],
                'interests' => $user->interests ?? [],
                'email_verified' => $user->hasVerifiedEmail(),
                'phone_verified' => $user->phone_verified,
                'identity_verified' => $user->identity_verified,
                'member_since' => $user->created_at->format('F Y'),
                'listings_count' => $user->listings()->where('status', 'active')->count(),
            ],
        ]);
    }

    /**
     * Deactivate account.
     */
    public function deactivateAccount(Request $request): JsonResponse
    {
        $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Mot de passe incorrect.',
            ], 422);
        }

        // Revoke all tokens
        $user->tokens()->delete();

        // Soft-delete or deactivate
        $user->update(['role' => 'deactivated']);

        return response()->json([
            'message' => 'Compte désactivé.',
        ]);
    }

    private function formatUser($user): array
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'phone_country_code' => $user->phone_country_code,
            'birth_date' => $user->birth_date?->format('Y-m-d'),
            'role' => $user->role,
            'email_verified' => $user->hasVerifiedEmail(),
            'phone_verified' => $user->phone_verified,
            'identity_verified' => $user->identity_verified,
            'address_street' => $user->address_street,
            'address_city' => $user->address_city,
            'address_postal_code' => $user->address_postal_code,
            'address_country' => $user->address_country,
            'bio' => $user->bio,
            'city' => $user->city,
            'profession' => $user->profession,
            'languages_spoken' => $user->languages_spoken ?? [],
            'interests' => $user->interests ?? [],
            'profile_photo_url' => $user->profile_photo_full_url,
            'preferred_language' => $user->preferred_language,
            'preferred_currency' => $user->preferred_currency,
            'timezone' => $user->timezone,
            'notification_preferences' => $user->notification_preferences ?? [
                'reservations_email' => true,
                'reservations_sms' => false,
                'messages_email' => true,
                'messages_sms' => false,
                'reminders_email' => true,
                'reminders_sms' => false,
                'promotions_email' => false,
                'promotions_sms' => false,
            ],
            'receive_marketing' => $user->receive_marketing,
            'member_since' => $user->created_at->format('Y-m-d'),
        ];
    }
}
