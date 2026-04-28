<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Travail;
use App\Models\Property;
use App\Models\User;

class TravailController extends Controller
{
    public function index()
    {
        $travaux = Travail::with('property')->latest()->get();
        return view('travaux.index', compact('travaux'));
    }

    public function create()
    {
        $properties = Property::all();
        $prestataires = User::where('role', 'prestataire')
        ->where('est_actif', true)
        ->orderBy('nom')
        ->get();
        return view('travaux.create', compact('properties', 'prestataires'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'property_id' => 'required|exists:properties,id',
    //         'type_travail' => 'required|string',
    //         'date_travail' => 'required|date',
    //     ]);

    //     Travail::create($request->all());

    //     return redirect()->route('travaux.index')
    //         ->with('success', 'Travail enregistré avec succès.');
    // }



    public function store(Request $request)
{
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'prestataire_id' => 'nullable|exists:users,id',
        'type_travail' => 'required|string|max:255',
        'date_travail' => 'required|date',
        'description' => 'nullable|string',
    ]);

    Travail::create([
        'property_id' => $request->property_id,
        'prestataire_id' => $request->prestataire_id,
        'type_travail' => $request->type_travail,
        'description' => $request->description,
        'date_travail' => $request->date_travail,
    ]);

    return redirect()->route('travaux.index')
        ->with('success', 'Travail enregistré avec succès.');
}


    public function show(Travail $travail)
    {
        $travail->load('property', 'depenses');
        return view('travaux.show', compact('travail'));
    }
}
