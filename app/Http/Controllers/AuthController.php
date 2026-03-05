<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Mail\ResetPasswordMail;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    /**
     * Register a new user (email-first flow - no password required).
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'receive_marketing' => ['boolean'],
        ]);

        // Generate email verification token
        $verificationToken = Str::random(64);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => null, // Password will be set after email verification
            'birth_date' => $validated['birth_date'] ?? null,
            'receive_marketing' => $validated['receive_marketing'] ?? false,
            'email_verification_token' => $verificationToken,
        ]);

        // Send verification email
        Mail::to($user->email)->send(new VerifyEmail($user, $verificationToken));

        // Do NOT return a token - user must verify email first
        return response()->json([
            'message' => 'Inscription réussie. Veuillez vérifier votre email.',
            'email' => $user->email,
        ], 201);
    }

    /**
     * Login user and return token.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if user exists and has a password set
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Identifiants incorrects.',
            ], 401);
        }

        if (!$user->password) {
            return response()->json([
                'message' => 'Veuillez d\'abord vérifier votre email et définir votre mot de passe.',
            ], 401);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Identifiants incorrects.',
            ], 401);
        }

        $user = Auth::user();

        // Revoke previous tokens (optional - for single device login)
        // $user->tokens()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified' => $user->hasVerifiedEmail(),
            ],
            'token' => $token,
        ]);
    }

    /**
     * Logout user (revoke current token).
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }

    /**
     * Get authenticated user profile.
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified' => $user->hasVerifiedEmail(),
                'birth_date' => $user->birth_date?->format('Y-m-d'),
                'receive_marketing' => $user->receive_marketing,
            ],
        ]);
    }

    /**
     * Verify email with token.
     */
    public function verifyEmail(Request $request, string $token): JsonResponse
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Token de vérification invalide ou expiré.',
            ], 400);
        }

        $user->email_verified_at = now();

        // Generate a password setup token (reuse the same field for simplicity)
        $passwordSetupToken = Str::random(64);
        $user->email_verification_token = 'pwd_' . $passwordSetupToken;
        $user->save();

        return response()->json([
            'message' => 'Email vérifié avec succès.',
            'password_setup_token' => $passwordSetupToken,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified' => true,
            ],
        ]);
    }

    /**
     * Set password after email verification.
     */
    public function setPassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        // Find user by password setup token
        $user = User::where('email_verification_token', 'pwd_' . $validated['token'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Token invalide ou expiré. Veuillez vous réinscrire.',
            ], 400);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Veuillez d\'abord vérifier votre email.',
            ], 400);
        }

        // Set the password
        $user->password = Hash::make($validated['password']);
        $user->email_verification_token = null; // Clear the token
        $user->save();

        // Create API token and log the user in
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Mot de passe créé avec succès.',
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified' => true,
            ],
            'token' => $token,
        ]);
    }

    /**
     * Resend verification email.
     */
    public function resendVerification(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Votre email est déjà vérifié.',
            ], 400);
        }

        // Generate new verification token
        $verificationToken = Str::random(64);
        $user->email_verification_token = $verificationToken;
        $user->save();

        // Send verification email
        Mail::to($user->email)->send(new VerifyEmail($user, $verificationToken));

        return response()->json([
            'message' => 'Email de vérification envoyé.',
        ]);
    }

    /**
     * Request password reset — generates token, stores it, sends email.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $plainToken = Str::random(64);

            // Store hashed token (upsert so one reset per email at a time)
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token'      => Hash::make($plainToken),
                    'created_at' => now(),
                ]
            );

            Mail::to($user->email)->send(new ResetPasswordMail($user, $plainToken));
        }

        // Always return success to prevent email enumeration
        return response()->json([
            'message' => 'Si cette adresse email existe, un lien de réinitialisation a été envoyé.',
        ]);
    }

    /**
     * Reset password using the token received by email.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'                 => ['required', 'email'],
            'token'                 => ['required', 'string'],
            'password'              => ['required', 'string', Password::min(8), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->first();

        if (! $record || ! Hash::check($validated['token'], $record->token)) {
            return response()->json([
                'message' => 'Lien de réinitialisation invalide ou expiré.',
            ], 400);
        }

        // Token expires after 60 minutes
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

            return response()->json([
                'message' => 'Le lien a expiré. Veuillez en demander un nouveau.',
            ], 400);
        }

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json(['message' => 'Utilisateur introuvable.'], 404);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        // Invalidate the reset token
        DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

        // Revoke all previous tokens and issue a fresh one
        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Mot de passe réinitialisé avec succès.',
            'user' => [
                'id'             => $user->id,
                'first_name'     => $user->first_name,
                'last_name'      => $user->last_name,
                'email'          => $user->email,
                'role'           => $user->role,
                'email_verified' => $user->hasVerifiedEmail(),
            ],
            'token' => $token,
        ]);
    }
}

