<?php

namespace App\Http\Controllers;
use App\Models\ConsommationEau;
use App\Models\PaiementEau;
use Illuminate\Http\Request;
use App\Mail\PaiementEauMail;
use Illuminate\Support\Facades\Mail;

class PaiementEauController extends Controller
{
    // public function store( Request $request, ConsommationEau $consommation ) {
    //     $request->validate( [
    //         'montant_paye' => 'required|numeric|min:0',
    //         'methode' => 'required|string',
    //         'date_paiement' => 'required|date',
    //     ] );

    //     if ( $consommation->statut === 'paye' ) {
    //         return back()->with( 'error', 'Déjà payé.' );
    //     }

    //     PaiementEau::create( [
    //         'consommation_eau_id' => $consommation->id,
    //         'montant_paye' => $request->montant_paye,
    //         'methode' => $request->methode,
    //         'date_paiement' => $request->date_paiement,
    //     ] );

    //     $consommation->update( [ 'statut' => 'paye' ] );

    //     Mail::to( $consommation->user->email )
    //     ->send( new PaiementEauMail( $consommation ) );

    //     return back()->with( 'success', 'Paiement enregistré.' );
    // }



    public function store(Request $request, ConsommationEau $consommationEau)
    {
        $request->validate([
            'montant_paye' => 'required|numeric|min:0',
            'methode' => 'required|string',
            'date_paiement' => 'required|date',
        ]);

        if ($consommationEau->statut === 'paye') {
            return back()->with('error', 'Déjà payé.');
        }

        PaiementEau::create([
            'consommation_eau_id' => $consommationEau->id,
            'montant_paye' => $request->montant_paye,
            'methode' => $request->methode,
            'date_paiement' => $request->date_paiement,
        ]);

        $consommationEau->update(['statut' => 'paye']);

        Mail::to($consommationEau->user->email)
            ->send(new PaiementEauMail($consommationEau));

        return back()->with('success', 'Paiement enregistré et un reçu de paiement a été envoyé au locataire.');
    }

}
