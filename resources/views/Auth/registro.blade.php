<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">


<!-- MODAL EMERGENTE  -->
<div id="registerModal" class="fixed inset-0 z-50 hidden bg-slate-900/20 backdrop-blur-sm flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-[440px] rounded-[40px] bg-white p-8 shadow-[0_30px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 sm:p-10 font-[Poppins]">

        <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-[28px] bg-slate-100 shadow-sm">
            <img src="/images/registrar.png" alt="Logo" class="h-12 w-12 object-contain" />
        </div>

        <h2 class="text-3xl font-bold text-center text-slate-900">Crear cuenta</h2>
        <p class="mt-2 text-center text-sm text-slate-500">Regístrate para comenzar a construir tu portafolio.</p>

        <!-- FORMULARIO ORIGINAL  -->
        <form id="formRegistro" method="POST" action="/registro" class="mt-8 space-y-5">
            @csrf

            <!-- Nombre y Apellido -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

                <div>
                    <label class="text-sm">Apellidos</label>
                    <input type="text" name="apellido" id="apellido"
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm">Correo electrónico</label>
                <input type="email" name="email" id="email"
                    class="w-full border rounded-lg px-3 py-2 mt-1">
                <p id="errorEmail" class="text-xs mt-1 hidden"></p>
            </div>

            <!-- Contraseña -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                <div class="relative">
                    <label class="text-sm">Contraseña</label>
                    <input type="password" name="password" id="password"
                        class="w-full border rounded-lg px-3 py-2 mt-1 pr-10">

                    <button type="button" onclick="togglePassword('password')" class="absolute right-2 top-9">
                        <span id="eye-icon" class="material-icons">visibility_off</span>
                    </button>

                    <p id="errorPassword" class="text-xs mt-1"></p>
                </div>

                <div class="relative">
                    <label class="text-sm">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border rounded-lg px-3 py-2 mt-1 pr-10">

                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-2 top-9">
                        <span id="eye-icon-confirm" class="material-icons">visibility_off</span>
                    </button>

                    <p id="errorConfirm" class="text-xs mt-1"></p>
                </div>

            </div>

            <!-- Términos -->
            <div class="text-sm">
               <input type="checkbox" id="terminos"> Acepto los 
               <a href="#" id="abrirTerminos" class="text-blue-600 hover:underline">términos de servicio</a>
            </div>

            <!-- Botón -->
            <button id="btnSubmit"
                class="w-full bg-blue-600 text-white py-3 rounded-[28px] hover:bg-blue-700 transition">
                Registrarse →
            </button>

            <!-- Mensaje general -->
            <div id="mensajeGeneral" class="hidden mt-2 text-sm text-red-500"></div>

        </form>

        <p class="text-center mt-6 text-sm text-slate-600">
            ¿Ya tienes cuenta?
            <button type="button" onclick="toggleRegister(); toggleModal();" class="font-semibold text-slate-900 hover:text-sky-600 cursor-pointer">
                Inicia sesión
            </button>
        </p>

    </div>
</div>

<!-- OVERLAY ORIGINAL -->
<div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg flex items-center gap-3">
        <div class="w-6 h-6 border-2 border-gray-300 border-t-blue-600 rounded-full animate-spin"></div>
        <span>Registrando usuario...</span>
    </div>
</div>

<!-- TODO TU SCRIPT  -->
<script>

const password = document.getElementById('password');
const confirm = document.getElementById('password_confirmation');
const email = document.getElementById('email');

const errorPassword = document.getElementById('errorPassword');
const errorConfirm = document.getElementById('errorConfirm');
const errorEmail = document.getElementById('errorEmail');
const mensajeGeneral = document.getElementById('mensajeGeneral');
const overlay = document.getElementById('overlay');
const terminos = document.getElementById('terminos');
const inputNombre = document.getElementById('nombre');
const inputApellido = document.getElementById('apellido');

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
        errorPassword.textContent = "Contraseña válida";
        errorPassword.className = "text-xs mt-1 text-green-500";
    } else {
        password.classList.add('border-red-500');
        password.classList.remove('border-green-500');
        errorPassword.textContent = "Mínimo 8 caracteres y un número";
        errorPassword.className = "text-xs mt-1 text-red-500";
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
        errorConfirm.textContent = "Coinciden";
        errorConfirm.className = "text-xs mt-1 text-green-500";
    } else {
        confirm.classList.add('border-red-500');
        confirm.classList.remove('border-green-500');
        errorConfirm.textContent = "No coinciden";
        errorConfirm.className = "text-xs mt-1 text-red-500";
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
        errorEmail.textContent = "El correo no es válido";
        errorEmail.className = "text-xs mt-1 text-red-500";
        errorEmail.classList.remove("hidden");
    } else {
        email.classList.add("border-green-500");
        email.classList.remove("border-red-500");
        errorEmail.textContent = "Correo válido";
        errorEmail.className = "text-xs mt-1 text-green-500";
        errorEmail.classList.remove("hidden");
    }
});


