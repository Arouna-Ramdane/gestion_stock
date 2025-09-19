<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Personne;
use App\Models\Client;
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
    // Validation pour la table personnes
$validatedData = $request->validate([
    'first_name' => 'required|max:255',
    'name'       => 'required|max:255',
    'contact'    => 'required|regex:/^\+[0-9]{1,3}[0-9]{6,12}$/|unique:personnes,contact',
    'adresse'    => 'required|string|max:255',

    'email'    => 'required|email|unique:users,email',
    'password' => 'required|min:4',
    'profile'  => 'nullable|image|max:2048',
], [
    'first_name.required' => 'Le nom est obligatoire.',
    'name.required'       => 'Le prenom est obligatoire.',
    'contact.required'    => 'Veuillez entrer un contact.',
    'contact.regex' => 'Veuillez saisir un contact valide avec indicatif EX:+22891627160.',
    'contact.unique'      => 'Un employé a déjà un contact identique dans le système.',
    'adresse.required'    => 'L’adresse est obligatoire.',

    'email.required' => 'L’email est obligatoire.',
    'email.email'    => 'Veuillez saisir un email valide.',
    'email.unique'   => 'Un employé a déjà un email identique dans le système.',
    'password.required' => 'Le mot de passe est obligatoire.',
    'password.min'      => 'Le mot de passe doit contenir au moins 6 caractères.',
    'profile.image'     => 'Le fichier doit être une image.',
    'profile.max'       => 'L’image ne doit pas dépasser 2 Mo.',
]);


$validat_data_personne = collect($validatedData)->only(['first_name','name','contact','adresse'])->toArray();
$validat_data_user     = collect($validatedData)->only(['email','password','profile'])->toArray();


    DB::transaction(function () use ($request, $validat_data_personne, $validat_data_user) {

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

            Client::create([
            'personne_id' => $personne->personne_id,
        ]);
        }

    });

    return redirect()->route('users.index');
}



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $image_personnes = User::where('user_id', $user->user_id)->first();
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
    $validator = Validator::make($request->all(), [
        // Table personnes
        'first_name' => 'required',
        'name'       => 'required',
        'contact'    => 'required|regex:/^\+[0-9]{1,3}[0-9]{6,12}$/|unique:personnes,contact,' . $user->personne_id . ',personne_id',
        'adresse'    => 'required',

        // Table users
        'email'    => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
        'password' => 'nullable|min:4',
        'profile'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'first_name.required' => 'Le nom est obligatoire.',
        'name.required'       => 'Le prénom est obligatoire.',
        'contact.required'    => 'Le contact est obligatoire.',
        'contact.regex' => 'Veuillez saisir un contact valide avec indicatif EX:+22891627160.',
        'contact.unique'      => 'Un employé avec ce contact existe déjà.',
        'adresse.required'    => 'L’adresse est obligatoire.',

        'email.required' => 'L’email est obligatoire.',
        'email.email'    => 'Le format de l’email est invalide.',
        'email.unique'   => 'Un employé avec cet email existe déjà.',

        'password.min' => 'Le mot de passe doit contenir au moins 4 caractères.',

        'profile.image' => 'Le fichier doit être une image.',
        'profile.mimes' => 'L’image doit être au format jpeg, png, jpg ou gif.',
        'profile.max'   => 'L’image ne doit pas dépasser 2Mo.',
    ]);

    $validator->validate();

    $validat_data_personne = collect($validator->validated())->only(['first_name','name','contact','adresse'])->toArray();
    $validat_data_user     = collect($validator->validated())->only(['email','password','profile'])->toArray();




    $name = trim(strtolower(str_replace(" ", "", $validat_data_personne['first_name'] . $validat_data_personne['name'])));

    $data_personne = [
        'first_name' => $validat_data_personne['first_name'],
        'name' => $validat_data_personne['name'],
        'contact' => $validat_data_personne['contact'],
        'adresse' => $validat_data_personne['adresse'],
    ];

    if ($request->hasFile('profile')) {
        $img = $request->file('profile');
        $extension = $img->getClientOriginalExtension();
        $file_name = $name . '.' . $extension;
        $path = $img->storeAs('imagePersonne', $file_name);
        $validat_data_user['profile'] = $path;

        $data_user = [
        'email' => $validat_data_user['email'],
        'profile' => $validat_data_user['profile'],
    ];

    }

    $user->personne->update($data_personne);

    $data_user = [
        'email' => $validat_data_user['email'],
        //'profile' => $validat_data_user['profile'],
    ];

    if (!empty($validat_data_user['password'])) {
        $data_user['password'] = Hash::make($validat_data_user['password']);
    }

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
