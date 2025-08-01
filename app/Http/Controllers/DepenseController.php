<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DepenseController extends Controller
{
    /**
     * Affiche toutes les dépenses.
     */
    public function index()
    {
        //$depenses = Depense::orderBy('created_at', 'desc')->get();
        return view('depenses.index', [
            'depenses' => DB::table('depenses')->whereDate('created_at', now())->get()
        ]);
    }

    /**
     * Affiche le formulaire de création d’une dépense.
     */
    public function create()
    {
        return view('depenses.create');
    }

    /**
     * Enregistre une nouvelle dépense.
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'motif' => 'nullable|string',
        ]);

        Depense::create([
            'motif' => $request->motif,
            'montant' => $request->montant,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée avec succès.');
    }

    /**
     * Affiche une seule dépense.
     */
    public function show(Depense $depense)
    {
        return view('depenses.show', compact('depense'));
    }

    /**
     * Formulaire d’édition.
     */
    public function edit(Depense $depense)
    {
        return view('depenses.edit', compact('depense'));
    }

    /**
     * Mise à jour de la dépense.
     */
    public function update(Request $request, Depense $depense)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'motif' => 'nullable|string|max:255',
        ]);

        $depense->update([
            'montant' => $request->montant,
            'motif' => $request->motif,
        ]);

        return redirect()->route('depenses.index')->with('success', 'Dépense mise à jour.');
    }

    /**
     * Suppression de la dépense.
     */
    public function destroy(Depense $depense)
    {
        $depense->delete();
        return redirect()->back()->with('success', 'Dépense supprimée.');
    }
}
