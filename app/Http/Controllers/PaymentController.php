<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\PaymentConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Exception;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Facades\Log;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use FedaPay\Error\Base as FedaPayError;

class PaymentController extends Controller {
    // public function index()
    // {
    //     $payments = Payment::with( [ 'user', 'property' ] )
    //         ->latest()
    //         ->paginate( 20 );

    //     return view( 'payment.index', compact( 'payments' ) );
    // }

    public function index() {
        $payments = Payment::with( [ 'user', 'property' ] )
        ->orderBy( 'created_at', 'desc' )
        ->paginate( 20 );

        // Statistiques
        $totalPaye = Payment::payes()->sum( 'montant' );
        $enAttente = Payment::enAttente()->count();
        $moisEnCours = Payment::payes()
        ->where( 'mois_paye', date( 'Y-m' ) )
        ->sum( 'montant' );

        return view( 'payment.index', compact( 'payments', 'totalPaye', 'enAttente', 'moisEnCours' ) );
    }

    // public function create() {
    //     $locataires = User::where( 'role', 'locataire' )
    //     ->where( 'est_actif', true )
    //     ->with( 'property' )
    //     ->get();

    //     return view( 'payment.create', compact( 'locataires' ) );
    // }

    //     public function create()
    // {
    //     $locataires = User::where( 'role', 'locataire' )
    //         ->where( 'est_actif', true )
    //         ->whereNotNull( 'property_id' )
    //         ->with( [
    //             'property',
    //             'paiements' => function ( $q ) {
    //                 $q->where( 'statut', 'paye' )
    //                   ->orderByDesc( 'mois_paye' )
    //                   ->limit( 1 );
    //             }
    // ] )
    //         ->get();

    //     return view( 'payment.create', compact( 'locataires' ) );
    // }

    //     public function create()
    // {
    //     $locataires = User::where( 'role', 'locataire' )
    //         ->where( 'est_actif', true )
    //         ->whereNotNull( 'property_id' )
    //         ->with( [
    //             'property',
    //             'paiements' => function ( $q ) {
    //                 $q->where( 'statut', 'paye' )
    //                 ->orderByDesc( 'mois_paye' )
    //                 ->limit( 1 );
    //             }
    // ] )
    //         ->get();

    //     return view( 'payment.create', compact( 'locataires' ) );
    // }

    //     public function create()
    // {
    //     $locataires = User::where( 'role', 'locataire' )
    //         ->where( 'est_actif', true )
    //         ->whereNotNull( 'property_id' )
    //         ->with( [
    //             'property',
    //             'dernierPaiement'
    // ] )
    //         ->get();

    //     return view( 'payment.create', compact( 'locataires' ) );
    // }

    public function create() {
        $locataires = User::where( 'role', 'locataire' )
        ->where( 'est_actif', true )
        ->whereNotNull( 'property_id' )
        ->with( [
            'property',
            'dernierPaiement' // ✅ dernier paiement payé par locataire
        ] )
        ->get();

        return view( 'payment.create', compact( 'locataires' ) );
    }

