<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    // Admin: enviar notificación
    public function store(Request $request)
    {
        if (!Auth::user()->es_admin) abort(403);

        $request->validate([
            'titulo'          => 'required|string|max:150',
            'mensaje'         => 'required|string|max:1000',
            'tipo_envio'      => 'required|in:individual,todos,rol',
            'destinatario_id' => 'nullable|exists:users,id',
        ]);

        // Si es individual, debe tener destinatario
        if ($request->tipo_envio === 'individual' && !$request->destinatario_id) {
            return back()->withErrors(['destinatario_id' => 'Selecciona un usuario.']);
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

        return back()->with('success', 'Notificación enviada.');
    }

    // Usuario: obtener sus notificaciones (para la campanita)
    public function misNotificaciones()
    {
        $user = Auth::user();

        $notificaciones = Notificacion::where(function ($q) use ($user) {
                // Para él específicamente
                $q->where('tipo_envio', 'individual')
                  ->where('destinatario_id', $user->id);
            })
            ->orWhere('tipo_envio', 'todos')
            ->orWhere(function ($q) use ($user) {
                // Solo si es admin
                $q->where('tipo_envio', 'rol')
                  ->where(function($q2) use ($user) {
                      if ($user->es_admin) $q2->whereNotNull('id');
                      else $q2->whereNull('id'); // no le llega si no es admin
                  });
            })
            ->orderByDesc('created_at')
            ->get();

        $noLeidas = $notificaciones->where('leida', false)->count();

        return response()->json([
            'notificaciones' => $notificaciones,
            'no_leidas'      => $noLeidas,
        ]);
    }

    // Usuario: marcar como leída
    public function marcarLeida($id)
    {
        $user = Auth::user();
        $notif = Notificacion::findOrFail($id);

        // Verificar que le pertenece
        if (
            $notif->tipo_envio === 'individual' &&
            $notif->destinatario_id !== $user->id
        ) {
            abort(403);
        }

        $notif->update(['leida' => true]);
        return response()->json(['ok' => true]);
    }

    // Admin: ver todas las enviadas
    public function index()
    {
        if (!Auth::user()->es_admin) abort(403);

        $notificaciones = Notificacion::with(['creadoPor', 'destinatario'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notificaciones);
    }

    // Admin: eliminar notificación
    public function destroy($id)
    {
        if (!Auth::user()->es_admin) abort(403);

        Notificacion::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}