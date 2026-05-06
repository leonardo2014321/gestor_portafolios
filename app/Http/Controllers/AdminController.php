<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Busqueda;
use App\Models\Actividad;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Muestra el panel de administración con estadísticas y listados.
     */
    public function index()
    {
        // Estadísticas de Usuarios
        $stats = [
            'total_usuarios' => Usuario::count(),
            'usuarios_activos' => Usuario::where('activo', true)->count(),
            'usuarios_inactivos' => Usuario::where('activo', false)->count(),
            'total_admins' => Usuario::where('es_admin', true)->count(),
        ];

        // Estadísticas de Portafolios (Busquedas)
        // Como no hay campo público/privado explícito, usaremos has_users como proxy o simplemente el total
        $portafolios_stats = [
            'total' => Busqueda::where('tipo', '!=', 'perfil')->where('titulo', '!=', 'Administrador')->count(),
            'con_usuarios' => Busqueda::where('tipo', '!=', 'perfil')->where('has_users', true)->count(),
            'sin_usuarios' => Busqueda::where('tipo', '!=', 'perfil')->where('has_users', false)->count(),
        ];

        // Listados
        $usuarios_recientes = Usuario::orderBy('created_at', 'desc')->limit(5)->get();
        $todos_usuarios = Usuario::orderBy('created_at', 'desc')->get();
        $todos_portafolios = Busqueda::where('tipo', '!=', 'perfil')->where('titulo', '!=', 'Administrador')->orderBy('created_at', 'desc')->get();

        // Actividad Reciente (Últimas 10 acciones)
        $actividades_recientes = Actividad::with('usuario')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin', compact(
            'stats', 
            'portafolios_stats', 
            'usuarios_recientes', 
            'todos_usuarios', 
            'todos_portafolios',
            'actividades_recientes'
        ));
    }
}
