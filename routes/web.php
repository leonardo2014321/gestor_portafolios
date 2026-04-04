<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecuperacionController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas web del sistema.
| Estas rutas responden a solicitudes del navegador y cargan vistas
| o ejecutan métodos de controladores.
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Ruta de inicio del sistema
|--------------------------------------------------------------------------
| Muestra la vista principal "home.blade.php"
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    return view('home');
})->name('home');


/*
|--------------------------------------------------------------------------
| Ruta para mostrar la vista de recuperación de contraseña
|--------------------------------------------------------------------------
| Carga el formulario donde el usuario solicita recuperar su cuenta
|--------------------------------------------------------------------------
*/
Route::get('/recuperar-password', function () {
    return view('Auth.recuperar');
})->name('password.request');


/*
|--------------------------------------------------------------------------
| Ruta para solicitar recuperación de contraseña
|--------------------------------------------------------------------------
| Envía los datos del formulario al controlador encargado de generar
| y procesar la solicitud de recuperación
|--------------------------------------------------------------------------
*/
Route::post('/recuperar', [RecuperacionController::class, 'solicitarRecuperacion'])
    ->name('password.email');


/*
|--------------------------------------------------------------------------
| Ruta para cambiar la contraseña con token
|--------------------------------------------------------------------------
| Procesa el cambio de contraseña una vez que el usuario recibió
| el token o enlace de recuperación
|--------------------------------------------------------------------------
*/
Route::post('/reset-password', [RecuperacionController::class, 'cambiarContrasena'])
    ->name('password.update');


/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
| LoginController maneja el inicio y cierre de sesión
|--------------------------------------------------------------------------
*/

/*
| Mostrar formulario de login
*/
Route::get('/login', [LoginController::class, 'index'])->name('login');

/*
| Procesar credenciales del login
*/
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

/*
| Cerrar sesión del usuario autenticado
*/
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


/*
|--------------------------------------------------------------------------
| Rutas del menú principal del sistema
|--------------------------------------------------------------------------
| Estas rutas cargan las vistas del panel principal y se usarán
| para la interfaz tipo dashboard de SansiFolios
|--------------------------------------------------------------------------
*/

/*
| Menú principal del sistema
| Muestra la vista menu.blade.php
*/
Route::get('/menu', function () {
    return view('menu');
})->name('menu');

/*
| Sección inicio del dashboard
| Puede apuntar a la misma vista mientras estructuras el sistema
*/
Route::get('/inicio', function () {
    return view('menu');
})->name('inicio');

/*
| Sección características
| Por ahora carga la misma vista base del menú
*/
Route::get('/caracteristicas', function () {
    return view('menu');
})->name('caracteristicas');

/*
| Sección portafolios
| Desde aquí puedes luego conectar un controlador real
*/
Route::get('/portafolios', function () {
    return view('menu');
})->name('portafolios.index');

/*
| Sección académica
*/
Route::get('/academico', function () {
    return view('menu');
})->name('academico');

/*
| Sección reportes
*/
Route::get('/reportes', function () {
    return view('menu');
})->name('reportes');

/*
| Sección perfil del usuario
*/
Route::get('/perfil', function () {
    return view('menu');
})->name('perfil');