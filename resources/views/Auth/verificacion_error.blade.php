<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ __('app.verificacion_error.titulo') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow text-center">

        <h2 class="text-2xl font-bold text-red-600">
            {{ __('app.verificacion_error.token_invalido') }}
        </h2>

        <p class="mt-3 text-gray-600">
            {{ __('app.verificacion_error.enlace_invalido') }}
        </p>

        <a href="/?registro=1"
           class="mt-5 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">
            {{ __('app.verificacion_error.volver_registrarse') }}
        </a>

    </div>
</div>

</body>
</html>