<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETS AROUNA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body>
    @include('layouts.navbar')
    <div class="flex-1 bg-gray-200 h-screen overflow-y-auto">
        @yield('content')
    </div>
     <footer class="bg-white text-black mt-auto">
        @include('layouts.footer')
    </footer>
</body>
</html>
