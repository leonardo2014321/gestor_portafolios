<!-- Usamos x-layouts.app porque tu carpeta se llama layouts con 's' -->
<x-layouts.app>
    <div class="p-4 lg:p-8">
        <!-- Título -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Sistema de Portafolios
            </h1>
            <p class="text-slate-500 text-sm">Gestión institucional de activos digitales - UMSS</p>
        </div>

        <!-- Buscador -->
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200 mb-8">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="flex-1 flex items-center gap-3 bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-3 focus-within:border-blue-500 transition-all">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"></circle><line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2"></line></svg>
                    <input type="text" value="Pro" class="bg-transparent border-none outline-none w-full text-slate-700 font-medium" placeholder="Buscar proyectos, habilidades...">
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all">
                    Buscar
                </button>
            </div>

            <div class="flex flex-wrap gap-2">
                <button class="px-5 py-2 rounded-full bg-blue-600 text-white font-bold text-xs">Todos</button>
                <button class="px-5 py-2 rounded-full bg-slate-100 text-slate-500 font-bold text-xs hover:bg-slate-200">Proyectos</button>
                <button class="px-5 py-2 rounded-full bg-slate-100 text-slate-500 font-bold text-xs hover:bg-slate-200">Documentos</button>
                <button class="px-5 py-2 rounded-full bg-slate-100 text-slate-500 font-bold text-xs hover:bg-slate-200">Habilidades</button>
            </div>
        </div>

        <!-- Resultados -->
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                4 RESULTADOS ENCONTRADOS
            </h2>
        </div>

        <!-- Grid de Tarjetas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Tarjeta 1 -->
            <div class="bg-sky-500 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-lg group cursor-pointer transition-all hover:-translate-y-1">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl leading-tight">Programa de Optimización Fiscal</h3>
                    </div>
                    <p class="text-xs opacity-90 leading-relaxed mb-6">Mejora de flujos de caja institucionales mediante procesamiento de datos.</p>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-white/10 rounded-lg text-[9px] font-bold border border-white/20">#FINANCE</span>
                        <span class="px-3 py-1 bg-white/10 rounded-lg text-[9px] font-bold border border-white/20">#AGILE</span>
                    </div>
                </div>
                <svg class="absolute -bottom-6 -right-6 w-40 h-40 text-white/10 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
            </div>

            <!-- Tarjeta 2 -->
            <div class="bg-blue-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-lg group cursor-pointer transition-all hover:-translate-y-1">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl leading-tight">Programación en PHP / Symfony</h3>
                    </div>
                    <p class="text-xs opacity-90 leading-relaxed mb-6">Desarrollo de prototipos escalables y gestión de sistemas institucionales.</p>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-white/10 rounded-lg text-[9px] font-bold border border-white/20">#PHP</span>
                        <span class="px-3 py-1 bg-white/10 rounded-lg text-[9px] font-bold border border-white/20">#BACKEND</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>