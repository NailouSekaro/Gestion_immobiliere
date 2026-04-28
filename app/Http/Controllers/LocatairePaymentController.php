<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Mail\PaymentConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use PDF;
use Exception;
use Illuminate\Support\Str;
use FedaPay\Error\Base as FedaPayError;

class LocatairePaymentController extends Controller
{
    /**
     * Afficher les paiements du locataire
     */
    public function index()
    {
        $user = Auth::user();
        
        // Vérifier que c'est bien un locataire
        if (!$user->isLocataire()) {
            abort(403, 'Accès non autorisé');
        }
        
        $payments = Payment::where('user_id', $user->id)
            ->with('property')
            ->orderBy('annee', 'desc')
            ->orderByRaw("STR_TO_DATE(CONCAT(annee, '-', mois_paye), '%Y-%m') DESC")
            ->paginate(15);

        // Statistiques pour le locataire
        $totalPaye = Payment::where('user_id', $user->id)
            ->where('statut', 'paye')
            ->sum('montant');

        $enAttente = Payment::where('user_id', $user->id)
            ->where('statut', 'en_attente')
            ->count();

        $enRetard = Payment::where('user_id', $user->id)
            ->where('statut', 'en_attente')
            ->where('date_limite', '<', now())
            ->count();

        return view('locataire.payments.index', compact('payments', 'totalPaye', 'enAttente', 'enRetard'));
    }

    public function fedapayPage()
    {
        $user = Auth::user();

        if (!$user->isLocataire()) {
            abort(403, 'Accès non autorisé');
        }

        $payments = Payment::where('user_id', $user->id)
            ->with('property')
            ->whereIn('statut', ['en_attente', 'echec', 'annule'])
            ->orderBy('date_limite')
            ->get();

        $months = [
            1 => 'Janvier', 2 => 'Fevrier', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Aout',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Decembre',
        ];
        $years = range(now()->year - 1, now()->year + 1);

        return view('locataire.payments.fedapay', compact('payments', 'months', 'years'));
    }

    public function initiateFedaPayForPeriod(Request $request)
    {
        $user = Auth::user();

        if (!$user->isLocataire()) {
            abort(403, 'Acces non autorise');
        }

        $request->validate([
            'mois' => 'required|integer|between:1,12',
            'annee' => 'required|integer|min:2000|max:' . (now()->year + 5),
        ]);

        $user->load('property');

        if (!$user->property) {
            return back()->with('error', 'Aucune propriete ne vous est assignee pour le moment.');
        }

        $moisPaye = $request->annee . '-' . str_pad($request->mois, 2, '0', STR_PAD_LEFT);

        $payment = Payment::where('user_id', $user->id)
            ->where('mois_paye', $moisPaye)
            ->first();

        if ($payment && $payment->statut === 'paye') {
            return back()->with('error', "Le mois {$request->mois}/{$request->annee} est deja regle.");
        }

        $payment = $payment ?: Payment::creerPaiementMensuel(
            $user,
            $user->property,
            $request->mois,
            $request->annee
        );

        if ((float) $payment->montant > 5000) {
            return back()->with(
                'error',
                "Le montant de ce loyer est de " . number_format($payment->montant, 0, ',', ' ') .
                " FCFA. Votre compte FedaPay semble actuellement limite a 5 000 FCFA par transaction. Il faut demander a FedaPay d'augmenter ce plafond ou mettre en place un systeme de paiements partiels."
            );
        }

        return $this->initiateFedaPay($payment);
    }

    /**
     * Détail d'un paiement
     */
    public function show(Payment $payment)
    {
        $user = Auth::user();
        
        // Vérifier que le paiement appartient au locataire connecté
        if (!$user->isLocataire() || $payment->user_id !== $user->id) {
            abort(403, 'Accès non autorisé');
        }

        $payment->load('property');
        return view('locataire.payments.show', compact('payment'));
    }

