@extends('layouts.base_no_dashbord')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8 justify-center">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Formulaire d'enregistrement d'une dépense</h1>

    <form action="{{ route('depenses.store') }}" method="POST">
        @csrf
        <div>
            <input type="text" name="motif" value="{{ old('motif') }}" required placeholder="motif"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">

            @error('motif')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <input type="number" min="0" name="montant" value="{{ old('montant') }}" required placeholder="Montant"
                class="mt-4 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">

            @error('montant')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex justify-between pt-6">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Enregistrer</button>
            <button type="reset"
                class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Annuler</button>
        </div>
    </form>
</div>
<div class="flex justify-center pt-6">
    <a href="{{ route('depenses.index') }}">
<button type="submit"
                class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">BACK</button>
    </a>
</div>
@endsection
