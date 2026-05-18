<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SesionUsuario;

class RastrearSesion
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $sessionId = session()->getId();

            // Actualizar last_seen_at de la sesión activa
            $actualizado = SesionUsuario::where('usuario_id', Auth::id())
                ->where('token', $sessionId)
                ->where('expiracion', '>=', now())
                ->update(['last_seen_at' => now()]);

            // Si no existe el registro (ej: login con Google u otro flujo),
            // lo creamos para no perder el rastro
            if (! $actualizado) {
                SesionUsuario::updateOrCreate(
                    [
                        'usuario_id' => Auth::id(),
                        'token'      => $sessionId,
                    ],
                    [
                        'ip_address'   => $request->ip(),
                        'user_agent'   => $request->userAgent(),
                        'expiracion'   => now()->addHours(2),
                        'last_seen_at' => now(),
                    ]
                );
            }

            // Limpiar sesiones expiradas de este usuario (mantenimiento liviano)
            SesionUsuario::where('usuario_id', Auth::id())
                ->where('expiracion', '<', now()->subDay())
                ->delete();
        }

        return $next($request);
    }
}