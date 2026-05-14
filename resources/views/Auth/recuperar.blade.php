<div id="modalRecuperar" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/20 px-4 py-8 backdrop-blur-sm" role="dialog" aria-modal="true" onclick="handleModalBackdropClick(event)">

    <div class="relative w-full max-w-[440px] rounded-[40px] bg-white p-8 shadow-[0_30px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 sm:p-10 font-[Poppins]" onclick="event.stopPropagation()">

        {{-- Botón cerrar --}}
        <button type="button" onclick="cerrarModalRecuperar()"
            class="absolute right-5 top-5 flex h-8 w-8 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>

        {{-- Encabezado con ícono --}}
        <div class="mb-7 flex flex-col items-center text-center">
            <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-[20px] bg-blue-50 ring-1 ring-blue-100 shadow-sm">
                <svg width="30" height="30" fill="none" stroke="#2563eb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('app.recuperar.titulo') }}</h2>
            <p id="mensajePrincipal" class="mt-2 text-sm text-slate-500 leading-relaxed max-w-[300px]">
                {{ __('app.recuperar.descripcion_correo') }}
            </p>
        </div>

        {{-- FORMULARIO 1: Enviar correo --}}
        <form id="formRecuperar" class="space-y-4">

            <div>
                <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 7 10-7"/></svg>
                    {{ __('app.recuperar.label_correo') }}
                </label>
                <div id="rec-email-wrap" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                    <input type="email" id="email_recuperar"
                        placeholder="{{ __('app.recuperar.placeholder_correo') }}"
                        class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400"
                        autocomplete="email">
                </div>
                <p id="errorEmail" class="mt-1.5 text-xs hidden"></p>
            </div>

            <div id="loadingEmail" class="hidden items-center gap-2 text-slate-500 text-sm">
                <div class="w-4 h-4 border-2 border-slate-200 border-t-blue-600 rounded-full animate-spin"></div>
                <span>{{ __('app.recuperar.enviando_correo') }}</span>
            </div>

            <div id="mensajeEmail" class="mt-1"></div>

            <button id="btnRecuperar" type="submit"
                class="relative w-full rounded-2xl bg-blue-600 hover:bg-blue-700 px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-blue-500/25 transition-all active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed">
                <span id="btnRecuperarText">{{ __('app.recuperar.btn_enviar_enlace') }}</span>
                <span id="btnRecuperarLoading" class="hidden absolute inset-0 flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    {{ __('app.recuperar.enviando_correo') }}
                </span>
            </button>

        </form>

        {{-- FORMULARIO 2: Nueva contraseña --}}
        <form id="formReset" class="hidden space-y-4">

            <div>
                <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    {{ __('app.recuperar.label_nueva_contrasena') }}
                </label>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 flex items-center gap-2 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                    <input type="password" id="resetPassword"
                        placeholder="{{ __('app.recuperar.placeholder_nueva_contrasena') }}"
                        class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
                    <button type="button" onclick="toggleRecuperarPassword('resetPassword')" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition" tabindex="-1">
                        <svg id="eye-icon-resetPassword" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <p id="errorNewPassword" class="mt-1.5 text-xs text-rose-500 hidden"></p>
                {{-- Indicadores de reglas --}}
                <div class="mt-2.5 flex gap-3">
                    <p id="ruleLength" class="flex items-center gap-1 text-xs text-slate-400">
                        <span class="inline-block w-3.5 h-3.5 rounded-full border-2 border-slate-300 flex-shrink-0"></span>
                        {{ __('app.recuperar.regla_longitud') }}
                    </p>
                    <p id="ruleNumber" class="flex items-center gap-1 text-xs text-slate-400">
                        <span class="inline-block w-3.5 h-3.5 rounded-full border-2 border-slate-300 flex-shrink-0"></span>
                        {{ __('app.recuperar.regla_numero_simbolo') }}
                    </p>
                </div>
            </div>

            <div>
                <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    {{ __('app.recuperar.label_confirmar_contrasena') }}
                </label>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 flex items-center gap-2 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                    <input type="password" id="resetConfirmPassword"
                        placeholder="{{ __('app.recuperar.placeholder_confirmar_contrasena') }}"
                        class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
                    <button type="button" onclick="toggleRecuperarPassword('resetConfirmPassword')" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition" tabindex="-1">
                        <svg id="eye-icon-resetConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <p id="statusConfirm" class="text-xs font-semibold mt-1.5 hidden"></p>
            </div>

            <div id="mensajeReset" class="mt-1"></div>

            <button id="btnReset" type="submit"
                class="relative w-full rounded-2xl bg-blue-600 hover:bg-blue-700 px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-blue-500/25 transition-all active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed">
                <span id="btnResetText">{{ __('app.recuperar.btn_actualizar_contrasena') }}</span>
                <span id="btnResetLoading" class="hidden absolute inset-0 flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    {{ __('app.recuperar.actualizando') }}
                </span>
            </button>

        </form>

    </div>
