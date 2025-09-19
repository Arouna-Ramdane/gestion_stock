 @extends('layouts.base_no_dashbord')

@section('content')


<div class="p-6">
            <a href="{{route('produits.index')}}"><button  class="btn btn-neutral">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
</svg>
retour
            </button></a>
            </div>
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8 justify-center">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Modification du produit</h1>

        <form action="{{ route('produits.update', $produits->produit_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <input type="text" name="libelle" value="{{ $produits->libelle }}" required placeholder="libelle"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                     @error('libelle')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            <div>
                <input type="text" name="prix" value="{{ $produits->prix }}" required placeholder="prix"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <input type="number" name="quantiteStock" value="{{ $produits->quantiteStock }}" required placeholder="quantiteStock"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                    @error('quantiteStock')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            <div>
                <input type="file" name="image" value="{{ $produits->image }}" placeholder="image"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                    @error('quantiteStock')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            <div class="flex justify-between pt-4">
                <button type="submit"
                    class="btn btn-neutral px-6 py-2 rounded-lg hover:bg-gray-900 transition">Enregistrer</button>
               <button type="reset"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Annuler</button>
            </div>
        </form>
    </div>
@endsection
