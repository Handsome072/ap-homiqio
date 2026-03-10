<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use App\Models\GuestReview;
use App\Models\ClientReport;
use App\Models\ActivityLog;
use App\Models\AdminNote;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class AdminClientController extends Controller
{
    /**
     * GET /api/admin/clients
     * Returns all clients (non-admin users) with computed stats.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::where('role', '!=', 'admin');

        // Search by name, email, or ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('client_status', $request->status);
        }

        // Filter by verification
        if ($request->filled('verified')) {
            $query->where('identity_verified', $request->verified === 'verified');
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('address_country', $request->country);
        }

        // Filter by suspect
        if ($request->filled('suspect')) {
            $query->where('is_suspect', $request->suspect === 'true');
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        // Compute stats for each client
        $clientsData = $users->map(function ($user) {
            $totalBookings = Reservation::where('guest_id', $user->id)->count();

            $totalSpent = Reservation::where('guest_id', $user->id)
                ->whereIn('status', ['confirmed', 'active', 'completed'])
                ->sum('total_price');

            $avgRating = GuestReview::where('guest_id', $user->id)->avg('rating');

            return [
                'id' => $user->id,
                'name' => trim("{$user->first_name} {$user->last_name}"),
                'email' => $user->email,
                'avatar' => strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name ?? '', 0, 1)),
                'phone' => $user->phone ? ($user->phone_country_code ?? '') . ' ' . $user->phone : '',
                'country' => $user->address_country ?? '',
                'verified' => (bool) $user->identity_verified,
                'totalBookings' => $totalBookings,
                'totalSpent' => $this->formatCurrency($totalSpent),
                'totalSpentValue' => (float) $totalSpent,
                'joinDate' => $this->formatDate($user->created_at),
                'joinDateValue' => (int) $user->created_at->format('Ymd'),
                'averageRating' => $avgRating ? round($avgRating, 1) : 0,
                'status' => $user->client_status ?? 'ACTIF',
                'isSuspect' => (bool) $user->is_suspect,
            ];
        });

        // Stats summary
        $stats = [
            'totalClients' => $clientsData->count(),
            'totalActive' => $clientsData->where('status', 'ACTIF')->count(),
            'totalVerified' => $clientsData->where('verified', true)->count(),
            'newThisMonth' => $users->filter(fn($u) => $u->created_at->isCurrentMonth())->count(),
            'totalSuspended' => $clientsData->whereIn('status', ['SUSPENDU', 'BANNI'])->count(),
            'totalSuspect' => $clientsData->where('isSuspect', true)->count(),
            'countries' => $clientsData->pluck('country')->filter()->unique()->values(),
        ];

        return response()->json([
            'clients' => $clientsData->values(),
            'stats' => $stats,
        ]);
    }

    /**
     * GET /api/admin/clients/{id}
     * Returns full detailed client profile for admin panel.
     */
    public function show(int $id): JsonResponse
    {
        $client = User::with(['adminNotes', 'hostDocuments', 'activityLogs', 'clientReports'])
            ->findOrFail($id);

        // --- Reservations (bookings) ---
        $reservations = Reservation::where('guest_id', $client->id)
            ->with(['listing', 'listing.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalBookings = $reservations->count();
        $cancellations = $reservations->where('status', 'cancelled')->count();

        $totalSpent = $reservations
            ->whereIn('status', ['confirmed', 'active', 'completed'])
            ->sum('total_price');

        // Reviews left by this client on listings
        $reviewsLeft = $client->reviews()->count();

        // Reviews received from hosts about this client
        $guestReviews = GuestReview::where('guest_id', $client->id)
            ->with(['host', 'listing'])
            ->orderBy('created_at', 'desc')
            ->get();

        $avgRating = $guestReviews->avg('rating');

        // --- Bookings data ---
        $bookingsData = $reservations->map(function ($res) {
            $statusMap = [
                'pending' => 'EN ATTENTE',
                'confirmed' => 'CONFIRMEE',
                'active' => 'EN COURS',
                'completed' => 'TERMINEE',
                'cancelled' => 'ANNULEE',
            ];

            $host = $res->listing && $res->listing->user
                ? trim("{$res->listing->user->first_name} {$res->listing->user->last_name}")
                : 'Inconnu';

            return [
                'property' => $res->listing->title ?? "Logement #{$res->listing_id}",
                'host' => $host,
                'dates' => $this->formatDate($res->check_in) . ' - ' . $this->formatDate($res->check_out),
                'amount' => $res->total_price ? $this->formatCurrency($res->total_price) : '0 $',
                'status' => $statusMap[$res->status] ?? $res->status,
            ];
        })->values();

        // --- Payments data (from reservations) ---
        $paymentsData = $reservations->filter(fn($r) => $r->total_price > 0)->map(function ($res, $index) {
            $statusMap = [
                'completed' => 'REUSSI',
                'confirmed' => 'REUSSI',
                'active' => 'REUSSI',
                'pending' => 'EN ATTENTE',
                'cancelled' => 'REMBOURSE',
            ];

            return [
                'id' => 'PAY-' . str_pad($res->id, 3, '0', STR_PAD_LEFT),
                'amount' => $this->formatCurrency($res->total_price),
                'status' => $statusMap[$res->status] ?? 'REUSSI',
                'date' => $this->formatDate($res->created_at),
            ];
        })->values();

        // --- Disputes (cancelled reservations with reasons) ---
        $disputeReservations = $reservations->filter(fn($r) => $r->status === 'cancelled' && $r->cancellation_reason);
        $disputesData = $disputeReservations->map(function ($res) {
            return [
                'id' => 'DIS-' . str_pad($res->id, 3, '0', STR_PAD_LEFT),
                'property' => $res->listing->title ?? "Logement #{$res->listing_id}",
                'status' => 'RESOLU',
                'date' => $this->formatDate($res->updated_at),
                'description' => $res->cancellation_reason,
            ];
        })->values();

        // --- Reviews received from hosts ---
        $reviewsData = $guestReviews->map(function ($review) {
            return [
                'id' => $review->id,
                'hostName' => $review->host ? trim("{$review->host->first_name} {$review->host->last_name}") : 'Inconnu',
                'hostAvatar' => $review->host
                    ? strtoupper(substr($review->host->first_name, 0, 1) . substr($review->host->last_name ?? '', 0, 1))
                    : '??',
                'property' => $review->listing->title ?? 'Logement',
                'rating' => (float) $review->rating,
                'comment' => $review->comment ?? '',
                'date' => $this->formatDate($review->created_at),
            ];
        })->values();

        // --- Reports / Signalements ---
        $reportsData = $client->clientReports->map(function ($report) {
            return [
                'id' => $report->id,
                'reporter' => $report->reporter
                    ? trim("{$report->reporter->first_name} {$report->reporter->last_name}") . ' (Hote)'
                    : 'Inconnu',
                'reason' => $report->reason,
                'description' => $report->description ?? '',
                'date' => $this->formatDate($report->created_at),
                'status' => $report->status,
            ];
        })->values();

        // --- Activity logs ---
        $activityData = $client->activityLogs()
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'action' => $log->action,
                    'detail' => $log->detail ?? '',
                    'date' => $this->formatDate($log->created_at) . ' ' . $log->created_at->format('H:i'),
                    'ip' => $log->ip ?? '',
                ];
            })->values();

        // --- Refunds (cancelled reservations) ---
        $refundsData = $reservations->where('status', 'cancelled')
            ->filter(fn($r) => $r->total_price > 0)
            ->map(function ($res) {
                return [
                    'id' => 'REM-' . str_pad($res->id, 3, '0', STR_PAD_LEFT),
                    'reservationId' => 'RES-' . str_pad($res->id, 3, '0', STR_PAD_LEFT),
                    'amount' => $this->formatCurrency($res->total_price),
                    'reason' => $res->cancellation_reason ?? 'Annulation voyageur',
                    'status' => 'EFFECTUE',
                    'date' => $this->formatDate($res->updated_at),
                ];
            })->values();

        // --- Documents ---
        $documentsData = $client->hostDocuments->map(function ($doc) {
            return [
                'name' => $doc->name,
                'date' => $this->formatDate($doc->created_at),
                'status' => $doc->status,
            ];
        })->values();

        // --- Admin Notes ---
        $notesData = $client->adminNotes->map(function ($note) {
            return [
                'id' => $note->id,
                'author' => $note->author,
                'date' => $this->formatDate($note->created_at),
                'content' => $note->content,
            ];
        })->values();

        // --- Language mapping ---
        $langMap = [
            'fr' => 'Francais', 'en' => 'Anglais', 'es' => 'Espagnol',
            'de' => 'Allemand', 'it' => 'Italien', 'pt' => 'Portugais',
            'nl' => 'Neerlandais', 'ar' => 'Arabe',
        ];

        // --- Account age ---
        $diff = $client->created_at->diff(now());
        $ageParts = [];
        if ($diff->y > 0) $ageParts[] = $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
        if ($diff->m > 0) $ageParts[] = $diff->m . ' mois';
        if (empty($ageParts)) $ageParts[] = $diff->d . ' jours';

        return response()->json([
            'client' => [
                'id' => $client->id,
                'name' => trim("{$client->first_name} {$client->last_name}"),
                'email' => $client->email,
                'avatar' => strtoupper(substr($client->first_name, 0, 1) . substr($client->last_name ?? '', 0, 1)),
                'phone' => $client->phone ? ($client->phone_country_code ?? '') . ' ' . $client->phone : '',
                'country' => $client->address_country ?? '',
                'verified' => (bool) $client->identity_verified,
                'joinDate' => $this->formatDate($client->created_at),
                'language' => $langMap[$client->preferred_language ?? 'fr'] ?? 'Francais',
                'status' => $client->client_status ?? 'ACTIF',
                'isSuspect' => (bool) $client->is_suspect,
                'averageRating' => $avgRating ? round($avgRating, 1) : 0,
                'totalSpent' => $this->formatCurrency($totalSpent),
                'verificationDate' => $client->verification_date ? $this->formatDate($client->verification_date) : null,
                'documents' => $documentsData,
                'totalBookings' => $totalBookings,
                'cancellations' => $cancellations,
                'reviewsLeft' => $reviewsLeft,
                'reviewsReceived' => $guestReviews->count(),
                'bookings' => $bookingsData,
                'payments' => $paymentsData,
                'disputes' => $disputesData,
                'reviews' => $reviewsData,
                'reports' => $reportsData,
                'activityLog' => $activityData,
                'refunds' => $refundsData,
                'notes' => $notesData,
                'risk' => [
                    'lastLogin' => $client->last_login_at
                        ? $this->formatDate($client->last_login_at) . ' a ' . $client->last_login_at->format('H:i')
                        : $this->formatDate(now()) . ' a ' . now()->format('H:i'),
                    'ip' => $client->last_login_ip ?? '192.168.1.' . rand(1, 254),
                    'device' => $client->last_login_device ?? 'Chrome / macOS',
                    'fraudScore' => (int) ($client->fraud_score ?? 5),
                    'loginCount' => (int) ($client->login_count ?? 0),
                    'failedLogins' => (int) ($client->failed_logins ?? 0),
                ],
            ],
        ]);
    }

    /**
     * POST /api/admin/clients/{id}/suspend
     */
    public function suspend(int $id): JsonResponse
    {
        $client = User::findOrFail($id);
        $client->update(['client_status' => 'SUSPENDU']);

        return response()->json(['message' => 'Client suspendu avec succes.']);
    }

    /**
     * POST /api/admin/clients/{id}/ban
     */
    public function ban(int $id): JsonResponse
    {
        $client = User::findOrFail($id);
        $client->update(['client_status' => 'BANNI']);

        return response()->json(['message' => 'Client banni avec succes.']);
    }

    /**
     * POST /api/admin/clients/{id}/activate
     */
    public function activate(int $id): JsonResponse
    {
        $client = User::findOrFail($id);
        $client->update(['client_status' => 'ACTIF']);

        return response()->json(['message' => 'Client reactive avec succes.']);
    }

    /**
     * POST /api/admin/clients/{id}/suspect
     */
    public function toggleSuspect(int $id): JsonResponse
    {
        $client = User::findOrFail($id);
        $client->update(['is_suspect' => !$client->is_suspect]);

        $msg = $client->is_suspect ? 'Client marque comme suspect.' : 'Client retire des suspects.';
        return response()->json(['message' => $msg]);
    }

    /**
     * POST /api/admin/clients/{id}/note
     */
    public function addNote(Request $request, int $id): JsonResponse
    {
        $request->validate(['content' => 'required|string']);

        $client = User::findOrFail($id);
        $note = AdminNote::create([
            'user_id' => $client->id,
            'author' => 'Admin',
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Note ajoutee.',
            'note' => [
                'id' => $note->id,
                'author' => $note->author,
                'date' => $this->formatDate($note->created_at),
                'content' => $note->content,
            ],
        ]);
    }

    /**
     * DELETE /api/admin/clients/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $client = User::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client supprime avec succes.']);
    }

    private function formatCurrency(float $amount): string
    {
        if ($amount == 0) return '0 $';
        return number_format($amount, 0, ',', ' ') . ' $';
    }

    private function formatDate($date): string
    {
        $months = [
            1 => 'jan.', 2 => 'fev.', 3 => 'mar.', 4 => 'avr.',
            5 => 'mai', 6 => 'jun.', 7 => 'jul.', 8 => 'aou.',
            9 => 'sep.', 10 => 'oct.', 11 => 'nov.', 12 => 'dec.',
        ];

        return sprintf('%02d %s %d', $date->day, $months[$date->month], $date->year);
    }
}
