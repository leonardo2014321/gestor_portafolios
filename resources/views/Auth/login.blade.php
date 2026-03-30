<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
font-family:'Poppins',sans-serif;
}
</style>

</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md px-6">

<!-- LOGO -->
<div class="flex flex-col items-center mb-6">

<img src="{{ asset('logo.png') }}" class="w-16 mb-4">

<h1 class="text-3xl font-bold text-gray-800">
Bienvenido de nuevo
</h1>

<p class="text-gray-500 text-sm mt-2">
Inicia sesión para gestionar tu portafolio
</p>

</div>


<!-- TARJETA LOGIN -->

<div class="bg-white rounded-3xl shadow-lg p-8">

<form id="formLogin" class="space-y-5">

<!-- EMAIL -->

<div>
<label class="text-xs font-semibold text-gray-500">
CORREO ELECTRÓNICO
</label>

<input
type="email"
id="email"
placeholder="ejemplo@gmail.com"
class="w-full mt-2 p-3 rounded-xl bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none">
</div>


<!-- PASSWORD -->

<div>
<label class="text-xs font-semibold text-gray-500">
CONTRASEÑA
</label>

<input
type="password"
id="password"
placeholder="••••••••"
class="w-full mt-2 p-3 rounded-xl bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none">
</div>


<!-- OPCIONES -->

<div class="flex justify-between items-center text-sm">

<label class="flex items-center gap-2 text-gray-600">
<input type="checkbox">
Recordar sesión
</label>

<a href="{{ url('/recuperar') }}" class="text-blue-500 hover:underline">
¿Olvidaste tu contraseña?
</a>

</div>


<!-- BOTON LOGIN -->

<button
type="submit"
class="w-full py-3 rounded-xl text-white font-semibold
bg-gradient-to-r from-blue-500 to-blue-700
hover:from-blue-600 hover:to-blue-800 shadow-md">

Entrar al sistema

</button>


<!-- GOOGLE -->

<button
type="button"
class="w-full flex items-center justify-center gap-3
bg-gray-100 py-3 rounded-xl shadow-sm">

<img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5">

Continuar con Google

</button>


<!-- REGISTRO -->

<p class="text-center text-gray-500 text-sm">

¿No tienes cuenta?
<a href="{{ url('/registro') }}" class="font-semibold text-gray-700">
Regístrate
</a>

</p>

</form>

</div>

</div>

</body>
</html>