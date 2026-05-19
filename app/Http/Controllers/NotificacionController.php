<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // El admin SOLO ve los mensajes de contacto que
            // los usuarios le enviaron directamente a él.
            // No ve las notificaciones que él mismo mandó.
            $notificaciones = Notificacion::with('creadoPor')
                ->where('tipo_envio', 'individual')
                ->where('destinatario_id', $user->id)
                ->where('creado_por', '!=', $user->id) // excluir las suyas propias
                ->orderByDesc('created_at')
                ->get()
                ->map(fn($n) => $this->mapNotif($n));
        } else {
            // El usuario normal ve todo lo que le corresponde
            $notificaciones = Notificacion::with('creadoPor')
                ->where(function ($q) use ($user) {
                    $q->where('tipo_envio', 'individual')
                      ->where('destinatario_id', $user->id);
                })
                ->orWhere('tipo_envio', 'todos')
                ->orWhere(function ($q) use ($user) {
                    $q->where('tipo_envio', 'rol')
                      ->where(function ($q2) use ($user) {
                          $q2->whereNull('id'); // usuarios normales no tienen rol admin
                      });
                })
                ->orderByDesc('created_at')
                ->get()
                ->map(fn($n) => $this->mapNotif($n));
        }

        $noLeidas = $notificaciones->where('leida', false)->count();

        return response()->json([
            'notificaciones' => $notificaciones,
            'no_leidas'      => $noLeidas,
        ]);
    }

    // ── Helper: formatear notificación para la campanita ─────
    private function mapNotif(Notificacion $n): array
    {
        $esContacto = str_starts_with($n->titulo, '[Usuario] ');
        return [
            'id'          => $n->id,
            'titulo'      => $esContacto
                                ? substr($n->titulo, strlen('[Usuario] '))
                                : $n->titulo,
            'mensaje'     => $n->mensaje,
            'tipo_envio'  => $n->tipo_envio,
            'leida'       => $n->leida,
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

        if (
            $notif->tipo_envio === 'individual' &&
            $notif->destinatario_id !== $user->id
        ) {
            abort(403);
        }

        $notif->update(['leida' => true]);
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

    // ── Admin: eliminar notificación ─────────────────────────
    public function destroy($id)
    {
        if (!Auth::user()->es_admin) abort(403);

        Notificacion::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}