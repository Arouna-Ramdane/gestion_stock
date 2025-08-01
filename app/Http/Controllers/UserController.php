<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Personne;
use App\Models\User;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    $validat_data_personne = $request->validate([
        'first_name' => 'required',
        'name' => 'required',
        'contact' => 'required|unique:personnes,contact',
        'adresse' => 'required',
    ],[
        'contact.unique' => 'un employe a déja un contact identique dans le système ',
    ]
);

    $validat_data_user = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
    ],[
        'email.unique' => 'un employe a déja un email identique dans le système ',
    ]);

    DB::transaction(function () use ($validat_data_personne, $validat_data_user) {
        $personne = Personne::create($validat_data_personne);

        User::create([
            'email' => $validat_data_user['email'],
            'password' => Hash::make($validat_data_user['password']),
            'personne_id' => $personne->personne_id,
        ]);
    });

    return redirect()->route('users.index');
}


    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        //
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
    $validated_data = $request->validate([
        'first_name' => 'required',
        'name' => 'required',
        'contact' => 'required',
        'email' => 'required|email',
        'adresse' => 'required',
        'password' => 'required'
    ]);
    $validated_data['password'] = Hash::make($validated_data['password']);

    DB::transaction(function () use ($validated_data, $user) {
    DB::table('personnes')->where('personne_id', $user->personne_id)->update([
            'first_name' => $validated_data['first_name'],
            'name' => $validated_data['name'],
            'contact' => $validated_data['contact'],
            'adresse' => $validated_data['adresse']
        ]);

    DB::table('users')->where('user_id', $user->user_id)->update([
            'email' => $validated_data['email'],
            'password' => $validated_data['password']
        ]);
    });
    return redirect()->route('users.index');
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
}
