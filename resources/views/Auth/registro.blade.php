{{--
    Partial: Auth/registro.blade.php
--}}
@include('Auth.terminos')
<div id="registerModal" class="fixed inset-0 z-50 hidden bg-slate-900/20 backdrop-blur-sm flex items-center justify-center px-4 py-6">
    {{-- Contenedor con scroll interno --}}
    <div class="w-full max-w-[440px] max-h-[92vh] overflow-y-auto rounded-[32px] bg-white shadow-[0_30px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 font-[Poppins]
                scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">

        <div class="p-8 sm:p-9">

            {{-- Botón cerrar --}}
            <div class="flex justify-end -mt-1 -mr-1 mb-4">
                <button type="button" onclick="document.getElementById('registerModal').classList.add('hidden')"
                    class="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            {{-- Encabezado --}}
            <div class="mb-6 flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-[20px] bg-blue-50 ring-1 ring-blue-100 shadow-sm">
                    <img src="/images/registrar.png" alt="Logo" class="h-10 w-10 object-contain" />
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('app.registro.titulo') }}</h2>
                <p class="mt-1.5 text-sm text-slate-500">{{ __('app.registro.subtitulo') }}</p>
            </div>

            <!-- FORMULARIO -->
            <form id="formRegistro" method="POST" action="/registro"
                class="space-y-4"
                data-msg-exito="{{ __('app.registro.exito') }}"
                data-msg-conexion="{{ __('app.registro.error_conexion') }}"
                data-correo-valido="{{ __('app.registro.correo_valido') }}"
                data-correo-invalido="{{ __('app.registro.correo_invalido') }}"
                data-pass-valida="{{ __('app.registro.pass_valida') }}"
                data-pass-invalida="{{ __('app.registro.pass_invalida') }}"
                data-pass-coinciden="{{ __('app.registro.pass_coinciden') }}"
                data-pass-no-coinciden="{{ __('app.registro.pass_no_coinciden') }}"
                data-error-nombre="{{ __('app.registro.error_nombre') }}"
                data-error-letras-n="{{ __('app.registro.error_solo_letras_n') }}"
                data-error-apellido="{{ __('app.registro.error_apellido') }}"
                data-error-letras-a="{{ __('app.registro.error_solo_letras_a') }}"
                data-error-correo="{{ __('app.registro.error_correo') }}"
                data-error-formato="{{ __('app.registro.error_formato') }}"
                data-error-dominio="{{ __('app.registro.error_dominio') }}"
                data-error-punto="{{ __('app.registro.error_punto_inicio') }}"
                data-error-dobles="{{ __('app.registro.error_puntos_dobles') }}"
                data-error-usuario-largo="{{ __('app.registro.error_usuario_largo') }}"
                data-error-correo-largo="{{ __('app.registro.error_correo_largo') }}"
                data-error-pass="{{ __('app.registro.error_pass') }}"
                data-error-confirmacion="{{ __('app.registro.error_confirmacion') }}"
                data-error-terminos="{{ __('app.registro.error_terminos') }}">
                @csrf

                {{-- Nombre y Apellido --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ __('app.registro.nombre') }}
                        </label>
                        <div id="wrap-nombre" class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                            <input type="text" name="nombre" id="nombre"
                                placeholder="María"
                                class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
                        </div>
                        <p id="errorNombreField" class="mt-1 text-xs hidden"></p>
                    </div>
                    <div>
                        <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ __('app.registro.apellido') }}
                        </label>
                        <div id="wrap-apellido" class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                            <input type="text" name="apellido" id="apellido"
                                placeholder="García"
                                class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
                        </div>
                        <p id="errorApellidoField" class="mt-1 text-xs hidden"></p>
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 7 10-7"/></svg>
                        {{ __('app.registro.correo') }}
                    </label>
                    <div id="wrap-email" class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                        <input type="email" name="email" id="email"
                            placeholder="{{ __('app.login.tu_correo') }}"
                            class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
                    </div>
                    <p id="errorEmail" class="text-xs mt-1 hidden"></p>
                </div>

                {{-- Contraseñas --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            {{ __('app.registro.password') }}
                        </label>
                        <div id="wrap-password" class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 flex items-center gap-2 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                            <input type="password" name="password" id="password"
                                placeholder="{{ __('app.registro.8_caracteres') }}"
                                class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
                            <button type="button" onclick="togglePasswordRegistro('password')" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition" tabindex="-1">
                                <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        <p id="errorPassword" class="text-xs mt-1"></p>
                    </div>
                    <div>
                        <label class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            {{ __('app.registro.password_confirm') }}
                        </label>
                        <div id="wrap-password_confirmation" class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 flex items-center gap-2 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="{{ __('app.registro.repite') }}"
                                class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400">
                            <button type="button" onclick="togglePasswordRegistro('password_confirmation')" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition" tabindex="-1">
                                <svg id="eye-icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        <p id="errorConfirm" class="text-xs mt-1"></p>
                    </div>
                </div>

                {{-- Términos --}}
                <div class="flex items-start gap-2.5 rounded-xl bg-slate-50 border border-slate-200 px-4 py-3">
                    <input type="checkbox" id="terminos" class="mt-0.5 h-4 w-4 flex-shrink-0 rounded border-slate-300 text-blue-600 focus:ring-blue-500 accent-blue-600">
                    <label for="terminos" class="text-xs text-slate-600 cursor-pointer leading-relaxed">
                        {{ __('app.registro.terminos') }}
                        <a href="#" id="abrirTerminos" class="font-semibold text-blue-600 hover:text-blue-700 transition">{{ __('app.registro.terminos_link') }}</a>
                    </label>
                </div>

                {{-- Botón --}}
                <button id="btnSubmit"
                    class="relative w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-2xl text-sm font-semibold shadow-md shadow-blue-500/25 transition-all active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed">
                    <span id="btnSubmitText">{{ __('app.registro.btn_registrarse') }}</span>
                    <span id="btnSubmitLoading" class="hidden absolute inset-0 flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Registrando...
                    </span>
                </button>

                {{-- Mensaje general --}}
                <div id="mensajeGeneral" class="hidden text-sm text-red-500 rounded-xl bg-red-50 border border-red-200 px-4 py-3"></div>

            </form>

            <p class="text-center mt-5 text-sm text-slate-500">
                {{ __('app.registro.ya_tienes_cuenta') }}
                <button type="button" onclick="toggleRegister(); toggleModal();" class="font-semibold text-blue-600 hover:text-blue-700 cursor-pointer transition">
                    {{ __('app.registro.inicia_sesion') }}
                </button>
            </p>

        </div>
    </div>
</div>



<script>
const form = document.getElementById('formRegistro');
const t = {
    exito:             form.dataset.msgExito,
    conexion:          form.dataset.msgConexion,
    correoValido:      form.dataset.correoValido,
    correoInvalido:    form.dataset.correoInvalido,
    passValida:        form.dataset.passValida,
    passInvalida:      form.dataset.passInvalida,
    passCoinciden:     form.dataset.passCoinciden,
    passNoCoinciden:   form.dataset.passNoCoinciden,
    errorNombre:       form.dataset.errorNombre,
    errorLetrasN:      form.dataset.errorLetrasN,
    errorApellido:     form.dataset.errorApellido,
    errorLetrasA:      form.dataset.errorLetrasA,
    errorCorreo:       form.dataset.errorCorreo,
    errorFormato:      form.dataset.errorFormato,
    errorDominio:      form.dataset.errorDominio,
    errorPunto:        form.dataset.errorPunto,
    errorDobles:       form.dataset.errorDobles,
    errorUsuarioLargo: form.dataset.errorUsuarioLargo,
    errorCorreoLargo:  form.dataset.errorCorreoLargo,
    errorPass:         form.dataset.errorPass,
    errorConfirmacion: form.dataset.errorConfirmacion,
    errorTerminos:     form.dataset.errorTerminos,
};

const password = document.getElementById('password');
const confirm  = document.getElementById('password_confirmation');
const email    = document.getElementById('email');

const errorPassword  = document.getElementById('errorPassword');
const errorConfirm   = document.getElementById('errorConfirm');
const errorEmail     = document.getElementById('errorEmail');
const mensajeGeneral = document.getElementById('mensajeGeneral');

const terminos       = document.getElementById('terminos');
const inputNombre    = document.getElementById('nombre');
const inputApellido  = document.getElementById('apellido');

[inputNombre, inputApellido].forEach(input => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    });
});

