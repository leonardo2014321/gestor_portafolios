<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SansiFolios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- 1. Agregamos min-h-screen (mínimo toda la pantalla) y flex-col -->
<body class="bg-[#f5f5f5] min-h-screen flex flex-col">

    <x-layout.navbar />

    <!-- 2. Envolvemos la sección en un <main> con 'flex-1' -->
    <!-- 'flex-1' obliga a esta parte a estirarse y empujar al footer hacia abajo -->
   <main class="flex-1 bg-[#f8fafc] py-12 px-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- TÍTULO Y SUBTÍTULO -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-[#1e293b] mb-2">Características</h1>
            <p class="text-blue-600 font-medium text-lg uppercase tracking-wide">
                El enfoque aquí es la versatilidad y la facilidad de uso.
            </p>
        </div>

        <!-- CONTENIDO PRINCIPAL: Texto e Imagen -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- COLUMNA IZQUIERDA: LISTA DE CARACTERÍSTICAS -->
            <div class="space-y-8">
                
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-bold text-xl text-gray-800">Diseño Adaptable</h3>
                    <p class="text-gray-600 leading-relaxed mt-1">
                        Plantillas profesionales diseñadas para resaltar lo mejor de cada carrera, desde portafolios visuales hasta currículums ejecutivos.
                    </p>
                </div>

                <div class="border-l-4 border-purple-500 pl-4">
                    <h3 class="font-bold text-xl text-gray-800">Editor Intuitivo</h3>
                    <p class="text-gray-600 leading-relaxed mt-1">
                        Crea y organiza tu información sin complicaciones. Si sabes llenar un formulario, sabes usar SansiFolios.
                    </p>
                </div>

                <div class="border-l-4 border-pink-500 pl-4">
                    <h3 class="font-bold text-xl text-gray-800">Marca Personal</h3>
                    <p class="text-gray-600 leading-relaxed mt-1">
                        Personaliza colores, tipografías y secciones para que tu perfil refleje exactamente quién eres como profesional.
                    </p>
                </div>

                <div class="border-l-4 border-orange-500 pl-4">
                    <h3 class="font-bold text-xl text-gray-800">Exportación Inteligente</h3>
                    <p class="text-gray-600 leading-relaxed mt-1">
                        Genera una versión en PDF optimizada con un solo clic, lista para enviar por correo o imprimir.
                    </p>
                </div>

                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-bold text-xl text-gray-800">Enlace Único</h3>
                    <p class="text-gray-600 leading-relaxed mt-1 italic">
                        Obtén una URL personalizada <span class="text-blue-600 font-mono text-sm">(sansifolios.com/tu-nombre)</span> para compartir en redes sociales.
                    </p>
                </div>

            </div>

            <!-- COLUMNA DERECHA: IMAGEN ILUSTRATIVA -->
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

    <!-- 3. El Footer siempre quedará al final gracias al flex-1 del main -->
    <x-layout.footer />

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
</body>
</html>