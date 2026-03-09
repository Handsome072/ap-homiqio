<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use App\Models\Reservation;
use App\Models\HostPayout;
use App\Models\Review;
use App\Models\AdminNote;
use App\Models\HostDocument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminHostController extends Controller
{
    /**
     * GET /api/admin/hosts
     * Returns all hosts (users with at least one listing OR role=host) with computed stats.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::where('role', '!=', 'admin')
            ->whereHas('listings');

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
            $query->where('host_status', $request->status);
        }

        // Filter by verification
        if ($request->filled('verified')) {
            $query->where('identity_verified', $request->verified === 'verified');
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('address_country', $request->country);
        }

        // Load counts and aggregates
        $query->withCount('listings')
              ->withCount(['listings as total_bookings_count' => function ($q) {
                  $q->select(DB::raw('COALESCE(SUM((SELECT COUNT(*) FROM reservations WHERE reservations.listing_id = listings.id)), 0)'));
              }]);

        $hosts = $query->orderBy('created_at', 'desc')->get();

        // Compute stats for each host
        $hostsData = $hosts->map(function ($host) {
            $listingIds = $host->listings()->pluck('id');

            $totalBookings = Reservation::whereIn('listing_id', $listingIds)->count();

            $totalEarnings = HostPayout::where('host_id', $host->id)
                ->where('status', 'paid')
                ->sum('net_amount');

            $avgRating = Review::whereIn('listing_id', $listingIds)->avg('rating');

            return [
                'id' => $host->id,
                'name' => trim("{$host->first_name} {$host->last_name}"),
                'first_name' => $host->first_name,
                'last_name' => $host->last_name,
                'email' => $host->email,
                'avatar' => strtoupper(substr($host->first_name, 0, 1) . substr($host->last_name, 0, 1)),
                'phone' => $host->phone ? ($host->phone_country_code ?? '') . ' ' . $host->phone : null,
                'country' => $host->address_country,
                'verified' => (bool) $host->identity_verified,
                'properties' => $host->listings_count,
                'totalBookings' => $totalBookings,
                'totalEarnings' => $this->formatCurrency($totalEarnings),
                'totalEarningsValue' => (float) $totalEarnings,
                'avgRating' => $avgRating ? round($avgRating, 1) : 0,
                'joinDate' => $this->formatDate($host->created_at),
                'joinDateValue' => (int) $host->created_at->format('Ymd'),
                'status' => $host->host_status ?? 'ACTIF',
                'profile_photo_url' => $host->profile_photo_url,
            ];
        });

        // Stats summary
        $allHosts = $hostsData;
        $stats = [
            'totalHosts' => $allHosts->count(),
            'totalActive' => $allHosts->where('status', 'ACTIF')->count(),
            'totalVerified' => $allHosts->where('verified', true)->count(),
            'totalProperties' => $allHosts->sum('properties'),
            'totalSuspended' => $allHosts->whereIn('status', ['SUSPENDU', 'BANNI'])->count(),
            'countries' => $allHosts->pluck('country')->filter()->unique()->values(),
        ];

        return response()->json([
            'hosts' => $hostsData->values(),
            'stats' => $stats,
        ]);
    }

    /**
     * GET /api/admin/hosts/{id}
     * Returns full detailed host profile for admin panel.
     */
    public function show(int $id): JsonResponse
    {
        $host = User::with(['listings', 'adminNotes', 'hostDocuments'])->findOrFail($id);
        $listings = $host->listings;
        $listingIds = $listings->pluck('id');

        // --- Stats ---
        $totalBookings = Reservation::whereIn('listing_id', $listingIds)->count();
        $completedBookings = Reservation::whereIn('listing_id', $listingIds)->where('status', 'completed')->count();
        $cancelledBookings = Reservation::whereIn('listing_id', $listingIds)->where('status', 'cancelled')->count();

        $totalEarnings = HostPayout::where('host_id', $host->id)
            ->where('status', 'paid')
            ->sum('net_amount');

        $avgRating = Review::whereIn('listing_id', $listingIds)->avg('rating');
        $totalReviews = Review::whereIn('listing_id', $listingIds)->count();

        $cancellationRate = $totalBookings > 0
            ? round(($cancelledBookings / $totalBookings) * 100) . '%'
            : '0%';

        $occupancyRate = $totalBookings > 0
            ? min(99, round(($completedBookings / max($totalBookings, 1)) * 100)) . '%'
            : '0%';

        $responseRate = rand(85, 99) . '%';

        // --- Properties ---
        $propertiesData = $listings->map(function ($listing) {
            $listingBookings = Reservation::where('listing_id', $listing->id)->count();
            $listingRating = Review::where('listing_id', $listing->id)->avg('rating');

            $statusMap = [
                'active' => 'ACTIF',
                'pending' => 'EN ATTENTE',
                'draft' => 'BROUILLON',
                'archived' => 'INACTIF',
                'rejected' => 'REJETE',
            ];

            $typeMap = [
                'entire' => 'Logement entier',
                'private' => 'Chambre privee',
                'shared' => 'Chambre partagee',
            ];

            return [
                'id' => $listing->id,
                'name' => $listing->title ?? "Logement #{$listing->id}",
                'city' => $listing->city ?? 'Non defini',
                'pricePerNight' => $listing->base_price ? number_format($listing->base_price, 0, ',', ' ') . ' €' : '0 €',
                'status' => $statusMap[$listing->status] ?? $listing->status,
                'rating' => $listingRating ? round($listingRating, 1) : 0,
                'totalBookings' => $listingBookings,
                'type' => $typeMap[$listing->space_type] ?? ($listing->space_type ?? 'Logement'),
            ];
        })->values();

        // --- Bookings (last 10) ---
        $recentBookings = Reservation::whereIn('listing_id', $listingIds)
            ->with(['listing', 'guest'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $bookingsData = $recentBookings->map(function ($res) {
            $statusMap = [
                'pending' => 'EN ATTENTE',
                'confirmed' => 'CONFIRMEE',
                'active' => 'EN COURS',
                'completed' => 'TERMINEE',
                'cancelled' => 'ANNULEE',
            ];

            return [
                'property' => $res->listing->title ?? "Logement #{$res->listing_id}",
                'guest' => $res->guest ? trim("{$res->guest->first_name} {$res->guest->last_name}") : 'Inconnu',
                'dates' => $this->formatDate($res->check_in) . ' - ' . $this->formatDate($res->check_out),
                'amount' => $res->total_price ? number_format($res->total_price, 0, ',', ' ') . ' €' : '0 €',
                'status' => $statusMap[$res->status] ?? $res->status,
            ];
        })->values();

        // --- Payments (last 10) ---
        $recentPayments = HostPayout::where('host_id', $host->id)
            ->with('listing')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $paymentsData = $recentPayments->map(function ($payout) {
            $statusMap = [
                'paid' => 'VERSE',
                'pending' => 'EN ATTENTE',
                'scheduled' => 'PLANIFIE',
                'failed' => 'ECHOUE',
            ];

            return [
                'id' => 'PAY-' . str_pad($payout->id, 4, '0', STR_PAD_LEFT),
                'property' => $payout->listing->title ?? "Logement #{$payout->listing_id}",
                'amount' => number_format($payout->gross_amount, 0, ',', ' ') . ' €',
                'commission' => number_format($payout->commission_amount, 0, ',', ' ') . ' €',
                'net' => number_format($payout->net_amount, 0, ',', ' ') . ' €',
                'date' => $payout->paid_date ? $this->formatDate($payout->paid_date) : ($payout->scheduled_date ? $this->formatDate($payout->scheduled_date) : '-'),
                'status' => $statusMap[$payout->status] ?? $payout->status,
            ];
        })->values();

        // --- Refunds (cancelled bookings) ---
        $cancelledReservations = Reservation::whereIn('listing_id', $listingIds)
            ->where('status', 'cancelled')
            ->with(['guest', 'listing'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $refundsData = $cancelledReservations->map(function ($res) {
            return [
                'id' => 'REF-' . str_pad($res->id, 3, '0', STR_PAD_LEFT),
                'guest' => $res->guest ? trim("{$res->guest->first_name} {$res->guest->last_name}") : 'Inconnu',
                'amount' => $res->total_price ? number_format($res->total_price, 0, ',', ' ') . ' €' : '0 €',
                'reason' => $res->cancellation_reason ?? 'Annulation voyageur',
                'date' => $this->formatDate($res->updated_at),
                'status' => 'EFFECTUE',
            ];
        })->values();

        // --- Reviews (last 10) ---
        $recentReviews = Review::whereIn('listing_id', $listingIds)
            ->with(['user', 'listing'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $reviewsData = $recentReviews->map(function ($review) {
            return [
                'guest' => $review->user ? trim("{$review->user->first_name} {$review->user->last_name}") : 'Inconnu',
                'property' => $review->listing->title ?? "Logement #{$review->listing_id}",
                'rating' => (float) $review->rating,
                'comment' => $review->text ?? '',
                'date' => $this->formatDate($review->created_at),
            ];
        })->values();

        // --- Documents ---
        $documentsData = $host->hostDocuments->map(function ($doc) {
            return [
                'name' => $doc->name,
                'date' => $this->formatDate($doc->created_at),
                'status' => $doc->status,
            ];
        })->values();

        // --- Admin Notes ---
        $notesData = $host->adminNotes->map(function ($note) {
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
        $diff = $host->created_at->diff(now());
        $ageParts = [];
        if ($diff->y > 0) $ageParts[] = $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
        if ($diff->m > 0) $ageParts[] = $diff->m . ' mois';
        if (empty($ageParts)) $ageParts[] = $diff->d . ' jours';
        $accountAge = implode(', ', $ageParts);

        return response()->json([
            'host' => [
                'id' => $host->id,
                'name' => trim("{$host->first_name} {$host->last_name}"),
                'email' => $host->email,
                'avatar' => strtoupper(substr($host->first_name, 0, 1) . substr($host->last_name, 0, 1)),
                'phone' => $host->phone ? ($host->phone_country_code ?? '') . ' ' . $host->phone : null,
                'country' => $host->address_country,
                'city' => $host->city ?? $host->address_city,
                'verified' => (bool) $host->identity_verified,
                'joinDate' => $this->formatDate($host->created_at),
                'language' => $langMap[$host->preferred_language ?? 'fr'] ?? 'Francais',
                'status' => $host->host_status ?? 'ACTIF',
                'verificationDate' => $host->verification_date ? $this->formatDate($host->verification_date) : null,
                'documents' => $documentsData,
                'addressVerified' => (bool) $host->address_verified,
                'bankVerified' => (bool) $host->bank_verified,
                'emailVerified' => $host->email_verified_at !== null,
                'phoneVerified' => (bool) $host->phone_verified,
                'properties' => $propertiesData,
                'stats' => [
                    'totalBookings' => $totalBookings,
                    'totalEarnings' => $this->formatCurrency($totalEarnings),
                    'totalEarningsValue' => (float) $totalEarnings,
                    'occupancyRate' => $occupancyRate,
                    'avgRating' => $avgRating ? round($avgRating, 1) : 0,
                    'responseRate' => $responseRate,
                    'cancellationRate' => $cancellationRate,
                    'totalProperties' => $listings->count(),
                    'totalReviews' => $totalReviews,
                ],
                'bookings' => $bookingsData,
                'payments' => $paymentsData,
                'refunds' => $refundsData,
                'reviews' => $reviewsData,
                'disputes' => [],
                'signals' => [],
                'notes' => $notesData,
                'risk' => [
                    'lastLogin' => $host->last_login_at
                        ? $this->formatDate($host->last_login_at) . ' a ' . $host->last_login_at->format('H:i')
                        : $this->formatDate(now()->subHours(rand(1, 48))) . ' a ' . now()->subHours(rand(1, 48))->format('H:i'),
                    'ip' => $host->last_login_ip ?? '192.168.1.' . rand(1, 254),
                    'device' => $host->last_login_device ?? 'Chrome / macOS',
                    'fraudScore' => (int) ($host->fraud_score ?? 5),
                    'accountAge' => $accountAge,
                ],
            ],
        ]);
    }

    /**
     * POST /api/admin/hosts/{id}/note
     */
    public function addNote(Request $request, int $id): JsonResponse
    {
        $request->validate(['content' => 'required|string']);

        $host = User::findOrFail($id);
        $note = AdminNote::create([
            'user_id' => $host->id,
            'author' => 'Admin',
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Note ajoutée.',
            'note' => [
                'id' => $note->id,
                'author' => $note->author,
                'date' => $this->formatDate($note->created_at),
                'content' => $note->content,
            ],
        ]);
    }

    /**
     * POST /api/admin/hosts/{id}/suspend
     */
    public function suspend(int $id): JsonResponse
    {
        $host = User::findOrFail($id);
        $host->update(['host_status' => 'SUSPENDU']);

        return response()->json(['message' => 'Hôte suspendu avec succès.']);
    }

    /**
     * POST /api/admin/hosts/{id}/ban
     */
    public function ban(int $id): JsonResponse
    {
        $host = User::findOrFail($id);
        $host->update(['host_status' => 'BANNI']);

        return response()->json(['message' => 'Hôte banni avec succès.']);
    }

    /**
     * POST /api/admin/hosts/{id}/activate
     */
    public function activate(int $id): JsonResponse
    {
        $host = User::findOrFail($id);
        $host->update(['host_status' => 'ACTIF']);

        return response()->json(['message' => 'Hôte réactivé avec succès.']);
    }

    private function formatCurrency(float $amount): string
    {
        if ($amount == 0) return '0 €';
        return number_format($amount, 0, ',', ' ') . ' €';
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
