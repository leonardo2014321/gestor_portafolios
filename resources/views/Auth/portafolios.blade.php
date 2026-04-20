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
   <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-1 pb-20">
        
        <!-- ================= CABECERA DE SECCIÓN ================= -->
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

        <!-- ================= FILTROS DE CATEGORÍA ================= -->
        <div class="sticky top-0 z-10 bg-[#f8fafc]/80 backdrop-blur-md py-6 border-b border-gray-200">
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

        <!-- ================= GRID DE PORTAFOLIOS ================= -->
        <section class="max-w-7xl mx-auto px-6 mt-12">
            <!-- Grid: 1 columna en móvil, 2 en tablet, 3 o 4 en PC -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                
                <!-- EJEMPLO 1: ARQUITECTURA -->
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
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            Ver Perfil <i class="bi bi-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- EJEMPLO 2: SALUD -->
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
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            Ver Perfil <i class="bi bi-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- EJEMPLO 3: NEGOCIOS -->
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
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            Ver Perfil <i class="bi bi-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- EJEMPLO 4: EDUCACIÓN -->
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
                        <a href="#" class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-gray-900 rounded-2xl text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            Ver Perfil <i class="bi bi-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- 3. El Footer siempre quedará al final gracias al flex-1 del main -->
    <x-layout.footer />

</body>
</html>