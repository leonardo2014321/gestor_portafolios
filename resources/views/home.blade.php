<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SansiFolios - UMSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @include('_styles_menu')

    <style>
        /* ── Reset específico del home (sobreescribe lo del menú) ── */
        html, body {
            height: auto !important;
            overflow: auto !important;
            background: #f5f5f5;
        }

        /* ── SPA vistas ── */
        .spa-view        { display: none; }
        .spa-view.active { display: block; }

        /* ── Topbar del home (sticky) ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
        }
                /* ── Las vistas del menú incluidas en el home necesitan scroll ── */
        #view-caracteristicas,
        #view-portafolios,
        #view-explorador {
            min-height: 100vh;
            overflow-y: auto;
            padding: 1.6rem 1.8rem;
            background: #f1f5f9;
        }

        /* ── El explorador necesita su padding propio ── */
        #view-explorador {
            padding: 1.6rem 1.8rem;
        }
    </style>
</head>

<body class="bg-[#f5f5f5]">

<x-layout.navbar />

{{-- ══ VISTA: INICIO ══ --}}
<div id="view-inicio" class="spa-view active">

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
                    <a href="#" onclick="spaNav('portafolios'); return false;"
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

    <section class="bg-gradient-to-b from-[#6a85f1] to-[#c13c78] py-20">
        <div class="text-center text-black mb-16">
            <h3 class="text-3xl font-bold" style="font-family:'Plus Jakarta Sans',sans-serif;">
                {{ __('app.home.seccion_titulo') }}
            </h3>
            <p class="mt-2 text-sm">{{ __('app.home.seccion_desc') }}</p>
        </div>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-6">
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
            <div class="bg-teal-200 p-8 rounded-3xl">
                <img src="{{ asset('images/icono-medalla.png') }}" class="w-12 mb-4" alt="">
                <h4 class="text-xl font-bold mb-2">{{ __('app.home.card2_titulo') }}</h4>
                <p class="text-sm">{{ __('app.home.card2_desc') }}</p>
                <p class="mt-6 text-xs font-bold">{{ __('app.home.card2_cta') }}</p>
            </div>
            <div class="bg-indigo-100 p-6 rounded-3xl">
                <img src="{{ asset('images/icono-perfil.png') }}" class="w-12 mb-3" alt="">
                <h4 class="font-bold text-lg">{{ __('app.home.card3_titulo') }}</h4>
                <p class="text-sm text-gray-600">{{ __('app.home.card3_desc') }}</p>
            </div>
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

</div>{{-- fin #view-inicio --}}


{{-- ══ VISTA: CARACTERÍSTICAS ══ --}}
<div id="view-caracteristicas" class="spa-view">
    @include('_caracteristicas_menu')
</div>


{{-- ══ VISTA: PORTAFOLIOS ══ --}}
<div id="view-portafolios" class="spa-view">
    @include('_portafolios_menu')
</div>


{{-- ══ VISTA: EXPLORADOR ══ --}}
<div id="view-explorador" class="spa-view">
    @include('_explorador_menu')
</div>


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

@guest
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);

        if (params.get('verificado') === '1') {
            window.history.replaceState({}, '', '/');
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            const msg = document.getElementById('loginMensaje');
            if (msg) {
                msg.innerHTML = '✔ Cuenta verificada. Ya puedes iniciar sesión.';
                msg.className = 'mt-3 text-sm text-green-600';
            }
        }

        if (params.get('registro') === '1') {
            window.history.replaceState({}, '', '/');
            const registerModal = document.getElementById('registerModal');
            if (registerModal) {
                registerModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }
    });

    window.addEventListener('storage', function(event) {
        if (event.key === 'email_verificado') {
            localStorage.removeItem('email_verificado');
            const registerModal = document.getElementById('registerModal');
            if (registerModal) registerModal.classList.add('hidden');
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            const msg = document.getElementById('loginMensaje');
            if (msg) {
                msg.innerHTML = '✔ Cuenta verificada. Ya puedes iniciar sesión.';
                msg.className = 'mt-3 text-sm text-green-600';
            }
        }
    });
</script>
@endguest

{{-- ══ SPA: función de navegación para el home ══ --}}
<script>
function spaNav(view) {
    if (typeof showView === 'function') {
        showView(view);
        return;
    }
    // Quitar active de todas
    document.querySelectorAll('.spa-view').forEach(v => v.classList.remove('active'));
    // Activar la pedida
    const target = document.getElementById('view-' + view);
    if (target) {
        target.classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}
</script>

</body>
</html>