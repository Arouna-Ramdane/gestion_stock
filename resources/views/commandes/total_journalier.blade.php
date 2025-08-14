@extends("layouts.base")

@section("content")
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">

    <form action="{{ route('totalJournalier') }}" method="GET" class="mb-6">
        <label for="date" class="block mb-1 font-semibold">📅 Choisir une date :</label>
        <input type="date" name="date" id="date" class="border p-2 rounded w-full" value="{{ $date }}">
        <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Voir les ventes</button>
    </form>

    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-700">📊 Résumé du {{ $date }}</h2>
        <p class="mt-2 text-green-600">💰 Total des ventes : <strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong> </p>
        <p class="text-red-500">💸 Dépenses : <strong>{{ number_format($depenses, 0, ',', ' ') }} FCFA</strong></p>
        <p class="mt-2 text-blue-800 font-bold">📈 Résultat final :
            <strong>{{ number_format($total - $depenses, 0, ',', ' ') }} FCFA</strong>
        </p>
    </div>



</div>
@endsection
