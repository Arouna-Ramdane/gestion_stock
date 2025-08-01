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





class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //dd($request->all());
        $all = DB::table('commandes')->join('users', 'commandes.user_id', 'users.user_id')->join('clients', 'commandes.client_id', 'clients.client_id')->join('personnes', 'personnes.personne_id', 'clients.personne_id')->select('commandes.*','personnes.*','users.*','clients.*')->whereDate('commandes.dateCommande', now())->paginate(8);
        if ($request->date) {
$all = DB::table('commandes')->join('users', 'commandes.user_id', 'users.user_id')->join('clients', 'commandes.client_id', 'clients.client_id')->join('personnes', 'personnes.personne_id', 'clients.personne_id')->select('commandes.*','personnes.*','users.*','clients.*')->whereDate('commandes.dateCommande', $request->date)->paginate(8);
        }


        //dd($all);
        $user = Auth::user()->personne;
        return view('commandes.index',[
            'commandes'=>$all,
            'users'=>$user,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ctl = DB::table('personnes')->join('clients', 'personnes.personne_id', 'clients.personne_id')->select('personnes.*','clients.*')->get();
        //dd($ctl);
        return view('commandes.create',[
            'produits'=>Produit::all(),
            'clients'=> $ctl
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
        'client_id.required' => 'Veuillez sélectionner ou ajouté un client si il n\'existe pas dans la base.',
        'client_id.exists' => 'Le client sélectionné est invalide.',
        'qte.required' => 'Veuillez ajouter au moins un produit.',
        'qte.min' => 'Veuillez ajouter au moins un produit.',
        'qte.*.required' => 'La quantité est requise pour chaque produit.',
        'qte.*.integer' => 'Chaque quantité doit être un nombre entier.',
        'qte.*.min' => 'Chaque quantité doit être d\'au moins 1.',
        'id_prod.required' => 'Veuillez ajouter au moins un produit.',
        'id_prod.*.exists' => 'Un des produits sélectionnés n\'existe pas.',
        'value_total.required' => 'Le total de la commande est requis.',
        'value_total.numeric' => 'Le total de la commande doit être un nombre.',
        'value_total.min' => 'Le total de la commande doit être supérieur à zéro.'
    ]);

    DB::transaction(function () use ($request) {

        $commande = Commande::create([
            'dateCommande' => now(),
            'prix_total' => $request->value_total,
            'user_id' => 1,
            'client_id' => $request->client_id,
        ]);

        $quantites = [];
        foreach ($request->id_prod as $index => $id) {
            $quantites[$id] = ($quantites[$id] ?? 0) + $request->qte[$index];
        }

        foreach ($quantites as $produit_id => $qte) {

            $produit = Produit::find($produit_id);
            if (!$produit) {
                continue;
            }

            LigneCommande::create([
                'commande_id' => $commande->commande_id,
                'produit_id' => $produit_id,
                'quantite' => $qte,
                'prix_ligne' => $produit->prix * $qte,
            ]);

                if ($produit->quantiteStock - $qte > 0) {
                    $prod = Produit::all()->where('produit_id', $produit->produit_id)->first();
                    // dd($prod);
                    $prod -> update([
                        'quantiteStock' => $produit->quantiteStock - $qte
                    ]);
                } else {
                    return('quantiter insuffisante');
                }

        }
    });

    return redirect()->route('commandes.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
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


}
