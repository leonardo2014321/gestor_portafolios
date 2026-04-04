


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- 🔥 AQUÍ -->
    <title>Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

<x-layout.navbar />

<main class="flex-grow flex items-center justify-center px-4">

    <div class="grid grid-cols-1 md:grid-cols-2 bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-5xl min-h-[500px]">




        {{-- IZQUIERDA --}}
        <div style="background: linear-gradient(to bottom, #D9EBFF 42%, #195FF8);" class="text-white p-6 md:p-10 flex flex-col justify-center">


            <!-- IMAGEN -->
            <img src="/images/registrar.png" 
                class="w-32 mb-6 self-start" 
                alt="Registro">

            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight text-black font-[Poppins]">
                Crea tu portafolio personal y <br>
                <span class="text-[#2F6BFF] font-semibold">
                    muestra tus proyectos al mundo
                </span>
            </h2>

            <p class="mt-10 text-2xl font-[Poppins] text-black">¿Listo para el siguiente nivel?</p>


            <div class="mt-6 space-y-3">
                <div class="bg-white text-gray-800 p-3 rounded-lg">
                    <b>Muestra tus habilidades</b><br>
                    <span class="text-sm">Convierte tus habilidades en oportunidades</span>
                </div>

                <div class="bg-white text-gray-800 p-3 rounded-lg">
                    <b>Conecta tus redes</b><br>
                    <span class="text-sm">Integra tus plataformas y amplía tu alcance</span>
                </div>
            </div>
        </div>

        {{-- DERECHA --}}
