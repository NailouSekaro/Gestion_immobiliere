<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['user', 'property'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        $locataires = User::where('role', 'locataire')
            ->whereHas('property')
            ->with('property')
            ->get();

        $properties = Property::libres()->get();

        return view('admin.contracts.create', compact('locataires', 'properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'date_debut' => 'required|date',
            'duree_mois' => 'required|integer|min:1|max:36',
            'loyer_mensuel' => 'required|numeric|min:0',
            'caution' => 'nullable|numeric|min:0',
            'termes' => 'nullable|string',
            'clauses_speciales' => 'nullable|array'
        ]);

        // Vérifier que le locataire n'a pas déjà un contrat actif pour cette propriété
        $existingContract = Contract::where('user_id', $request->user_id)
            ->where('property_id', $request->property_id)
            ->where('statut', 'actif')
            ->first();

        if ($existingContract) {
            return back()->withErrors(['user_id' => 'Ce locataire a déjà un contrat actif pour cette propriété.']);
        }

        $contractData = $request->all();
        $contractData['date_fin'] = \Carbon\Carbon::parse($request->date_debut)
            ->addMonths($request->duree_mois)
            ->subDay();

        $contract = Contract::create($contractData);

        // Générer le PDF
        $contract->genererPdf();

        // Mettre à jour le statut de la propriété
        $property = Property::find($request->property_id);
        $property->update(['statut' => 'occupé']);

        return redirect()->route('contracts.show', $contract)
            ->with('success', 'Contrat créé avec succès. Le PDF a été généré.');
    }

    public function show(Contract $contract)
    {
        $contract->load(['user', 'property']);
        return view('admin.contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $locataires = User::where('role', 'locataire')->get();
        $properties = Property::all();

        return view('admin.contracts.edit', compact('contract', 'locataires', 'properties'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'duree_mois' => 'required|integer|min:1|max:36',
            'loyer_mensuel' => 'required|numeric|min:0',
            'caution' => 'nullable|numeric|min:0',
            'termes' => 'nullable|string',
            'clauses_speciales' => 'nullable|array',
            'statut' => 'required|in:actif,expire,resilie,avenant'
        ]);

        $contractData = $request->all();
        $contractData['date_fin'] = \Carbon\Carbon::parse($request->date_debut)
            ->addMonths($request->duree_mois)
            ->subDay();

        $contract->update($contractData);

        // Regénérer le PDF si nécessaire
        if ($request->regenerer_pdf) {
            $contract->genererPdf();
        }

        return redirect()->route('contracts.show', $contract)
            ->with('success', 'Contrat mis à jour avec succès.');
    }

    public function destroy(Contract $contract)
    {
        // Supprimer le fichier PDF
        if ($contract->fichier_pdf) {
            Storage::disk('public')->delete($contract->fichier_pdf);
        }

        $contract->delete();

        return redirect()->route('contracts.index')
            ->with('success', 'Contrat supprimé avec succès.');
    }

    public function download(Contract $contract)
    {
        if (!$contract->fichier_pdf || !Storage::disk('public')->exists($contract->fichier_pdf)) {
            // Regénérer le PDF s'il n'existe pas
            $contract->genererPdf();
        }

        $filePath = storage_path('app/public/' . $contract->fichier_pdf);
        return response()->download($filePath);
    }

    public function generatePdf(Contract $contract)
    {
        $contract->genererPdf();
        return back()->with('success', 'PDF regénéré avec succès.');
    }

    public function preview(Contract $contract)
    {
        $contract->load(['user', 'property']);

        $pdf = Pdf::loadView('admin.contracts.templates.default', compact('contract'));

        return $pdf->stream('contrat-' . $contract->numero_contrat . '.pdf');
    }

    public function sign(Contract $contract)
    {
        $contract->update([
            'date_signature' => now(),
            'statut' => 'actif'
        ]);

        return back()->with('success', 'Contrat signé avec succès.');
    }

    public function terminate(Contract $contract)
    {
        $contract->update([
            'date_resiliation' => now(),
            'statut' => 'resilie'
        ]);

        // Libérer la propriété
        $contract->property->update(['statut' => 'libre']);

        return back()->with('success', 'Contrat résilié avec succès.');
    }
}
