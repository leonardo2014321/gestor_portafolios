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
        <h2 class="text-2xl font-bold text-green-600">✔ Cuenta verificada</h2>
        <p class="mt-3 text-gray-600">Puedes cerrar esta pestaña.</p>
    </div>
</div>

<script>
    // Avisar a la pestaña original
    localStorage.setItem('email_verificado', 'true');

    // Intentar cerrar esta pestaña
    setTimeout(() => window.close(), 1000);
</script>

</body>
</html>
