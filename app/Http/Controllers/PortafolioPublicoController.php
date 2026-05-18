<?php

namespace App\Http\Controllers;

use App\Models\Portafolio;
use Illuminate\Http\Request;

class PortafolioPublicoController extends Controller
{
    public function show(string $id)
    {
        $portafolio = Portafolio::with([
            'usuario',
            'proyectos' => fn($q) => $q->where('estado', 'publicado'),
            'proyectos.archivos',
        ])
        ->where('estado', 'publicado')
        ->findOrFail($id);

        $proyectos = $portafolio->proyectos;

        return view('portafolio.publico', compact('portafolio', 'proyectos'));
    }
}