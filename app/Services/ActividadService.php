<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Servicio encargado de registrar actividades del sistema.
 * Guarda acciones de usuarios para auditoría y control.
 */
class ActividadService
{
    /**
     * Registrar una actividad en el sistema
     */
    public static function log($usuarioId, $accion, $detalles = null)
    {
        DB::table('actividades_log')->insert([
            'usuario_id' => $usuarioId,
            'accion' => $accion,
            'detalles' => $detalles ? json_encode($detalles) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}