    public function store( Request $request ) {
        $request->validate( [
            'user_id' => 'required|exists:users,id',
            'mois' => 'required|integer|between:1,12',
            'annee' => 'required|integer|min:2000|max:' . ( now()->year + 5 ),
            'montant' => 'required|numeric|min:0',
            'methode' => 'required|in:mtn_momo,orange_money,wave,feda_pay,virement,especes,autre',
            'operateur' => 'nullable|string|max:50',
            'numero_transaction' => 'nullable|string|max:100',
            'date_paiement' => 'required|date',
            'preuve_paiement' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string'
        ] );

        $user = User::findOrFail( $request->user_id );

        if ( !$user->property ) {
            return back()->withErrors( [ 'user_id' => 'Ce locataire n\'a pas de propriété assignée.']);
        }

        $moisPaye = $request->annee . '-' . str_pad($request->mois, 2, '0', STR_PAD_LEFT);
        $existingPayment = Payment::where('user_id', $user->id)
            ->where('mois_paye', $moisPaye)
            ->first();

        if ($existingPayment && $existingPayment->statut === 'paye') {
            return back()->with('error', "⚠️ Le paiement du mois {$request->mois}/{$request->annee} a déjà été effectué pour ce locataire.");
        }

        $payment = $existingPayment ?: Payment::creerPaiementMensuel(
            $user,
            $user->property,
            $request->mois,
            $request->annee
        );


         // Si c'est FedaPay, initier le paiement en ligne
            if ( $request->methode === 'feda_pay' ) {
                return $this->initiateFedaPayForTenant( $payment, $user, $request->montant );
            }

            // Pour les autres méthodes ( paiement manuel par admin )
            $paymentData = [
                'montant' => $request->montant,
                'methode' => $request->methode,
                'operateur' => $request->operateur,
                'numero_transaction' => $request->numero_transaction,
                'date_paiement' => $request->date_paiement,
                'notes' => $request->notes,
                'statut' => 'paye',
                'paye_le' => now()
            ];

            // Gestion de la preuve de paiement
            if ( $request->hasFile( 'preuve_paiement' ) ) {
                $file = $request->file( 'preuve_paiement' );
                $path = $file->store( 'payments/preuves', 'public' );
                $paymentData[ 'preuve_paiement' ] = $path;
            }

            $payment->update( $paymentData );

            // Envoyer email de confirmation
            try {
                Mail::to( $user->email )->send( new PaymentConfirmationMail( $payment ) );
            } catch ( \Exception $e ) {
                Log::error( 'Erreur envoi email confirmation: ' . $e->getMessage() );
            }

            return redirect()->route( 'payments.index' )
            ->with( 'success', 'Paiement enregistré avec succès. Un email de confirmation a été envoyé au locataire.' );
        }

