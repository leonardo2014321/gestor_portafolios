<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    @vite('resources/css/app.css')
</head>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<body class="bg-gray-100 min-h-screen flex items-center justify-center font-[Poppins]">

<div class="w-full max-w-lg px-4 sm:px-6">

    <!-- 🔹 LOGO -->
    <div class="flex items-center gap-2 mb-4 sm:mb-6">
        <img src="{{ asset('logo.png') }}" class="w-8 h-8">
        <span class="font-semibold text-gray-700 text-lg">SansiFolios</span>
    </div>

    <!-- 🔹 TITULO -->
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6 sm:mb-8">
        Recuperar acceso <br> a tu cuenta
    </h1>

    <!-- 🔹 TARJETA -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md w-full">

        <!-- 🔹 MENSAJE DINÁMICO -->
        <p id="mensajePrincipal" class="text-gray-600 mb-6 text-sm sm:text-base">
            Ingresa tu correo electrónico registrado y te enviaremos un enlace para restablecer tu acceso al sistema.
        </p>

        <!-- ========================= -->
        <!--  FORMULARIO EMAIL -->
        <!-- ========================= -->
        <form id="formRecuperar">

            <label class="text-xs font-semibold text-gray-500">
                CORREO ELECTRÓNICO
            </label>

            <input 
                type="email" 
                id="email"
                placeholder="ejemplo@correo.com"
                class="w-full mt-2 p-3 rounded-xl bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none text-sm sm:text-base"
            >

            <p id="errorEmail" class="text-red-500 text-sm mt-2 hidden"></p>

            <button 
                id="btnRecuperar"
                type="submit"
                class="w-full mt-5 py-3 sm:py-3.5 rounded-xl text-white font-semibold 
                    bg-gradient-to-r from-blue-500 to-blue-700 
                    hover:from-blue-600 hover:to-blue-800 shadow-md">
                Enviar enlace de recuperación →
            </button>

            <!-- LOADING -->
            <div id="loadingEmail" class="hidden mt-4 flex items-center gap-2 text-gray-600">
                <div class="w-5 h-5 border-2 border-gray-300 border-t-blue-600 rounded-full animate-spin"></div>
                <span>Enviando correo...</span>
            </div>

            <div id="mensajeEmail" class="mt-5"></div>

        </form>

        <!-- ========================= -->
        <!--  FORMULARIO RESET -->
        <!-- ========================= -->
        <form id="formReset" class="hidden mt-6">

            <h2 class="text-lg sm:text-xl font-bold mb-4">
                Establecer nueva contraseña
            </h2>

            <!-- PASSWORD -->
            <label class="text-xs font-semibold text-gray-500">
                NUEVA CONTRASEÑA
            </label>

            <div class="relative mt-2">

                <input 
                    type="password" 
                    id="password"
                    class="w-full p-3 pr-12 rounded-xl bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none"
                >

                <button 
                    type="button"
                    onclick="togglePassword('password', this)"
                    class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">

                    👁

                </button>

            </div>

            <p id="errorPassword" class="text-red-500 text-sm mt-2 hidden"></p>

            <!-- CONFIRMAR -->
            <label class="text-xs font-semibold text-gray-500 mt-4 block">
                CONFIRMAR CONTRASEÑA
            </label>

            <div class="relative mt-2">

                <input 
                    type="password" 
                    id="confirmPassword"
                    class="w-full p-3 pr-12 rounded-xl bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none"
                >

                <button 
                    type="button"
                    onclick="togglePassword('confirmPassword', this)"
                    class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">

                    👁

                </button>

            </div>

            <p id="errorConfirm" class="text-red-500 text-sm mt-2 hidden"></p>

            <!-- REGLAS -->
            <div class="mt-4 sm:mt-5 space-y-3">

                <div id="ruleLength" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border">
                    <div class="icon w-6 h-6 flex items-center justify-center rounded-full bg-gray-300 text-white text-sm">✕</div>
                    <span class="text-gray-600 text-sm sm:text-base">Mínimo 8 caracteres</span>
                </div>

                <div id="ruleNumber" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border">
                    <div class="icon w-6 h-6 flex items-center justify-center rounded-full bg-gray-300 text-white text-sm">✕</div>
                    <span class="text-gray-600 text-sm sm:text-base">Número o símbolo</span>
                </div>

            </div>

            <button 
                type="submit"
                class="w-full mt-6 py-3 sm:py-3.5 rounded-xl text-white font-semibold 
                    bg-gradient-to-r from-blue-500 to-blue-700 
                    hover:from-blue-600 hover:to-blue-800 shadow-md">
                Actualizar contraseña →
            </button>

            <div id="mensajeReset" class="mt-5"></div>

        </form>

    </div>
</div>

<script>

/**
 * Obtener token desde la URL
 */
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('token');

/**
 * Mostrar formulario de reset si existe token
 */
