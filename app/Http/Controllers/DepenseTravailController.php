<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Travail;

class DepenseTravailController extends Controller
{
    // public function store(Request $request, Travail $travail)
    // {
    //     $request->validate([
    //         'libelle' => 'required|string',
    //         'montant' => 'required|numeric|min:0',
    //         'date_depense' => 'required|date'
    //     ]);

    //     $travail->depenses()->create($request->all());

    //     $travail->recalculerTotal();

    //     return back()->with('success', 'Dépense ajoutée.');
    // }


    public function store(Request $request, Travail $travail)
{
    $request->validate([
        'libelle' => 'required|string|max:255',
        'montant' => 'required|numeric|min:0',
        'date_depense' => 'required|date',
    ]);

    $travail->depenses()->create([
        'libelle' => $request->libelle,
        'montant' => $request->montant,
        'date_depense' => $request->date_depense,
    ]);

    // Mise à jour du total
    $travail->update([
        'total_depense' => $travail->depenses()->sum('montant')
    ]);

    return back()->with('success', 'Dépense ajoutée avec succès.');
}

}
