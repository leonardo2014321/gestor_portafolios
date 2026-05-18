<?php

// ============================================================
// PerfilPublicoController.php
// Ruta sugerida: app/Http/Controllers/PerfilPublicoController.php
// ============================================================

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class PerfilPublicoController extends Controller
{
    public function show(int $usuarioId)
    {
        $usuario = Usuario::findOrFail($usuarioId);

        // Solo mostrar perfiles activos
        abort_if(!$usuario->activo, 404);

        // Redes con visible = true
        $redes = $usuario->redesPerfil()
            ->where('visible', true)
            ->whereNotNull('url')
            ->where('url', '!=', '')
            ->get();

        $habilidades     = $usuario->habilidades()->orderBy('tipo')->orderBy('nombre')->get();
        $experiencias    = $usuario->experiencias()->orderByDesc('fecha_inicio')->get();
        $formaciones     = $usuario->formaciones()->orderByDesc('fecha_inicio')->get();
        $certificaciones = $usuario->certificaciones()->orderByDesc('fecha_obtencion')->get();

        // Solo portafolios publicados
        $portafolios = $usuario->portafolios()
            ->where('estado', 'publicado')
            ->orderByDesc('created_at')
            ->get();

        return view('perfil.publico', compact(
            'usuario',
            'redes',
            'habilidades',
            'experiencias',
            'formaciones',
            'certificaciones',
            'portafolios'
        ));
    }
}