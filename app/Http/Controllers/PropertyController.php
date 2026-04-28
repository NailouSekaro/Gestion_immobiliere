<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('locataireActuel')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'nullable|string|max:255',
            'adresse' => 'required|string|max:500',
            'ville' => 'required|string|max:100',
            'type' => 'required|in:maison,appartement,studio,bureau',
            'nombre_pieces' => 'required|integer|min:1',
            'surface' => 'required|numeric|min:1',
            'loyer_mensuel' => 'required|numeric|min:0',
            'caution' => 'nullable|numeric|min:0',
            'date_disponibilite' => 'required|date',
            'caracteristiques' => 'nullable|array',
            'notes' => 'nullable|string'
        ]);

        $property = Property::create($request->all());

        return redirect()->route('properties.index')
            ->with('success', 'Propriété créée avec succès.');
    }

    // public function show(Property $property)
    // {
    //     $property->load('locataireActuel', 'locataires', 'paiements');

    //     return view('properties.show', compact('property'));
    // }

    public function show(Property $property)
    {
        $property->load('locataireActuel', 'locataires', 'paiements');

        $locatairesSansPropriete = User::where('role', 'locataire')
            ->where(function($query) {
                $query->whereNull('property_id')
                    ->orWhere('property_id', '');
            })
            ->where('est_actif', true)
            ->get();

        return view('properties.show', compact('property', 'locatairesSansPropriete'));
    }

    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'nom' => 'nullable|string|max:255',
            'adresse' => 'required|string|max:500',
            'ville' => 'required|string|max:100',
            'type' => 'required|in:maison,appartement,studio,bureau',
            'nombre_pieces' => 'required|integer|min:1',
            'surface' => 'required|numeric|min:1',
            'loyer_mensuel' => 'required|numeric|min:0',
            'caution' => 'nullable|numeric|min:0',
            'date_disponibilite' => 'required|date',
            'statut' => 'required|in:libre,occupé,maintenance',
            'caracteristiques' => 'nullable|array',
            'notes' => 'nullable|string'
        ]);

        $property->update($request->all());

        return redirect()->route('properties.index')
            ->with('success', 'Propriété mise à jour avec succès.');
    }

    public function destroy(Property $property)
    {
        // Vérifier s'il y a des locataires
        if ($property->locataires()->exists()) {
            return redirect()->route('properties.index')
                ->with('error', 'Impossible de supprimer une propriété avec des locataires.');
        }

        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Propriété supprimée avec succès.');
    }

    // Assigner un locataire à une propriété
    public function assignLocataire(Request $request, Property $property)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);

        // Vérifier que l'utilisateur est un locataire
        if ($user->role !== 'locataire') {
            return back()->withErrors(['user_id' => 'Seuls les locataires peuvent être assignés à une propriété.']);
        }

        // Vérifier que la propriété est libre
        if ($property->statut !== 'libre') {
            return back()->withErrors(['property' => 'Cette propriété n\'est pas disponible.']);
        }

        DB::transaction(function () use ($user, $property) {
        // Libérer l'ancienne propriété si existante
        if ($user->property_id) {
            $ancienneProperty = Property::find($user->property_id);
            $user->update(['property_id' => null]);
            $ancienneProperty->updateStatut(); // ← Mettre à jour le statut
        }

        // Assigner la nouvelle propriété
        $user->update(['property_id' => $property->id]);
        $property->updateStatut(); // ← Mettre à jour le statut
    });

    return redirect()->route('properties.show', $property)
        ->with('success', 'Locataire assigné avec succès.');

    }

    // Libérer une propriété
    public function liberer(Property $property)
    {
        if ($property->statut !== 'occupé') {
            return back()->with('error', 'Cette propriété n\'est pas occupée.');
        }

        DB::transaction(function () use ($property) {
            // Libérer le locataire
            $property->locataireActuel->update(['property_id' => null]);

            // Libérer la propriété
            $property->update(['statut' => 'libre']);
        });

        return redirect()->route('properties.show', $property)
            ->with('success', 'Propriété libérée avec succès.');
    }
}
