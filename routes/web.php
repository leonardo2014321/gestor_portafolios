<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecuperacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;

/**
 * Ruta principal del sistema
 * Muestra la página de inicio
 */
Route::get('/home', function () {
    return view('home');
})->name('home');

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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');