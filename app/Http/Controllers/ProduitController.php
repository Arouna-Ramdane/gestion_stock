<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class ProduitController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-produit', only: ['index', 'show']),
            new Middleware('permission:add-produit', only: ['create', 'store']),
            new Middleware('permission:edit-produit', only: ['edit', 'update']),
            new Middleware('permission:delete-produit', only: ['destroy']),
        ];
    }

    public function index()
    {
        $all = Produit::orderBy('libelle', 'asc')->get();
        return view('produits.index',[
            'produits' => $all,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validat_data_produit = $request->validate(
    [
        'libelle' => 'required|unique:produits,libelle',
        'prix' => 'required|integer',
        'quantiteStock' => 'required|integer|min:1',
        'image' => 'nullable|image',
    ], [
        'libelle.required' => 'Le nom du produit est obligatoire.',
        'libelle.unique' => 'Un produit avec ce nom existe déjà.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.integer' => 'Le prix doit être un nombre entier.',
        'quantiteStock.required' => 'Veuillez saisir la quantité en stock.',
        'quantiteStock.integer' => 'La quantité doit être un nombre entier.',
        'image.image' => 'Le fichier doit être une image valide.',
    ]);



    if ($request->file('image')) {
        $name=$validat_data_produit['libelle'];
        $name=trim(strtolower($name));
        $name=str_replace(" ", "", $name);


        $img = $request->file('image');


        $extension= $img->getClientOriginalExtension();
        $file_name=$name.".".$extension;
        $path = $img->storeAs('imageProduit', $file_name, 'public');
        


        $produit = Produit::create([
            'libelle' =>$validat_data_produit['libelle'],
            'prix' => $validat_data_produit['prix'],
            'quantiteStock' => $validat_data_produit['quantiteStock'],
            'image' => $path,
        ]);
    } else {
        $produit = Produit::create([
            'libelle' =>$validat_data_produit['libelle'],
            'prix' => $validat_data_produit['prix'],
            'quantiteStock' => $validat_data_produit['quantiteStock'],
        ]);
    }

        return redirect()->route('produits.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        $image_produit = Produit::all()->where('produit_id', $produit->produit_id)->first();
        //dd($image_produit);
        return view('produits.show',[
            'produit' => $image_produit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        $all=DB::table('produits')->where('produits.produit_id',$produit->produit_id)->first();
        return view('produits.edit',[
            'produits' => $all,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Produit $produit)
{
    $validat_data_produit = $request->validate([
        'libelle' => 'required|unique:produits,libelle,' . $produit->produit_id . ',produit_id',
        'prix' => 'required|integer',
        'quantiteStock' => 'required|integer',
        'image' => 'nullable|image',
    ], [
        'libelle.required' => 'Le nom du produit est obligatoire.',
        'libelle.unique' => 'Un produit avec ce nom existe déjà.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.integer' => 'Le prix doit être un nombre entier.',
        'quantiteStock.required' => 'Veuillez saisir la quantité en stock.',
        'quantiteStock.integer' => 'La quantité doit être un nombre entier.',
        'image.image' => 'Le fichier doit être une image valide.',
    ]);


    // Nettoyage du libellé
    $name = trim(strtolower(str_replace(" ", "", $validat_data_produit['libelle'])));

    // Préparation des données
    $data = [
        'libelle' => $validat_data_produit['libelle'],
        'prix' => $validat_data_produit['prix'],
        'quantiteStock' => $validat_data_produit['quantiteStock'],
    ];

    // Gestion de l’image si présente
    if ($request->hasFile('image')) {
        $img = $request->file('image');
        $extension = $img->getClientOriginalExtension();
        $file_name = $name . '.' . $extension;
        $path = $img->storeAs('imageProduit', $file_name, 'public');
        $data['image'] = $path;
    }

    $produit->update($data);

    return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimer avec succès.');
    }
}