    /**
     * Initier un paiement FedaPay
     */
    public function initiateFedaPay(Payment $payment)
    {
        $user = Auth::user();
        
        // Vérifier que le paiement appartient au locataire connecté
        if (!$user->isLocataire() || $payment->user_id !== $user->id) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que le paiement n'est pas déjà payé
        if ($payment->statut === 'paye') {
            return redirect()->route('paiements.index')
                ->with('error', 'Ce paiement a déjà été effectué.');
        }

        $this->configureFedaPay();

        try {
            $transaction = Transaction::create([
                'description' => "Paiement loyer - {$payment->periode}",
                'amount' => (int) round((float) $payment->montant),
                'currency' => ['iso' => config('services.fedapay.currency', 'XOF')],
                'callback_url' => route('paiements.fedapay.callback', [
                    'payment_id' => $payment->id
                ]),
                'customer' => [
                    'firstname' => $user->prenom,
                    'lastname' => $user->nom,
                    'email' => $user->email,
                    'phone_number' => [
                        'number' => $user->telephone ?? '',
                        'country' => 'bj'
                    ]
                ]
            ]);

            $token = $transaction->generateToken();
            
            // Mettre à jour le paiement
            $payment->update([
                'numero_transaction' => $transaction->id,
                'statut' => 'en_attente',
                'methode' => 'feda_pay'
            ]);

            // Rediriger vers la page de paiement FedaPay
            return redirect($token->url);

        } catch (\Exception $e) {
            Log::error('Erreur FedaPay locataire: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'user_id' => $user->id,
                'fedapay_env' => config('services.fedapay.env'),
                'has_secret_key' => filled(config('services.fedapay.secret_key')),
                'http_status' => $e instanceof FedaPayError ? $e->getHttpStatus() : null,
                'http_body' => $e instanceof FedaPayError ? $e->getHttpBody() : null,
                'json_body' => $e instanceof FedaPayError ? $e->getJsonBody() : null,
                'errors' => $e instanceof FedaPayError ? $e->getErrors() : null,
            ]);

            return back()->with('error', $this->formatFedaPayErrorMessage($e));
        }
    }

    /**
     * Callback FedaPay après paiement locataire
     */
    public function fedapayCallback(Request $request)
    {
        if (!$request->has('id')) {
            return redirect()->route('paiements.index')
                ->with('error', 'ID de transaction introuvable.');
        }

        $payment = Payment::findOrFail($request->payment_id);

        $this->configureFedaPay();

        try {
            // Récupérer le statut de la transaction FedaPay
            $transaction = Transaction::retrieve($request->id);

            if ($transaction->status === 'approved') {
                $payment->update([
                    'statut' => 'paye',
                    'paye_le' => now(),
                    'date_paiement' => now(),
                    'numero_transaction' => $transaction->id,
                ]);

                // Envoyer email de confirmation avec reçu
                try {
                    $pdf = PDF::loadView('locataire.payments.receipt', [
                        'payment' => $payment,
                        'user' => $payment->user,
                        'property' => $payment->property
                    ]);

                    Mail::to($payment->user->email)->send(
                        (new PaymentConfirmationMail($payment))->attachData(
                            $pdf->output(),
                            "recu-{$payment->reference}.pdf",
                            ['mime' => 'application/pdf']
                        )
                    );
                } catch (\Exception $e) {
                    Log::error('Erreur envoi email: ' . $e->getMessage());
                }

                return redirect()->route('paiements.show', $payment->id)
                    ->with('success', 'Paiement effectué avec succès ! Un reçu vous a été envoyé par email.');

            } elseif (in_array($transaction->status, ['canceled', 'declined'])) {
                $payment->update(['statut' => 'echec']);
                
                return redirect()->route('paiements.index')
                    ->with('error', 'Le paiement a été annulé ou refusé. Veuillez réessayer.');
            }

            return redirect()->route('paiements.index')
                ->with('info', 'Paiement en cours de traitement...');

        } catch (\Exception $e) {
            Log::error('Erreur callback FedaPay locataire: ' . $e->getMessage());
            return redirect()->route('paiements.index')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }

    /**
     * Télécharger le reçu de paiement
     */
    public function downloadReceipt(Payment $payment)
    {
        $user = Auth::user();
        
        // Vérifier que le paiement appartient au locataire connecté
        if (!$user->isLocataire() || $payment->user_id !== $user->id) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que le paiement est payé
        if ($payment->statut !== 'paye') {
            return back()->with('error', 'Le reçu n\'est disponible que pour les paiements effectués.');
        }

        // Générer le PDF du reçu
        $pdf = PDF::loadView('locataire.payments.receipt', [
            'payment' => $payment,
            'user' => $payment->user,
            'property' => $payment->property
        ]);

        return $pdf->download("recu-paiement-{$payment->reference}.pdf");
    }

    private function configureFedaPay(): void
    {
        $secretKey = trim((string) config('services.fedapay.secret_key'));
        $environment = Str::lower(trim((string) config('services.fedapay.env', 'sandbox')));

        if ($secretKey === '') {
            throw new Exception('La clé secrète FedaPay est absente.');
        }

        FedaPay::setApiKey($secretKey);
        FedaPay::setEnvironment($environment ?: 'sandbox');
    }

    private function formatFedaPayErrorMessage(\Exception $exception): string
    {
        $message = $exception->getMessage();

        if ($exception instanceof FedaPayError && $exception->hasErrors()) {
            $errors = collect($exception->getErrors())
                ->flatten()
                ->filter()
                ->implode(' ');

            if ($errors !== '') {
                return 'Erreur FedaPay: ' . $errors;
            }
        }

        if (Str::contains(Str::lower($message), 'auth')) {
            return 'Authentification FedaPay échouée. Vérifiez FEDAPAY_SECRET_KEY et FEDAPAY_ENV dans le fichier .env.';
        }

        return 'Erreur FedaPay: ' . $message;
    }
}
