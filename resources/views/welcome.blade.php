<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SansiFolios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-[#1f2a44] text-white flex flex-wrap items-center justify-between gap-4 px-8 py-4">
    <h1 class="font-bold text-xl">SansiFolios</h1>

    <div class="flex flex-wrap items-center gap-6">
        <a href="#" class="text-teal-400">INICIO</a>
        <a href="#">CARACTERÍSTICAS</a>
        <a href="#">PORTAFOLIOS</a>
    </div>

    <div class="flex flex-wrap items-center gap-4">
        <button id="openLoginModal" class="text-white hover:text-sky-200">INICIAR SESIÓN</button>
        <a href="/registro" class="bg-sky-500 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-sky-600">REGISTRARSE</a>
    </div>
</nav>

<!-- HERO -->
<section class="text-center py-32 bg-white">
    <h1 class="text-5xl font-bold text-[#1f2a44]">
        Tu Portafolio, Tu Futuro.
        <span class="text-sky-500">Sin Límites.</span>
    </h1>

    <p class="mt-6 max-w-3xl mx-auto text-gray-600">
        Gestiona tus proyectos, habilidades y experiencia en una sola plataforma digital diseñada para destacar tu talento.
    </p>

    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
        <a href="/registro" class="bg-sky-500 text-white px-8 py-3 rounded-full text-sm font-semibold shadow-lg hover:bg-sky-600">
            Crear cuenta
        </a>

        <button id="heroLoginBtn" class="bg-white text-[#1f2a44] px-8 py-3 rounded-full text-sm font-semibold shadow border border-gray-200 hover:bg-gray-50">
            Iniciar sesión
        </button>
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10 px-6 md:px-10">
        <div class="bg-white p-6 rounded-3xl shadow-lg shadow-slate-200/60">
            <h3 class="font-bold mb-2">Portafolio</h3>
            <p class="text-sm text-gray-500">Organiza tu información profesional con estilo y claridad.</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-lg shadow-slate-200/60">
            <h3 class="font-bold mb-2">Proyectos</h3>
            <p class="text-sm text-gray-500">Muestra tus trabajos realizados en una vista moderna y atractiva.</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-lg shadow-slate-200/60">
            <h3 class="font-bold mb-2">Acceso Seguro</h3>
            <p class="text-sm text-gray-500">Autenticación y privacidad pensadas para tu tranquilidad.</p>
        </div>
    </div>
</section>

@include('Auth.login')

<script>
    const modal = document.getElementById('loginModal');
    const openButtons = [document.getElementById('openLoginModal'), document.getElementById('heroLoginBtn')];
    const closeButton = document.getElementById('closeModal');

    const toggleModal = () => {
        if (!modal) return;
        modal.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    };

    openButtons.forEach(btn => {
        if (btn) btn.addEventListener('click', toggleModal);
    });

    if (closeButton) closeButton.addEventListener('click', toggleModal);

    if (modal) {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) toggleModal();
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            toggleModal();
        }
    });
</script>

</body>
</html>
