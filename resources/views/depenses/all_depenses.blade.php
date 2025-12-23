@extends("layouts.base")

@section("content")
<div class="p-12">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-5">
            <form method="GET" action="{{ route('allDepenses') }}" class="flex items-center gap-4">
                filter par date :
                <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                <button type="submit" class="btn btn-neutral">Valider</button>
            </form>

            <div>
            <a href="{{route('allDepenses')}}"><button  class="btn btn-neutral">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
  <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
</svg>ACTUALISER
            </button></a>
            </div>
            
        </div>

    

        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 max-h-[500px] overflow-y-auto">
        <table class="table">
                <thead class="text-white bg-gray-900 sticky top-0 z-10">

                <tr>
                    <th>Montant</th>
                    <th>Motif</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($depenses as $depense)
                    <tr>
                        <td>{{ $depense->montant }} FCFA</td>
                        <td>{{ $depense->motif ?? 'non specifier' }}</td>
                        <td>{{ date('d/m/Y', strtotime($depense->created_at)) }}</td>
                        <td>
                            <div class="flex gap-2">

                                <a href="{{ route('depenses.edit', $depense->depense_id) }}">
                                    <button class="text-yellow-600 hover:text-yellow-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                </a>
                                <form action="{{ route('depenses.destroy', $depense->depense_id) }}" method="POST" onsubmit="return confirm('Supprimer cette dépense ?')">
                                    @csrf
                                    @method('DELETE')
                                   <button class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                                </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Aucune dépense enregistrée.</td>
                    </tr>
                    @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
