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
use App\Http\Controllers\Portafolio\PortafolioController;
use App\Http\Controllers\Portafolio\PortafolioProyectoController;
use App\Http\Controllers\Portafolio\PortafolioArchivoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PerfilPublicoController;
use App\Http\Controllers\PortafolioPublicoController;
use App\Http\Controllers\ProyectoPublicoController; 


/*
|--------------------------------------------------------------------------
| Rutas Públicas (Acceso para todos)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return response()->view('home')->withHeaders([
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma'        => 'no-cache',
        'Expires'       => '0',
    ]);
})->name('inicio');

Route::get('/home', function () {
    return response()->view('home')->withHeaders([
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma'        => 'no-cache',
        'Expires'       => '0',
    ]);
})->name('home');

Route::get('/caracteristicas', function () {
    return view('Auth.caracteristicas');
})->name('caracteristicas');

Route::get('/explorador', function () {
    return view('Auth.explorador');
})->name('explorador');

// RUTA CORREGIDA: Ahora está en la zona pública y no pedirá login
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
        $busquedas        = \App\Models\Busqueda::where('titulo', '!=', 'Administrador')->get();
        $portafolios      = \App\Models\Portafolio::where('usuario_id', auth()->id())
                               ->orderByDesc('updated_at')
                               ->get();
        $totalPortafolios = $portafolios->count();
        $totalDocumentos  = \App\Models\PortafolioProyecto::whereIn('portafolio_id', $portafolios->pluck('id'))->count();
        $totalAprobados   = $portafolios->where('estado', 'publicado')->count();
        return view('menu', compact('busquedas', 'portafolios', 'totalPortafolios', 'totalDocumentos', 'totalAprobados'));
    })->name('menu');

    // Panel de Administrador (solo accesible para cuentas admin)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('es_admin');


    /**
     * IMPLEMENTACIÓN DEL EXPLORADOR
     * Carga la vista ubicada en resources/views/Auth/explorador.blade.php
     */
    Route::get('/explorador', [App\Http\Controllers\ExploradorController::class, 'index'])->name('explorador');

    // (La ruta de portafolios ya fue eliminada de aquí)

    Route::get('/academico', function () {
        return view('academico');
    })->name('academico');

    Route::get('/reportes', function () {
        return view('_reportes_menu');
    })->name('reportes');

    // Gestión de Perfil y Redes
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::post('/perfil/desactivar', [PerfilController::class, 'desactivar'])->name('perfil.desactivar');
    Route::post('/perfil/redes', [RedPerfilController::class, 'guardarRedes']);
    Route::get('/perfil/redes', [RedPerfilController::class, 'obtenerRedes']);

    // Portafolios (contenedores con banner/logo)
    Route::post('/portafolios', [PortafolioController::class, 'storePortafolio']);

    // Portafolios (CRUD)
    Route::get('/mis-portafolios', [PortafolioController::class, 'index']);
    Route::post('/mis-portafolios/{id}', [PortafolioController::class, 'update']);
    Route::delete('/mis-portafolios/{id}', [PortafolioController::class, 'destroy']);

    // Proyectos dentro de portafolios (tabla portafolio_proyecto)
    Route::get('/portafolio-proyecto/portafolio/{id}', [PortafolioProyectoController::class, 'byPortafolio']);
    Route::post('/portafolio-proyecto', [PortafolioProyectoController::class, 'store']);
    Route::post('/portafolio-proyecto/{id}', [PortafolioProyectoController::class, 'update']);
    Route::delete('/portafolio-proyecto/{id}', [PortafolioProyectoController::class, 'destroy']);

    // Archivos de proyectos (tabla portafolio_archivos)
    Route::post('/portafolio-archivos', [PortafolioArchivoController::class, 'store']);
    Route::delete('/portafolio-archivos/{id}', [PortafolioArchivoController::class, 'destroy']);

    // Trayectoria y Habilidades
    Route::get('/trayectoria', [TrayectoriaController::class, 'index']);
    Route::post('/trayectoria/habilidades', [TrayectoriaController::class, 'storeHabilidad']);
    Route::put('/trayectoria/habilidades/{id}', [TrayectoriaController::class, 'updateHabilidad']);
    Route::delete('/trayectoria/habilidades/{id}', [TrayectoriaController::class, 'destroyHabilidad']);
    Route::post('/trayectoria/experiencias', [TrayectoriaController::class, 'storeExperiencia']);
    Route::put('/trayectoria/experiencias/{id}', [TrayectoriaController::class, 'updateExperiencia']);
    Route::delete('/trayectoria/experiencias/{id}', [TrayectoriaController::class, 'destroyExperiencia']);
    Route::post('/trayectoria/formaciones', [TrayectoriaController::class, 'storeFormacion']);
    Route::put('/trayectoria/formaciones/{id}', [TrayectoriaController::class, 'updateFormacion']);
    Route::delete('/trayectoria/formaciones/{id}', [TrayectoriaController::class, 'destroyFormacion']);
    Route::post('/trayectoria/certificaciones', [TrayectoriaController::class, 'storeCertificacion']);
    Route::put('/trayectoria/certificaciones/{id}', [TrayectoriaController::class, 'updateCertificacion']);
    Route::delete('/trayectoria/certificaciones/{id}', [TrayectoriaController::class, 'destroyCertificacion']);
    
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
Route::post('/reactivar-cuenta', [LoginController::class, 'reactivar'])->name('reactivar');

