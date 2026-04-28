<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\PaymentReminderMail;
use Illuminate\Support\Facades\Mail;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', date('Y-m'));
        $currentDate = Carbon::parse($selectedMonth);

        // Paiements du mois sélectionné
        $payments = Payment::with(['user', 'property'])
            ->where('mois_paye', $selectedMonth)
            ->orderBy('date_limite')
            ->get();

        // Échéances à venir (prochains 30 jours)
        $upcomingPayments = Payment::with(['user', 'property'])
            ->where('statut', 'en_attente')
            ->whereBetween('date_limite', [now(), now()->addDays(30)])
            ->orderBy('date_limite')
            ->get();

        // Paiements en retard
        $overduePayments = Payment::with(['user', 'property'])
            ->where('statut', 'en_attente')
            ->where('date_limite', '<', now())
            ->orderBy('date_limite')
            ->get();

        // Générer les données du calendrier
        $calendarData = $this->generateCalendarData($currentDate, $payments);

        return view('admin.calendar.index', compact(
            'currentDate',
            'payments',
            'upcomingPayments',
            'overduePayments',
            'calendarData'
        ));
    }

    private function generateCalendarData($currentDate, $payments)
    {
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        $calendar = [];
        $currentDay = $startOfMonth->copy();

        // Générer tous les jours du mois
        while ($currentDay <= $endOfMonth) {
            $dayPayments = $payments->filter(function ($payment) use ($currentDay) {
                return Carbon::parse($payment->date_limite)->isSameDay($currentDay);
            });

            $calendar[] = [
                'date' => $currentDay->copy(),
                'is_current_month' => true,
                'is_today' => $currentDay->isToday(),
                'payments' => $dayPayments,
                'payment_count' => $dayPayments->count(),
                'is_weekend' => $currentDay->isWeekend(),
            ];

            $currentDay->addDay();
        }

        return $calendar;
    }

    public function markAsPaid(Payment $payment)
    {
        $payment->marquerCommePaye();

        return redirect()->back()
            ->with('success', 'Paiement marqué comme payé avec succès.');
    }

    // public function sendReminder(Payment $payment)
    // {
    //     // TODO: Implémenter l'envoi de rappel
    //     // Mail::to($payment->user->email)->send(new PaymentReminderMail($payment));

    //     return redirect()->back()
    //         ->with('success', 'Rappel envoyé au locataire.');
    // }

    public function sendReminder(Payment $payment)
    {
        try {
            Mail::to($payment->user->email)
                ->send(new PaymentReminderMail($payment));

            // Enregistrer dans les logs
            \Log::info('Rappel envoyé à ' . $payment->user->email . ' pour le paiement ' . $payment->reference);

            return redirect()->back()
                ->with('success', 'Rappel envoyé au locataire avec succès.');

        } catch (\Exception $e) {
            \Log::error('Erreur envoi rappel: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Erreur lors de l\'envoi du rappel: ' . $e->getMessage());
        }
    }

    public function getCalendarEvents(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $payments = Payment::with(['user', 'property'])
            ->whereBetween('date_limite', [$start, $end])
            ->get()
            ->map(function ($payment) {
                $isOverdue = $payment->date_limite < now() && $payment->statut === 'en_attente';

                return [
                    'id' => $payment->id,
                    'title' => $payment->user->prenom . ' - ' . number_format($payment->montant, 0, ',', ' ') . ' XAF',
                    'start' => $payment->date_limite->format('Y-m-d'),
                    'end' => $payment->date_limite->format('Y-m-d'),
                    'color' => $payment->statut === 'paye' ? '#28a745' : ($isOverdue ? '#dc3545' : '#ffc107'),
                    'extendedProps' => [
                        'payment_id' => $payment->id,
                        'tenant' => $payment->user->prenom . ' ' . $payment->user->nom,
                        'property' => $payment->property->adresse,
                        'amount' => $payment->montant,
                        'status' => $payment->statut,
                        'is_overdue' => $isOverdue,
                    ]
                ];
            });

        return response()->json($payments);
    }
}
