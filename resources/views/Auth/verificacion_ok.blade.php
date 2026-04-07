<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow text-center">

        <h2 class="text-2xl font-bold text-green-600">
            ✔ Cuenta verificada
        </h2>

        <p class="mt-3 text-gray-600">
            Redirigiendo al login...
        </p>

        <a href="/login"
           class="mt-5 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">
            Ir ahora
        </a>

    </div>
</div>

<script>
// avisar a la otra pestaña
localStorage.setItem('email_verificado', 'true');

// cerrar la pestaña automáticamente
setTimeout(() => {
    window.close();
}, 1000);
</script>

