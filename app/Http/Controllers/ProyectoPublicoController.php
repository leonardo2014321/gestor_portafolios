<?php

// ============================================================
// ProyectoPublicoController.php
// Ruta: app/Http/Controllers/ProyectoPublicoController.php
// ============================================================

namespace App\Http\Controllers;

use App\Models\PortafolioProyecto;
use Illuminate\Http\Request;

class ProyectoPublicoController extends Controller
{
    public function show(string $id)
    {
        $proyecto = PortafolioProyecto::with([
            'portafolio',
            'portafolio.usuario',
            'archivos',
            // Otros proyectos del mismo portafolio (para el sidebar)
            'portafolio.proyectos' => fn($q) => $q
                ->where('estado', 'publicado')
                ->where('id', '!=', $id),
        ])
        ->where('estado', 'publicado')
        ->findOrFail($id);

        $portafolio     = $proyecto->portafolio;
        $usuario        = $portafolio->usuario;
        $otrosProyectos = $portafolio->proyectos;

        // Solo mostrar si el portafolio está publicado y el usuario activo
        abort_if($portafolio->estado !== 'publicado', 404);
        abort_if(!$usuario->activo, 404);

        return view('proyecto.publico', compact(
            'proyecto',
            'portafolio',
            'usuario',
            'otrosProyectos',
        ));
    }
}