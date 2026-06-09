<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{
    // ── Admin: enviar notificación a usuarios ────────────────
    public function store(Request $request)
    {
        if (!Auth::user()->es_admin) abort(403);

        $request->validate([
            'titulo'          => 'required|string|max:150',
            'mensaje'         => 'required|string|max:1000',
            'tipo_envio'      => 'required|in:individual,todos,rol',
            'destinatario_id' => 'nullable|exists:usuarios,id',
        ]);

        if ($request->tipo_envio === 'individual' && !$request->destinatario_id) {
            return response()->json(['error' => 'Selecciona un usuario.'], 422);
        }

        Notificacion::create([
            'titulo'          => $request->titulo,
            'mensaje'         => $request->mensaje,
            'tipo_envio'      => $request->tipo_envio,
            'destinatario_id' => $request->tipo_envio === 'individual'
                                    ? $request->destinatario_id
                                    : null,
            'creado_por'      => Auth::id(),
            'leida'           => false,
        ]);

        return response()->json(['ok' => true]);
    }

    // ── Usuario: enviar mensaje al administrador ─────────────
    public function storeDesdeUsuario(Request $request)
    {
        $request->validate([
            'titulo'  => 'required|string|max:150',
            'mensaje' => 'required|string|max:1000',
        ]);

        $user  = Auth::user();
        $admin = Usuario::where('es_admin', true)->where('activo', true)->first();

        if (!$admin) {
            return response()->json(['error' => 'No hay administradores disponibles.'], 503);
        }

        Notificacion::create([
            'titulo'          => '[Usuario] ' . $request->titulo,
            'mensaje'         => $request->mensaje,
            'tipo_envio'      => 'individual',
            'destinatario_id' => $admin->id,
            'creado_por'      => $user->id,
            'leida'           => false,
        ]);

        return response()->json(['ok' => true]);
    }

    // ── Campanita: notificaciones del usuario autenticado ────
    public function misNotificaciones()
    {
        $user = Auth::user();

        if ($user->es_admin) {
            // Admin ve mensajes de contacto que le enviaron
            $notificaciones = Notificacion::with('creadoPor')
                ->where('tipo_envio', 'individual')
                ->where('destinatario_id', $user->id)
                ->where('creado_por', '!=', $user->id)
                ->orderByDesc('created_at')
                ->get()
                ->map(fn($n) => $this->mapNotif($n, $user->id));
        } else {
            // Usuario normal: ve las suyas, excluyendo las que eliminó
            $eliminadas = DB::table('notificacion_usuario_estado')
                ->where('usuario_id', $user->id)
                ->where('eliminada', true)
                ->pluck('notificacion_id')
                ->toArray();

            $notificaciones = Notificacion::with('creadoPor')
                ->where(function ($q) use ($user) {
                    $q->where(function ($q1) use ($user) {
                        $q1->where('tipo_envio', 'individual')
                           ->where('destinatario_id', $user->id);
                    })
                    ->orWhere('tipo_envio', 'todos');
                })
                ->when(!empty($eliminadas), fn($q) => $q->whereNotIn('id', $eliminadas))
                ->orderByDesc('created_at')
                ->limit(50)
                ->get()
                ->map(fn($n) => $this->mapNotif($n, $user->id));
        }

        $noLeidas = $notificaciones->where('leida', false)->count();

        return response()->json([
            'notificaciones' => $notificaciones,
            'no_leidas'      => $noLeidas,
        ]);
    }

    // ── Helper: formatear notificación ───────────────────────
    private function mapNotif(Notificacion $n, int $userId): array
    {
        $esContacto = str_starts_with($n->titulo, '[Usuario] ');

        // Leer estado personalizado del usuario desde la tabla pivot
        $estado = DB::table('notificacion_usuario_estado')
            ->where('notificacion_id', $n->id)
            ->where('usuario_id', $userId)
            ->first();

        // Si hay estado personalizado de leída, usarlo; si no, usar el campo global
        $leida = $estado ? (bool) $estado->leida : (bool) $n->leida;

        return [
            'id'          => $n->id,
            'titulo'      => $esContacto
                                ? substr($n->titulo, strlen('[Usuario] '))
                                : $n->titulo,
            'mensaje'     => $n->mensaje,
            'tipo_envio'  => $n->tipo_envio,
            'leida'       => $leida,
            'created_at'  => $n->created_at,
            'remitente'   => $esContacto && $n->creadoPor
                                ? $n->creadoPor->nombre . ' ' . $n->creadoPor->apellido
                                : null,
            'es_contacto' => $esContacto,
        ];
    }

    // ── Marcar notificación como leída ───────────────────────
    public function marcarLeida($id)
    {
        $user  = Auth::user();
        $notif = Notificacion::findOrFail($id);

        $tieneAcceso = $notif->tipo_envio === 'todos'
            || ($notif->tipo_envio === 'individual' && $notif->destinatario_id == $user->id);

        if (!$tieneAcceso) abort(403);

        // Siempre usar la pivot — admin y usuario por igual
        DB::table('notificacion_usuario_estado')->upsert(
            [
                'notificacion_id' => $notif->id,
                'usuario_id'      => $user->id,
                'leida'           => true,
                'eliminada'       => false,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            ['notificacion_id', 'usuario_id'],
            ['leida', 'updated_at']
        );

        return response()->json(['ok' => true]);
    }

    // ── Usuario: eliminar (borrado lógico) ───────────────────
    public function destroy($id)
    {
        $user  = Auth::user();
        $notif = Notificacion::findOrFail($id);

        if ($user->es_admin) {
            // Admin: borrado físico real
            $notif->delete();
        } else {
            // Usuario: verificar que le corresponde
            $tieneAcceso = $notif->tipo_envio === 'todos'
                || ($notif->tipo_envio === 'individual' && $notif->destinatario_id == $user->id);

            if (!$tieneAcceso) abort(403);

            // Borrado lógico — solo desaparece para este usuario
            DB::table('notificacion_usuario_estado')->upsert(
                [
                    'notificacion_id' => $notif->id,
                    'usuario_id'      => $user->id,
                    'eliminada'       => true,
                    'leida'           => true,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ],
                ['notificacion_id', 'usuario_id'],
                ['eliminada', 'leida', 'updated_at']
            );
        }

        return response()->json(['ok' => true]);
    }

    // ── Admin: listar historial completo ─────────────────────
    public function index()
    {
        if (!Auth::user()->es_admin) abort(403);

        $notificaciones = Notificacion::with(['creadoPor', 'destinatario'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($n) {
                $esContacto = str_starts_with($n->titulo, '[Usuario] ');
                return [
                    'id'              => $n->id,
                    'titulo'          => $esContacto
                                            ? substr($n->titulo, strlen('[Usuario] '))
                                            : $n->titulo,
                    'mensaje'         => $n->mensaje,
                    'tipo_envio'      => $n->tipo_envio,
                    'created_at'      => $n->created_at,
                    'es_contacto'     => $esContacto,
                    'remitente'       => $n->creadoPor
                                            ? $n->creadoPor->nombre . ' ' . $n->creadoPor->apellido
                                            : null,
                    'remitente_email' => $n->creadoPor?->email,
                    'destinatario'    => $n->destinatario
                                            ? $n->destinatario->nombre . ' ' . $n->destinatario->apellido
                                            : null,
                ];
            });

        return response()->json($notificaciones);
    }
}