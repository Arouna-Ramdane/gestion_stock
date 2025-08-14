<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Personne;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ClientController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-client', only: ['index', 'show']),
            new Middleware('permission:add-client', only: ['create', 'store']),
            new Middleware('permission:edit-client', only: ['edit', 'update']),
            new Middleware('permission:delete-client', only: ['destroy']),
        ];
    }

    public function index()
    {
        $all=DB::table('personnes')->join('clients', 'personnes.personne_id', 'clients.personne_id')->select('personnes.*','clients.*')->orderBy('personnes.first_name', 'asc')->get();
        return view('clients.index',[
            'clients' => $all,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validat_data_personne = $request->validate([
        'first_name' => 'required',
        'name' => 'required',
        'contact' => 'required',
        'adresse' => 'required',
    ]);

    DB::transaction(function () use ($validat_data_personne) {
        $personne = Personne::create($validat_data_personne);

        Client::create([
            'personne_id' => $personne->personne_id,
        ]);
    });

    return redirect()->route('commandes.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {

        $all=DB::table('personnes')->join('clients', 'personnes.personne_id', 'clients.personne_id')->select('personnes.*','clients.*')->where('clients.personne_id',$client->personne_id)->first();
        //dd($all->personne_id);
        return view('clients.edit',[
            'personne' => $all,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //dd($client);
        $validated_data = $request->validate([
        'first_name' => 'required',
        'name' => 'required',
        'contact' => 'required',
        'adresse' => 'required'
    ]);
    DB::table('personnes')->where('personne_id', $client->personne_id)->update([
            'first_name' => $validated_data['first_name'],
            'name' => $validated_data['name'],
            'contact' => $validated_data['contact'],
            'adresse' => $validated_data['adresse']
        ]);

    return redirect()->route('clients.index')->with('success', 'modification du client reussi.');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $delete_personnes =DB::table('personnes')->where('personne_id', $client->personne_id);
        $delete_personnes->delete();
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'client supprimée.');
    }
}