        /**
        * Initier un paiement FedaPay pour le locataire ( depuis l'admin)
     */
    private function initiateFedaPayForTenant(Payment $payment, User $user, $montant)
    {
        $this->configureFedaPay();

        try {
            $transaction = Transaction::create([
                'description' => "Paiement loyer pour {$user->prenom} {$user->nom} - {$payment->periode}",
                'amount' => (int) round((float) $montant),
                'currency' => ['iso' => config('services.fedapay.currency', 'XOF')],
                'callback_url' => route('payments.fedapay.callback', [
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

            // Mettre à jour le paiement avec l'ID de transaction
        $payment->update( [
            'numero_transaction' => $transaction->id,
            'statut' => 'en_attente',
            'methode' => 'feda_pay',
            'montant' => $montant
        ] );

        // Rediriger vers la page de paiement FedaPay
        return redirect( $token->url );

    } catch ( \Exception $e ) {
        Log::error('Erreur FedaPay: ' . $e->getMessage(), [
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
     * Callback FedaPay après paiement
     */
    public function fedapayCallback(Request $request)
    {
        if (!$request->has('id')) {
            return redirect()->route('payments.index')
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

                // Envoyer email de confirmation
                try {
                    Mail::to($payment->user->email)->send(new PaymentConfirmationMail($payment));
                } catch (\Exception $e) {
                    Log::error('Erreur envoi email: ' . $e->getMessage());
                }

                return redirect()->route('payments.index')
                    ->with('success', 'Paiement confirmé avec succès !');

            } elseif (in_array($transaction->status, ['canceled', 'declined'])) {
                $payment->update(['statut' => 'echec']);

                return redirect()->route('payments.index')
                    ->with('error', 'Le paiement a été annulé ou refusé.');
            }

            return redirect()->route('payments.index')
                ->with('info', 'Paiement en cours de traitement.');

        } catch (\Exception $e) {
            Log::error('Erreur callback FedaPay: ' . $e->getMessage());
            return redirect()->route('payments.index')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }

    public function initiateFedapay(Request $request)
{
    // Validation
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'mois' => 'required|integer|between:1,12',
        'annee' => 'required|integer',
        'montant' => 'required|numeric|min:0'
    ]);

    $user = User::findOrFail($request->user_id);

    if (!$user->property) {
        return back()->withErrors(['user_id' => 'Ce locataire n\'a pas de propriété assignée.']);
    }

    // Vérifier si paiement déjà effectué
    $moisPaye = $request->annee . '-' . str_pad($request->mois, 2, '0', STR_PAD_LEFT);
    $existingPayment = Payment::where('user_id', $user->id)
        ->where('mois_paye', $moisPaye)
        ->where('statut', 'paye')
        ->first();

    if ($existingPayment) {
        return back()->with('error', "⚠️ Le paiement du mois {$request->mois}/{$request->annee} a déjà été effectué.");
    }

    // Créer le paiement
    $payment = Payment::creerPaiementMensuel(
        $user,
        $user->property,
        $request->mois,
        $request->annee
    );

    // Initier FedaPay
    return $this->initiateFedaPayForTenant($payment, $user, $request->montant);
}

    // public function initiateFedapay(Request $request)
    // {
    //     $payment = Payment::findOrFail($request->payment_id);
    //     $user = $payment->user;

    //     return $this->initiateFedaPayForTenant($payment, $user, $request->montant);
    // }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'property']);
        return view('payment.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')
            ->with('success', 'Paiement supprimé avec succès');
    }

    // public function downloadReceipt($id)
    // {
    //     $payment = Payment::with(['user', 'property'])->findOrFail($id);

    //     $pdf = PDF::loadView('locataire.payments.receipt', [
    //         'payment' => $payment,
    //         'user' => $payment->user,
    //         'property' => $payment->property,
    //     ]);

    //     return $pdf->download(
    //         'recu_paiement_' . $payment->reference . '.pdf'
    //     );
    // }



public function downloadReceipt($id)
{
    $payment = Payment::with(['user', 'property'])->findOrFail($id);

    // Sécurité (comme on a déjà fait)
    if (
        auth()->id() !== $payment->user_id &&
        !auth()->user()->hasRole('admin')
    ) {
        abort(403);
    }

    // Génération du QR code ICI (PHP pur)
    $qrCode = QrCode::size(120)->generate(
        route('payments.verify', $payment->verification_token)
    );

    $pdf = PDF::loadView('locataire.payments.receipt', [
        'payment' => $payment,
        'user' => $payment->user,
        'property' => $payment->property,
        'qrCode' => $qrCode, // 👈 on passe le HTML au Blade
    ]);

    return $pdf->download('recu_' . $payment->reference . '.pdf');
}


    public function verify($token)
    {
        $payment = Payment::where('verification_token', $token)->firstOrFail();

        return view('payments.verify', compact('payment' ) );
    }

    public function edit(){

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



//     public function store(Request $request)
// {
//     $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'mois' => 'required|integer|between:1,12',
//         'annee' => 'required|integer|min:2000|max:' . (now()->year + 5),
//         'montant' => 'required|numeric|min:0',
//         'methode' => 'required|in:mtn_momo,orange_money,wave,feda_pay,virement,especes,autre',
//         // ... autres validations
//     ]);

//     $user = User::findOrFail($request->user_id);

//     if (!$user->property) {
//         return back()->withErrors(['user_id' => 'Ce locataire n\'a pas de propriété assignée.']);
//     }

//     // Vérifier si un paiement existe déjà
//     $moisPaye = $request->annee . '-' . str_pad($request->mois, 2, '0', STR_PAD_LEFT);
//     $existingPayment = Payment::where('user_id', $user->id)
//         ->where('mois_paye', $moisPaye)
//         ->where('statut', 'paye')
//         ->first();

//     if ($existingPayment) {
//         return back()->with('error', "⚠️ Le paiement du mois {$request->mois}/{$request->annee} a déjà été effectué pour ce locataire.");
//     } else {
//         // Créer le paiement mensuel de base
//         $payment = Payment::creerPaiementMensuel(
//             $user,
//             $user->property,
//             $request->mois,
//             $request->annee
//         );
//     }

//     // ✅ CORRECTION : Décommenter cette partie
//     if ($request->methode === 'feda_pay') {
//         return $this->initiateFedaPayForTenant($payment, $user, $request->montant);
//     }

//     // Pour les autres méthodes (paiement manuel)
//     $paymentData = [
//         'montant' => $request->montant,
//         'methode' => $request->methode,
//         'operateur' => $request->operateur,
//         'numero_transaction' => $request->numero_transaction,
//         'date_paiement' => $request->date_paiement,
//         'notes' => $request->notes,
//         'statut' => 'paye',
//         'paye_le' => now()
//     ];

//     // Gestion de la preuve de paiement
//     if ($request->hasFile('preuve_paiement')) {
//         $file = $request->file('preuve_paiement');
//         $path = $file->store('payments/preuves', 'public');
//         $paymentData['preuve_paiement'] = $path;
//     }

//     $payment->update($paymentData);

//     // Envoyer email de confirmation
//     try {
//         Mail::to($user->email)->send(new PaymentConfirmationMail($payment));
//     } catch (\Exception $e) {
//         Log::error('Erreur envoi email confirmation: ' . $e->getMessage());
//     }

//     return redirect()->route('payments.index')
//         ->with('success', 'Paiement enregistré avec succès. Un email de confirmation a été envoyé au locataire.');
// }

// private function initiateFedaPayForTenant(Payment $payment, User $user, $montant)
// {
//     FedaPay::setApiKey(config('services.fedapay.secret_key'));
//     FedaPay::setEnvironment(config('services.fedapay.env'));

//     try {
//         $transaction = Transaction::create([
//             'description' => "Paiement loyer pour {$user->prenom} {$user->nom} - {$payment->periode}",
//             'amount' => $montant,
//             'currency' => ['iso' => config('services.fedapay.currency', 'XOF')],
//             // ✅ CORRECTION : Nom correct de la route
//             'callback_url' => route('payments.fedapay.callback', [
//                 'payment_id' => $payment->id
//             ]),
//             'customer' => [
//                 'firstname' => $user->prenom,
//                 'lastname' => $user->nom,
//                 'email' => $user->email,
//                 'phone_number' => [
//                     'number' => $user->telephone ?? '',
//                     'country' => 'bj'
//                 ]
//             ]
//         ]);

//         // ✅ CORRECTION : Générer le token
//         $token = $transaction->generateToken();

//         // Mettre à jour le paiement avec l'ID de transaction
//         $payment->update([
//             'numero_transaction' => $transaction->id,
//             'statut' => 'pending',
//             'methode' => 'feda_pay',
//             'montant' => $montant
//         ]);

//         // Rediriger vers la page de paiement FedaPay
//         return redirect($token->url);

//     } catch (\Exception $e) {
//         Log::error('Erreur FedaPay: ' . $e->getMessage());
//         return back()->withErrors(['fedapay' => 'Erreur lors de l\'initiation du paiement. Réessayez.']);
//     }
// }

// public function fedapayCallback(Request $request)
// {
//     if (!$request->has('id')) {
//         return redirect()->route('payments.index') // ✅ CORRECTION : pluriel
//             ->with('error', 'ID de transaction introuvable.');
//     }

//     $payment = Payment::findOrFail($request->payment_id);

//     FedaPay::setApiKey(config('services.fedapay.secret_key'));
//     FedaPay::setEnvironment(config('services.fedapay.env'));

//     try {
//         // Récupérer le statut de la transaction FedaPay
//         $transaction = Transaction::retrieve($request->id);

//         if ($transaction->status === 'approved') {
//             $payment->update([
//                 'statut' => 'paye',
//                 'paye_le' => now(),
//                 'date_paiement' => now(),
//                 'numero_transaction' => $transaction->id,
//             ]);

//             // Envoyer email de confirmation
//             try {
//                 Mail::to($payment->user->email)->send(new PaymentConfirmationMail($payment));
//             } catch (\Exception $e) {
//                 Log::error('Erreur envoi email: ' . $e->getMessage());
//             }

//             return redirect()->route('payments.index') // ✅ CORRECTION : pluriel
//                 ->with('success', 'Paiement confirmé avec succès !');

//         } elseif (in_array($transaction->status, ['canceled', 'declined'])) {
//             $payment->update(['statut' => 'echec']);

//             return redirect()->route('payments.index') // ✅ CORRECTION : pluriel
//                 ->with('error', 'Le paiement a été annulé ou refusé.');
//         }

//         return redirect()->route('payments.index') // ✅ CORRECTION : pluriel
//             ->with('info', 'Paiement en cours de traitement.');

//     } catch (\Exception $e) {
//         Log::error('Erreur callback FedaPay: ' . $e->getMessage());
//         return redirect()->route('payments.index') // ✅ CORRECTION : pluriel
//             ->with('error', 'Erreur lors de la vérification du paiement.');
//     }
// }


}
