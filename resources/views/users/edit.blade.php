@extends('layouts.base_no_dashbord')

@section('content')

<div class="p-6">
    <a href="{{route('users.index')}}">
        <button class="btn btn-neutral">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            retour
        </button>
    </a>
</div>

<div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8 justify-center">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Modification de l'Utilisateur</h1>

    <form action="{{ route('users.update', $personne->user_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <input type="text" name="first_name" value="{{ old('first_name', $personne->first_name) }}" placeholder="Nom"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input type="text" name="name" value="{{ old('name', $personne->name) }}" placeholder="Pénom"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input type="tel" name="contact" value="{{ old('contact', $personne->contact) }}" placeholder="Contact"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            @error('contact')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input type="file" name="profile" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            @error('profile')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input type="email" name="email" value="{{ old('email', $personne->email) }}"  placeholder="Email"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input type="text" name="adresse" value="{{ old('adresse', $personne->adresse) }}"  placeholder="Adresse"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            @error('adresse')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input type="password" name="password" placeholder="Entrez le nouveau mot de passe si vous souhaitez modifier l'ancien"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
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
