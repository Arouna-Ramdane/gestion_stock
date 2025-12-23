@extends('layouts.base_no_dashbord')

@section('content')

{{-- Bouton retour --}}
<div class="p-6">
    <a href="{{ route('commandes.index') }}">
        <button class="btn btn-neutral gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>
            Retour
        </button>
    </a>
</div>

<div class="p-12 gap-5">

    {{-- TITRE --}}
    <div class="flex justify-between  mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-wide">
            📊 Statistiques des ventes
        </h1>
        <form method="GET" class="mb-12">
        <div class="flex justify-between mb-6 gap-5">

            <div>
                <label class="font-semibold text-gray-700">Date début</label>
                 filter par date :
                <input type="date" name="date_debut" value="{{ $date_debut }}"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div>
                <label class="font-semibold text-gray-700">Date fin</label>
                filter par date :
                <input type="date" name="date_fin" value="{{ $date_fin }}"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <button type="submit" class="btn btn-neutral">Valider</button>
        </div>
    </form>
    </div>

    {{-- FILTRE --}}
    

    {{-- 3 CARDS STAT --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

        <div class="p-8 rounded-2xl bg-base-100 border border-base-content/10 shadow-lg hover:shadow-2xl transition-all duration-300">
            <p class="text-green-500 text-sm">Total commandes</p>
            <h2 class="text-4xl font-black text-green-500 mt-2"> {{ $totalCommandes }}</h2>
        </div>

        <div class="p-8 rounded-2xl bg-base-100 border border-base-content/10 shadow-lg hover:shadow-2xl transition-all duration-300">
            <p class="text-green-500 text-sm">Chiffre d’affaires</p>
            <h2 class="text-4xl font-black text-green-500 mt-2">{{ number_format($chiffreAffaire) }} FCFA</h2>
        </div>

        <div class="p-8 rounded-2xl bg-base-100 border border-base-content/10 shadow-lg hover:shadow-2xl transition-all duration-300">
            <p class="text-green-500 text-sm">Produits vendus</p>
            <h2 class="text-4xl font-black text-green-500 mt-2">{{ $produits->sum('total_vendu') }}</h2>
        </div>

    </div>

    {{-- GRAPH --}}
    <div class="p-8 rounded-2xl bg-base-100 border border-base-content/10 shadow-xl mb-16">
        <h2 class="text-xl font-bold text-gray-900 mb-4">📈 Quantité vendue par produit</h2>
        <canvas id="produitChart" height="130"></canvas>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 max-h-[500px] overflow-y-auto">
        <table class="table">
            <thead class="text-white bg-gray-900">
            <tr>
                <th>Produit</th>
                <th>Quantité vendue</th>
                <th>Montant généré</th>
            </tr>
            </thead>

            <tbody>
            @forelse($produits as $p)
                <tr class="hover:bg-base-200/50 transition-all">
                    <td class="font-semibold">{{ $p->libelle }}</td>
                    <td>{{ $p->total_vendu }}</td>
                    <td>{{ number_format($p->montant_genere) }} FCFA</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">
                        Aucun produit trouvé pour cette période.
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>


{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('produitChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($produits->pluck('libelle')) !!},
            datasets: [{
                label: "Quantité vendue",
                data: {!! json_encode($produits->pluck('total_vendu')) !!},
                backgroundColor: [
                    '#6366F1', '#F59E0B', '#10B981', '#EF4444',
                    '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6'
                ],
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
