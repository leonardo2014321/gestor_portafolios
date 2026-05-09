<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SansiFolios - UMSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Estilos mínimos que necesita el navbar/footer --}}
    <style>
        :root {
            --navy: #0f172a;
            --blue: #2563eb;
            --gray2: #e2e8f0;
            --gray3: #cbd5e1;
            --muted: #64748b;
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            height: 64px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .tb-left  { display: flex; align-items: center; gap: 12px; }
        .tb-nav   { display: flex; align-items: center; gap: 28px; }
        .tb-right { display: flex; align-items: center; gap: 10px; }

        .logo-img {
            width: 44px; height: 44px; object-fit: contain;
            border-radius: 8px; background: rgba(255,255,255,0.08); padding: 2px;
        }
        .sysname {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px;
        }
        .sysname span { color: #f87171; }

        .tb-bell {
            width: 36px; height: 36px; border-radius: 9px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center; cursor: pointer;
        }
        .tb-bell svg {
            width: 16px; height: 16px; fill: none;
            stroke: rgba(255,255,255,0.7); stroke-width: 2; stroke-linecap: round;
        }

        .sb-av {
            border-radius: 50%; overflow: hidden; flex-shrink: 0;
            background: linear-gradient(135deg, #3b82f6, #0d9488);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-family: 'DM Sans', sans-serif;
        }

        /* ── Footer ── */
        footer {
            height: 40px; background: var(--navy);
            display: flex; align-items: center; justify-content: center;
        }
        .footer-content {
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .footer-logo { height: 20px; width: auto; object-fit: contain; display: block; }
        footer p {
            font-size: 11.5px; color: #5a7fa0;
            display: flex; align-items: center; gap: 6px; margin: 0;
            font-family: 'DM Sans', sans-serif;
        }
        footer b { color: #7a9cc0; }

        /* ── Responsive navbar ── */
        @media (max-width: 768px) {
            .topbar { padding: 0 16px; height: auto; padding-top: 10px; padding-bottom: 10px; flex-wrap: wrap; gap: 10px; }
            .tb-left { width: 100%; justify-content: space-between; }
            .tb-right { width: 100%; justify-content: flex-end; }
            .sysname { font-size: 18px; }
            .tb-nav { display: none; }
        }
        @media (max-width: 480px) {
            .sysname { display: none; }
        }
    </style>
</head>

<body class="bg-[#f5f5f5]">

{{-- Navbar unificado (detecta @auth/@guest automáticamente) --}}
<x-layout.navbar />

{{-- ================= HERO ================= --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center px-6 md:px-10">

        {{-- TEXTO --}}
        <div>
            <h2 class="text-4xl md:text-6xl font-bold text-[#1f2a44] leading-tight"
                style="font-family:'Plus Jakarta Sans',sans-serif;">
                Tu Portafolio,<br>
                Tu Futuro.<br>
                <span class="text-blue-600">Sin Límites.</span>
            </h2>

            <p class="mt-6 text-gray-600 text-lg">
                Gestiona tus proyectos, habilidades y experiencia
                en una sola plataforma profesional.
            </p>

            {{-- BOTONES --}}
            <div class="mt-6 flex flex-col sm:flex-row gap-4">
                @auth
                    {{-- Si ya inició sesión, lo mandamos directo al dashboard --}}
                    <a href="{{ route('menu') }}"
                       class="bg-blue-600 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-blue-700 transition">
                        Ir al Dashboard →
                    </a>
                @else
                    {{-- Si es visitante, abre el modal de login --}}
                    <button id="openLoginModal"
                            class="bg-blue-600 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-blue-700 transition">
                        Empezar Ahora →
                    </button>
                @endauth

                <a href="{{ route('portafolios.index') }}"
                   class="border px-6 py-3 rounded-xl text-blue-600 flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                    Ver portafolios →
                </a>
            </div>
        </div>

        {{-- IMAGEN HERO --}}
        <div class="flex justify-center md:justify-end mt-8 md:mt-0">
            <img src="{{ asset('images/imagen-hero.jpeg') }}"
                 class="w-full max-w-sm md:max-w-[550px] rounded-xl shadow-lg"
                 alt="SansiFolios hero">
        </div>

    </div>
</section>

{{-- ================= SECCIÓN CARACTERÍSTICAS ================= --}}
<section class="bg-gradient-to-b from-[#6a85f1] to-[#c13c78] py-20">

    <div class="text-center text-black mb-16">
        <h3 class="text-3xl font-bold" style="font-family:'Plus Jakarta Sans',sans-serif;">
            Todo tu perfil profesional en un solo lugar
        </h3>
        <p class="mt-2 text-sm">
            Crea, gestiona y comparte tu portafolio digital con proyectos,
            habilidades y experiencia profesional de forma sencilla.
        </p>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-6">

        {{-- Tarjeta portafolio (grande) --}}
        <div class="md:col-span-2 bg-pink-100 p-8 rounded-3xl">
            <img src="{{ asset('images/folder.png') }}" class="w-8 mb-4" alt="">
            <h4 class="text-xl font-bold mb-2">Creación de Portafolio</h4>
            <p class="text-gray-600 mb-6">
                Construye tu portafolio profesional de forma sencilla y organiza
                tu información en un solo lugar.
            </p>
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

        {{-- Tarjeta proyectos --}}
        <div class="bg-teal-200 p-8 rounded-3xl">
            <img src="{{ asset('images/icono-medalla.png') }}" class="w-12 mb-4" alt="">
            <h4 class="text-xl font-bold mb-2">Gestión de Proyectos</h4>
            <p class="text-sm">
                Agrega y administra tus proyectos con descripciones,
                tecnologías y evidencias.
            </p>
            <p class="mt-6 text-xs font-bold">ACCEDER A TU CUENTA →</p>
        </div>

        {{-- Tarjeta perfil --}}
        <div class="bg-indigo-100 p-6 rounded-3xl">
            <img src="{{ asset('images/icono-perfil.png') }}" class="w-12 mb-3" alt="">
            <h4 class="font-bold text-lg">Perfil Profesional</h4>
            <p class="text-sm text-gray-600">
                Muestra tu información personal, experiencia y habilidades.
            </p>
        </div>

        {{-- Tarjeta seguridad --}}
        <div class="md:col-span-2 bg-sky-100 p-6 rounded-3xl flex justify-between items-center">
            <div>
                <img src="{{ asset('images/icono-seguro.png') }}" class="w-12 mb-2" alt="">
                <h4 class="font-bold text-lg">Acceso Seguro</h4>
                <p class="text-sm text-gray-600">
                    Sistema de autenticación con registro, inicio de sesión
                    y recuperación de contraseña.
                </p>
            </div>
            <img src="{{ asset('images/icono-seguridad.jpeg') }}" class="w-40 rounded-xl" alt="">
        </div>

    </div>
</section>

{{-- Footer --}}
<x-layout.footer />

{{-- Modales de auth (solo para visitantes) --}}
@guest
    @include('Auth.login')
    @include('Auth.registro')
    @include('Auth.recuperar')
@endguest

{{-- ── Scripts de modales (solo necesarios para visitantes) ── --}}
@guest
<script>
    /* ── Modal Login ── */
    const modal        = document.getElementById('loginModal');
    const closeButton  = document.getElementById('closeModal');
    const openButtons  = [
        document.getElementById('openLoginModal'),
        document.getElementById('openLoginModalMobile'),
    ];

    const toggleModal = () => {
        if (!modal) return;
        modal.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    };

    openButtons.forEach(btn => { if (btn) btn.addEventListener('click', toggleModal); });
    if (closeButton) closeButton.addEventListener('click', toggleModal);
    if (modal) modal.addEventListener('click', e => { if (e.target === modal) toggleModal(); });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) toggleModal();
    });

    /* ── Modal Registro ── */
    const registerModal   = document.getElementById('registerModal');
    const registerButtons = [
        document.getElementById('openRegisterModal'),
        document.getElementById('openRegisterModalMobile'),
    ];

    const toggleRegister = () => {
        if (!registerModal) return;
        registerModal.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    };

    registerButtons.forEach(btn => { if (btn) btn.addEventListener('click', toggleRegister); });
    if (registerModal) registerModal.addEventListener('click', e => { if (e.target === registerModal) toggleRegister(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && registerModal && !registerModal.classList.contains('hidden')) toggleRegister();
    });

    /* ── Modal Recuperar contraseña ── */
    const modalRecuperar   = document.getElementById('modalRecuperar');
    const recuperarButtons = [ document.getElementById('openRecuperarModal') ];

    const toggleRecuperar = () => {
        if (!modalRecuperar) return;
        modalRecuperar.classList.toggle('hidden');
        document.body.style.overflow = modalRecuperar.classList.contains('hidden') ? 'auto' : 'hidden';
    };

    recuperarButtons.forEach(btn => { if (btn) btn.addEventListener('click', toggleRecuperar); });
    if (modalRecuperar) modalRecuperar.addEventListener('click', e => {
        if (e.target === modalRecuperar) cerrarModalRecuperar();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modalRecuperar && !modalRecuperar.classList.contains('hidden')) cerrarModalRecuperar();
    });
</script>
@endguest

{{-- Reabrir modal login si hay errores de validación --}}
@if ($errors->any() || session('cuenta_desactivada'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    });
</script>
@endif

@if(session('email_verificado') === true)
<script>
    localStorage.setItem('email_verificado', 'true');
</script>
@endif

</body>
</html>