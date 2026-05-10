{{--
    Partial: Auth/registro.blade.php
--}}

<!-- MODAL EMERGENTE  -->
<div id="registerModal" class="fixed inset-0 z-50 hidden bg-slate-900/20 backdrop-blur-sm flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-[440px] rounded-[40px] bg-white p-8 shadow-[0_30px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 sm:p-10 font-[Poppins]">

        {{-- Botón cerrar --}}
        <div class="flex justify-end -mt-2 -mr-2 mb-2">
            <button type="button" onclick="document.getElementById('registerModal').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600 transition">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-[28px] bg-slate-100 shadow-sm">
            <img src="/images/registrar.png" alt="Logo" class="h-12 w-12 object-contain" />
        </div>

        <h2 class="text-3xl font-bold text-center text-slate-900">{{ __('app.registro.titulo') }}</h2>
        <p class="mt-2 text-center text-sm text-slate-500">{{ __('app.registro.subtitulo') }}</p>

        <!-- FORMULARIO -->
        <form id="formRegistro" method="POST" action="/registro"
            class="mt-8 space-y-5"
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

            <!-- Nombre y Apellido -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm">{{ __('app.registro.nombre') }}</label>
                    <input type="text" name="nombre" id="nombre"
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm">{{ __('app.registro.apellido') }}</label>
                    <input type="text" name="apellido" id="apellido"
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm">{{ __('app.registro.correo') }}</label>
                <input type="email" name="email" id="email"
                    class="w-full border rounded-lg px-3 py-2 mt-1">
                <p id="errorEmail" class="text-xs mt-1 hidden"></p>
            </div>

            <!-- Contraseña -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="relative">
                    <label class="text-sm">{{ __('app.registro.password') }}</label>
                    <input type="password" name="password" id="password"
                        class="w-full border rounded-lg px-3 py-2 mt-1 pr-10">
                    <button type="button" onclick="togglePasswordRegistro('password')" class="absolute right-2 top-9">
                        <span id="eye-icon-password" class="material-icons">visibility_off</span>
                    </button>
                    <p id="errorPassword" class="text-xs mt-1"></p>
                </div>
                <div class="relative">
                    <label class="text-sm">{{ __('app.registro.password_confirm') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border rounded-lg px-3 py-2 mt-1 pr-10">
                    <button type="button" onclick="togglePasswordRegistro('password_confirmation')" class="absolute right-2 top-9">
                        <span id="eye-icon-password_confirmation" class="material-icons">visibility_off</span>
                    </button>
                    <p id="errorConfirm" class="text-xs mt-1"></p>
                </div>
            </div>

            <!-- Términos -->
            <div class="text-sm">
               <input type="checkbox" id="terminos"> {{ __('app.registro.terminos') }}
               <a href="#" id="abrirTerminos" class="text-blue-600 hover:underline">{{ __('app.registro.terminos_link') }}</a>
            </div>

            <!-- Botón -->
            <button id="btnSubmit"
                class="w-full bg-blue-600 text-white py-3 rounded-[28px] hover:bg-blue-700 transition">
                {{ __('app.registro.btn_registrarse') }}
            </button>

            <!-- Mensaje general -->
            <div id="mensajeGeneral" class="hidden mt-2 text-sm text-red-500"></div>

        </form>

        <p class="text-center mt-6 text-sm text-slate-600">
            {{ __('app.registro.ya_tienes_cuenta') }}
            <button type="button" onclick="toggleRegister(); toggleModal();" class="font-semibold text-slate-900 hover:text-sky-600 cursor-pointer">
                {{ __('app.registro.inicia_sesion') }}
            </button>
        </p>

    </div>
</div>

<!-- OVERLAY -->
<div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg flex items-center gap-3">
        <div class="w-6 h-6 border-2 border-gray-300 border-t-blue-600 rounded-full animate-spin"></div>
        <span>{{ __('app.registro.registrando') }}</span>
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
const overlay        = document.getElementById('overlay');
const terminos       = document.getElementById('terminos');
const inputNombre    = document.getElementById('nombre');
const inputApellido  = document.getElementById('apellido');

[inputNombre, inputApellido].forEach(input => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    });
});