</div>

<script>
// ─── 1. CONTROL DEL MODAL ─────────────────────────────────────────────────────
function abrirModalRecuperar() {
    const loginModal = document.getElementById('loginModal');
    if (loginModal) loginModal.classList.add('hidden');
    document.getElementById('modalRecuperar').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function cerrarModalRecuperar() {
    document.getElementById('modalRecuperar').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Cierra el modal solo si se hace click en el fondo (backdrop) y NO hay token en la URL
function handleModalBackdropClick(event) {
    if (event.target === event.currentTarget && !token) {
        cerrarModalRecuperar();
    }
}

// ─── 2. DETECTAR TOKEN EN URL ─────────────────────────────────────────────────
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('token');

window.addEventListener('DOMContentLoaded', () => {
    if (token) {
        // Esta pestaña llegó desde el enlace del correo: mostrar el form de reset
        abrirModalRecuperar();
        document.getElementById('formRecuperar').classList.add('hidden');
        document.getElementById('formReset').classList.remove('hidden');
        document.getElementById('mensajePrincipal').textContent =
            '{{ __('app.recuperar.descripcion_reset') }}';
        // Evitar que el listener global del home cierre este modal al hacer click afuera
        document.getElementById('modalRecuperar').setAttribute('data-no-close', 'true');
    } else {
        // Escuchar si el reset se completó en otra pestaña (vía BroadcastChannel)
        const canal = new BroadcastChannel('sansifolios_reset');
        canal.onmessage = (e) => {
            if (e.data && e.data.tipo === 'reset_exitoso') {
                canal.close();
                abrirLoginConExito(e.data.mensaje);
            }
        };

        // Fallback: si llegamos aquí con ?reset_exitoso=1 (window.close() fue bloqueado)
        const params = new URLSearchParams(window.location.search);
        if (params.get('reset_exitoso') === '1') {
            // Limpiar el parámetro de la URL sin recargar
            history.replaceState({}, '', window.location.pathname);
            abrirLoginConExito('{{ __('app.recuperar.exito_login') }}');
        }
    }
});

function abrirLoginConExito(mensaje) {
    // Cerrar modal recuperar si estaba abierto
    document.getElementById('modalRecuperar')?.classList.add('hidden');
    document.body.style.overflow = 'auto';

    document.getElementById('loginModal')?.classList.remove('hidden');
    const msgLogin = document.getElementById('loginMensaje');
    if (msgLogin) {
        msgLogin.innerHTML = mensaje || '{{ __('app.recuperar.exito_login') }}';
        msgLogin.className = 'mt-3 text-sm text-emerald-600 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3';
    }
}

// ─── 3. OJITO ────────────────────────────────────────────────────────────────
function toggleRecuperarPassword(id) {
    const input = document.getElementById(id);
    const icon  = document.getElementById('eye-icon-' + id);
    if (!input || !icon) return;
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    icon.innerHTML = show
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
}

// ─── 4. VALIDACIÓN EN VIVO ────────────────────────────────────────────────────
function validarEmailRec(email) {
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[A-Za-z]{2,})+$/.test(email);
}

function validarPasswordRec(pass) {
    return pass.length >= 8 && /[0-9!@#$%^&*]/.test(pass);
}

const recWrapBase = 'rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all';
const recWrapOk   = 'rounded-2xl border border-emerald-400 bg-emerald-50 px-4 py-3 ring-3 ring-emerald-100 transition-all';
const recWrapErr  = 'rounded-2xl border border-rose-400 bg-rose-50 px-4 py-3 ring-3 ring-rose-100 transition-all';

document.getElementById('email_recuperar')?.addEventListener('input', function () {
    const val  = this.value.trim();
    const wrap = document.getElementById('rec-email-wrap');
    const err  = document.getElementById('errorEmail');
    if (val === '') {
        wrap.className = recWrapBase;
        err.classList.add('hidden');
        return;
    }
    if (validarEmailRec(val)) {
        wrap.className = recWrapOk;
        err.innerHTML  = '<span class="flex items-center gap-1 text-emerald-600 font-semibold"><svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>{{ __('app.recuperar.correo_valido') }}</span>';
        err.classList.remove('hidden');
    } else {
        wrap.className = recWrapErr;
        err.innerHTML  = '<span class="flex items-center gap-1 text-rose-500 font-semibold"><svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>{{ __('app.recuperar.correo_invalido') }}</span>';
        err.classList.remove('hidden');
    }
});

document.getElementById('resetPassword')?.addEventListener('input', function () {
    const val        = this.value;
    const ruleLength = document.getElementById('ruleLength');
    const ruleNumber = document.getElementById('ruleNumber');

    const dotOk  = '<span class="inline-block w-3.5 h-3.5 rounded-full bg-emerald-500 flex-shrink-0 flex items-center justify-center"><svg width="8" height="8" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></span>';
    const dotErr = '<span class="inline-block w-3.5 h-3.5 rounded-full border-2 border-slate-300 flex-shrink-0"></span>';

    if (val.length >= 8) {
        ruleLength.innerHTML = dotOk + ' {{ __('app.recuperar.regla_longitud') }}';
        ruleLength.className = 'flex items-center gap-1 text-xs text-emerald-600 font-semibold';
    } else {
        ruleLength.innerHTML = dotErr + ' {{ __('app.recuperar.regla_longitud') }}';
        ruleLength.className = 'flex items-center gap-1 text-xs text-slate-400';
    }
    if (/[0-9!@#$%^&*]/.test(val)) {
        ruleNumber.innerHTML = dotOk + ' {{ __('app.recuperar.regla_numero_simbolo') }}';
        ruleNumber.className = 'flex items-center gap-1 text-xs text-emerald-600 font-semibold';
    } else {
        ruleNumber.innerHTML = dotErr + ' {{ __('app.recuperar.regla_numero_simbolo') }}';
        ruleNumber.className = 'flex items-center gap-1 text-xs text-slate-400';
    }
    validarConfirm();
});

document.getElementById('resetConfirmPassword')?.addEventListener('input', validarConfirm);

function validarConfirm() {
    const pass    = document.getElementById('resetPassword').value;
    const confirm = document.getElementById('resetConfirmPassword').value;
    const status  = document.getElementById('statusConfirm');
    if (!confirm) { status.classList.add('hidden'); return; }
    status.classList.remove('hidden');
    if (confirm === pass) {
        status.innerHTML = '<span class="flex items-center gap-1 text-emerald-600"><svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>{{ __('app.recuperar.contrasenas_coinciden') }}</span>';
        status.className = 'text-xs font-semibold mt-1.5';
    } else {
        status.innerHTML = '<span class="flex items-center gap-1 text-rose-500"><svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>{{ __('app.recuperar.contrasenas_no_coinciden') }}</span>';
        status.className = 'text-xs font-semibold mt-1.5';
    }
}

// ─── 5. HELPERS DE MENSAJE ────────────────────────────────────────────────────
function mostrarMensaje(elemento, texto, tipo) {
    elemento.innerHTML = tipo === 'error'
        ? `<div class="flex gap-3 items-start bg-rose-50 border border-rose-200 text-rose-700 p-3.5 rounded-2xl text-sm">
               <div class="bg-rose-500 text-white w-5 h-5 flex-shrink-0 flex items-center justify-center rounded-full text-xs font-bold">✕</div>
               <div>${texto}</div>
           </div>`
        : `<div class="flex gap-3 items-start bg-emerald-50 border border-emerald-200 text-emerald-700 p-3.5 rounded-2xl text-sm">
               <div class="bg-emerald-500 text-white w-5 h-5 flex-shrink-0 flex items-center justify-center rounded-full text-xs font-bold">✓</div>
               <div>${texto}</div>
           </div>`;
}

// ─── 6. ENVÍO DE CORREO ───────────────────────────────────────────────────────
document.getElementById('formRecuperar')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const emailVal  = document.getElementById('email_recuperar').value.trim();
    const errorEl   = document.getElementById('errorEmail');
    const mensajeEl = document.getElementById('mensajeEmail');
    const loading   = document.getElementById('loadingEmail');
    const boton     = document.getElementById('btnRecuperar');

    errorEl.classList.add('hidden');
    mensajeEl.innerHTML = '';

    if (!emailVal) {
        errorEl.innerHTML = '<span class="flex items-center gap-1 text-rose-500 font-semibold">{{ __('app.recuperar.error_correo_obligatorio') }}</span>';
        errorEl.classList.remove('hidden');
        return;
    }
    if (!validarEmailRec(emailVal)) {
        errorEl.innerHTML = '<span class="flex items-center gap-1 text-rose-500 font-semibold">{{ __('app.recuperar.correo_invalido') }}</span>';
        errorEl.classList.remove('hidden');
        return;
    }

    loading.classList.remove('hidden');
    boton.disabled = true;
    boton.classList.add('opacity-60', 'cursor-not-allowed');
    document.getElementById('btnRecuperarText')?.classList.add('invisible');
    document.getElementById('btnRecuperarLoading')?.classList.remove('hidden');

    try {
        const res  = await fetch('/recuperar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ email: emailVal })
        });
        const data = await res.json();
        loading.classList.add('hidden');
        boton.disabled = false;
        boton.classList.remove('opacity-60', 'cursor-not-allowed');
        document.getElementById('btnRecuperarText')?.classList.remove('invisible');
        document.getElementById('btnRecuperarLoading')?.classList.add('hidden');
        mostrarMensaje(mensajeEl, data.mensaje || (res.ok ? '{{ __('app.recuperar.correo_enviado') }}' : '{{ __('app.recuperar.error_enviar') }}'), res.ok ? 'success' : 'error');
    } catch (err) {
        loading.classList.add('hidden');
        boton.disabled = false;
        boton.classList.remove('opacity-60', 'cursor-not-allowed');
        document.getElementById('btnRecuperarText')?.classList.remove('invisible');
        document.getElementById('btnRecuperarLoading')?.classList.add('hidden');
        mostrarMensaje(mensajeEl, '{{ __('app.recuperar.error_conexion') }}', 'error');
    }
});

