<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class DepenseController extends Controller implements HasMiddleware
{
    /**
     * Affiche toutes les dépenses.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-depense', only: ['index', 'show']),
            new Middleware('permission:add-depense', only: ['create', 'store']),
            new Middleware('permission:edit-depense', only: ['edit', 'update']),
            new Middleware('permission:delete-depense', only: ['destroy']),
        ];
    }


    public function index()
    {
        
        $depenses = DB::table('depenses')->whereDate('created_at', now())->get();
        $total_depenses = $depenses->sum('montant');
        return view('depenses.index', [
            'depenses' => $depenses,
            'total_depense' => $total_depenses
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

    public function all_depenses(Request $request){
        
        $depenses = DB::table('depenses')->get();
        
        if ($request->date) {
            $depenses = DB::table('depenses')->whereDate('depenses.created_at', $request->date)->get();
        }

        return view('depenses.all_depenses', [
            'depenses' => $depenses,
        ]);
    }
}
