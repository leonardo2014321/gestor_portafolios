{{--
    Partial: Auth/terminos.blade.php
    Modal de Términos y Condiciones — Sansifolios
--}}

<div id="modalTerminos"
    class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm"
    role="dialog" aria-modal="true" aria-labelledby="terminos-titulo">

    <div class="relative w-full max-w-[600px] max-h-[90vh] flex flex-col rounded-[32px] bg-white shadow-[0_30px_80px_rgba(15,23,42,0.22)] ring-1 ring-slate-200/70 font-[Poppins]">

        {{-- Cabecera --}}
        <div class="flex-shrink-0 flex items-center justify-between px-8 pt-7 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600">
                    <svg width="20" height="20" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <div>
                    <h2 id="terminos-titulo" class="text-[15px] font-bold leading-tight">
                        <span class="text-slate-800">{{ __('app.terminos.titulo_prefijo') }}</span><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ __('app.terminos.vigencia') }}</p>
                </div>
            </div>
            <button type="button" onclick="cerrarTerminos()"
                class="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Cuerpo --}}
        <div class="flex-1 overflow-y-auto px-8 py-7 space-y-7 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">

            {{-- Aviso inicial --}}
            <div class="flex gap-3 rounded-2xl bg-slate-50 border border-slate-200 px-5 py-4">
                <svg class="flex-shrink-0 mt-0.5" width="15" height="15" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p class="text-[12.5px] text-slate-500 leading-relaxed">
                    {{ __('app.terminos.aviso_intro') }} <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b>{{ __('app.terminos.aviso_intro_2') }}
                </p>
            </div>

            {{-- 1 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">1</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s1_titulo') }}</h3>
                </div>
                <p class="text-[13px] text-slate-600 leading-[1.85] pl-9">
                    <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s1_texto') }}
                </p>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 2 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">2</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s2_titulo') }}</h3>
                </div>
                <ul class="list-disc pl-9 space-y-2.5">
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s2_item1_a') }} <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s2_item1_b') }} <strong class="text-slate-700">{{ __('app.terminos.s2_item1_edad') }}</strong>{{ __('app.terminos.s2_item1_c') }}</li>
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s2_item2_a') }} <strong class="text-slate-700">{{ __('app.terminos.s2_item2_veraz') }}</strong>{{ __('app.terminos.s2_item2_b') }}</li>
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s2_item3_a') }} <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s2_item3_b') }}</li>
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s2_item4_a') }} <strong class="text-slate-700">{{ __('app.terminos.s2_item4_una') }}</strong>{{ __('app.terminos.s2_item4_b') }}</li>
                </ul>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 3 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">3</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s3_titulo') }}</h3>
                </div>
                <p class="text-[13px] text-slate-600 leading-[1.8] pl-9 mb-3">{{ __('app.terminos.s3_intro_a') }} <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b>{{ __('app.terminos.s3_intro_b') }} <strong class="text-slate-700">{{ __('app.terminos.s3_no') }}</strong>{{ __('app.terminos.s3_intro_c') }}</p>
                <ul class="list-disc pl-9 space-y-2.5">
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s3_item1') }}</li>
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s3_item2') }}</li>
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s3_item3') }}</li>
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s3_item4') }}</li>
                    <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s3_item5') }}</li>
                </ul>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 4 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">4</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s4_titulo') }}</h3>
                </div>
                <div class="pl-9 space-y-3">
                    <p class="text-[13px] text-slate-600 leading-[1.85]">
                        {{ __('app.terminos.s4_p1_a') }} <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b>{{ __('app.terminos.s4_p1_b') }} <strong class="text-slate-700">{{ __('app.terminos.s4_p1_licencia') }}</strong>{{ __('app.terminos.s4_p1_c') }}
                    </p>
                    <p class="text-[13px] text-slate-600 leading-[1.85]">
                        <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> <strong class="text-slate-700">{{ __('app.terminos.s4_p2_no_vende') }}</strong> {{ __('app.terminos.s4_p2_resto') }}
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 5 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">5</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s5_titulo') }}</h3>
                </div>
                <div class="pl-9 space-y-3">
                    <p class="text-[13px] text-slate-600 leading-[1.85]">
                        <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s5_p1_a') }} <strong class="text-slate-700">{{ __('app.terminos.s5_p1_no_comparte') }}</strong>{{ __('app.terminos.s5_p1_b') }}
                    </p>
                    <p class="text-[13px] text-slate-600 leading-[1.85]">
                        {{ __('app.terminos.s5_p2') }}
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 6 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">6</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s6_titulo') }}</h3>
                </div>
                <div class="pl-9 space-y-3">
                    <p class="text-[13px] text-slate-600 leading-[1.8]"><b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s6_intro') }}</p>
                    <ul class="list-disc pl-5 space-y-2.5">
                        <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s6_item1') }}</li>
                        <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s6_item2') }}</li>
                        <li class="text-[13px] text-slate-600 leading-[1.8]">{{ __('app.terminos.s6_item3') }}</li>
                    </ul>
                    <p class="text-[13px] text-slate-600 leading-[1.85]">
                        {{ __('app.terminos.s6_reactivacion') }}
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 7 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">7</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s7_titulo') }}</h3>
                </div>
                <p class="text-[13px] text-slate-600 leading-[1.85] pl-9">
                    {{ __('app.terminos.s7_p1_a') }} <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s7_p1_b') }}
                </p>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 8 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">8</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s8_titulo') }}</h3>
                </div>
                <p class="text-[13px] text-slate-600 leading-[1.85] pl-9">
                    <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s8_texto') }}
                </p>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 9 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">9</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s9_titulo') }}</h3>
                </div>
                <p class="text-[13px] text-slate-600 leading-[1.85] pl-9">
                    {{ __('app.terminos.s9_p1_a') }} <strong class="text-slate-700">{{ __('app.terminos.s9_bolivia') }}</strong>{{ __('app.terminos.s9_p1_b') }} <b><span class="text-blue-600">Sansi</span><span style="color:#f87171">folios</span></b> {{ __('app.terminos.s9_p1_c') }}
                </p>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- 10 --}}
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white flex-shrink-0">10</span>
                    <h3 class="text-[13px] font-bold text-slate-800 tracking-tight uppercase text-xs">{{ __('app.terminos.s10_titulo') }}</h3>
                </div>
                <div class="pl-9 space-y-3">
                    <p class="text-[13px] text-slate-600 leading-[1.8]">
                        {{ __('app.terminos.s10_texto') }}
                    </p>
                    <a href="mailto:infinitycode34@gmail.com"
                        class="inline-flex items-center gap-2.5 rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 text-[13px] font-semibold text-slate-700 hover:bg-slate-100 transition">
                        <svg width="14" height="14" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 7 10-7"/></svg>
                        infinitycode34@gmail.com
                    </a>
                </div>
            </div>

        </div>

        {{-- Pie fijo --}}
        <div class="flex-shrink-0 border-t border-slate-100 px-8 py-5 flex flex-col sm:flex-row items-center gap-3">
            <button type="button" onclick="aceptarTerminos()"
                class="w-full sm:flex-1 rounded-2xl bg-blue-600 hover:bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-blue-500/25 transition-all active:scale-[0.98]">
                {{ __('app.terminos.btn_aceptar') }}
            </button>
            <button type="button" onclick="cerrarTerminos()"
                class="w-full sm:w-auto rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 px-6 py-3 text-sm font-semibold text-slate-600 transition-all active:scale-[0.98]">
                {{ __('app.terminos.btn_cerrar') }}
            </button>
        </div>

    </div>
</div>

<script>
function abrirTerminos(e) {
    if (e) e.preventDefault();
    document.getElementById('modalTerminos').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function cerrarTerminos() {
    document.getElementById('modalTerminos').classList.add('hidden');
}

function aceptarTerminos() {
    var checkbox = document.getElementById('terminos');
    if (checkbox) checkbox.checked = true;
    cerrarTerminos();
}

document.addEventListener('DOMContentLoaded', function () {
    var btnTerminos = document.getElementById('abrirTerminos');
    if (btnTerminos) {
        btnTerminos.addEventListener('click', abrirTerminos);
    }
});

document.getElementById('modalTerminos')?.addEventListener('click', function (e) {
    if (e.target === this) cerrarTerminos();
});
</script>