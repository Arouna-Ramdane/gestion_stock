@extends('layouts.base_no_dashbord')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8 justify-center">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Formulaire d'enregistrement d'un produit</h1>

        <form action="{{route('produits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <input type="text" name="libelle" value="{{ old('libelle') }}" required placeholder="libelle"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">

                    @error('libelle')
    <span class="text-red-600 text-sm">{{ $message }}</span>
@enderror

            </div>

            <div>
                <input type="text" name="prix" value="{{ old('prix') }}" required placeholder="prix"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">

            </div>

            <div>
                <input type="number"  name="quantiteStock" value="{{ old('quantiteStock') }}" required placeholder="quantiteStock"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">

                    @error('quantiteStock')
    <span class="text-red-600 text-sm">{{ $message }}</span>
@enderror

            </div>

            <div>
                <input type="file" name="image" value="{{ old('image') }}" placeholder="image"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">

            </div>

            <div class="flex justify-between pt-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Enregistrer</button>
               <button type="reset"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Annuler</button>
            </div>
        </form>
    </div>

@endsection