/* ── helpers wrapper ── */
const wrapBase  = 'rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all';
const wrapOk    = 'rounded-xl border border-emerald-400 bg-emerald-50 px-3.5 py-2.5 ring-3 ring-emerald-100 transition-all';
const wrapErr   = 'rounded-xl border border-rose-400 bg-rose-50 px-3.5 py-2.5 ring-3 ring-rose-100 transition-all';
const wrapPwBase= 'rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 flex items-center gap-2 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all';
const wrapPwOk  = 'rounded-xl border border-emerald-400 bg-emerald-50 px-3.5 py-2.5 flex items-center gap-2 ring-3 ring-emerald-100 transition-all';
const wrapPwErr = 'rounded-xl border border-rose-400 bg-rose-50 px-3.5 py-2.5 flex items-center gap-2 ring-3 ring-rose-100 transition-all';

const wrapClasses = { base: wrapBase, ok: wrapOk, err: wrapErr, basePw: wrapPwBase, okPw: wrapPwOk, errPw: wrapPwErr };

/* ---------------- PASSWORD VALIDATION ---------------- */
password.addEventListener('input', () => {
    const valido = password.value.length >= 8 && /\d/.test(password.value);
    const wrap = document.getElementById('wrap-password');
    if (valido) {
        if (wrap) wrap.className = wrapClasses.okPw;
        errorPassword.textContent = t.passValida;
        errorPassword.className   = "text-xs mt-1 text-emerald-600 font-semibold";
    } else {
        if (wrap) wrap.className = wrapClasses.errPw;
        errorPassword.textContent = t.passInvalida;
        errorPassword.className   = "text-xs mt-1 text-rose-500 font-semibold";
    }
});

