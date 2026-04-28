<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\ConsommationEau;
use App\Mail\FactureEauMail;
use PDF;

class ConsommationEauController extends Controller {
    // public function create() {
    //     $users = User::whereNotNull( 'property_id' )->get();
    //     return view( 'consommations_eau.create', compact( 'users' ) );
    // }


    public function create()
    {
        $users = User::whereNotNull('property_id')
            ->with([
                'property',
                'consommationsEau' => function ($q) {
                    $q->latest()->limit(1);
                }
            ])
            ->get();

        return view('consommations_eau.create', compact('users'));
    }



    //     public function index()
    // {
    //     $consommations = ConsommationEau::with( [
    //         'user',
    //         'property',
    //         'paiementEau'
    // ] )
    //     ->orderBy( 'periode_fin', 'desc' )
    //     ->get();

    //     return view( 'consommations_eau.index', compact( 'consommations' ) );
    // }


    // public function create()
    // {
    //     $users = User::with(['property', 'consommationsEau' => function($query) {
    //         $query->orderBy('periode_fin', 'desc')->first();
    //     }])->get();

    //     // Ajouter le dernier index d'eau pour chaque utilisateur
    //     $users = $users->map(function($user) {
    //         $lastConsumption = $user->consommationsEau->first();
    //         $user->lastWaterIndex = $lastConsumption ? $lastConsumption->index_compteur : 0;
    //         return $user;
    //     });

    //     return view('consommations_eau.create', compact('users'));
    // }

    public function index() {
        $consommations = ConsommationEau::with( [
            'user',
            'property',
            'paiementEau'
        ] )
        ->orderBy( 'periode_fin', 'desc' )
        ->get();

        // Calcul des statistiques
        $totalConsumption = $consommations->sum( 'consommation' );
        $totalAmount = $consommations->sum( 'montant' );
        $paidCount = $consommations->where( 'statut', 'paye' )->count();
        $unpaidCount = $consommations->where( 'statut', 'non_paye' )->count();

        // Alternative si votre champ de statut est différent
        // Si vous avez un système de paiement lié, vous pouvez aussi faire :
        // $paidCount = $consommations->filter( fn( $c ) => $c->paiementEau && $c->paiementEau->statut === 'payé' )->count();

        return view( 'consommations_eau.index', compact(
            'consommations',
            'totalConsumption',
            'totalAmount',
            'paidCount',
            'unpaidCount'
        ) );
    }

    public function store( Request $request ) {
        $request->validate( [
            'user_id' => 'required|exists:users,id',
            'index_compteur' => 'required|numeric|min:0',
            'periode_debut' => 'nullable|date',
            'periode_fin' => 'nullable|date|after_or_equal:periode_debut',
        ] );

        $user = User::with( 'property' )->findOrFail( $request->user_id );

        $last = ConsommationEau::where( 'user_id', $user->id )
        ->latest()
        ->first();

        $indexPrecedent = $last ? $last->index_compteur : 0;

        if ( $request->index_compteur < $indexPrecedent ) {
            return back()->withErrors( [
                'index_compteur' => 'Index inférieur au précédent.'
            ] );
        }

        $consommation = $request->index_compteur - $indexPrecedent;
        $montant = $consommation * 550;

        $consommationEau = ConsommationEau::create( [
            'user_id' => $user->id,
            'property_id' => $user->property->id,
            'index_precedent' => $indexPrecedent,
            'index_compteur' => $request->index_compteur,
            'consommation' => $consommation,
            'montant' => $montant,
            'periode_debut' => $request->periode_debut,
            'periode_fin' => $request->periode_fin,
        ] );

        Mail::to( $user->email )
        ->send( new FactureEauMail( $consommationEau ) );

        return redirect()->route( 'consommations-eau.index' )
        ->with( 'success', 'Consommation enregistrée et facture envoyée.' );
    }

    public function facture( ConsommationEau $consommationEau ) {
        $pdf = PDF::loadView(
            'consommations_eau.facture',
            compact( 'consommationEau' )
        );

        return $pdf->download( 'facture-eau-'.$consommationEau->id.'.pdf' );
    }

        //     public function facture(ConsommationEau $consommation)
        // {
        //     $consommation->load(['user', 'property', 'paiementEau']);

        //     $pdf = PDF::loadView('consommations_eau.facture', [
        //         'consommationEau' => $consommation
        //     ]);

        //     return $pdf->download(
        //         'facture-eau-' . $consommation->id . '.pdf'
        //     );
        // }


    // public function show( ConsommationEau $consommationEau )
    // {
    //     $consommationEau->load( [
    //         'user',
    //         'property',
    //         'paiementEau',

    // ] );

    //     return view( 'consommations_eau.show', compact( 'consommationEau' ) );
    // }

    public function show( ConsommationEau $consommationEau ) {
        $consommationEau->load( [
            'user',
            'property',
            'paiementEau'
        ] );

        // Calculer le montant si nécessaire ( optionnel )
        if ( !$consommationEau->montant ) {
            $consommationEau->montant = ( $consommationEau->index_compteur - $consommationEau->index_precedent ) * $consommationEau->prix_m3;
        }

        return view( 'consommations_eau.show', compact( 'consommationEau' ) );
    }

}

