<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    public function index() {
        $users = User::withTrashed()->latest()->get();
        return view( 'admin.users.index', compact( 'users' ) );
    }

    public function create() {
        return view( 'admin.users.create' );
    }

    // public function store( Request $request )
    // {
    //     $validated = $request->validate( [
    //         'nom' => 'required|string|max:100',
    //         'prenom' => 'required|string|max:100',
    //         'email' => 'required|email|unique:users,email',
    //         'telephone' => 'nullable|string|max:20',
    //         'role' => 'required|in:admin,locataire,prestataire',
    //         'specialite' => 'nullable|required_if:role,prestataire|in:plombier,electricien,technicien',
    //         'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'est_actif' => 'boolean'
    // ] );

    //     // Génération du mot de passe temporaire
    //     $tempPassword = Str::random( 12 );
    //     $validated[ 'password' ] = Hash::make( $tempPassword );
    //     $validated[ 'uuid' ] = Str::uuid();
    //     $validated[ 'est_actif' ] = $request->has( 'est_actif' );

    //     // Gestion de la photo de profil
    //     if ( $request->hasFile( 'photo_profil' ) ) {
    //         $validated[ 'photo_profil' ] = $request->file( 'photo_profil' )->store( 'profiles', 'public' );
    //     }

    //     $user = User::create( $validated );

    //     return redirect()->route( 'users.index' )
    //         ->with( 'success', "Utilisateur créé avec succès. Mot de passe temporaire: $tempPassword" );
    // }

    // public function store( Request $request ) {
    //     $validated = $request->validate( [
    //         'nom' => 'required|string|max:100',
    //         'prenom' => 'required|string|max:100',
    //         'email' => 'required|email|unique:users,email',
    //         'telephone' => 'nullable|string|max:20',
    //         'role' => 'required|in:admin,locataire,prestataire',
    //         'specialite' => 'nullable|required_if:role,prestataire|in:plombier,electricien,technicien',
    //         'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'est_actif' => 'boolean',
    //         'property_id' => 'required|exists:properties,id',
    // ] );

    //     // Génération du mot de passe temporaire
    //     $tempPassword = Str::random( 12 );
    //     $validated[ 'password' ] = Hash::make( $tempPassword );
    //     $validated[ 'uuid' ] = Str::uuid();
    //     $validated[ 'est_actif' ] = $request->has( 'est_actif' );

    //     // Gestion de la photo de profil
    //     if ( $request->hasFile( 'photo_profil' ) ) {
    //         $validated[ 'photo_profil' ] = $request->file( 'photo_profil' )->store( 'profiles', 'public' );
    //     }

    //     $user = User::create( $validated );
    //     if ( $user->property_id ) {
    //         $property = Property::find( $user->property_id );
    //         $property->updateStatut();
    //         // ← Nouvelle méthode
    //     }

    //     $user = User::create( $validated );

    //     // Envoi du mail avec le mot de passe temporaire
    //     try {
    //         Mail::to( $user->email )->send( new UserCreatedMail( $user, $tempPassword ) );

    //         return redirect()->route( 'users.index' )
    //         ->with( 'success', 'Utilisateur créé avec succès. Un email avec le mot de passe temporaire a été envoyé.' );

    //     } catch ( \Exception $e ) {
    //         // Fallback si l'envoi d'email échoue
    //         return redirect()->route( 'users.index' )
    //         ->with( 'success', "Utilisateur créé avec succès. Mot de passe temporaire: $tempPassword" )
    //         ->with( 'warning', "L'email n'a pas pu être envoyé: " . $e->getMessage() );
    //     }
    // }

    public function store( Request $request ) {
        $validated = $request->validate( [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,locataire,prestataire',
            'specialite' => [
                'nullable',
                Rule::requiredIf(fn () => $request->input('role') === 'prestataire'),
                'in:plombier,electricien,technicien',
            ],
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'est_actif' => 'boolean',
            'property_id' => [
                'nullable',
                Rule::requiredIf(fn () => $request->input('role') === 'locataire'),
                'exists:properties,id',
            ],
        ] );

        // Mot de passe temporaire
        $tempPassword = Str::random( 12 );
        $validated[ 'password' ] = Hash::make( $tempPassword );
        $validated[ 'est_actif' ] = $request->has( 'est_actif' );
        $validated[ 'uuid' ] = Str::uuid();
        $validated['property_id'] = $validated['role'] === 'locataire'
            ? ($validated['property_id'] ?? null)
            : null;
        $validated['specialite'] = $validated['role'] === 'prestataire'
            ? ($validated['specialite'] ?? null)
            : null;

        // Photo de profil
        if ( $request->hasFile( 'photo_profil' ) ) {
            $validated[ 'photo_profil' ] = $request->file( 'photo_profil' )
            ->store( 'profiles', 'public' );
        }

        // ✅ UNE SEULE création
        $user = User::create( $validated );

        // Mise à jour du statut de la propriété
        if ( $user->property_id ) {
            $user->property->updateStatut();
        }

        // Email avec mot de passe temporaire
        try {
            Mail::to( $user->email )->send(
                new UserCreatedMail( $user, $tempPassword )
            );

            return redirect()->route( 'users.index' )
            ->with( 'success', 'Utilisateur créé avec succès. Un email avec le mot de passe temporaire a été envoyé.' );

        } catch ( \Exception $e ) {
            return redirect()->route( 'users.index' )
            ->with( 'success', "Utilisateur créé avec succès. Mot de passe temporaire : $tempPassword" )
            ->with( 'warning', "L'email n'a pas pu être envoyé : " . $e->getMessage() );
        }
    }

    public function show( User $user ) {
        return view( 'admin.users.show', compact( 'user' ) );
    }

    public function edit( User $user ) {
        return view( 'admin.users.edit', compact( 'user' ) );
    }

    public function update( Request $request, User $user ) {
        $validated = $request->validate( [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,locataire,prestataire',
            'specialite' => [
                'nullable',
                Rule::requiredIf(fn () => $request->input('role') === 'prestataire'),
                'in:plombier,electricien,technicien',
            ],
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'est_actif' => 'boolean',
            'property_id' => [
                'nullable',
                Rule::requiredIf(fn () => $request->input('role') === 'locataire'),
                'exists:properties,id',
            ],
        ] );

        $validated[ 'est_actif' ] = $request->has( 'est_actif' );
        $validated['property_id'] = $validated['role'] === 'locataire'
            ? ($validated['property_id'] ?? null)
            : null;
        $validated['specialite'] = $validated['role'] === 'prestataire'
            ? ($validated['specialite'] ?? null)
            : null;

        // Gestion de la photo de profil
        if ( $request->hasFile( 'photo_profil' ) ) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo_profil) {
                Storage::disk('public')->delete($user->photo_profil);
            }
            $validated['photo_profil'] = $request->file('photo_profil')->store('profiles', 'public');
        }

        $anciennePropertyId = $user->property_id;

    $user->update($validated);

    // Mettre à jour l'ancienne propriété si elle a changé
            if ( $anciennePropertyId && $anciennePropertyId != $user->property_id ) {
                $ancienneProperty = Property::find( $anciennePropertyId );
                $ancienneProperty->updateStatut();
            }

            // Mettre à jour la nouvelle propriété
            if ( $user->property_id ) {
                $nouvelleProperty = Property::find( $user->property_id );
                $nouvelleProperty->updateStatut();
            }

            return redirect()->route( 'users.index' )
            ->with( 'success', 'Utilisateur mis à jour avec succès' );
        }

        public function destroy( User $user ) {
            $user->delete();
            return redirect()->route( 'users.index' )
            ->with( 'success', 'Utilisateur archivé avec succès' );
        }

        public function restore( $id ) {
            $user = User::withTrashed()->findOrFail( $id );
            $user->restore();

            return redirect()->route( 'users.index' )
            ->with( 'success', 'Utilisateur restauré avec succès' );
        }

        public function forceDelete( $id ) {
            $user = User::withTrashed()->findOrFail( $id );

            // Supprimer la photo de profil
            if ( $user->photo_profil ) {
                Storage::disk( 'public' )->delete( $user->photo_profil );
            }

            $user->forceDelete();

            return redirect()->route( 'users.index' )
            ->with( 'success', 'Utilisateur supprimé définitivement' );
        }

        public function toggleStatus( User $user ) {
            $user->update( [ 'est_actif' => !$user->est_actif ] );

            return response()->json( [
                'status' => 'success',
                'message' => 'Statut mis à jour',
                'est_actif' => $user->est_actif
            ] );
        }
    }
