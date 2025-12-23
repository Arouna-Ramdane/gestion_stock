@extends("layouts.base")

@section("content")

<div class="max-w-3xl mx-auto mt-12">

    {{-- Carte principale --}}
    <div class="bg-white rounded-3xl shadow-xl p-10 border border-base-content/10">

        {{-- En-tête --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
               
                Résumé journalier
            </h1>
            <p class="text-gray-600 mt-2">
                Consulte les ventes, dépenses et le résultat net du jour choisi.
            </p>
        </div>

        {{-- Formulaire --}}
        <form action="{{ route('totalJournalier') }}" method="GET" class="space-y-5">

            <div>
                <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">
                    Sélectionner une date
                </label>

                <input 
                    type="date" 
                    name="date" 
                    id="date" 
                    value="{{ $date }}" 
                    class="input input-bordered w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900"
                >
            </div>

            <button 
                type="submit" 
                class="btn w-full bg-gray-900 hover:bg-gray-700 text-white text-lg rounded-xl py-3 flex items-center justify-center gap-2 shadow-md"
            >
                Voir les ventes
            </button>

        </form>

        {{-- Résultats --}}
        <div class="mt-10">

            <h2 class="text-2xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                📊 Résumé du {{ $date }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- Carte total vente --}}
                <div class="bg-green-50 border border-green-200 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-green-700 font-semibold text-lg mb-2">💰 Total ventes</h3>
                    <p class="text-2xl font-extrabold text-green-700">
                        {{ number_format($total, 0, ',', ' ') }} FCFA
                    </p>
                </div>

                {{-- Carte dépenses --}}
                <div class="bg-red-50 border border-red-200 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-red-600 font-semibold text-lg mb-2">💸 Dépenses</h3>
                    <p class="text-2xl font-extrabold text-red-600">
                        {{ number_format($depenses, 0, ',', ' ') }} FCFA
                    </p>
                </div>

                {{-- Carte résultat final --}}
                <div class="bg-blue-50 border border-blue-200 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-blue-700 font-semibold text-lg mb-2">📈 Résultat final</h3>
                    <p class="text-2xl font-extrabold text-blue-700">
                        {{ number_format($total - $depenses, 0, ',', ' ') }} FCFA
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
