<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">
    @include('layouts.navbar')
    <div class="flex flex-1 overflow-hidden">
        <aside class="w-64 shrink-0 bg-white shadow-md h-full overflow-y-auto">
            @include('layouts.dashbord')
        </aside>
        <main class="flex-1 bg-gray-200 p-4 overflow-y-auto">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')

</body>
</html>
