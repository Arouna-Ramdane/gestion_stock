   @extends('layouts.base_no_dashbord')

@section('content')


<div class="p-6">
            <a href="{{route('users.index')}}"><button  class="btn btn-neutral">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
</svg>
retour
            </button></a>
            </div>

            @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8 justify-center">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Modification de l'Utilisateur</h1>

        <form action="{{ route('users.update', $personne->user_id) }}" method="POST" enctype="multipart/form-data">
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
                <div>
                <input type="file" name="profile" value="{{ old('profile') }}" placeholder="profile"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <input type="email" name="email" value="{{ $personne->email }}" required placeholder="Email"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <input type="text" name="adresse" value="{{ $personne->adresse }}" required placeholder="Adresse"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <input type="password" name="password" value="{{ $personne->password }}" required placeholder="Mot de passe"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div class="flex justify-between pt-4">
                <button type="submit"
                    class="btn btn-neutral px-6 py-2 rounded-lg hover:bg-gray-700 transition">Enregistrer</button>
               <button type="reset"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Annuler</button>
            </div>
        </form>
    </div>

@endsection
