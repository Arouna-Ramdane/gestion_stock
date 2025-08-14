@extends('layouts.base_no_dashbord')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white font-sans">
    <div class="w-full max-w-md bg-[#1e293b] p-8 rounded-xl shadow-xl border border-white/10">

          <h1 class="text-2xl font-bold text-cyan-400 text-center px-4">Connexion</h1>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block font-bold text-cyan-400 mb-1">Email</label>
                <input type="email" name="email" id="email" placeholder="exemple@gmail.com" class="w-full px-4 py-2 rounded bg-[#334155] font-bold text-gray-200 placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-cyan-400" required/>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>
            <div>
                <label for="password" class="block font-bold text-cyan-400 mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="••••••" class="w-full px-4 py-2 rounded bg-[#334155] font-bold text-gray-200 placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-cyan-400" required/>
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="submit"
                class="w-full py-2 rounded text-white font-semibold bg-gradient-to-r from-cyan-400 to-fuchsia-600  hover:opacity-90 transition">
                Se connecter
            </button>
        </form>
    </div>
</div>
@endsection
