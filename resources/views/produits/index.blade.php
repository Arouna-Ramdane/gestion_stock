@extends("layouts.base")
@section("content")
<div class="p-12">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-5 items-center">
        <h1 class="text-2xl font-semibold">La liste des produits</h1>
        @can('add-produit')
        <a href="{{ route('produits.create') }}">
            <button class="btn btn-neutral">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                ADD produit
            </button>
        </a>
        @endcan
    </div>

        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 max-h-[500px] overflow-y-auto">
        <table class="table">
                <thead class="text-white bg-gray-900 sticky top-0 z-10">

                <tr>
                    <th class="text-center">Image</th>
                    <th class="text-center">Libelle</th>
                    <th class="text-center">Prix (FCFA)</th>
                    <th class="text-center">Quantité en stock</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produits as $produit)
                    <tr class="hover:bg-gray-50 border-b border-gray-200">
                        <td class="border-b border-gray-500">
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->libelle }}" class="w-12 h-12 object-cover rounded">
                        </td>
                        <td class=" border-b border-gray-500 text-center">{{ $produit->libelle }}</td>
                        <td class=" border-b border-gray-500 text-center">{{ number_format($produit->prix, 0, ',', ' ') }}</td>
                        <td class=" border-b border-gray-500 text-center">{{ $produit->quantiteStock }}</td>
                        <td class=" border-b border-gray-500 text-center">
                            <div class="flex gap-2">
                                <a href="{{ route('produits.show', $produit->produit_id) }}" class="text-blue-600 hover:text-blue-800" title="Voir">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                <a href="{{ route('produits.edit', $produit->produit_id) }}" class="text-yellow-600 hover:text-yellow-800" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                <form action="{{ route('produits.destroy', $produit->produit_id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-3 text-center text-gray-500">Aucun produit trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
