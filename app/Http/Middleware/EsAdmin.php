<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->es_admin) {
            abort(403, 'Acceso denegado: se requieren privilegios de administrador.');
        }

        return $next($request);
    }
}