/* ---------------- CONFIRMACIÓN ---------------- */
function validarConfirmacion() {
    const wrap = document.getElementById('wrap-password_confirmation');
    if (!confirm.value) {
        errorConfirm.textContent = "";
        if (wrap) wrap.className = wrapClasses.basePw;
        return;
    }
    if (confirm.value === password.value) {
        if (wrap) wrap.className = wrapClasses.okPw;
        errorConfirm.textContent = t.passCoinciden;
        errorConfirm.className   = "text-xs mt-1 text-emerald-600 font-semibold";
    } else {
        if (wrap) wrap.className = wrapClasses.errPw;
        errorConfirm.textContent = t.passNoCoinciden;
        errorConfirm.className   = "text-xs mt-1 text-rose-500 font-semibold";
    }
}
confirm.addEventListener('input', validarConfirmacion);
password.addEventListener('input', validarConfirmacion);

/* ---------------- EMAIL EN VIVO ---------------- */
email.addEventListener("input", () => {
    const value = email.value.trim();
    const formatoValido = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[A-Za-z]{2,})+$/.test(value);
    const wrap = document.getElementById('wrap-email');

    if (value === "") {
        errorEmail.textContent = "";
        errorEmail.classList.add("hidden");
        if (wrap) wrap.className = wrapClasses.base;
        return;
    }
    if (!formatoValido) {
        if (wrap) wrap.className = wrapClasses.err;
        errorEmail.textContent = t.correoInvalido;
        errorEmail.className   = "text-xs mt-1 text-rose-500 font-semibold";
        errorEmail.classList.remove("hidden");
    } else {
        if (wrap) wrap.className = wrapClasses.ok;
        errorEmail.textContent = t.correoValido;
        errorEmail.className   = "text-xs mt-1 text-emerald-600 font-semibold";
        errorEmail.classList.remove("hidden");
    }
});

/* ---------------- OJITO (SVG) ---------------- */
function togglePasswordRegistro(id) {
    const input   = document.getElementById(id);
    const eyeIcon = document.getElementById('eye-icon-' + id);
    if (!input || !eyeIcon) return;
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    eyeIcon.innerHTML = show
        ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
        : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
}

