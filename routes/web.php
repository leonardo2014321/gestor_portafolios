<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecuperacionController;
use App\Http\Controllers\AuthController;

/**
 * Ruta principal del sistema
 * Muestra la página de inicio
 */
Route::get('/', function () {
    return view('home');
});

/**
 * Mostrar vista de recuperación de contraseña
 */
Route::get('/recuperar-password', function () {
    return view('Auth.recuperar');
});

/**
 * Solicitar recuperación de contraseña
 */
Route::post('/recuperar', [RecuperacionController::class, 'solicitarRecuperacion']);

/**
 * Cambiar contraseña mediante token
 */
Route::post('/reset-password', [RecuperacionController::class, 'cambiarContrasena']);

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/recuperar', function () {
    return view('auth.recuperar');
});

Route::get('/registro', function () {
    return view('auth.registro');
});