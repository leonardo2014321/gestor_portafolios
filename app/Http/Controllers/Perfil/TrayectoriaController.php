<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Habilidad;
use App\Models\Experiencia;
use App\Models\Formacion;

class TrayectoriaController extends Controller
{
    public function index()
    {
        $usuario = Auth::id();

        return response()->json([
            'habilidades' => Habilidad::where('usuario_id', $usuario)->orderBy('nombre')->get(),
            'experiencias' => Experiencia::where('usuario_id', $usuario)->orderByDesc('fecha_inicio')->get(),
            'formaciones' => Formacion::where('usuario_id', $usuario)->orderByDesc('fecha_inicio')->get(),
        ]);
    }

    public function storeHabilidad(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'nivel'  => ['required', Rule::in(['principiante', 'intermedio', 'avanzado'])],
        ]);

        $usuario_id = Auth::id();

        $existe = Habilidad::where('usuario_id', $usuario_id)
            ->whereRaw('LOWER(nombre) = ?', [strtolower($data['nombre'])])
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'Ya tienes registrada esta habilidad.'], 422);
        }

        $habilidad = Habilidad::create([
            'usuario_id' => $usuario_id,
            'nombre'     => strip_tags($data['nombre']),
            'nivel'      => $data['nivel'],
        ]);

        return response()->json($habilidad, 201);
    }

    public function destroyHabilidad($id)
    {
        $habilidad = Habilidad::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();
        $habilidad->delete();
        return response()->json(['ok' => true]);
    }

    public function storeExperiencia(Request $request)
    {
        $data = $request->validate([
            'empresa'     => 'required|string|max:150',
            'cargo'       => 'required|string|max:150',
            'fecha_inicio' => 'required|date',
            'fecha_fin'   => 'nullable|date|after_or_equal:fecha_inicio',
            'actual'      => 'boolean',
            'descripcion' => 'nullable|string|max:2000',
        ], [
            'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser anterior a la de inicio.',
        ]);

        $experiencia = Experiencia::create([
            'usuario_id'  => Auth::id(),
            'empresa'     => strip_tags($data['empresa']),
            'cargo'       => strip_tags($data['cargo']),
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'   => ($data['actual'] ?? false) ? null : ($data['fecha_fin'] ?? null),
            'actual'      => $data['actual'] ?? false,
            'descripcion' => $data['descripcion'] ? strip_tags($data['descripcion']) : null,
        ]);

        return response()->json($experiencia, 201);
    }

    public function destroyExperiencia($id)
    {
        $experiencia = Experiencia::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();
        $experiencia->delete();
        return response()->json(['ok' => true]);
    }

    public function storeFormacion(Request $request)
    {
        $data = $request->validate([
            'institucion' => 'required|string|max:200',
            'titulo'      => 'nullable|string|max:200',
            'fecha_inicio' => 'required|date',
            'fecha_fin'   => 'nullable|date|after_or_equal:fecha_inicio',
        ], [
            'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser anterior a la de inicio.',
        ]);

        $formacion = Formacion::create([
            'usuario_id'  => Auth::id(),
            'institucion' => strip_tags($data['institucion']),
            'titulo'      => $data['titulo'] ? strip_tags($data['titulo']) : null,
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'   => $data['fecha_fin'] ?? null,
        ]);

        return response()->json($formacion, 201);
    }

    public function destroyFormacion($id)
    {
        $formacion = Formacion::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();
        $formacion->delete();
        return response()->json(['ok' => true]);
    }
}
