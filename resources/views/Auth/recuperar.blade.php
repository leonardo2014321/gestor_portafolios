<div id="modalRecuperar" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="cerrarModalRecuperar()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block w-full max-w-xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-xl sm:my-8 sm:align-middle">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" onclick="cerrarModalRecuperar()" class="text-gray-400 hover:text-gray-500">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <div class="px-6 py-8 sm:p-10">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight mb-4">
                    Recuperar acceso <br> a tu cuenta
                </h1>

                <p id="mensajePrincipal" class="text-black-600 mb-6 text-sm sm:text-base">
                    Ingresa tu correo electrónico registrado y te enviaremos un enlace para restablecer tu acceso al sistema.
                </p>

                {{-- FORMULARIO 1: Enviar correo --}}
                <form id="formRecuperar">
                    <label class="text-xs font-semibold text-gray-500">CORREO ELECTRÓNICO</label>
                    <input type="email" id="email_recuperar" placeholder="ejemplo@correo.com"
                        class="w-full mt-2 p-3 rounded-xl bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none text-sm sm:text-base">
                    <p id="errorEmail" class="text-red-500 text-sm mt-2 hidden"></p>
                    <button id="btnRecuperar" type="submit"
                        class="w-full mt-5 py-3 sm:py-3.5 rounded-xl text-white font-semibold bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 shadow-md">
                        Enviar enlace de recuperación →
                    </button>
                    <div id="loadingEmail" class="hidden mt-4 flex items-center gap-2 text-gray-600">
                        <div class="w-5 h-5 border-2 border-gray-300 border-t-blue-600 rounded-full animate-spin"></div>
                        <span>Enviando correo...</span>
                    </div>
                    <div id="mensajeEmail" class="mt-5"></div>
                </form>

                {{-- FORMULARIO 2: Cambiar contraseña --}}
                <form id="formReset" class="hidden mt-6">
                    <h2 class="text-lg sm:text-xl font-bold mb-2">Establecer nueva contraseña</h2>

                    <label class="text-xs font-semibold text-gray-500 mt-4 block uppercase">Nueva contraseña</label>
                    <div class="relative mt-2">
                        <input type="password" id="resetPassword"
                            class="w-full p-3 pr-12 rounded-xl bg-gray-100 border-2 border-transparent focus:border-gray-900 focus:bg-white outline-none transition-all">
                        <button type="button" onclick="togglePassword('resetPassword')" class="absolute right-3 top-3 text-gray-500">
                            <span id="eye-icon-resetPassword" class="material-icons">visibility</span>
                        </button>
                    </div>
                    <p id="errorNewPassword" class="text-red-500 text-sm font-bold mt-1 hidden"></p>
                    <div class="mt-2 space-y-1">
                        <p id="ruleLength" class="text-xs text-gray-400">✕ Mínimo 8 caracteres</p>
                        <p id="ruleNumber" class="text-xs text-gray-400">✕ Al menos un número o símbolo</p>
                    </div>

                    <label class="text-xs font-semibold text-gray-500 mt-4 block uppercase">Confirmar contraseña</label>
                    <div class="relative mt-2">
                        <input type="password" id="resetConfirmPassword"
                            class="w-full p-3 pr-12 rounded-xl bg-gray-100 border-2 border-transparent focus:border-gray-900 focus:bg-white outline-none transition-all">
                        <button type="button" onclick="togglePassword('resetConfirmPassword')" class="absolute right-3 top-3 text-gray-500">
                            <span id="eye-icon-resetConfirmPassword" class="material-icons">visibility</span>
                        </button>
                    </div>
                    <p id="statusConfirm" class="text-xs font-bold mt-2 hidden"></p>

                    <button type="submit" class="w-full mt-6 py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-blue-500 to-blue-700 shadow-md">
                        Actualizar contraseña →
                    </button>
                    <div id="mensajeReset" class="mt-5"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ─── 1. CONTROL DEL MODAL ─────────────────────────────────────────────────────
