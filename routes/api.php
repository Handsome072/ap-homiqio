<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AdminListingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\HostRevenueController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminHostController;
use App\Http\Controllers\AdminClientController;

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
        Route::post('/start', [ConversationController::class, 'startConversation']);
        Route::get('/unread-count', [ConversationController::class, 'unreadCount']);
        Route::get('/', [ConversationController::class, 'index']);
        Route::get('/{id}/messages', [ConversationController::class, 'messages']);
        Route::post('/{id}/messages', [ConversationController::class, 'sendMessage']);
        Route::post('/{id}/messages/image', [ConversationController::class, 'sendImage']);
        Route::post('/{id}/read', [ConversationController::class, 'markAsRead']);
        Route::post('/{id}/unread', [ConversationController::class, 'markAsUnread']);
        Route::post('/{id}/archive', [ConversationController::class, 'archive']);
        Route::post('/{id}/unarchive', [ConversationController::class, 'unarchive']);
    });

    // Host Revenue & Payouts
    Route::prefix('host/revenues')->group(function () {
        Route::get('/summary', [HostRevenueController::class, 'summary']);
        Route::get('/chart', [HostRevenueController::class, 'chart']);
        Route::get('/stats', [HostRevenueController::class, 'stats']);
        Route::get('/upcoming', [HostRevenueController::class, 'upcoming']);
        Route::get('/history', [HostRevenueController::class, 'history']);
        Route::get('/export', [HostRevenueController::class, 'export']);
        Route::get('/listings', [HostRevenueController::class, 'listings']);
        Route::get('/{id}', [HostRevenueController::class, 'show']);
    });

    // Reviews
    Route::post('/listings/{id}/reviews', [ReviewController::class, 'store']);

    // Listings (Logements)
    Route::get('/listings/check-title', [ListingController::class, 'checkTitle']);
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

        // Admin Clients Management
        Route::get('/clients', [AdminClientController::class, 'index']);
        Route::get('/clients/{id}', [AdminClientController::class, 'show']);
        Route::post('/clients/{id}/suspend', [AdminClientController::class, 'suspend']);
        Route::post('/clients/{id}/ban', [AdminClientController::class, 'ban']);
        Route::post('/clients/{id}/activate', [AdminClientController::class, 'activate']);
        Route::post('/clients/{id}/suspect', [AdminClientController::class, 'toggleSuspect']);
        Route::post('/clients/{id}/note', [AdminClientController::class, 'addNote']);
        Route::get('/clients/{id}/messages', [AdminClientController::class, 'getMessages']);
        Route::post('/clients/{id}/messages', [AdminClientController::class, 'sendAdminMessage']);
        Route::delete('/clients/{id}', [AdminClientController::class, 'destroy']);

        // Admin Hosts Management
        Route::get('/hosts', [AdminHostController::class, 'index']);
        Route::get('/hosts/{id}', [AdminHostController::class, 'show']);
        Route::post('/hosts/{id}/suspend', [AdminHostController::class, 'suspend']);
        Route::post('/hosts/{id}/ban', [AdminHostController::class, 'ban']);
        Route::post('/hosts/{id}/activate', [AdminHostController::class, 'activate']);
        Route::post('/hosts/{id}/note', [AdminHostController::class, 'addNote']);
    });
});