/* ---------------- SUBMIT + VALIDACIONES ---------------- */
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    mensajeGeneral.classList.add('hidden');
    mensajeGeneral.innerHTML = "";
    errorEmail.classList.add('hidden');
    errorPassword.classList.add('hidden');
    errorConfirm.classList.add('hidden');
    terminos.classList.remove("ring-2", "ring-red-500");

    let errores = [];

    const nombre   = inputNombre.value.trim();
    const apellido = inputApellido.value.trim();
    const correo   = email.value.trim();

    const formatoEmail    = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[A-Za-z]{2,})+$/;
    const dominiosValidos = ["gmail.com","hotmail.com","outlook.com","yahoo.com","est.umss.edu.bo"];
    const soloLetras      = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if (!formatoEmail.test(correo)) {
        errores.push(t.errorFormato);
        const w = document.getElementById('wrap-email');
        if (w) w.className = wrapClasses.err;
    }

    const dominio = correo.split("@")[1];
    if (dominio && !dominiosValidos.includes(dominio)) {
        errores.push(t.errorDominio);
        const w = document.getElementById('wrap-email');
        if (w) w.className = wrapClasses.err;
    }

    const usuario = correo.split("@")[0];
    if (usuario.startsWith(".") || usuario.endsWith(".")) errores.push(t.errorPunto);
    if (usuario.includes(".."))   errores.push(t.errorDobles);
    if (usuario.length > 64)      errores.push(t.errorUsuarioLargo);
    if (correo.length > 100)      errores.push(t.errorCorreoLargo);

    if (!nombre)                        errores.push(t.errorNombre);
    else if (!soloLetras.test(nombre))  errores.push(t.errorLetrasN);

    if (!apellido)                       errores.push(t.errorApellido);
    else if (!soloLetras.test(apellido)) errores.push(t.errorLetrasA);

    if (!correo) errores.push(t.errorCorreo);

    if (password.value.length < 8 || !/\d/.test(password.value)) errores.push(t.errorPass);
    if (password.value !== confirm.value) errores.push(t.errorConfirmacion);

    if (!terminos.checked) {
        errores.push(t.errorTerminos);
        terminos.classList.add("ring-2", "ring-red-500");
    }

    if (errores.length > 0) {
        mensajeGeneral.innerHTML = errores.join("<br>");
        mensajeGeneral.classList.remove('hidden');
        return;
    }


    /* ── Loading botón ── */
    const btnSubmit        = document.getElementById('btnSubmit');
    const btnSubmitText    = document.getElementById('btnSubmitText');
    const btnSubmitLoading = document.getElementById('btnSubmitLoading');
    if (btnSubmit) btnSubmit.disabled = true;
    if (btnSubmitText)    btnSubmitText.classList.add('invisible');
    if (btnSubmitLoading) btnSubmitLoading.classList.remove('hidden');

    try {
        const formData = new FormData(e.target);
        const res = await fetch('/registro', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        if (res.status === 422) {
            const data = await res.json();
            if (btnSubmit) btnSubmit.disabled = false;
            if (btnSubmitText)    btnSubmitText.classList.remove('invisible');
            if (btnSubmitLoading) btnSubmitLoading.classList.add('hidden');
            let erroresBackend = [];
            if (data.errors) {
                if (data.errors.email) {
                    const w = document.getElementById('wrap-email');
                    if (w) w.className = wrapClasses.err;
                    errorEmail.textContent = data.errors.email[0];
                    errorEmail.className   = "text-xs mt-1 text-rose-500 font-semibold";
                    errorEmail.classList.remove('hidden');
                }
                Object.values(data.errors).forEach(arr => erroresBackend.push(arr[0]));
            }
            mensajeGeneral.innerHTML = erroresBackend.join("<br>");
            mensajeGeneral.classList.remove('hidden');
            return;
        }

        if (res.ok) {
            await res.json();
            localStorage.setItem('registro_origen', window.location.href);
            mensajeGeneral.innerHTML = t.exito;
            mensajeGeneral.className = "mt-3 text-sm text-emerald-600 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3";
            mensajeGeneral.classList.remove('hidden');
            return;
        }

        if (res.redirected) {
            window.location.href = res.url;
            return;
        }


    } catch (error) {
        if (btnSubmit) btnSubmit.disabled = false;
        if (btnSubmitText)    btnSubmitText.classList.remove('invisible');
        if (btnSubmitLoading) btnSubmitLoading.classList.add('hidden');
        mensajeGeneral.textContent = t.conexion;
        mensajeGeneral.classList.remove('hidden');
    }
});

/* -------- DETECCIÓN DE VERIFICACIÓN DE CORREO -------- */
window.addEventListener("storage", function(event) {
    if (event.key === "email_verificado") {
        document.getElementById("registerModal").classList.add("hidden");
        document.getElementById("loginModal").classList.remove("hidden");

        const msgLogin = document.getElementById('loginMensaje');
        if (msgLogin) {
            msgLogin.innerHTML = "{{ __('app.registro.verificado') }}";
            msgLogin.className = "mt-3 text-sm text-emerald-600 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3";
        }

        localStorage.removeItem('email_verificado');
    }
});
</script>