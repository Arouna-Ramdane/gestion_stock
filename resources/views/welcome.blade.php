<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col items-center justify-center bg-[#081b29] text-white font-[Arial]">

  <h1 class="text-2xl font-bold text-cyan-400 mb-8 text-center px-4">
    BIENVENUE SUR LA PAGE D'ACCUEIL DE NOTRE APPLICATION DE GESTION DE STOCK
  </h1>

  <a href="{{ route('login') }}">
    <button
      class="w-[288px] py-3 px-6 text-lg font-semibold rounded-full cursor-pointer
             bg-gradient-to-r from-cyan-400 to-fuchsia-600 shadow-lg
             transition hover:scale-105 active:scale-95">
      Connectez‑vous
    </button>
  </a>

</body>
</html>
