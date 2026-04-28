<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Payment;
use App\Models\Caution;
use App\Models\ConsommationEau;
use App\Models\User;
use App\Models\Property;
use App\Models\Travail;
use Carbon\Carbon;


class DashboardController extends Controller {
    // public function index()
    // {
    //     if ( Auth::check() && is_null( Auth::user()->password_changed_at ) ) {
    //         return redirect()->route( 'password.reset.form' );
    //     }

    //     return view( 'dashboard' );
    // }

    public function index() {
        $user = Auth::user();

        if ( is_null( $user->password_changed_at ) ) {
            return redirect()->route( 'password.reset.form' );
        }

        if ( $user->role === 'locataire' ) {

            $user->load( 'property' );

            // Dernier paiement de loyer
            $dernierPaiement = Payment::where( 'user_id', $user->id )
            ->where( 'statut', 'paye' )
            ->orderByDesc( 'mois_paye' )
            ->first();

            // Caution
            $caution = Caution::where( 'user_id', $user->id )->first();

            // Dernière facture d’eau
            $derniereEau = ConsommationEau::where( 'user_id', $user->id )
            ->latest()
            ->first();

            return view( 'locataire.dashboard', compact(
                'user',
                'dernierPaiement',
                'caution',
                'derniereEau'
            ) );
        }

        if ( $user->role === 'prestataire' ) {

        $travaux = Travail::with(['property', 'depenses'])
            ->where('prestataire_id', $user->id)
            ->latest()
            ->get();

        $totalTravaux = $travaux->count();

        $totalDepenses = $travaux->sum(function ($travail) {
            return $travail->depenses->sum('montant');
        });

        return view('prestataire.dashboard', compact(
            'travaux',
            'totalTravaux',
            'totalDepenses'
        ));
            return view( 'prestataire.dashboard' );
        }

        $propertiesCount = Property::count();

        $tenantsCount = User::where('role', 'locataire')
            ->where('est_actif', true)
            ->count();

        $rentCollected = Payment::where('statut', 'paye')->sum('montant');

        $maintenanceCount = Travail::count();

        return view('dashboard', compact(
            'propertiesCount',
            'tenantsCount',
            'rentCollected',
            'maintenanceCount'
        ));

        // return view( 'dashboard' );
        // admin
    }

    public function showResetForm() {
        return view( 'auth.force-reset' );
    }

    public function reset( Request $request ) {
        $request->validate( [
            'current_password' => [ 'required', 'current_password' ],
            'new_password'     => [
                'required',
                'confirmed',
                'min:12',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            ],
        ], [
            'current_password.required' => 'Veuillez entrer votre mot de passe actuel.',
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'new_password.confirmed'    => 'La confirmation ne correspond pas.',
            'new_password.min'          => 'Le mot de passe doit contenir au moins 12 caractères.',
            'new_password.regex'        => 'Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.',
        ] );

        $user = Auth::user();
        // $user->update( [
        //     'password'=> Hash::make( $request->new_password ),
        //     'password_changed_at'=> now(),
        // ] );
        $user->password = Hash::make( $request->input( 'new_password' ) );
        $user->password_changed_at = now();
        // Mettez à jour la date du changement de mot de passe
        $user->save();

        // dd( session()->all() );

        return redirect( route( 'dashboard' ) )->with( 'success', 'Votre mot de passe a été changé avec succès.' );
    }
}