// ─── 7. CAMBIAR CONTRASEÑA ────────────────────────────────────────────────────
document.getElementById('formReset')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const password  = document.getElementById('resetPassword').value;
    const confirm   = document.getElementById('resetConfirmPassword').value;
    const errorEl   = document.getElementById('errorNewPassword');
    const mensajeEl = document.getElementById('mensajeReset');

    errorEl.classList.add('hidden');

    if (!validarPasswordRec(password)) {
        errorEl.textContent = '{{ __('app.recuperar.error_contrasena_invalida') }}';
        errorEl.classList.remove('hidden');
        return;
    }
    if (password !== confirm) {
        validarConfirm();
        return;
    }

    try {
        const btnReset     = document.getElementById('btnReset');
        const btnResetTxt  = document.getElementById('btnResetText');
        const btnResetLoad = document.getElementById('btnResetLoading');
        if (btnReset) { btnReset.disabled = true; }
        if (btnResetTxt)  btnResetTxt.classList.add('invisible');
        if (btnResetLoad) btnResetLoad.classList.remove('hidden');

        const res  = await fetch('/reset-password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ token: token, contrasena: password })
        });
        const data = await res.json();
        const btnReset2     = document.getElementById('btnReset');
        const btnResetTxt2  = document.getElementById('btnResetText');
        const btnResetLoad2 = document.getElementById('btnResetLoading');
        if (btnReset2)     btnReset2.disabled = false;
        if (btnResetTxt2)  btnResetTxt2.classList.remove('invisible');
        if (btnResetLoad2) btnResetLoad2.classList.add('hidden');
        if (res.ok) {
            mostrarMensaje(mensajeEl, data.mensaje || '{{ __('app.recuperar.contrasena_actualizada') }}', 'success');
            setTimeout(() => {
                // Notificar a la pestaña original vía BroadcastChannel
                const canal = new BroadcastChannel('sansifolios_reset');
                canal.postMessage({
                    tipo: 'reset_exitoso',
                    mensaje: data.mensaje || '{{ __('app.recuperar.exito_login') }}'
                });
                canal.close();

                // Intentar cerrar esta pestaña (funciona si fue abierta por window.open)
                window.close();

                // Si window.close() fue bloqueado (link abierto desde Gmail/correo),
                // redirigir a la página principal con flag para abrir el login
                setTimeout(() => {
                    if (!window.closed) {
                        window.location.href = '/?reset_exitoso=1';
                    }
                }, 300);
            }, 1500);
        } else {
            mostrarMensaje(mensajeEl, data.mensaje || '{{ __('app.recuperar.error_actualizar') }}', 'error');
        }
    } catch (err) {
        mostrarMensaje(mensajeEl, '{{ __('app.recuperar.error_actualizar_contrasena') }}', 'error');
    }
});
</script>