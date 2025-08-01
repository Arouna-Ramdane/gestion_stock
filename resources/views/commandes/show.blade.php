@extends("layouts.base")
@section("content")
<div class="p-12">

    <div class="flex justify-between mb-5">
            <h1>La liste des lignes des commandes associer a cette commande</h1>
    </div>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table">
            <thead class="text-white bg-gray-900">
                <tr>
                    <th>quantite</th>
                    <th>libelle</th>
                    <th>Prix unitire</th>
                    <th>montant</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ligne_commandes as $lignes )
                    <tr>
                        <td>{{ $lignes->quantite }}</td>
                        <td>{{ $lignes->libelle }}</td>
                        <td>{{ $lignes->prix }}</td>
                        <td>{{ $lignes->prix_ligne }}</td>
                @empty
                        <td>Aucune ligne trouvé</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>

</div>
@endsection
