@extends("layouts.base_no_dashbord")

@section("content")
<div class="flex justify-center items-center min-h-screen bg-gray-50 p-4">
    <div class="w-[500px] h-auto bg-gray-800 shadow-lg rounded-xl overflow-hidden border">
        <figure class="flex justify-center items-center bg-gray-100 h-[400px]">
            <img src="{{ asset('storage/' . $produit->image) }}"
                 alt="{{ $produit->libelle }}"
                 class="max-h-full max-w-full object-contain transition duration-300 ease-in-out">
        </figure>
        <div class="p-4 text-center">
            <h2 class="text-xl font-semibold text-white">{{ $produit->libelle }}</h2>
        </div>
        <div class="flex justify-center">
    <a href="{{ route('produits.index') }}">
<button type="submit"
                class="bg-white text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">retour</button>
    </a>
</div>
    </div>
</div>

@endsection