<div class="p-8 font-[Poppins] text-gray-800 space-y-6 flex flex-col justify-center h-full">




    <h2 class="text-xl font-semibold">Formulario de Registro</h2>
    <p class="text-sm text-gray-600 mb-6">Crea tu cuenta para comenzar.</p>

    <form id="formRegistro" method="POST" action="/registro">
        @csrf

        {{-- Nombre + Apellido --}}
        <div class="grid grid-cols-2 gap-3 mb-4">
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

        {{-- EMAIL --}}
        <div class="mb-4">
            <label class="text-sm">Correo electrónico</label>

            <input type="email" name="email" id="email"
                class="w-full border rounded-lg px-3 py-2 mt-1">

            <p id="errorEmail" class="text-xs mt-1 hidden"></p>
        </div>

        {{-- PASSWORD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">

            <div class="relative">
                <label class="text-sm">Contraseña</label>

                <input type="password" name="password" id="password"
                    class="w-full border rounded-lg px-3 py-2 mt-1 pr-10">

                <button type="button" onclick="togglePassword('password')" class="absolute right-2 top-9">
                    <span id="eye-icon" class="material-icons">visibility</span>
                </button>


                <p id="errorPassword" class="text-xs mt-1"></p>
            </div>

            <div class="relative">
                <label class="text-sm">Confirmar Contraseña</label>

                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border rounded-lg px-3 py-2 mt-1 pr-10">

                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-2 top-9">
                    <span id="eye-icon-confirm" class="material-icons">visibility</span>
                </button>


                <p id="errorConfirm" class="text-xs mt-1"></p>
            </div>

        </div>

        {{-- CHECK --}}
        <div class="mb-4 text-sm">
            <input type="checkbox"> Acepto los <span class="text-blue-600">términos de servicio</span>
        </div>

        {{-- BOTÓN --}}
        <button id="btnSubmit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
            Registrarse →
        </button>

        {{-- MENSAJE GENERAL --}}
        <div id="mensajeGeneral" class="hidden mt-3 text-sm text-red-500"></div>

    </form>

</div>

{{-- LOADING OVERLAY --}}
<div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg flex items-center gap-3">
        <div class="w-6 h-6 border-2 border-gray-300 border-t-blue-600 rounded-full animate-spin"></div>
        <span>Registrando usuario...</span>
    </div>
</div>

<script>
const password = document.getElementById('password');
const confirm = document.getElementById('password_confirmation');
const email = document.getElementById('email');

const errorPassword = document.getElementById('errorPassword');
const errorConfirm = document.getElementById('errorConfirm');
const errorEmail = document.getElementById('errorEmail');
const mensajeGeneral = document.getElementById('mensajeGeneral');
const overlay = document.getElementById('overlay');

/**
 * PASSWORD
 */
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

/**
 * VALIDAR CONFIRMACIÓN EN TIEMPO REAL
 */
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

/**
 * EVENTOS (🔥 AQUÍ VA LO QUE PREGUNTAS)
 */
confirm.addEventListener('input', validarConfirmacion);
password.addEventListener('input', validarConfirmacion);

/**
 * OJITO
 */
function togglePassword(id) {
    const input = document.getElementById(id);
    const eyeIcon = id === 'password' ? document.getElementById('eye-icon') : document.getElementById('eye-icon-confirm');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.textContent = 'visibility_off';  // Cambiar al icono de ojo cerrado
    } else {
        input.type = 'password';
        eyeIcon.textContent = 'visibility';  // Cambiar al icono de ojo abierto
    }
}


/**
 * SUBMIT CON VALIDACIÓN + LOADING
 */
document.getElementById('formRegistro').addEventListener('submit', async (e) => {
    e.preventDefault();

    mensajeGeneral.classList.add('hidden');
    errorEmail.classList.add('hidden');

    let errores = [];

    const nombre = document.getElementById('nombre').value.trim();
    const correo = email.value.trim();

    if (!nombre) errores.push("El nombre es obligatorio");
    if (!correo) errores.push("El correo es obligatorio");

    if (password.value.length < 8 || !/\d/.test(password.value)) {
        errores.push("La contraseña no cumple los requisitos");
    }

    if (password.value !== confirm.value) {
        errores.push("Las contraseñas no coinciden");
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
                'X-Requested-With': 'XMLHttpRequest' // 👈 IMPORTANTE
            }
        });

        // 👇 SI HAY ERROR 422 (VALIDACIÓN LARAVEL)
        if (res.status === 422) {
            const data = await res.json();

            overlay.classList.add('hidden');

            let erroresBackend = [];

            if (data.errors) {

                // ERROR EMAIL
            if (data.errors.email) {
                email.classList.add('border-red-500');
                email.classList.remove('border-green-500');

                errorEmail.textContent = data.errors.email[0];
                errorEmail.className = "text-xs mt-1 text-red-500"; // 🔥 fuerza rojo
                errorEmail.classList.remove('hidden');
            }


                // OTROS ERRORES
                Object.values(data.errors).forEach(arr => {
                    erroresBackend.push(arr[0]);
                });
            }

            mensajeGeneral.innerHTML = erroresBackend.join("<br>");
            mensajeGeneral.classList.remove('hidden');

            return;
        }

        // 👇 SI TODO OK (ENVÍO DE CORREO)
        if (res.ok) {

            overlay.classList.add('hidden');

            mensajeGeneral.innerHTML = "Te enviamos un correo de verificación Revisa tu bandeja.";
            mensajeGeneral.className = "mt-3 text-sm text-green-600";
            mensajeGeneral.classList.remove('hidden');

            // 🔒 opcional: desactivar botón
            document.getElementById('btnSubmit').disabled = true;

            return;
        }

        
        // 👇 SI TODO OK (REDIRECT NORMAL)
        if (res.redirected) {
            window.location.href = res.url;
            return;
        }

        overlay.classList.add('hidden');

    } catch (error) {
        overlay.classList.add('hidden');
        mensajeGeneral.innerHTML = "Error en el servidor";
        mensajeGeneral.classList.remove('hidden');
    }
});

// 👀 Detectar si ya verificó el correo (🔥 AQUÍ VA)
setInterval(() => {

    if (localStorage.getItem('email_verificado') === 'true') {

        // limpiar flag
        localStorage.removeItem('email_verificado');

        // mensaje
        mensajeGeneral.innerHTML = "Correo verificado ✔ Redirigiendo...";
        mensajeGeneral.className = "mt-3 text-sm text-green-600";
        mensajeGeneral.classList.remove('hidden');

        // redirigir
        setTimeout(() => {
            window.location.href = "/login";
        }, 1500);
    }

}, 1000);



</script>
</main>
<x-layout.footer />
</body>
</html>
