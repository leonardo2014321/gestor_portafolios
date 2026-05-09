<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
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

    public function misNotificaciones()
    {
        $user = Auth::user();

        $notificaciones = Notificacion::where(function ($q) use ($user) {
                $q->where('tipo_envio', 'individual')
                  ->where('destinatario_id', $user->id);
            })
            ->orWhere('tipo_envio', 'todos')
            ->orWhere(function ($q) use ($user) {
                $q->where('tipo_envio', 'rol')
                  ->where(function($q2) use ($user) {
                      if ($user->es_admin) $q2->whereNotNull('id');
                      else $q2->whereNull('id');
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

    public function index()
    {
        if (!Auth::user()->es_admin) abort(403);

        $notificaciones = Notificacion::with(['creadoPor', 'destinatario'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notificaciones);
    }

    public function destroy($id)
    {
        if (!Auth::user()->es_admin) abort(403);

        Notificacion::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}