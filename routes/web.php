<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecuperacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistroController;
use Illuminate\Http\Request;
use App\Models\TokenRecuperacion;
use App\Models\Usuario;
use Illuminate\Support\Facades\Cache;
use App\Services\ActividadService;
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


/**
 * Mostrar formulario
 */
Route::get('/registro', [RegistroController::class, 'show'])->name('registro');

/**
 * Procesar registro
 */
Route::post('/registro', [RegistroController::class, 'register'])->name('registro.post');

/**
 * Verificación de correo electrónico
 */
Route::get('/verificar-email', function (Request $request) {

    $token = $request->token;

    // Obtener datos temporales
    $datos = Cache::get('registro_temp_'.$token);

    if (!$datos) {
        return redirect('/registro')->withErrors('Token inválido o expirado.');
    }

    // Crear usuario definitivo
    $usuario = Usuario::create([
        'nombre' => $datos['nombre'],
        'apellido' => $datos['apellido'] ?? null,
        'email' => $datos['email'],
        'contrasena' => $datos['password'],
        'email_verificado' => true,
    ]);

    // Registrar actividad
    ActividadService::log($usuario->id, 'registro_usuario', ['email' => $usuario->email]);

    // Borrar datos temporales
    Cache::forget('registro_temp_'.$token);

    return redirect('/login')->with('success', 'Correo verificado correctamente, ya puedes iniciar sesión.');
});

Route::get('/verificar-email', [RegistroController::class, 'verificarEmail']);

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

