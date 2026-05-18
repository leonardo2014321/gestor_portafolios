<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ __('app.verificacion_ok.titulo') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow text-center">
        <h2 class="text-2xl font-bold text-green-600">{{ __('app.verificacion_ok.cuenta_verificada') }}</h2>
        <p class="mt-3 text-gray-600">{{ __('app.verificacion_ok.cerrar_pestana') }}</p>
    </div>
</div>

<script>
    localStorage.setItem('email_verificado', 'true');
    setTimeout(() => window.close(), 1000);
</script>

</body>
</html>