/* ---------------- PASSWORD VALIDATION ---------------- */
password.addEventListener('input', () => {
    const valido = password.value.length >= 8 && /\d/.test(password.value);
    if (valido) {
        password.classList.add('border-green-500');
        password.classList.remove('border-red-500');
        errorPassword.textContent = t.passValida;
        errorPassword.className   = "text-xs mt-1 text-green-500";
    } else {
        password.classList.add('border-red-500');
        password.classList.remove('border-green-500');
        errorPassword.textContent = t.passInvalida;
        errorPassword.className   = "text-xs mt-1 text-red-500";
    }
});

/* ---------------- CONFIRMACIÓN ---------------- */
function validarConfirmacion() {
    if (!confirm.value) {
        errorConfirm.textContent = "";
        confirm.classList.remove('border-red-500', 'border-green-500');
        return;
    }
    if (confirm.value === password.value) {
        confirm.classList.add('border-green-500');
        confirm.classList.remove('border-red-500');
        errorConfirm.textContent = t.passCoinciden;
        errorConfirm.className   = "text-xs mt-1 text-green-500";
    } else {
        confirm.classList.add('border-red-500');
        confirm.classList.remove('border-green-500');
        errorConfirm.textContent = t.passNoCoinciden;
        errorConfirm.className   = "text-xs mt-1 text-red-500";
    }
}
confirm.addEventListener('input', validarConfirmacion);
password.addEventListener('input', validarConfirmacion);

/* ---------------- VALIDACIÓN DE EMAIL EN VIVO ---------------- */
email.addEventListener("input", () => {
    const value = email.value.trim();
    const formatoValido = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[A-Za-z]{2,})+$/.test(value);

    if (value === "") {
        errorEmail.textContent = "";
        errorEmail.classList.add("hidden");
        email.classList.remove("border-red-500", "border-green-500");
        return;
    }
    if (!formatoValido) {
        email.classList.add("border-red-500");
        email.classList.remove("border-green-500");
        errorEmail.textContent = t.correoInvalido;
        errorEmail.className   = "text-xs mt-1 text-red-500";
        errorEmail.classList.remove("hidden");
    } else {
        email.classList.add("border-green-500");
        email.classList.remove("border-red-500");
        errorEmail.textContent = t.correoValido;
        errorEmail.className   = "text-xs mt-1 text-green-500";
        errorEmail.classList.remove("hidden");
    }
});

/* ---------------- OJITO ---------------- */
function togglePasswordRegistro(id) {
    const input   = document.getElementById(id);
    const eyeIcon = document.getElementById('eye-icon-' + id);
    if (input.type === 'password') {
        input.type           = 'text';
        eyeIcon.textContent  = 'visibility';
    } else {
        input.type           = 'password';
        eyeIcon.textContent  = 'visibility_off';
    }
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

    const formatoEmail  = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[A-Za-z]{2,})+$/;
    const dominiosValidos = ["gmail.com","hotmail.com","outlook.com","yahoo.com","est.umss.edu.bo"];
    const soloLetras    = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if (!formatoEmail.test(correo)) {
        errores.push(t.errorFormato);
        email.classList.add("border-red-500");
    }

    const dominio = correo.split("@")[1];
    if (dominio && !dominiosValidos.includes(dominio)) {
        errores.push(t.errorDominio);
        email.classList.add("border-red-500");
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

    overlay.classList.remove('hidden');

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
            overlay.classList.add('hidden');
            let erroresBackend = [];
            if (data.errors) {
                if (data.errors.email) {
                    email.classList.add('border-red-500');
                    errorEmail.textContent = data.errors.email[0];
                    errorEmail.className   = "text-xs mt-1 text-red-500";
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
            overlay.classList.add('hidden');
            localStorage.setItem('registro_origen', window.location.href);
            mensajeGeneral.innerHTML = t.exito;
            mensajeGeneral.className = "mt-3 text-sm text-green-600";
            mensajeGeneral.classList.remove('hidden');
            return;
        }

        if (res.redirected) {
            window.location.href = res.url;
            return;
        }

        overlay.classList.add('hidden');

    } catch (error) {
        overlay.classList.add('hidden');
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
            msgLogin.className = "mt-3 text-sm text-green-600";
        }

        localStorage.removeItem('email_verificado');
    }
});
</script>