<?php

namespace App\Http\Controllers;

use App\Models\HostPayout;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HostRevenueController extends Controller
{
    private const COMMISSION_RATE = 15.00;

    /**
     * Revenue summary: this month, this year, total, estimated (future reservations)
     */
    public function summary(Request $request)
    {
        $hostId = $request->user()->id;
        $now = Carbon::now();

        $baseQuery = fn () => HostPayout::where('host_id', $hostId);

        $thisMonth = (clone $baseQuery)()
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->whereIn('status', ['paid', 'scheduled', 'pending'])
            ->sum('net_amount');

        $thisYear = (clone $baseQuery)()
            ->whereYear('created_at', $now->year)
            ->whereIn('status', ['paid', 'scheduled', 'pending'])
            ->sum('net_amount');

        $total = (clone $baseQuery)()
            ->where('status', 'paid')
            ->sum('net_amount');

        // Estimated: pending + scheduled payouts (future)
        $estimated = (clone $baseQuery)()
            ->whereIn('status', ['pending', 'scheduled'])
            ->sum('net_amount');

        return response()->json([
            'revenue_this_month' => round((float) $thisMonth, 2),
            'revenue_this_year' => round((float) $thisYear, 2),
            'revenue_total' => round((float) $total, 2),
            'revenue_estimated' => round((float) $estimated, 2),
            'currency' => 'CAD',
        ]);
    }

    /**
     * Monthly/yearly revenue chart data
     */
    public function chart(Request $request)
    {
        $hostId = $request->user()->id;
        $year = $request->input('year', Carbon::now()->year);
        $listingId = $request->input('listing_id');

        $query = HostPayout::where('host_id', $hostId)
            ->whereYear('created_at', $year)
            ->whereIn('status', ['paid', 'scheduled', 'pending']);

        if ($listingId) {
            $query->where('listing_id', $listingId);
        }

        $monthly = $query
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(net_amount) as revenue'),
                DB::raw('SUM(gross_amount) as gross'),
                DB::raw('SUM(commission_amount) as commission')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Fill all 12 months
        $months = collect(range(1, 12))->map(function ($m) use ($monthly) {
            $data = $monthly->firstWhere('month', $m);
            return [
                'month' => $m,
                'revenue' => $data ? round((float) $data->revenue, 2) : 0,
                'gross' => $data ? round((float) $data->gross, 2) : 0,
                'commission' => $data ? round((float) $data->commission, 2) : 0,
            ];
        });

        // Yearly totals (last 5 years)
        $yearly = HostPayout::where('host_id', $hostId)
            ->whereIn('status', ['paid', 'scheduled', 'pending'])
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(net_amount) as revenue')
            )
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy('year')
            ->limit(5)
            ->get();

        return response()->json([
            'monthly' => $months,
            'yearly' => $yearly,
            'selected_year' => (int) $year,
        ]);
    }

    /**
     * Performance statistics
     */
    public function stats(Request $request)
    {
        $hostId = $request->user()->id;

        $payouts = HostPayout::where('host_id', $hostId)
            ->whereIn('status', ['paid', 'scheduled', 'pending'])
            ->get();

        $reservationIds = $payouts->pluck('reservation_id')->unique();
        $reservations = Reservation::whereIn('id', $reservationIds)->get();

        $totalNights = $reservations->sum(function ($r) {
            return Carbon::parse($r->check_in)->diffInDays(Carbon::parse($r->check_out));
        });

        $totalNetRevenue = $payouts->sum('net_amount');
        $avgPerNight = $totalNights > 0 ? round($totalNetRevenue / $totalNights, 2) : 0;

        $totalReservations = $reservations->count();
        $avgStayDuration = $totalReservations > 0
            ? round($totalNights / $totalReservations, 1)
            : 0;

        return response()->json([
            'total_nights' => $totalNights,
            'avg_revenue_per_night' => $avgPerNight,
            'avg_stay_duration' => $avgStayDuration,
            'total_reservations' => $totalReservations,
        ]);
    }

    /**
     * Upcoming payouts (pending/scheduled)
     */
    public function upcoming(Request $request)
    {
        $hostId = $request->user()->id;

        $payouts = HostPayout::where('host_id', $hostId)
            ->whereIn('status', ['pending', 'scheduled'])
            ->with(['reservation:id,check_in,check_out', 'listing:id,title,city'])
            ->orderBy('scheduled_date', 'asc')
            ->get()
            ->map(fn ($p) => $this->formatPayout($p));

        return response()->json(['payouts' => $payouts]);
    }

    /**
     * Payout history (paid/failed)
     */
    public function history(Request $request)
    {
        $hostId = $request->user()->id;
        $year = $request->input('year');
        $month = $request->input('month');

        $query = HostPayout::where('host_id', $hostId)
            ->whereIn('status', ['paid', 'failed'])
            ->with(['reservation:id,check_in,check_out', 'listing:id,title,city']);

        if ($year) {
            $query->whereYear('paid_date', $year);
        }
        if ($month && $year) {
            $query->whereMonth('paid_date', $month);
        }

        $payouts = $query
            ->orderBy('paid_date', 'desc')
            ->get()
            ->map(fn ($p) => $this->formatPayout($p));

        return response()->json(['payouts' => $payouts]);
    }

    /**
     * Payout detail
     */
    public function show(Request $request, int $id)
    {
        $payout = HostPayout::where('host_id', $request->user()->id)
            ->with(['reservation:id,check_in,check_out,total_price,guests_count', 'listing:id,title,city,cleaning_fee'])
            ->findOrFail($id);

        return response()->json([
            'payout' => [
                'id' => $payout->id,
                'reservation_id' => $payout->reservation_id,
                'listing' => $payout->listing ? [
                    'id' => $payout->listing->id,
                    'title' => $payout->listing->title,
                    'city' => $payout->listing->city,
                ] : null,
                'reservation' => $payout->reservation ? [
                    'id' => $payout->reservation->id,
                    'check_in' => $payout->reservation->check_in?->format('Y-m-d'),
                    'check_out' => $payout->reservation->check_out?->format('Y-m-d'),
                    'total_price' => $payout->reservation->total_price,
                    'guests_count' => $payout->reservation->guests_count,
                ] : null,
                'gross_amount' => round((float) $payout->gross_amount, 2),
                'cleaning_fee' => round((float) $payout->cleaning_fee, 2),
                'commission_rate' => round((float) $payout->commission_rate, 2),
                'commission_amount' => round((float) $payout->commission_amount, 2),
                'taxes' => round((float) $payout->taxes, 2),
                'net_amount' => round((float) $payout->net_amount, 2),
                'currency' => $payout->currency,
                'status' => $payout->status,
                'scheduled_date' => $payout->scheduled_date?->format('Y-m-d'),
                'paid_date' => $payout->paid_date?->format('Y-m-d'),
                'reference' => $payout->reference,
                'created_at' => $payout->created_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * Export CSV report
     */
    public function export(Request $request)
    {
        $hostId = $request->user()->id;
        $year = $request->input('year');
        $month = $request->input('month');

        $query = HostPayout::where('host_id', $hostId)
            ->with(['reservation:id,check_in,check_out', 'listing:id,title'])
            ->orderBy('created_at', 'desc');

        if ($year) {
            $query->whereYear('created_at', $year);
        }
        if ($month && $year) {
            $query->whereMonth('created_at', $month);
        }

        $payouts = $query->get();

        $csv = "Date,Reservation,Annonce,Montant brut,Commission,Frais menage,Taxes,Revenu net,Statut\n";

        foreach ($payouts as $p) {
            $date = $p->paid_date?->format('Y-m-d') ?? $p->scheduled_date?->format('Y-m-d') ?? $p->created_at->format('Y-m-d');
            $reservation = "RES-{$p->reservation_id}";
            $listing = str_replace(',', ' ', $p->listing->title ?? '');
            $csv .= "{$date},{$reservation},{$listing},{$p->gross_amount},{$p->commission_amount},{$p->cleaning_fee},{$p->taxes},{$p->net_amount},{$p->status}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="revenus-' . ($year ?? 'all') . ($month ? "-{$month}" : '') . '.csv"',
        ]);
    }

    /**
     * Get host's listings for filter dropdown
     */
    public function listings(Request $request)
    {
        $listings = $request->user()->listings()
            ->select('id', 'title', 'city')
            ->orderBy('title')
            ->get();

        return response()->json(['listings' => $listings]);
    }

    private function formatPayout(HostPayout $p): array
    {
        return [
            'id' => $p->id,
            'reservation_id' => $p->reservation_id,
            'listing' => $p->listing ? [
                'id' => $p->listing->id,
                'title' => $p->listing->title,
                'city' => $p->listing->city,
            ] : null,
            'reservation_dates' => $p->reservation ? [
                'check_in' => $p->reservation->check_in?->format('Y-m-d'),
                'check_out' => $p->reservation->check_out?->format('Y-m-d'),
            ] : null,
            'gross_amount' => round((float) $p->gross_amount, 2),
            'commission_amount' => round((float) $p->commission_amount, 2),
            'net_amount' => round((float) $p->net_amount, 2),
            'currency' => $p->currency,
            'status' => $p->status,
            'scheduled_date' => $p->scheduled_date?->format('Y-m-d'),
            'paid_date' => $p->paid_date?->format('Y-m-d'),
        ];
    }
}