function abrirModalRecuperar() {
    const modalLogin = document.getElementById('modalLogin');
    if (modalLogin) modalLogin.classList.add('hidden');
    document.getElementById('modalRecuperar').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function cerrarModalRecuperar() {
    document.getElementById('modalRecuperar').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// ─── 2. DETECTAR TOKEN EN URL ─────────────────────────────────────────────────
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('token');

window.addEventListener('DOMContentLoaded', () => {
    if (token) {
        abrirModalRecuperar();
        document.getElementById('formRecuperar').classList.add('hidden');
        document.getElementById('formReset').classList.remove('hidden');
        document.getElementById('mensajePrincipal').innerText =
            "Define una nueva contraseña segura para proteger tu cuenta y tu portafolio";
    }
});

// ─── 3. UTILIDADES ────────────────────────────────────────────────────────────
function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validarPassword(pass) {
    return pass.length >= 8 && /[0-9!@#$%^&*]/.test(pass);
}

function togglePassword(id) {
    const input = document.getElementById(id);
    const eye = document.getElementById('eye-icon-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        eye.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        eye.textContent = 'visibility';
    }
}

function mostrarMensaje(elemento, texto, tipo) {
    elemento.innerHTML = tipo === 'error'
        ? `<div class="flex gap-3 bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl">
               <div class="bg-red-500 text-white w-6 h-6 flex items-center justify-center rounded-full">✕</div>
               <div>${texto}</div>
           </div>`
        : `<div class="flex gap-3 bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl">
               <div class="bg-green-500 text-white w-6 h-6 flex items-center justify-center rounded-full">✓</div>
               <div>${texto}</div>
           </div>`;
}

// ─── 4. VALIDACIÓN EN TIEMPO REAL ─────────────────────────────────────────────
document.getElementById('resetPassword')?.addEventListener('input', function () {
    const val = this.value;

    // Regla longitud
    const ruleLength = document.getElementById('ruleLength');
    if (val.length >= 8) {
        ruleLength.textContent = '✓ Mínimo 8 caracteres';
        ruleLength.className = 'text-xs text-green-500 font-semibold';
    } else {
        ruleLength.textContent = '✕ Mínimo 8 caracteres';
        ruleLength.className = 'text-xs text-gray-400';
    }

    // Regla número/símbolo
    const ruleNumber = document.getElementById('ruleNumber');
    if (/[0-9!@#$%^&*]/.test(val)) {
        ruleNumber.textContent = '✓ Al menos un número o símbolo';
        ruleNumber.className = 'text-xs text-green-500 font-semibold';
    } else {
        ruleNumber.textContent = '✕ Al menos un número o símbolo';
        ruleNumber.className = 'text-xs text-gray-400';
    }

    validarConfirm(); // revalida coincidencia si ya escribió algo en confirmar
});

document.getElementById('resetConfirmPassword')?.addEventListener('input', validarConfirm);

function validarConfirm() {
    const pass = document.getElementById('resetPassword').value;
    const confirm = document.getElementById('resetConfirmPassword').value;
    const status = document.getElementById('statusConfirm');

    if (!confirm) {
        status.classList.add('hidden');
        return;
    }

    status.classList.remove('hidden');
    if (confirm === pass) {
        status.textContent = '✓ Las contraseñas coinciden';
        status.className = 'text-xs text-green-500 font-semibold mt-2';
    } else {
        status.textContent = '✕ Las contraseñas no coinciden';
        status.className = 'text-xs text-red-500 font-semibold mt-2';
    }
}

// ─── 5. ENVÍO DE CORREO ───────────────────────────────────────────────────────
document.getElementById('formRecuperar')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = document.getElementById('email_recuperar').value;
    const errorEmail = document.getElementById('errorEmail');
    const mensaje = document.getElementById('mensajeEmail');
    const loading = document.getElementById('loadingEmail');
    const boton = document.getElementById('btnRecuperar');

    errorEmail.classList.add('hidden');
    mensaje.innerHTML = '';

    if (!email) {
        errorEmail.innerText = 'El correo es obligatorio';
        errorEmail.classList.remove('hidden');
        return;
    }
    if (!validarEmail(email)) {
        errorEmail.innerText = 'Correo inválido';
        errorEmail.classList.remove('hidden');
        return;
    }

    loading.classList.remove('hidden');
    boton.disabled = true;
    boton.classList.add('opacity-50');

    try {
        const res = await fetch('/recuperar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email })
        });
        const data = await res.json();
        loading.classList.add('hidden');
        boton.disabled = false;
        boton.classList.remove('opacity-50');
        mostrarMensaje(mensaje, data.mensaje || (res.ok ? 'Correo enviado' : 'Error al enviar'), res.ok ? 'success' : 'error');
    } catch (err) {
        loading.classList.add('hidden');
        boton.disabled = false;
        boton.classList.remove('opacity-50');
        mostrarMensaje(mensaje, 'No se pudo conectar con el servidor', 'error');
    }
});

// ─── 6. CAMBIAR CONTRASEÑA ────────────────────────────────────────────────────
document.getElementById('formReset')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const password = document.getElementById('resetPassword').value;
    const confirm = document.getElementById('resetConfirmPassword').value;
    const errorNewPassword = document.getElementById('errorNewPassword');
    const mensaje = document.getElementById('mensajeReset');

    errorNewPassword.classList.add('hidden');

    if (!validarPassword(password)) {
        errorNewPassword.innerText = 'Mínimo 8 caracteres y un número o símbolo';
        errorNewPassword.classList.remove('hidden');
        return;
    }
    if (password !== confirm) {
        validarConfirm();
        return;
    }

    // ✅ Llama al backend igual que antes — sin cambios en BD
    try {
        const res = await fetch('/reset-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ token: token, contrasena: password })
        });
        const data = await res.json();

        if (res.ok) {
            mostrarMensaje(mensaje, data.mensaje || 'Contraseña actualizada correctamente', 'success');
            // Cierra modal y abre login después de 1.5s
            setTimeout(() => {
                cerrarModalRecuperar();
                document.getElementById('modalLogin')?.classList.remove('hidden');
            }, 1500);
        } else {
            mostrarMensaje(mensaje, data.mensaje || 'Error al actualizar', 'error');
        }
    } catch (err) {
        mostrarMensaje(mensaje, 'Error al actualizar contraseña', 'error');
    }
});
</script>