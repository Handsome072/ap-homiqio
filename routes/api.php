<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AdminListingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ConversationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'HOMIQIO API',
        'timestamp' => now()->toIso8601String(),
    ]);
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Public listings (no authentication required)
Route::get('/listings/public', [ListingController::class, 'publicIndex']);
Route::get('/listings/public/{id}', [ListingController::class, 'publicShow']);

// Public auth routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
    Route::post('/set-password', [AuthController::class, 'setPassword']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Protected routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/resend-verification', [AuthController::class, 'resendVerification']);
    });

    // User Profile & Settings
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserProfileController::class, 'show']);
        Route::put('/profile', [UserProfileController::class, 'updatePersonalInfo']);
        Route::put('/password', [UserProfileController::class, 'updatePassword']);
        Route::put('/notifications', [UserProfileController::class, 'updateNotifications']);
        Route::put('/preferences', [UserProfileController::class, 'updatePreferences']);
        Route::put('/profile/bio', [UserProfileController::class, 'updateProfile']);
        Route::post('/profile/photo', [UserProfileController::class, 'uploadPhoto']);
        Route::get('/profile/public', [UserProfileController::class, 'publicProfile']);
        Route::post('/account/deactivate', [UserProfileController::class, 'deactivateAccount']);
    });

    // Conversations (Messaging)
    Route::prefix('conversations')->group(function () {
        Route::get('/', [ConversationController::class, 'index']);
        Route::get('/{id}/messages', [ConversationController::class, 'messages']);
        Route::post('/{id}/messages', [ConversationController::class, 'sendMessage']);
        Route::post('/{id}/messages/image', [ConversationController::class, 'sendImage']);
        Route::post('/{id}/read', [ConversationController::class, 'markAsRead']);
        Route::post('/{id}/unread', [ConversationController::class, 'markAsUnread']);
        Route::post('/{id}/archive', [ConversationController::class, 'archive']);
        Route::post('/{id}/unarchive', [ConversationController::class, 'unarchive']);
    });

    // Listings (Logements)
    Route::get('/listings', [ListingController::class, 'index']);
    Route::post('/listings', [ListingController::class, 'store']);
    Route::get('/listings/{id}', [ListingController::class, 'show']);
    Route::put('/listings/{id}', [ListingController::class, 'update']);
    Route::delete('/listings/{id}', [ListingController::class, 'destroy']);

    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/check', function () {
            return response()->json(['admin' => true]);
        });

        // Admin Listings Management
        Route::get('/listings', [AdminListingController::class, 'index']);
        Route::get('/listings/{id}', [AdminListingController::class, 'show']);
        Route::post('/listings/{id}/approve', [AdminListingController::class, 'approve']);
        Route::post('/listings/{id}/reject', [AdminListingController::class, 'reject']);
        Route::post('/listings/{id}/suspend', [AdminListingController::class, 'suspend']);
        Route::delete('/listings/{id}', [AdminListingController::class, 'destroy']);
    });
});