Route::get('/registro', function () {
    return redirect('/?registro=1');
})->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro.post');

// Recuperación de Contraseña
Route::post('/recuperar', [RecuperacionController::class, 'solicitarRecuperacion']);
Route::post('/reset-password', [RecuperacionController::class, 'cambiarContrasena']);

/*
|--------------------------------------------------------------------------
| Verificación de correo electrónico (Lógica de Registro Temporal)
|--------------------------------------------------------------------------
*/

// usa el controller que ya tiene el redirect correcto
Route::get('/verificar-email', [RegistroController::class, 'verificarEmail']);


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

// ── Notificaciones ──────────────────────────────
Route::middleware('auth')->group(function () {

    // Usuario: ver sus notificaciones (campanita)
    Route::get('/mis-notificaciones', [App\Http\Controllers\NotificacionController::class, 'misNotificaciones'])
        ->name('notificaciones.mis');

    // Usuario: marcar como leída
    Route::post('/mis-notificaciones/{id}/leida', [App\Http\Controllers\NotificacionController::class, 'marcarLeida'])
        ->name('notificaciones.leida');

    // Admin: enviar notificación
    Route::post('/admin/notificaciones', [App\Http\Controllers\NotificacionController::class, 'store'])
        ->name('notificaciones.store');

    // Admin: listar todas
    Route::get('/admin/notificaciones', [App\Http\Controllers\NotificacionController::class, 'index'])
        ->name('notificaciones.index');

    // Admin: eliminar
    Route::delete('/admin/notificaciones/{id}', [App\Http\Controllers\NotificacionController::class, 'destroy'])
        ->name('notificaciones.destroy');

    // Admin: Gestión de Usuarios (Estado y Rol)
    Route::post('/admin/usuarios/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.usuarios.toggle-status')->middleware('es_admin');
    Route::post('/admin/usuarios/{id}/toggle-role', [AdminController::class, 'toggleRole'])->name('admin.usuarios.toggle-role')->middleware('es_admin');
    
    // Admin: Limpiar actividades recientes
    Route::delete('/admin/actividad/limpiar', [AdminController::class, 'limpiarActividad'])->name('admin.actividad.limpiar')->middleware('es_admin');
});
// lenguaje 
Route::get('/lang/{lang}', [LanguageController::class, 'switch'])
     ->name('lang.switch');
 
// Vista pública del perfil de un usuario
Route::get('/perfil/{usuarioId}', [PerfilPublicoController::class, 'show'])
     ->name('perfil.publico');
// Vista pública de un portafolio
Route::get('/portafolio/{portafolio_id}', [PortafolioPublicoController::class, 'show'])
    ->name('portafolio.publico')
    ->whereNumber('portafolio_id');

Route::get('/portafolio/{id}', [PortafolioPublicoController::class, 'show'])
     ->name('portafolio.publico');

Route::get('/proyecto/{proyecto}',    [ProyectoPublicoController::class,   'show'])->name('proyecto.publico');