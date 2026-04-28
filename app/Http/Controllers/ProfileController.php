<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire d’édition du profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Mettre à jour le profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
            'photo_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Mot de passe optionnel
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        /* 🔐 Vérification de l’ancien mot de passe */
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Mot de passe actuel incorrect.'
                ]);
            }

            $user->password = Hash::make($request->new_password);
        }

        /* 🖼️ Gestion photo de profil */
        if ($request->hasFile('photo_profil')) {
            // Supprimer l’ancienne photo
            if ($user->photo_profil) {
                Storage::disk('public')->delete($user->photo_profil);
            }

            $user->photo_profil = $request
                ->file('photo_profil')
                ->store('profiles', 'public');
        }

        /* 📝 Mise à jour infos */
        $user->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'] ?? null,
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
