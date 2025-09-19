@extends('layouts.base_no_dashbord')

@section('content')

<div class="p-6">
            <a href="{{ route('clients.index') }}"><button  class="btn btn-neutral">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
</svg>
retour
            </button></a>
            </div>

    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8 justify-center">

        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Formulaire d'enregistrement d'un client</h1>

        <form action="{{route('clients.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Nom"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                    @error('first_name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
            </div>

            <div>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Prenom"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                    @error('name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
            </div>

            <div>
                <input type="tel" name="contact" value="{{ old('contact') }}" placeholder="contact"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                    @error('contact')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror

            </div>

            <div>
                <input type="text" name="adresse" value="{{ old('adresse') }}" placeholder="Adresse"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                    @error('adresse')
                      <div class="text-red-500 text-sm">{{ $message }}</div>
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
