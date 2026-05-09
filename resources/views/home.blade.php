<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SansiFolios - UMSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0f172a;
            --blue: #2563eb;
            --gray2: #e2e8f0;
            --gray3: #cbd5e1;
            --muted: #64748b;
        }
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
        .logo-img { width: 44px; height: 44px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.08); padding: 2px; }
        .sysname { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .sysname span { color: #f87171; }
        .tb-bell { width: 36px; height: 36px; border-radius: 9px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .tb-bell svg { width: 16px; height: 16px; fill: none; stroke: rgba(255,255,255,0.7); stroke-width: 2; stroke-linecap: round; }
        .sb-av { border-radius: 50%; overflow: hidden; flex-shrink: 0; background: linear-gradient(135deg, #3b82f6, #0d9488); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #fff; font-family: 'DM Sans', sans-serif; }
        footer { height: 40px; background: var(--navy); display: flex; align-items: center; justify-content: center; }
        .footer-content { display: flex; align-items: center; justify-content: center; gap: 10px; }
        .footer-logo { height: 20px; width: auto; object-fit: contain; display: block; }
        footer p { font-size: 11.5px; color: #5a7fa0; display: flex; align-items: center; gap: 6px; margin: 0; font-family: 'DM Sans', sans-serif; }
        footer b { color: #7a9cc0; }
        @media (max-width: 768px) {
            .topbar { padding: 0 16px; height: auto; padding-top: 10px; padding-bottom: 10px; flex-wrap: wrap; gap: 10px; }
            .tb-left { width: 100%; justify-content: space-between; }
            .tb-right { width: 100%; justify-content: flex-end; }
            .sysname { font-size: 18px; }
            .tb-nav { display: none; }
        }
        @media (max-width: 480px) { .sysname { display: none; } }
    </style>
</head>

<body class="bg-[#f5f5f5]">

<x-layout.navbar />

{{-- HERO --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center px-6 md:px-10">
        <div>
            <h2 class="text-4xl md:text-6xl font-bold text-[#1f2a44] leading-tight"
                style="font-family:'Plus Jakarta Sans',sans-serif;">
                {{ __('app.home.hero_linea1') }}<br>
                {{ __('app.home.hero_linea2') }}<br>
                <span class="text-blue-600">{{ __('app.home.hero_linea3') }}</span>
            </h2>
            <p class="mt-6 text-gray-600 text-lg">
                {{ __('app.home.hero_desc') }}
            </p>
            <div class="mt-6 flex flex-col sm:flex-row gap-4">
                @auth
                    <a href="{{ route('menu') }}"
                       class="bg-blue-600 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-blue-700 transition">
                        {{ __('app.home.ir_dashboard') }}
                    </a>
                @else
                    <button id="openLoginModal"
                            class="bg-blue-600 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-blue-700 transition">
                        {{ __('app.home.empezar') }}
                    </button>
                @endauth
                <a href="{{ route('portafolios.index') }}"
                   class="border px-6 py-3 rounded-xl text-blue-600 flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                    {{ __('app.home.ver_portafolios') }}
                </a>
            </div>
        </div>
        <div class="flex justify-center md:justify-end mt-8 md:mt-0">
            <img src="{{ asset('images/imagen-hero.jpeg') }}"
                 class="w-full max-w-sm md:max-w-[550px] rounded-xl shadow-lg"
                 alt="SansiFolios hero">
        </div>
    </div>
</section>

{{-- SECCIÓN CARACTERÍSTICAS --}}
<section class="bg-gradient-to-b from-[#6a85f1] to-[#c13c78] py-20">
    <div class="text-center text-black mb-16">
        <h3 class="text-3xl font-bold" style="font-family:'Plus Jakarta Sans',sans-serif;">
            {{ __('app.home.seccion_titulo') }}
        </h3>
        <p class="mt-2 text-sm">
            {{ __('app.home.seccion_desc') }}
        </p>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-6">

        {{-- Tarjeta portafolio --}}
        <div class="md:col-span-2 bg-pink-100 p-8 rounded-3xl">
            <img src="{{ asset('images/folder.png') }}" class="w-8 mb-4" alt="">
            <h4 class="text-xl font-bold mb-2">{{ __('app.home.card1_titulo') }}</h4>
            <p class="text-gray-600 mb-6">{{ __('app.home.card1_desc') }}</p>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-xl border text-sm">
                    <b>{{ __('app.home.card1_sub1') }}</b><br>
                    <span class="text-gray-400 text-xs">{{ __('app.home.card1_sub1_label') }}</span>
                </div>
                <div class="bg-white p-4 rounded-xl border text-sm text-pink-600">
                    <b>{{ __('app.home.card1_sub2') }}</b><br>
                    <span class="text-gray-400 text-xs">{{ __('app.home.card1_sub2_label') }}</span>
                </div>
            </div>
        </div>

        {{-- Tarjeta proyectos --}}
        <div class="bg-teal-200 p-8 rounded-3xl">
            <img src="{{ asset('images/icono-medalla.png') }}" class="w-12 mb-4" alt="">
            <h4 class="text-xl font-bold mb-2">{{ __('app.home.card2_titulo') }}</h4>
            <p class="text-sm">{{ __('app.home.card2_desc') }}</p>
            <p class="mt-6 text-xs font-bold">{{ __('app.home.card2_cta') }}</p>
        </div>

        {{-- Tarjeta perfil --}}
        <div class="bg-indigo-100 p-6 rounded-3xl">
            <img src="{{ asset('images/icono-perfil.png') }}" class="w-12 mb-3" alt="">
            <h4 class="font-bold text-lg">{{ __('app.home.card3_titulo') }}</h4>
            <p class="text-sm text-gray-600">{{ __('app.home.card3_desc') }}</p>
        </div>

        {{-- Tarjeta seguridad --}}
        <div class="md:col-span-2 bg-sky-100 p-6 rounded-3xl flex justify-between items-center">
            <div>
                <img src="{{ asset('images/icono-seguro.png') }}" class="w-12 mb-2" alt="">
                <h4 class="font-bold text-lg">{{ __('app.home.card4_titulo') }}</h4>
                <p class="text-sm text-gray-600">{{ __('app.home.card4_desc') }}</p>
            </div>
            <img src="{{ asset('images/icono-seguridad.jpeg') }}" class="w-40 rounded-xl" alt="">
        </div>

    </div>
</section>

<x-layout.footer />

@guest
    @include('Auth.login')
    @include('Auth.registro')
    @include('Auth.recuperar')
@endguest

@guest
<script>
    const modal       = document.getElementById('loginModal');
    const closeButton = document.getElementById('closeModal');
    const openButtons = [
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

@if ($errors->any() || session('cuenta_desactivada'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('loginModal');
        if (modal) { modal.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
    });
</script>
@endif

@if(session('email_verificado') === true)
<script>localStorage.setItem('email_verificado', 'true');</script>
@endif

</body>
</html>