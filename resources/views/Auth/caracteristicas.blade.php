<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SansiFolios - Características</title>
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

    <main class="flex-1 bg-[#f8fafc] py-12 px-6">
        <div class="max-w-7xl mx-auto">

            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-[#1e293b] mb-2">Características</h1>
                <p class="text-blue-600 font-medium text-lg uppercase tracking-wide">
                    El enfoque aquí es la versatilidad y la facilidad de uso.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div class="space-y-8">
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h3 class="font-bold text-xl text-gray-800">Diseño Adaptable</h3>
                        <p class="text-gray-600 leading-relaxed mt-1">Plantillas profesionales diseñadas para resaltar lo mejor de cada carrera, desde portafolios visuales hasta currículums ejecutivos.</p>
                    </div>
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="font-bold text-xl text-gray-800">Editor Intuitivo</h3>
                        <p class="text-gray-600 leading-relaxed mt-1">Crea y organiza tu información sin complicaciones. Si sabes llenar un formulario, sabes usar SansiFolios.</p>
                    </div>
                    <div class="border-l-4 border-pink-500 pl-4">
                        <h3 class="font-bold text-xl text-gray-800">Marca Personal</h3>
                        <p class="text-gray-600 leading-relaxed mt-1">Personaliza colores, tipografías y secciones para que tu perfil refleje exactamente quién eres como profesional.</p>
                    </div>
                    <div class="border-l-4 border-orange-500 pl-4">
                        <h3 class="font-bold text-xl text-gray-800">Exportación Inteligente</h3>
                        <p class="text-gray-600 leading-relaxed mt-1">Genera una versión en PDF optimizada con un solo clic, lista para enviar por correo o imprimir.</p>
                    </div>
                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="font-bold text-xl text-gray-800">Enlace Único</h3>
                        <p class="text-gray-600 leading-relaxed mt-1 italic">Obtén una URL personalizada <span class="text-blue-600 font-mono text-sm">(sansifolios.com/tu-nombre)</span> para compartir en redes sociales.</p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative bg-white rounded-2xl overflow-hidden shadow-2xl">
                        <img src="{{ asset('images/caracteristicasima.jpg') }}"
                             alt="Vista previa SansiFolios"
                             class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                </div>

            </div>
        </div>
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