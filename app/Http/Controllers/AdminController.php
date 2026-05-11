<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Busqueda;
use App\Models\Actividad;
use App\Models\Portafolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        // Estadísticas de Portafolios
        $portafolios_stats = [
            'total' => Portafolio::count(),
            'con_usuarios' => Portafolio::whereNotNull('usuario_id')->count(),
            'sin_usuarios' => Portafolio::whereNull('usuario_id')->count(),
        ];

        // Listados
        $usuarios_recientes = Usuario::orderBy('created_at', 'desc')->limit(5)->get();
        $todos_usuarios = Usuario::orderBy('created_at', 'desc')->get();
        $todos_portafolios = Portafolio::with('usuario')->orderBy('created_at', 'desc')->get();

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

    /**
     * Alterna el estado (activo/inactivo) de un usuario con validación de seguridad.
     */
    public function toggleStatus(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        // Si se va a desactivar, validamos la contraseña del admin
        if ($usuario->activo) {
            $request->validate([
                'password' => 'required'
            ]);

            if (!password_verify($request->password, auth()->user()->contrasena)) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'La contraseña de administrador es incorrecta.'
                ], 422);
            }

            $usuario->activo = false;
            $usuario->motivo_desactivacion = 'normas_inactividad';
        } else {
            // Si se va a activar
            $usuario->activo = true;
            $usuario->motivo_desactivacion = null;
        }

        $usuario->save();

        $accion = $usuario->activo ? 'reactivacion_cuenta' : 'CUENTA_DESACTIVADA';
        \App\Services\ActividadService::log(auth()->id(), $accion, [
            'usuario_afectado' => $usuario->nombre . ' ' . $usuario->apellido,
            'email' => $usuario->email
        ]);

        return response()->json([
            'success' => true,
            'activo' => $usuario->activo,
            'mensaje' => 'Estado del usuario actualizado correctamente.'
        ]);
    }

    /**
     * Alterna el rol (admin/usuario) de un usuario.
     */
    public function toggleRole(Request $request, $id)
    {
        // Validar contraseña del admin actual
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'mensaje' => 'La contraseña de administrador es incorrecta.'
            ], 403);
        }

        $usuario = Usuario::findOrFail($id);
        $usuario->es_admin = !$usuario->es_admin;
        $usuario->save();

        \App\Services\ActividadService::log(auth()->id(), 'CAMBIO_ROL', [
            'usuario_afectado' => $usuario->nombre . ' ' . $usuario->apellido,
            'nuevo_rol' => $usuario->es_admin ? 'Administrador' : 'Usuario'
        ]);

        return response()->json([
            'success' => true,
            'es_admin' => $usuario->es_admin,
            'mensaje' => 'Rol del usuario actualizado correctamente.'
        ]);
    }

    /**
     * Limpia todos los registros de la tabla de actividades recientes.
     */
    public function limpiarActividad(Request $request)
    {
        // Validar que el usuario que intenta limpiar es un administrador
        if (!auth()->user() || !auth()->user()->es_admin) {
            abort(403, 'No autorizado.');
        }

        Actividad::truncate();

        return redirect()->back()->with('success', 'Historial de actividades limpiado correctamente.');
    }
}
