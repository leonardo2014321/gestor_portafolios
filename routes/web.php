<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecuperacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistroController;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Cache;
use App\Services\ActividadService;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Perfil\RedPerfilController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\Perfil\TrayectoriaController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Acceso para todos)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('inicio');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/caracteristicas', function () {
    return view('Auth.caracteristicas');
})->name('caracteristicas');

// ✅ RUTA CORREGIDA: Ahora está en la zona pública y no pedirá login
Route::get('/portafolios', function () {
    return view('Auth.portafolios');
})->name('portafolios.index');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Solo usuarios autenticados)
|--------------------------------------------------------------------------
| Se protegen para evitar errores al intentar acceder a auth()->user()
*/

Route::middleware('auth')->group(function () {
    
    // Panel Principal
    Route::get('/menu', function () {
        return view('menu');
    })->name('menu');

    /**
     * IMPLEMENTACIÓN DEL EXPLORADOR
     * Carga la vista ubicada en resources/views/Auth/explorador.blade.php
     */
    Route::get('/explorador', function () {
        return view('Auth.explorador'); 
    })->name('explorador');

    // (La ruta de portafolios ya fue eliminada de aquí)

    Route::get('/academico', function () {
        return view('academico');
    })->name('academico');

    Route::get('/reportes', function () {
        return view('reportes');
    })->name('reportes');

    // Gestión de Perfil y Redes
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::post('/perfil/redes', [RedPerfilController::class, 'guardarRedes']);
    Route::get('/perfil/redes', [RedPerfilController::class, 'obtenerRedes']);

    // Trayectoria y Habilidades
    Route::get('/trayectoria', [TrayectoriaController::class, 'index']);
    Route::post('/trayectoria/habilidades', [TrayectoriaController::class, 'storeHabilidad']);
    Route::delete('/trayectoria/habilidades/{id}', [TrayectoriaController::class, 'destroyHabilidad']);
    Route::post('/trayectoria/experiencias', [TrayectoriaController::class, 'storeExperiencia']);
    Route::delete('/trayectoria/experiencias/{id}', [TrayectoriaController::class, 'destroyExperiencia']);
    Route::post('/trayectoria/formaciones', [TrayectoriaController::class, 'storeFormacion']);
    Route::delete('/trayectoria/formaciones/{id}', [TrayectoriaController::class, 'destroyFormacion']);
    
    // Salida segura
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Autenticación, Registro y Recuperación
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/registro', [RegistroController::class, 'show'])->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro.post');

// Recuperación de Contraseña
Route::post('/recuperar', [RecuperacionController::class, 'solicitarRecuperacion']);
Route::post('/reset-password', [RecuperacionController::class, 'cambiarContrasena']);

/*
|--------------------------------------------------------------------------
| Verificación de correo electrónico (Lógica de Registro Temporal)
|--------------------------------------------------------------------------
*/

Route::get('/verificar-email', function (Request $request) {
    $token = $request->token;

    // Obtener datos temporales almacenados en Cache
    $datos = Cache::get('registro_temp_'.$token);

    if (!$datos) {
        return redirect('/registro')->withErrors('Token inválido o expirado.');
    }

    // Crear usuario definitivo tras validación
    $usuario = Usuario::create([
        'nombre' => $datos['nombre'],
        'apellido' => $datos['apellido'] ?? null,
        'email' => $datos['email'],
        'contrasena' => $datos['password'],
        'email_verificado' => true,
    ]);

    // Registrar actividad en el sistema
    ActividadService::log($usuario->id, 'registro_usuario', ['email' => $usuario->email]);

    // Limpiar caché
    Cache::forget('registro_temp_'.$token);

    return redirect('/login')->with('success', 'Correo verificado correctamente, ya puedes iniciar sesión.');
});

/*
|--------------------------------------------------------------------------
| Autenticación por Google
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/Calendario', function () {
    return view('calendario');
});

Route::middleware('auth')->group(function () {

    Route::post('/perfil/redes', [RedPerfilController::class, 'guardarRedes']);
    Route::get('/perfil/redes', [RedPerfilController::class, 'obtenerRedes']);

});

