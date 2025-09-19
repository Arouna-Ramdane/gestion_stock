<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Ismaelw\LaraTeX\LaraTeX;

class RecuController extends Controller
{
    public function download($id)
    {
        $commande = DB::table('commandes')
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
    ->where('commandes.commande_id', $id)
    ->first();
        $all= DB::table('ligne_commandes')->join('produits', 'ligne_commandes.produit_id', 'produits.produit_id')->select('ligne_commandes.*', 'produits.*')->where('commande_id', $id)->get();
        //dd($all);
        return (new LaraTeX('latex.recu'))
            ->with([
                'commande' => $commande,
                'ligneCommande' => $all,
            ])
            ->download('recu-'.$commande->commande_id.'.pdf');
    }
}
