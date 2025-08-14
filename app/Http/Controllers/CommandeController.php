<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Personne;
use App\Models\Depense;
use App\Models\User;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;





class CommandeController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-commande', only: ['index', 'show']),
            new Middleware('permission:add-commande', only: ['create', 'store']),
            new Middleware('permission:edit-commande', only: ['edit', 'update']),
            new Middleware('permission:delete-commande', only: ['destroy']),
        ];
    }


    public function index()
    {
        //dd($request->all());
$all = DB::table('commandes')
    ->join('users', 'commandes.user_id', '=', 'users.user_id')
    ->join('clients', 'commandes.client_id', '=', 'clients.client_id')
    ->join('personnes as p1', 'p1.personne_id', '=', 'clients.personne_id') // client
    ->join('personnes as p2', 'p2.personne_id', '=', 'users.personne_id')   // user
    ->select(
        'commandes.*',
        'p1.*',
        'p2.first_name as user_first_name',
        'p2.name as user_name',
        'users.*',
        'clients.*'
    )
    ->whereDate('commandes.dateCommande', now())
    ->get();

        $totalCommandes = $all->sum('prix_total');


        //dd($all);
        $user = Auth::user()->personne;
        return view('commandes.index',[
            'commandes'=>$all,
            'tatal_commandes'=>$totalCommandes,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ctl = DB::table('personnes')->join('clients', 'personnes.personne_id', 'clients.personne_id')->select('personnes.*','clients.*')->get();
        return view('commandes.create',[
            'produits' => Produit::where('quantiteStock', '>', 0)->orderBy('libelle', 'asc')->get(),
            'clients'=> $ctl,


        ]);
    }


public function store(Request $request)
{
    //dd($request->all());

    $request->validate([
        'client_id' => 'required|exists:clients,client_id',
        'qte' => 'required|array|min:1',
        'qte.*' => 'required|integer|min:1',
        'id_prod' => 'required|array|min:1',
        'id_prod.*' => 'required|exists:produits,produit_id',
        'value_total' => 'required|numeric|min:1'
    ], [
        'client_id.required' => 'Veuillez sélectionner ou ajouter un client s’il n’existe pas dans la base.',
        'client_id.exists' => 'Le client sélectionné est invalide.',
        'qte.required' => 'Veuillez ajouter au moins un produit.',
        'qte.min' => 'Veuillez ajouter au moins un produit.',
        'qte.*.required' => 'La quantité est requise pour chaque produit.',
        'qte.*.integer' => 'Chaque quantité doit être un nombre entier.',
        'qte.*.min' => 'Chaque quantité doit être d’au moins 1.',
        'id_prod.required' => 'Veuillez ajouter au moins un produit.',
        'id_prod.*.exists' => 'Un des produits sélectionnés n’existe pas.',
        'value_total.required' => 'Le total de la commande est requis.',
        'value_total.numeric' => 'Le total de la commande doit être un nombre.',
        'value_total.min' => 'Le total de la commande doit être supérieur à zéro.'
    ]);

    try {
        DB::beginTransaction();

        $commande = Commande::create([
            'dateCommande' => now(),
            'prix_total' => $request->value_total,
            'user_id' =>  Auth::user()->user_id,
            'client_id' => $request->client_id,
        ]);

        $quantites = [];
        foreach ($request->id_prod as $index => $id) {
            $quantites[$id] = ($quantites[$id] ?? 0) + $request->qte[$index];
        }

        //dd($prix_achat);

        foreach ($request->id_prod as $index => $produit_id) {
    $qte = $request->qte[$index];
    $prix_unitaire = $request->id_prix_achat[$index];

    $produit = Produit::find($produit_id);

    if (!$produit) {
        continue;
    }

    if ($produit->quantiteStock < $qte) {
        DB::rollBack();
        return back()->withErrors(['stock' => "Stock insuffisant pour le produit : {$produit->libelle}"]);
    }

    LigneCommande::create([
        'commande_id' => $commande->commande_id,
        'produit_id' => $produit_id,
        'quantite' => $qte,
        'prix_ligne' => $prix_unitaire * $qte,
    ]);

    $produit->update([
        'quantiteStock' => $produit->quantiteStock - $qte
    ]);
}

        DB::commit();
        return redirect()->route('commandes.index')->with('success', 'Commande enregistrée avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Une erreur est survenue lors de l’enregistrement de la commande.']);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        $all= DB::table('ligne_commandes')->join('produits', 'ligne_commandes.produit_id', 'produits.produit_id')->select('ligne_commandes.*', 'produits.*')->where('commande_id', $commande->commande_id)->get();
        //dd($all);
        return view('commandes.show',[
            'ligne_commandes' => $all,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        $ctl = DB::table('personnes')->join('clients', 'personnes.personne_id', 'clients.personne_id')->select('personnes.*','clients.*')->get();
        $lign_commande=DB::table('ligne_commandes')->where('ligne_commandes.commande_id',$commande->commande_id)->get();
        $commande=DB::table('commandes')->where('commandes.commande_id',$commande->commande_id)->first();
        //dd($commande);
        $prod = DB::table('produits')->orderBy('libelle', 'asc')->get();
        //dd($prod);
        return view('commandes.edit',[
            'commande' => $commande,
            'lign_commande' => $lign_commande,
            'clients' => $ctl,
            'produits' => $prod

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
{
    //dd($request->all());
    $request->validate([
        'client_id' => 'required|exists:clients,client_id',
        'qte' => 'required|array|min:1',
        'qte.*' => 'required|integer|min:1',
        'id_prod' => 'required|array|min:1',
        'id_prod.*' => 'required|exists:produits,produit_id',
        'id_prix_achat' => 'required|array|min:1',
        'id_prix_achat.*' => 'required|numeric|min:0',
        'value_total' => 'required|numeric|min:1'
    ],  [
        'client_id.required' => 'Veuillez sélectionner ou ajouter un client s’il n’existe pas dans la base.',
        'client_id.exists' => 'Le client sélectionné est invalide.',
        'qte.required' => 'Veuillez ajouter au moins un produit.',
        'qte.min' => 'Veuillez ajouter au moins un produit.',
        'qte.*.required' => 'La quantité est requise pour chaque produit.',
        'qte.*.integer' => 'Chaque quantité doit être un nombre entier.',
        'qte.*.min' => 'Chaque quantité doit être d’au moins 1.',
        'id_prod.required' => 'Veuillez ajouter au moins un produit.',
        'id_prod.*.exists' => 'Un des produits sélectionnés n’existe pas dans la base.',
        'value_total.required' => 'Le total de la commande est requis.',
        'value_total.numeric' => 'Le total de la commande doit être un nombre.',
        'value_total.min' => 'Le total de la commande doit être supérieur à zéro.'
    ]);


    DB::beginTransaction();



    try {
        // Mise à jour de la commande
        $commande->update([
            'client_id' => $request->client_id,
            'user_id' => auth()->user()->user_id,
            'prix_total' => $request->value_total,
        ]);

        // Restauration du stock avant suppression des anciennes lignes
        $anciennesLignes = LigneCommande::where('commande_id', $commande->commande_id)->get();
        foreach ($anciennesLignes as $ligne) {
            $produit = Produit::find($ligne->produit_id);
            if ($produit) {
                $produit->update([
                    'quantiteStock' => $produit->quantiteStock + $ligne->quantite
                ]);
            }
        }

        // Suppression des anciennes lignes
        LigneCommande::where('commande_id', $commande->commande_id)->delete();

        // Recalcule les quantités groupées par produit
        $quantites = [];
        foreach ($request->id_prod as $index => $id) {
            $quantites[$id] = ($quantites[$id] ?? 0) + $request->qte[$index];
        }

        // Création des nouvelles lignes de commande
        foreach ($quantites as $produit_id => $qte) {
            $produit = Produit::find($produit_id);

            if (!$produit) {
                continue;
            }

            if ($produit->quantiteStock < $qte) {
                DB::rollBack();
                return back()->withErrors(['stock' => "Stock insuffisant pour le produit : {$produit->libelle}"]);
            }

            // Trouve l’index de ce produit pour accéder à son prix
            $index = array_search($produit_id, $request->id_prod);

            LigneCommande::create([
                'commande_id' => $commande->commande_id,
                'produit_id' => $produit_id,
                'quantite' => $qte,
                'prix_ligne' => $request->id_prix_achat[$index] * $qte,
                'prix_achat' => $request->id_prix_achat[$index],
            ]);

            $produit->update([
                'quantiteStock' => $produit->quantiteStock - $qte
            ]);
        }

        DB::commit();
        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour de la commande.']);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
{
    // Supprimer d'abord les lignes de commande associées
    DB::table('ligne_commandes')
        ->where('commande_id', $commande->commande_id)
        ->delete();

    // Supprimer la commande elle-même
    DB::table('commandes')
        ->where('commande_id', $commande->commande_id)
        ->delete();

    return redirect()->route('commandes.index')
        ->with('success', 'Commande supprimée avec succès.');
}


   public function totalJournalier(Request $request)
{

    $date = $request->input('date') ?? Carbon::today()->toDateString();
    //dd($date);
    $total = DB::table('commandes')
        ->whereDate('created_at', $date)
        ->sum('prix_total');

    $depenses = DB::table('depenses')->whereDate('created_at', $date)
        ->sum('montant');
//dd($depenses);
    return view('commandes.total_journalier', [
        'total' => $total,
        'depenses' => $depenses,
        'date' => $date,
    ]);
}

public function storeDepense(Request $request)
{
    //dd($request->method(), $request->all());
    $request->validate([
        'montant' => 'required|numeric|min:0',
        'date' => 'required|date'
    ]);

   // dd($request->all());

    $user = Auth::user();
    //dd($user->user_id);


    Depense::create([
        'date_depense' => $request->date,
        'montant' => $request->montant,
        'libelle' => $request->motif,
        'user_id' => $user->user_id
    ]);

    return redirect()->route('totalJournalier', ['date' => $request->date]);
}


public function all_commande(Request $request)
{
        $all = DB::table('commandes')
    ->join('users', 'commandes.user_id', '=', 'users.user_id')
    ->join('clients', 'commandes.client_id', '=', 'clients.client_id')
    ->join('personnes as p1', 'p1.personne_id', '=', 'clients.personne_id') // client
    ->join('personnes as p2', 'p2.personne_id', '=', 'users.personne_id')   // user
    ->select(
        'commandes.*',
        'p1.*',
        'p2.first_name as user_first_name',
        'p2.name as user_name',
        'users.*',
        'clients.*'
    )->get();
        if ($request->date) {
$all = DB::table('commandes')
    ->join('users', 'commandes.user_id', '=', 'users.user_id')
    ->join('clients', 'commandes.client_id', '=', 'clients.client_id')
    ->join('personnes as p1', 'p1.personne_id', '=', 'clients.personne_id') // client
    ->join('personnes as p2', 'p2.personne_id', '=', 'users.personne_id')   // user
    ->select(
        'commandes.*',
        'p1.*',
        'p2.first_name as user_first_name',
        'p2.name as user_name',
        'users.*',
        'clients.*'
    )->whereDate('commandes.dateCommande', $request->date)->get();
        }
        return view('commandes.all',[
            'commandes'=>$all,
        ]);
}

}