/* ---------------- OJITO ---------------- */
function togglePassword(id) {
    const input = document.getElementById(id);
    const eyeIcon = id === 'password'
        ? document.getElementById('eye-icon')
        : document.getElementById('eye-icon-confirm');

    input.type = input.type === 'password' ? 'text' : 'password';
    eyeIcon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
}


/* ---------------- SUBMIT + VALIDACIONES ---------------- */
document.getElementById('formRegistro').addEventListener('submit', async (e) => {
    e.preventDefault();

    mensajeGeneral.classList.add('hidden');
    mensajeGeneral.innerHTML = "";

    errorEmail.classList.add('hidden');
    errorPassword.classList.add('hidden');
    errorConfirm.classList.add('hidden');

    terminos.classList.remove("ring-2", "ring-red-500");

    let errores = [];

    const nombre = document.getElementById('nombre').value.trim();
    const apellido = document.getElementById('apellido').value.trim();
    const correo = email.value.trim();

    /* -------- EMAIL FORMATO -------- */
    const formatoEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[A-Za-z]{2,})+$/;

    if (!formatoEmail.test(correo)) {
        errores.push("El correo no tiene un formato válido");
        email.classList.add("border-red-500");
    }
    /* -------- VALIDACIÓN DE DOMINIO -------- */
    const dominiosValidos = [
        "gmail.com",
        "hotmail.com",
        "outlook.com",
        "yahoo.com",
        "est.umss.edu.bo" 
    ];

    const dominio = correo.split("@")[1];

    if (dominio && !dominiosValidos.includes(dominio)) {
        errores.push("Dominio de correo inválido o mal escrito");
        email.classList.add("border-red-500");
    }

    /* -------- VALIDACIÓN EMAIL -------- */
    const usuario = correo.split("@")[0];

    if (usuario.startsWith(".") || usuario.endsWith(".")) {
        errores.push("El correo no puede empezar o terminar con punto");
    }

    if (usuario.includes("..")) {
        errores.push("El correo no puede tener puntos consecutivos");
    }

    if (usuario.length > 64) {
        errores.push("El nombre del correo es demasiado largo");
    }

    if (correo.length > 100) {
        errores.push("El correo es demasiado largo");
    }

    /* -------- CAMPOS VACÍOS -------- */
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if (!nombre) errores.push("El nombre es obligatorio");
    else if (!soloLetras.test(nombre)) errores.push("El nombre solo puede contener letras");

    if (!apellido) errores.push("El apellido es obligatorio");
    else if (!soloLetras.test(apellido)) errores.push("El apellido solo puede contener letras");
    if (!correo) errores.push("El correo es obligatorio");

    /* -------- CONTRASEÑA -------- */
    if (password.value.length < 8 || !/\d/.test(password.value)) {
        errores.push("La contraseña no cumple los requisitos");
    }

    /* -------- CONFIRMACIÓN -------- */
    if (password.value !== confirm.value) {
        errores.push("Las contraseñas no coinciden");
    }

    /* -------- TÉRMINOS -------- */
    if (!terminos.checked) {
        errores.push("Debe aceptar los términos de servicio");
        terminos.classList.add("ring-2", "ring-red-500");
    }

    /* -------- MOSTRAR ERRORES -------- */
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
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        if (res.status === 422) {
            const data = await res.json();
            overlay.classList.add('hidden');

            let erroresBackend = [];

            if (data.errors) {
                if (data.errors.email) {
                    email.classList.add('border-red-500');
                    errorEmail.textContent = data.errors.email[0];
                    errorEmail.className = "text-xs mt-1 text-red-500";
                    errorEmail.classList.remove('hidden');
                }

                Object.values(data.errors).forEach(arr => erroresBackend.push(arr[0]));
            }

            mensajeGeneral.innerHTML = erroresBackend.join("<br>");
            mensajeGeneral.classList.remove('hidden');
            return;
        }

        if (res.ok) {
            overlay.classList.add('hidden');
            mensajeGeneral.innerHTML = "Si el correo es válido, recibirás un enlace de verificación.<br>Revisa también tu bandeja de spam.";
            mensajeGeneral.className = "mt-3 text-sm text-green-600";
            mensajeGeneral.classList.remove('hidden');
          //  document.getElementById('btnSubmit').disabled = true;
            return;
        }

        if (res.redirected) {
            window.location.href = res.url;
            return;
        }

        overlay.classList.add('hidden');

    } catch (error) {
        overlay.classList.add('hidden');
        mensajeGeneral.textContent = "No se pudo enviar el correo. Intenta más tarde.";
        mensajeGeneral.classList.remove('hidden');
    }
});


/* -------- DETECCIÓN DE VERIFICACIÓN DE CORREO -------- */
window.addEventListener("storage", function(event) {

    if (event.key === "email_verificado") {

        mensajeGeneral.innerHTML = "✔ Cuenta verificada correctamente";
        mensajeGeneral.className = "mt-3 text-sm text-green-600";
        mensajeGeneral.classList.remove('hidden');

        // cerrar modal registro
        document.getElementById("registerModal").classList.add("hidden");

        // abrir modal login
        document.getElementById("loginModal").classList.remove("hidden");

        localStorage.removeItem('email_verificado');
    }

});
</script>



</body>
</html>




