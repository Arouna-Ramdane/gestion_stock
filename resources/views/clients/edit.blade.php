    @extends('layouts.base')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8 justify-center">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Modification du client</h1>

        <form action="{{ route('clients.update', $personne->client_id)}}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <input type="text" name="first_name" value="{{ $personne->first_name }}" required placeholder="Prénom"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <input type="text" name="name" value="{{ $personne->name }}" required placeholder="Nom"
                 class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <input type="tel" name="contact" value="{{ $personne->contact }}" required placeholder="Contact"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <input type="text" name="adresse" value="{{ $personne->adresse }}" required placeholder="Adresse"
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
