<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    {{-- 🔹 RESPONSIVE --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Mi App' }}</title>

    {{-- 🔹 VITE CORREGIDO (DEV + BUILD) --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
        <link rel="stylesheet" href="http://localhost:5173/resources/css/app.css">
    @endif

    

</head>

<body class="min-h-screen flex flex-col bg-gray-100 overflow-hidden">


    {{-- Navbar --}}
    <x-layout.navbar />

    {{-- Contenido --}}
    <main class="flex-1 flex flex-col">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-layout.footer />

</body>
</html>