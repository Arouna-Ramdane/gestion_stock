@extends('layouts.base')

@section('content')
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
        {{-- Liste des produits --}}
        <div class="w-2/3">
            <h2 class="text-xl font-semibold mb-4">Produits disponibles</h2>
            <table class="w-full table-auto border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-sm text-left">
                        <th class="p-2">Image</th>
                        <th class="p-2">Produit</th>
                        <th class="p-2">Prix</th>
                        <th class="p-2">Stock</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-2"><img src="{{ asset('storage/' . $produit->image) }}" alt="img" class="w-12 h-12 object-cover"></td>
                            <td class="p-2">{{ $produit->libelle }}</td>
                            <td class="p-2">{{ $produit->prix }} FCFA</td>
                            <td class="p-2">{{ $produit->quantiteStock }}</td>
                            <td class="p-2">
                                <button type="button"
                                    class="bg-blue-500 text-white px-3 py-1 rounded text-sm"
                                    onclick="ajouterPanier('{{ $produit->libelle }}', '{{ $produit->prix }}', '{{ $produit->quantiteStock }}', '{{ $produit->produit_id }}')">
                                    Ajouter
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Panier + client + total --}}
        <div class="w-1/3 bg-blue-50 rounded-lg p-4 flex flex-col">
            <div>
                <label for="client_input" class="block text-sm font-semibold">Client</label>
                <input list="clients_list" name="client_id" id="client_input"
                       placeholder="ID ou nom client"
                       class="w-full border px-2 py-1 rounded mt-1">
                <datalist id="clients_list">
                    @foreach($clients as $client)
                        <option value="{{ $client->client_id }}">{{ $client->first_name }} {{ $client->name }}({{ $client->contact }})</option>
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

<script>
const prix_total = document.getElementById('prix_total');
prix_total.textContent = 0;

function ajouterPanier(nom, prix, qtd, id) {
    const panier = document.getElementById('panier');

    const dejaAjoute = Array.from(panier.children).some(ligne =>
        ligne.querySelector('input[name="id_prod[]"]').value == id
    );
    if (dejaAjoute) {
        alert("Ce produit est déjà dans le panier.");
        return;
    }

    const ligne = document.createElement('div');
    ligne.className = 'flex items-center justify-between bg-white p-2 rounded shadow';

    ligne.innerHTML = `
        <input type="number" min="0" max="${qtd}" value="1"
               class="w-16 p-1 border rounded modif_qte"
               name="qte[]" onchange="modifierPrix(event, ${prix})">
        <p class="flex-1 px-2">${nom}</p>
        <input type="hidden" name="id_prod[]" value="${id}">
        <span class="prix font-bold">${prix}</span> FCFA
    `;
    panier.appendChild(ligne);

    prix_total.textContent = Number(prix_total.textContent) + Number(prix);
}

function modifierPrix(event, prix_unitaire) {
    const input = event.target;
    const qte   = Number(input.value);
    const ligne = input.parentElement;
    const prixLigne = ligne.querySelector('.prix');
    const ancien = Number(prixLigne.textContent);

    if (qte <= 0) {
        ligne.remove();
        prix_total.textContent = Number(prix_total.textContent) - ancien;
        return;
    }

    const nouveau = qte * prix_unitaire;
    prixLigne.textContent = nouveau;
    prix_total.textContent = Number(prix_total.textContent) - ancien + nouveau;
}

document.getElementById('form').addEventListener('submit', e => {
    document.getElementById('input_total').value = prix_total.textContent;
});
</script>
@endsection
