<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SansiFolios - Portafolios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #0f172a; }
        .topbar { background:var(--navy);display:flex;align-items:center;justify-content:space-between;padding:0 28px;height:64px;border-bottom:1px solid rgba(255,255,255,0.06);position:sticky;top:0;z-index:50; }
        .tb-left { display:flex;align-items:center;gap:12px; }
        .tb-nav  { display:flex;align-items:center;gap:28px; }
        .tb-right{ display:flex;align-items:center;gap:10px; }
        .logo-img{ width:44px;height:44px;object-fit:contain;border-radius:8px;background:rgba(255,255,255,0.08);padding:2px; }
        .sysname { font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px; }
        .sysname span { color:#f87171; }
        .tb-bell { width:36px;height:36px;border-radius:9px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;cursor:pointer; }
        .tb-bell svg { width:16px;height:16px;fill:none;stroke:rgba(255,255,255,0.7);stroke-width:2;stroke-linecap:round; }
        .sb-av { border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-family:'DM Sans',sans-serif; }
        footer { height:40px;background:var(--navy);display:flex;align-items:center;justify-content:center; }
        .footer-content { display:flex;align-items:center;justify-content:center;gap:10px; }
        .footer-logo { height:20px;width:auto;object-fit:contain;display:block; }
        footer p { font-size:11.5px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0;font-family:'DM Sans',sans-serif; }
        footer b { color:#7a9cc0; }
        @media(max-width:768px){
            .topbar{padding:0 16px;height:auto;padding-top:10px;padding-bottom:10px;flex-wrap:wrap;gap:10px;}
            .tb-left{width:100%;justify-content:space-between;}
            .tb-right{width:100%;justify-content:flex-end;}
            .sysname{font-size:18px;}
            .tb-nav{display:none;}
        }
        @media(max-width:480px){ .sysname{display:none;} }
    </style>
</head>
<body class="bg-[#f5f5f5] min-h-screen flex flex-col">

    @include('components.layout.navbar')

    <main class="flex-1 pb-20">

        <section class="py-16 bg-[#D9EBFF] border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#1f2a44] mb-4">
                    Inspírate con profesionales reales
                </h1>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                    Explora cómo otros expertos destacan en su industria usando <span class="text-blue-600 font-semibold">SansiFolios</span>.
                    Encuentra ideas para tu propio perfil.
                </p>
            </div>
        </section>

        <div class="sticky top-[64px] z-10 bg-[#f8fafc]/80 backdrop-blur-md py-6 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-wrap justify-center gap-3">
                    <button class="px-6 py-2 rounded-full bg-blue-600 text-white shadow-lg text-sm font-medium transition hover:bg-blue-700">Todos</button>
                    <button class="px-6 py-2 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-medium hover:border-blue-500 hover:text-blue-600 transition">🎨 Creativos</button>
                    <button class="px-6 py-2 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-medium hover:border-blue-500 hover:text-blue-600 transition">🩺 Salud</button>
                    <button class="px-6 py-2 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-medium hover:border-blue-500 hover:text-blue-600 transition">💼 Negocios</button>
                    <button class="px-6 py-2 rounded-full bg-white border border-gray-200 text-gray-600 text-sm font-medium hover:border-blue-500 hover:text-blue-600 transition">🎓 Educación</button>
                </div>
            </div>
        </div>

        <section class="max-w-7xl mx-auto px-6 mt-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

                <div class="group bg-[#D9EBFF] rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/arqui.png') }}" alt="Preview" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-pink-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Arquitectura</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Arq. Roberto Méndez</h4>
                        <p class="text-gray-400 text-xs mb-4">Diseño Sostenible • Cochabamba</p>
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">Ver Perfil</a>
                    </div>
                </div>

                <div class="group bg-[#D9EBFF] rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/fisio.png') }}" alt="Preview" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-emerald-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Fisioterapia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Dra. Elena Vargas</h4>
                        <p class="text-gray-400 text-xs mb-4">Rehabilitación Deportiva • La Paz</p>
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">Ver Perfil</a>
                    </div>
                </div>

                <div class="group bg-[#D9EBFF] rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/contador.png') }}" alt="Preview" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Consultoría</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Lic. Carlos Duarte</h4>
                        <p class="text-gray-400 text-xs mb-4">Estrategia Financiera • Santa Cruz</p>
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">Ver Perfil</a>
                    </div>
                </div>

                <div class="group bg-[#D9EBFF] rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/prof.png') }}" alt="Preview" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-amber-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Docencia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Msc. Ana Jiménez</h4>
                        <p class="text-gray-400 text-xs mb-4">Metodologías Activas • Sucre</p>
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">Ver Perfil</a>
                    </div>
                </div>

            </div>
        </section>
    </main>

    @include('components.layout.footer')

    @guest
        @include('Auth.login')
        @include('Auth.registro')
        @include('Auth.recuperar')

        <script>
            const modal = document.getElementById('loginModal');
            const toggleModal = () => { if(!modal) return; modal.classList.toggle('hidden'); document.body.classList.toggle('overflow-hidden'); };
            ['openLoginModal','openLoginModalMobile'].forEach(id => { const b=document.getElementById(id); if(b) b.addEventListener('click',toggleModal); });
            const closeBtn = document.getElementById('closeModal');
            if(closeBtn) closeBtn.addEventListener('click', toggleModal);
            if(modal) modal.addEventListener('click', e => { if(e.target===modal) toggleModal(); });

            const registerModal = document.getElementById('registerModal');
            const toggleRegister = () => { if(!registerModal) return; registerModal.classList.toggle('hidden'); document.body.classList.toggle('overflow-hidden'); };
            ['openRegisterModal','openRegisterModalMobile'].forEach(id => { const b=document.getElementById(id); if(b) b.addEventListener('click',toggleRegister); });
            if(registerModal) registerModal.addEventListener('click', e => { if(e.target===registerModal) toggleRegister(); });

            document.addEventListener('keydown', e => {
                if(e.key==='Escape'){
                    if(modal && !modal.classList.contains('hidden')) toggleModal();
                    if(registerModal && !registerModal.classList.contains('hidden')) toggleRegister();
                }
            });
        </script>
    @endguest

</body>
</html>