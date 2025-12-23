@extends('layouts.base_no_dashbord')

@section('content')

 <div class="p-6">
            <a href="{{ route('commandes.index') }}"><button  class="btn btn-neutral">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
</svg>
retour
            </button></a>
            </div>
<form action="{{ route('commandes.store') }}" method="post" id="form">

    @csrf

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <div class="flex p-8 gap-6">
            <div class=" w-2/3 overflow-x-auto rounded-box border border-base-content/5 bg-base-100 max-h-[500px] overflow-y-auto">
            <h2 class="text-xl font-semibold mb-4">Produits disponibles</h2>

<table class="w-full table-auto border border-gray-300" id="produitsTable">
    <div class="mb-4">
    <input type="text" id="searchProduit" placeholder="Rechercher un produit..."
           class="w-full border px-3 py-2 rounded focus:outline-none">
</div>

    <thead class="text-gray-900 bg-gray-900 sticky top-0 z-10">
        <tr class="bg-gray-900 text-white text-sm text-left">
            <th class="p-2">Image</th>
            <th class="p-2">Produit</th>
            <th class="p-2">Prix</th>
            <th class="p-2">Stock</th>
            <th class="p-2">Action</th>
        </tr>
    </thead>
    <tbody class="text-gray-900" id="produitsBody">
        @foreach ($produits as $produit)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-2">
                    <img src="{{ asset('storage/' . ($produit->image ?? 'imageProduit/default.webp')) }}"
                        alt="{{ $produit->libelle }}" class="w-12 h-12 object-cover">
                </td>
                <td class="p-2">{{ $produit->libelle }}</td>
                <td class="p-2">{{ $produit->prix }} FCFA</td>
                <td class="p-2">{{ $produit->quantiteStock }}</td>
                <td class="p-2">
                    <button type="button"
                        class="btn btn-neutral px-3 py-1 hover:bg-gray-900 rounded text-sm"
                        onclick="ajouterPanier('{{ $produit->libelle }}', '{{ $produit->prix }}', '{{ $produit->quantiteStock }}', '{{ $produit->produit_id }}')">
                        Ajouter
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

        </div>


        <div class="w-1/3 bg-blue-50 rounded-lg p-4 flex flex-col">
            <div>
            le client n'existe pas ?
            <a href="{{ route('clients.create') }}" class="text-blue-600 text-sm underline ml-1">
                Ajouter-le
            </a>
        </div>
            <div>
                <label for="client_input" class="block text-sm font-semibold">Client</label>
                <input list="clients_list" name="client_name" id="client_input"
                    placeholder="nom client"
                    class="w-full border px-2 py-1 rounded mt-1">
                <input type="hidden" name="client_id" id="client_id">
                <datalist id="clients_list">
                    @foreach($clients as $client)
                        <option value="{{ $client->first_name }} {{ $client->name }} ({{ $client->contact }})" data-id="{{ $client->client_id }}">
                    @endforeach
                </datalist>
            </div>


            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Panier</h3>
                <div id="panier" class="space-y-2 max-h-64 overflow-y-auto"></div>
            </div>

            <input type="hidden" name="value_total" id="input_total">

            <div class="mt-auto pt-4 flex justify-between items-center border-t">
                <span class="text-sm font-medium">Total :</span>
                <span class="text-xl font-bold" id="prix_total">0</span> FCFA
            </div>

            <button type="submit"
                    class="mt-4 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                Enregistrer
            </button>
        </div>
    </div>
</form>
@endsection
@push('scripts')
    @vite('resources/js/commandes/vente.js')
@endpush
