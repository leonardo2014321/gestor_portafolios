<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SansiFolios</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#f5f5f5]">

<!-- ================= HEADER ================= -->
<header class="bg-[#050b36] h-20 flex items-center justify-between px-10">

    <!-- LOGO + TEXTO -->
    <div class="flex items-center gap-3">
        
        <!-- Imagen del logo -->
        <img src="{{ asset('images/logo.png') }}" 
             class="w-20 h-10 object-contain">

        <!-- Texto -->
        <h1 class="text-2xl font-bold text-white">
            Sansi<span class="text-red-500">Folios</span>
        </h1>
    </div>

    <!-- Menú de navegación -->
    <nav class="flex gap-8 text-white">
        <a href="#" class="text-cyan-300 font-semibold">Inicio</a>
        <a href="#">Características</a>
        <a href="#">Portafolios</a>
    </nav>

    <!-- Botones -->
    <div class="flex gap-4">
        <button class="text-white">Iniciar Sesión</button>
        <button class="bg-blue-600 px-4 py-2 rounded-lg text-white">
            Registrarse
        </button>
    </div>

</header>

<!-- ================= HERO ================= -->
<section class="py-20">

    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 items-center px-10">

        <!-- TEXTO -->
        <div>
            <h2 class="text-6xl font-bold text-[#1f2a44] leading-tight">
                Tu Portafolio,<br>
                Tu Futuro.<br>
                <span class="text-blue-600">Sin Limites.</span>
            </h2>

            <p class="mt-6 text-gray-600 text-lg">
                Gestiona tus proyectos, habilidades y experiencia
                en una sola plataforma profesional.
            </p>

            <!-- BOTONES -->
            <div class="mt-6 flex gap-4">

                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl flex items-center gap-2">
                    Empezar Ahora →
                </button>

                <button class="border px-6 py-3 rounded-xl text-blue-600 flex items-center gap-2">
                    Ver portafolios →
                </button>

            </div>
        </div>

        <!-- IMAGEN HERO -->
        <div class="flex justify-end">
            <img src="{{ asset('images/imagen-hero.jpeg') }}"
                 class="w-[550px] rounded-xl shadow-lg">
        </div>

    </div>
</section>

<!-- ================= SECCIÓN CARACTERÍSTICAS ================= -->
<section class="bg-gradient-to-b from-[#6a85f1] to-[#c13c78] py-20">

    <!-- TÍTULO -->
    <div class="text-center text-black mb-16">
        <h3 class="text-3xl font-bold">
            Todo tu perfil profesional en un solo lugar
        </h3>

        <p class="mt-2 text-sm">
            Crea, gestiona y comparte tu portafolio digital con proyectos,
            habilidades y experiencia profesional de forma sencilla.
        </p>
    </div>

    <!-- GRID PRINCIPAL -->
    <div class="max-w-6xl mx-auto grid grid-cols-3 gap-6 px-6">

        <!-- ===== TARJETA PORTAFOLIO (GRANDE) ===== -->
        <div class="col-span-2 bg-pink-100 p-8 rounded-3xl">

            <!-- ICONO -->
            <img src="{{ asset('images/folder.png') }}"
                 class="w-8 mb-4">

            <h4 class="text-xl font-bold mb-2">
                Creación de Portafolio
            </h4>

            <p class="text-gray-600 mb-6">
                Construye tu portafolio profesional de forma sencilla y organiza tu información en un solo lugar.
            </p>

            <!-- SUB OPCIONES -->
            <div class="grid grid-cols-2 gap-4">

                <div class="bg-white p-4 rounded-xl border text-sm">
                    <b>Comparte tu portafolio</b><br>
                    <span class="text-gray-400 text-xs">COMPARTE TU PERFIL</span>
                </div>

                <div class="bg-white p-4 rounded-xl border text-sm text-pink-600">
                    <b>Exportación PDF</b><br>
                    <span class="text-gray-400 text-xs">COMPARTE TU PORTAFOLIO</span>
                </div>

            </div>
        </div>

        <!-- ===== TARJETA PROYECTOS ===== -->
        <div class="bg-teal-200 p-8 rounded-3xl">

            <img src="{{ asset('images/icono-medalla.png') }}"
                 class="w-12 mb-4">

            <h4 class="text-xl font-bold mb-2">
                Gestión de Proyectos
            </h4>

            <p class="text-sm">
                Agrega y administra tus proyectos con descripciones,
                tecnologías y evidencias.
            </p>

            <p class="mt-6 text-xs font-bold">
                ACCEDER A TU CUENTA →
            </p>
        </div>

        <!-- ===== TARJETA PERFIL ===== -->
        <div class="bg-indigo-100 p-6 rounded-3xl">

            <img src="{{ asset('images/icono-perfil.png') }}" class="w-12 mb-3">

            <h4 class="font-bold text-lg">Perfil Profesional</h4>

            <p class="text-sm text-gray-600">
                Muestra tu información personal, experiencia y habilidades.
            </p>
        </div>

        <!-- ===== TARJETA SEGURIDAD ===== -->
        <div class="col-span-2 bg-sky-100 p-6 rounded-3xl flex justify-between items-center">

            <!-- TEXTO -->
            <div>
                <img src="{{ asset('images/icono-seguro.png') }}" class="w-12 mb-2">

                <h4 class="font-bold text-lg">Acceso Seguro</h4>

                <p class="text-sm text-gray-600">
                    Sistema de autenticación con registro, inicio de sesión y recuperación de contraseña.
                </p>
            </div>

            <!-- IMAGEN -->
            <img src="{{ asset('images/icono-seguridad.jpeg') }}"
                 class="w-40 rounded-xl">
        </div>

    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-[#050b36] py-6">

    <div class="max-w-7xl mx-auto flex items-center justify-end gap-6 px-10">

        <!-- Imagen (logo pequeño) -->
        <img src="{{ asset('images/InfinityCode.jpeg') }}"
             class="w-28 object-contain">

        <!-- Texto -->
        <p class="text-white text-sm">
            © 2026 Infinity Code. Todos los derechos reservados.
        </p>

    </div>

</footer>

</body>
</html>