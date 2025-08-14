<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Personne;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class UserController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-user', only: ['index', 'show']),
            new Middleware('permission:add-user', only: ['create', 'store']),
            new Middleware('permission:edit-user', only: ['edit', 'update']),
            new Middleware('permission:delete-user', only: ['destroy']),
        ];
    }

    public function index()
    {
        $all=DB::table('personnes')->join('users', 'personnes.personne_id', 'users.personne_id')->select('personnes.*','users.*')->get();
        return view('users.index',[
            'users' => $all,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validation des données pour Personne
    $validat_data_personne = $request->validate([
        'first_name' => 'required',
        'name' => 'required',
        'contact' => 'required|unique:personnes,contact',
        'adresse' => 'required',
    ], [
        'contact.unique' => 'Un employé a déjà un contact identique dans le système.',
    ]);

    // Validation des données pour User
    $validat_data_user = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'profile' => 'nullable|image',
    ], [
        'email.unique' => 'Un employé a déjà un email identique dans le système.',
    ]);

    DB::transaction(function () use ($request, $validat_data_personne, $validat_data_user) {

        // Gestion du fichier profile (image) pour la personne
        if ($request->file('profile')) {
            $name = trim(strtolower($validat_data_personne['first_name'] . $validat_data_personne['name']));
            $name = str_replace(' ', '', $name);

            $img = $request->file('profile');
            $extension = $img->getClientOriginalExtension();
            $file_name = $name . '.' . $extension;
            $path = $img->storeAs('imagePersonne', $file_name);

            $validat_data_user['profile'] = $path;

            $personne = Personne::create($validat_data_personne);

            $user = User::create([
            'email' => $validat_data_user['email'],
            'password' => Hash::make($validat_data_user['password']),
            'personne_id' => $personne->personne_id,
            'profile' => $validat_data_user['profile'],
        ]);

        $user->assignRole('userRole');

        }else {
                $personne = Personne::create($validat_data_personne);

               $user = User::create([
                'email' => $validat_data_user['email'],
                'password' => Hash::make($validat_data_user['password']),
                'personne_id' => $personne->personne_id,
            ]);

            $user->assignRole('user');

        }



        // Création de l'utilisateur lié à la personne

    });

    return redirect()->route('users.index');
}



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $image_personnes = User::where('user_id', $user->user_id)->first();
        //dd($image_personnes);
        return view('users.show',[
            'personne' => $image_personnes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $all=DB::table('personnes')->join('users', 'personnes.personne_id', 'users.personne_id')->select('personnes.*','users.*')->where('users.user_id',$user->user_id)->first();
        return view('users.edit',[

            'personne' => $all,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, User $user)
{
    // Validation pour la personne
    $validat_data_personne = $request->validate([
        'first_name' => 'required',
        'name' => 'required',
        'contact' => 'required|unique:personnes,contact,' . $user->personne_id . ',personne_id',
        'adresse' => 'required',

    ], [
        'contact.unique' => 'Un employé avec ce contact existe déjà.',
    ]);

    // Validation pour l'utilisateur
    $validat_data_user = $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
        'password' => 'nullable',
        'profile' => 'nullable|image',
    ], [
        'email.unique' => 'Un employé avec cet email existe déjà.',
    ]);

    // Nettoyage du nom complet (comme ton $name pour produit)
    $name = trim(strtolower(str_replace(" ", "", $validat_data_personne['first_name'] . $validat_data_personne['name'])));

    // Préparation des données Personne
    $data_personne = [
        'first_name' => $validat_data_personne['first_name'],
        'name' => $validat_data_personne['name'],
        'contact' => $validat_data_personne['contact'],
        'adresse' => $validat_data_personne['adresse'],
    ];

    // Gestion de l'image si présente
    if ($request->hasFile('profile')) {
        $img = $request->file('profile');
        $extension = $img->getClientOriginalExtension();
        $file_name = $name . '.' . $extension;
        $path = $img->storeAs('imagePersonne', $file_name);
        $validat_data_user['profile'] = $path;
    }

  //  dd(        $data_personne['profile'] = $path);
    // Mise à jour de la personne
    $user->personne->update($data_personne);

    // Préparation des données User
    $data_user = [
        'email' => $validat_data_user['email'],
        'profile' => $validat_data_user['profile'],
    ];

    if (!empty($validat_data_user['password'])) {
        $data_user['password'] = Hash::make($validat_data_user['password']);
    }

    // Mise à jour de l'utilisateur
    $user->update($data_user);

    return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $delete_personnes =DB::table('personnes')->where('personne_id', $user->personne_id);
        $delete_personnes->delete();
        $user->delete();
        return redirect()->route('users.index');
    }

    public function userImage(User $user)
    {

    }
}
