<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SansiFolios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-[#1f2a44] text-white flex items-center justify-between px-8 py-4">
    <h1 class="font-bold text-xl">SansiFolios</h1>

    <div class="space-x-6">
        <a href="#" class="text-teal-400">INICIO</a>
        <a href="#">CARACTERÍSTICAS</a>
        <a href="#">PORTAFOLIOS</a>
    </div>

    <div class="space-x-4">
        <a href="/login">INICIAR SESIÓN</a>
        <a href="/register" class="bg-sky-500 px-4 py-2 rounded">REGISTRARSE</a>
    </div>
</nav>

<!-- HERO -->
<section class="text-center py-32 bg-white">
    <h1 class="text-5xl font-bold text-[#1f2a44]">
        Tu Portafolio, Tu Futuro.
        <span class="text-sky-500">Sin Límites.</span>
    </h1>

    <p class="mt-6 text-gray-600">
        Gestiona tus proyectos, habilidades y experiencia en una sola plataforma.
    </p>

    <div class="mt-6 space-x-4">
        <a href="/register" class="bg-sky-500 text-white px-6 py-3 rounded-xl">
            Crear cuenta
        </a>

        <a href="#" class="bg-gray-200 px-6 py-3 rounded-xl">
            Ver portafolios
        </a>
    </div>
</section>

<!-- FEATURES -->
<section class="py-20 bg-gray-100 text-center">
    <h2 class="text-3xl font-bold text-[#1f2a44]">
        Todo tu perfil profesional en un solo lugar
    </h2>

    <p class="mt-4 text-gray-600">
        Crea, gestiona y comparte tu portafolio digital fácilmente.
    </p>

    <div class="grid grid-cols-3 gap-6 mt-10 px-10">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-bold">Portafolio</h3>
            <p class="text-sm text-gray-500">Organiza tu información profesional</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-bold">Proyectos</h3>
            <p class="text-sm text-gray-500">Muestra tus trabajos realizados</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-bold">Acceso Seguro</h3>
            <p class="text-sm text-gray-500">Autenticación y privacidad</p>
        </div>
    </div>
</section>

</body>
</html>