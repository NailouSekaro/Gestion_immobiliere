<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use App\Models\Message;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\caution;

class AdminDashboardController extends Controller
{
    // public function index()

    // {
    //     // Statistiques principales
    //     $stats = [
    //         'total_properties' => Property::count(),
    //         'occupied_properties' => Property::where('statut', 'occupé')->count(),
    //         'vacant_properties' => Property::where('statut', 'libre')->count(),
    //         'total_tenants' => User::where('role', 'locataire')->where('est_actif', true)->count(),
    //         'total_payments' => Payment::count(),
    //         'total_revenue' => Payment::where('statut', 'paye')->sum('montant'),
    //         'pending_payments' => Payment::where('statut', 'en_attente')->count(),
    //         'unread_messages' => Message::where('lu', false)->count(),
    //     ];

    //     // Revenus des 6 derniers mois
    //     $revenueLast6Months = $this->getRevenueLastMonths(6);

    //     // Paiements récents (7 derniers jours)
    //     $recentPayments = Payment::with(['user', 'property'])
    //         ->where('created_at', '>=', now()->subDays(7))
    //         ->orderBy('created_at', 'desc')
    //         ->take(10)
    //         ->get();

    //     // Propriétés récemment ajoutées
    //     $recentProperties = Property::with('locataireActuel')
    //         ->orderBy('created_at', 'desc')
    //         ->take(5)
    //         ->get();

    //     // Paiements en retard
    //     $overduePayments = Payment::with(['user', 'property'])
    //         ->where('statut', 'en_attente')
    //         ->where('date_limite', '<', now())
    //         ->orderBy('date_limite')
    //         ->get();

    //     return view('dashboard.index', compact(
    //         'stats',
    //         'revenueLast6Months',
    //         'recentPayments',
    //         'recentProperties',
    //         'overduePayments'
    //     ));
    // }

    public function index()
{
    // Statistiques principales
    $stats = [
        'total_properties'     => Property::count(),
        'occupied_properties'  => Property::where('statut', 'occupé')->count(),
        'vacant_properties'    => Property::where('statut', 'libre')->count(),
        'total_tenants'        => User::where('role', 'locataire')->where('est_actif', true)->count(),
        'total_payments'       => Payment::count(),
        'total_revenue'        => Payment::where('statut', 'paye')->sum('montant'),
        'pending_payments'     => Payment::where('statut', 'en_attente')->count(),
        'unread_messages'      => Message::where('lu', false)->count(),
    ];

    // ← Ajout du total des cautions
    $totalCautions = Caution::sum('total_caution');

    // Revenus des 6 derniers mois
    $revenueLast6Months = $this->getRevenueLastMonths(6);

    // Paiements récents (7 derniers jours)
    $recentPayments = Payment::with(['user', 'property'])
        ->where('created_at', '>=', now()->subDays(7))
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

    // Propriétés récemment ajoutées
    $recentProperties = Property::with('locataireActuel')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // Paiements en retard
    $overduePayments = Payment::with(['user', 'property'])
        ->where('statut', 'en_attente')
        ->where('date_limite', '<', now())
        ->orderBy('date_limite')
        ->get();

    return view('dashboard.index', compact(
        'stats',
        'totalCautions',           // ← ajouté ici
        'revenueLast6Months',
        'recentPayments',
        'recentProperties',
        'overduePayments'
    ));
}


    private function getRevenueLastMonths($months)
    {
        $revenueData = [];
        $now = Carbon::now();

        for ($i = $months - 1; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $monthName = $month->format('M Y');
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $revenue = Payment::where('statut', 'paye')
                ->whereBetween('date_paiement', [$monthStart, $monthEnd])
                ->sum('montant');

            $revenueData[] = [
                'month' => $monthName,
                'revenue' => $revenue
            ];
        }

        return $revenueData;
    }

    public function getChartData()
    {
        $revenueData = $this->getRevenueLastMonths(12);

        return response()->json([
            'labels' => array_column($revenueData, 'month'),
            'data' => array_column($revenueData, 'revenue')
        ]);
    }

    public function getQuickStats()
    {
        return response()->json([
            'total_revenue' => Payment::where('statut', 'paye')->sum('montant'),
            'pending_payments' => Payment::where('statut', 'en_attente')->count(),
            'vacant_properties' => Property::where('statut', 'libre')->count(),
            'unread_messages' => Message::where('lu', false)->count()
        ]);
    }
}