if (token) {
    document.getElementById('formRecuperar').classList.add('hidden');
    document.getElementById('formReset').classList.remove('hidden');

    document.getElementById('mensajePrincipal').innerText =
        "Define una nueva contraseña segura para proteger tu cuenta y tu portafolio";
}

/**
 * Mostrar u ocultar contraseña
 */
function togglePassword(id, btn) {

    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        btn.innerText = "🙈";
    } else {
        input.type = "password";
        btn.innerText = "👁";
    }
}

/**
 * Mostrar mensaje visual
 */
function mostrarMensaje(elemento, texto, tipo) {

    elemento.innerHTML = "";

    if (tipo === 'error') {

        elemento.innerHTML = `
            <div class="flex gap-3 bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl">
                <div class="bg-red-500 text-white w-6 h-6 flex items-center justify-center rounded-full">✕</div>
                <div>${texto}</div>
            </div>
        `;

    } else {

        elemento.innerHTML = `
            <div class="flex gap-3 bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl">
                <div class="bg-green-500 text-white w-6 h-6 flex items-center justify-center rounded-full">✓</div>
                <div>${texto}</div>
            </div>
        `;
    }
}

/**
 * Validar email
 */
function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

/**
 * Validar contraseña
 */
function validarPassword(pass) {
    return pass.length >= 8 && /[0-9!@#$%^&*]/.test(pass);
}

/**
 * Reglas visuales
 */
function setRule(id, ok) {

    const el = document.getElementById(id);
    const icon = el.querySelector('.icon');
    const text = el.querySelector('span');

    if (ok) {
        el.classList.add('bg-green-50', 'border-green-200');
        icon.className = "icon w-6 h-6 flex items-center justify-center rounded-full bg-green-500 text-white text-sm";
        icon.innerText = "✓";
        text.classList.add('text-green-600');
    } else {
        el.classList.remove('bg-green-50', 'border-green-200');
        icon.className = "icon w-6 h-6 flex items-center justify-center rounded-full bg-gray-300 text-white text-sm";
        icon.innerText = "✕";
        text.classList.remove('text-green-600');
    }
}

/**
 * Validación en tiempo real
 */
document.getElementById('password')?.addEventListener('input', () => {

    const value = document.getElementById('password').value;

    setRule('ruleLength', value.length >= 8);
    setRule('ruleNumber', /[0-9!@#$%^&*]/.test(value));
});

/**
 * Enviar correo
 */
document.getElementById('formRecuperar')?.addEventListener('submit', async (e) => {

    e.preventDefault();

    const email = document.getElementById('email').value;
    const errorEmail = document.getElementById('errorEmail');
    const mensaje = document.getElementById('mensajeEmail');
    const loading = document.getElementById('loadingEmail');
    const boton = document.getElementById('btnRecuperar');

    errorEmail.classList.add('hidden');
    mensaje.innerHTML = "";

    if (!email) {
        errorEmail.innerText = "El correo es obligatorio";
        errorEmail.classList.remove('hidden');
        return;
    }

    if (!validarEmail(email)) {
        errorEmail.innerText = "Correo inválido";
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

        if (!res.ok) {
            mostrarMensaje(mensaje, data.mensaje || "Error al enviar correo", 'error');
            return;
        }

        mostrarMensaje(mensaje, data.mensaje || "Correo enviado correctamente", 'success');

    } catch (error) {

        loading.classList.add('hidden');
        boton.disabled = false;
        boton.classList.remove('opacity-50');

        mostrarMensaje(mensaje, "No se pudo conectar con el servidor", 'error');
    }
});

/**
 * Reset contraseña
 */
document.getElementById('formReset')?.addEventListener('submit', async (e) => {

    e.preventDefault();

    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirmPassword').value;

    const errorPassword = document.getElementById('errorPassword');
    const errorConfirm = document.getElementById('errorConfirm');
    const mensaje = document.getElementById('mensajeReset');

    errorPassword.classList.add('hidden');
    errorConfirm.classList.add('hidden');

    if (!validarPassword(password)) {
        errorPassword.innerText = "Debe tener mínimo 8 caracteres y un número o símbolo";
        errorPassword.classList.remove('hidden');
        return;
    }

    if (password !== confirm) {
        errorConfirm.innerText = "Las contraseñas no coinciden";
        errorConfirm.classList.remove('hidden');
        return;
    }

    try {

        const res = await fetch('/reset-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                token: token,
                contrasena: password
            })
        });

        const data = await res.json();

        if (!res.ok) {
            mostrarMensaje(mensaje, data.mensaje, 'error');
            return;
        }

        mostrarMensaje(mensaje, "Contraseña actualizada correctamente", 'success');

    } catch (error) {

        mostrarMensaje(mensaje, "Error al actualizar contraseña", 'error');
    }
});

</script>

</body>
</html>