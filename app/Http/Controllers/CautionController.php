<?php

namespace App\Http\Controllers;

use App\Models\Caution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CautionPaymentMail;
use PDF;
use Illuminate\Support\Facades\Log;

class CautionController extends Controller
{
    // public function index()
    // {
    //     $cautions = Caution::with('user', 'property')
    //         ->latest()
    //         ->get();

    //     return view('cautions.index', compact('cautions'));
    // }


        public function index()
        {
            $cautions = Caution::with('user')
                ->latest()
                ->get();

            // Calcul du total de toutes les cautions
            $totalCautions = $cautions->sum('total_caution');

            // Calcul des cautions du mois en cours
            $debutMois = now()->startOfMonth();
            $finMois = now()->endOfMonth();

            $cautionsCeMois = $cautions->filter(function($caution) use ($debutMois, $finMois) {
                return $caution->date_paiement >= $debutMois &&
                    $caution->date_paiement <= $finMois;
            })->sum('total_caution');

            return view('cautions.index', compact('cautions', 'totalCautions', 'cautionsCeMois'));
        }

    public function create()
    {
        $users = User::whereHas('property')->get();
        return view('cautions.create', compact('users'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'payer_eau' => 'nullable|boolean',
    //         'payer_electricite' => 'nullable|boolean',
    //         'methode' => 'required|string',
    //         'operateur' => 'nullable|string',
    //         'numero_transaction' => 'nullable|string',
    //         'date_paiement' => 'required|date',
    //     ]);

    //     $user = User::findOrFail($request->user_id);

    //     if (!$user->property) {
    //         return back()->withErrors('Ce locataire n’a pas de chambre assignée.');
    //     }

    //     $cautionChambre = 60000;
    //     $cautionEau = $request->payer_eau ? 10000 : 0;
    //     $cautionElectricite = $request->payer_electricite ? 10000 : 0;

    //     $total = $cautionChambre + $cautionEau + $cautionElectricite;

    //     $caution = Caution::create([
    //         'user_id' => $user->id,
    //         'property_id' => $user->property->id,
    //         'caution_chambre' => $cautionChambre,
    //         'caution_eau' => $cautionEau,
    //         'caution_electricite' => $cautionElectricite,
    //         'total_caution' => $total,
    //         'methode' => $request->methode,
    //         'operateur' => $request->operateur,
    //         'numero_transaction' => $request->numero_transaction,
    //         'date_paiement' => $request->date_paiement,
    //         'statut' => 'paye',
    //     ]);

    //     Mail::to($user->email)->send(new CautionPaymentMail($caution));

    //     return redirect()->route('cautions.index')
    //         ->with('success', 'Paiement de caution enregistré avec succès.');
    // }



    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'caution_chambre' => 'required|numeric|min:0',
        'caution_eau' => 'required|numeric|min:0',
        'caution_electricite' => 'required|numeric|min:0',
        'total_caution' => 'nullable|numeric|min:0',
        'methode' => 'required|string',
        'date_paiement' => 'required|date',
    ]);

    $user = User::with('property')->findOrFail($request->user_id);

    // 🔒 Sécurité : le locataire doit avoir une propriété
    if (!$user->property) {
        return back()->withErrors([
            'user_id' => 'Ce locataire n’a pas de propriété assignée.'
        ]);
    }

    // 🔒 Éviter double paiement
    if (Caution::where('user_id', $user->id)->exists()) {
        return back()->with('error','La caution de ce locataire a déjà été payée.');
    }

    $total =$request->caution_chambre +($request->caution_eau ?? 0) +($request->caution_electricite ?? 0);

    $caution = Caution::create([
        'user_id' => $user->id,
        'property_id' => $user->property->id,
        'caution_chambre' => $request->caution_chambre,
        'caution_eau' => $request->caution_eau ?? 0,
        'caution_electricite' => $request->caution_electricite ?? 0,
        'total_caution' => $total,
        'methode' => $request->methode,
        'date_paiement' => $request->date_paiement,
        'statut' => 'paye',
    ]);

    // 📧 Mail de confirmation
    // Mail::to($user->email)->send(new CautionPaymentMail($caution));
    try {
            Mail::to($user->email)->send(new CautionPaymentMail($caution));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email confirmation: ' . $e->getMessage());
        }


    return redirect()->route('cautions.index')
        ->with('success', 'Caution enregistrée avec succès reçu envoyé par mail au locataire.');
}



    public function show(Caution $caution)
    {
        return view('cautions.show', compact('caution'));
    }

    public function downloadReceipt(Caution $caution)
    {
        if (Auth::id() !== $caution->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $pdf = PDF::loadView('cautions.receipt', compact('caution'));

        return $pdf->download('recu_caution_' . $caution->reference . '.pdf');
    }

    public function verify($token)
    {
        $caution = Caution::where('verification_token', $token)->firstOrFail();
        return view('cautions.verify', compact('caution'));
    }
}
