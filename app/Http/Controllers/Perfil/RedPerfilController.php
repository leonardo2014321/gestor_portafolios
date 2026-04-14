<?php

namespace App\Http\Controllers\Perfil;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Perfil\RedPerfilService;
use App\Http\Controllers\Controller;

class RedPerfilController extends Controller
{
    protected $service;

    public function __construct(RedPerfilService $service)
    {
        $this->service = $service;
    }

    public function guardarRedes(Request $request)
    {
        $request->validate([
            'redes' => 'required|array',
            'redes.*.tipo' => 'required|string',
            'redes.*.url' => 'nullable|url',
            'redes.*.visible' => 'boolean'
        ]);

        $this->service->guardar(Auth::id(), $request->redes);

        return response()->json([
            'mensaje' => 'Redes guardadas correctamente'
        ]);
    }

    public function obtenerRedes()
    {
        return response()->json(
            $this->service->obtener(Auth::id())
        );
    }
}