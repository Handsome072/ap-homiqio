<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConversationController extends Controller
{
    /**
     * List conversations for the authenticated user.
     * - role=host: conversations where user is the host
     * - role=guest: conversations where user is the guest
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $role = $request->query('role', 'guest');
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');
        $archived = $request->boolean('archived', false);

        $query = Conversation::with([
            'reservation.listing.photos',
            'host:id,first_name,last_name,profile_photo_url',
            'guest:id,first_name,last_name,profile_photo_url',
            'lastMessage',
        ]);

        // Filter by role
        if ($role === 'host') {
            $query->where('host_id', $user->id);
            $query->where('host_archived', $archived);
        } else {
            $query->where('guest_id', $user->id);
            $query->where('guest_archived', $archived);
        }

        // Filter by reservation status
        if ($filter !== 'all') {
            $query->whereHas('reservation', function ($q) use ($filter) {
                match ($filter) {
                    'pending' => $q->where('status', 'pending'),
                    'upcoming' => $q->where('status', 'confirmed')
                                    ->where('check_in', '>', now()),
                    'active' => $q->whereIn('status', ['confirmed', 'active'])
                                  ->where('check_in', '<=', now())
                                  ->where('check_out', '>=', now()),
                    'past' => $q->where(function ($sub) {
                        $sub->where('status', 'completed')
                            ->orWhere(function ($s) {
                                $s->whereIn('status', ['confirmed', 'active'])
                                  ->where('check_out', '<', now());
                            });
                    }),
                    default => null,
                };
            });
        }

        // Search by guest/host name or listing title
        if ($search) {
            $query->where(function ($q) use ($search, $role) {
                // Search the other participant's name
                $participantField = $role === 'host' ? 'guest_id' : 'host_id';
                $q->whereHas($role === 'host' ? 'guest' : 'host', function ($sub) use ($search) {
                    $sub->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
                // Search listing title
                $q->orWhereHas('reservation.listing', function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Order by last activity
        $query->orderByDesc('updated_at');

        $conversations = $query->get();

        $userId = $user->id;
        $formatted = $conversations->map(fn ($conv) => $this->formatConversation($conv, $userId));

        return response()->json([
            'conversations' => $formatted,
            'total' => $formatted->count(),
        ]);
    }

    /**
     * Get messages for a conversation.
     */
    public function messages(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();

        $conversation = Conversation::with([
            'reservation.listing.photos',
            'host:id,first_name,last_name,profile_photo_url',
            'guest:id,first_name,last_name,profile_photo_url',
            'lastMessage',
        ])->findOrFail($conversationId);

        // Ensure user is participant
        if ($conversation->host_id !== $user->id && $conversation->guest_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $messages = $conversation->messages()->get();

        return response()->json([
            'messages' => $messages->map(fn ($msg) => $this->formatMessage($msg)),
            'conversation' => $this->formatConversation($conversation, $user->id),
        ]);
    }

    /**
     * Send a text message.
     */
    public function sendMessage(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'text' => 'required|string|max:5000',
        ]);

        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->host_id !== $user->id && $conversation->guest_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'text' => $request->input('text'),
        ]);

        // Touch conversation to update ordering
        $conversation->touch();

        return response()->json([
            'message' => 'Message envoyé',
            'data' => $this->formatMessage($message),
        ], 201);
    }

    /**
     * Send an image message.
     */
    public function sendImage(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'image' => 'required|image|max:10240', // 10MB
            'text' => 'nullable|string|max:5000',
        ]);

        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->host_id !== $user->id && $conversation->guest_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $path = $request->file('image')->store(
            "conversations/{$conversation->id}",
            'public'
        );

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'text' => $request->input('text'),
            'image_path' => $path,
        ]);

        $conversation->touch();

        return response()->json([
            'message' => 'Image envoyée',
            'data' => $this->formatMessage($message),
        ], 201);
    }

    /**
     * Mark conversation as read.
     */
    public function markAsRead(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->host_id !== $user->id && $conversation->guest_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        // Mark all unread messages from the other participant as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'Conversation marquée comme lue']);
    }

    /**
     * Mark conversation as unread.
     */
    public function markAsUnread(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->host_id !== $user->id && $conversation->guest_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        // Set the last message from the other participant back to unread
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->whereNotNull('read_at')
            ->latest()
            ->first()
            ?->update(['read_at' => null]);

        return response()->json(['message' => 'Conversation marquée comme non lue']);
    }

    /**
     * Archive a conversation.
     */
    public function archive(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->host_id !== $user->id && $conversation->guest_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if ($conversation->host_id === $user->id) {
            $conversation->update(['host_archived' => true]);
        } else {
            $conversation->update(['guest_archived' => true]);
        }

        return response()->json(['message' => 'Conversation archivée']);
    }

    /**
     * Unarchive a conversation.
     */
    public function unarchive(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->host_id !== $user->id && $conversation->guest_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if ($conversation->host_id === $user->id) {
            $conversation->update(['host_archived' => false]);
        } else {
            $conversation->update(['guest_archived' => false]);
        }

        return response()->json(['message' => 'Conversation désarchivée']);
    }

    // ─── Formatters ─────────────────────────────────────────────────────

    private function formatConversation(Conversation $conv, int $currentUserId): array
    {
        $reservation = $conv->reservation;
        $listing = $reservation->listing;
        $firstPhoto = $listing->photos->first();

        // Count unread messages (from the other participant)
        $unreadCount = Message::where('conversation_id', $conv->id)
            ->where('sender_id', '!=', $currentUserId)
            ->whereNull('read_at')
            ->count();

        $lastMessage = $conv->lastMessage;

        return [
            'id' => $conv->id,
            'reservation' => [
                'id' => $reservation->id,
                'check_in' => $reservation->check_in->toDateString(),
                'check_out' => $reservation->check_out->toDateString(),
                'guests_count' => $reservation->guests_count,
                'status' => $reservation->status,
                'listing' => [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'photo_url' => $firstPhoto ? Storage::disk('public')->url($firstPhoto->path) : null,
                ],
            ],
            'host' => [
                'id' => $conv->host->id,
                'first_name' => $conv->host->first_name,
                'last_name' => $conv->host->last_name,
                'profile_photo_url' => $conv->host->profile_photo_url,
            ],
            'guest' => [
                'id' => $conv->guest->id,
                'first_name' => $conv->guest->first_name,
                'last_name' => $conv->guest->last_name,
                'profile_photo_url' => $conv->guest->profile_photo_url,
            ],
            'last_message' => $lastMessage ? [
                'text' => $lastMessage->text,
                'sender_id' => $lastMessage->sender_id,
                'created_at' => $lastMessage->created_at->toIso8601String(),
                'has_image' => (bool) $lastMessage->image_path,
            ] : null,
            'unread_count' => $unreadCount,
            'is_archived' => $conv->host_id === $currentUserId
                ? $conv->host_archived
                : $conv->guest_archived,
            'created_at' => $conv->created_at->toIso8601String(),
            'updated_at' => $conv->updated_at->toIso8601String(),
        ];
    }

    private function formatMessage(Message $msg): array
    {
        return [
            'id' => $msg->id,
            'conversation_id' => $msg->conversation_id,
            'sender_id' => $msg->sender_id,
            'text' => $msg->text,
            'image_url' => $msg->image_url,
            'read_at' => $msg->read_at?->toIso8601String(),
            'created_at' => $msg->created_at->toIso8601String(),
        ];
    }
}
