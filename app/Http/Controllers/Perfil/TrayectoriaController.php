<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Habilidad;
use App\Models\Experiencia;
use App\Models\Formacion;
use App\Models\Certificacion;

class TrayectoriaController extends Controller
{
    private function sanitize(string $value): string
    {
        return preg_replace('/[<>";\`\\\\{}]/', '', strip_tags($value));
    }

    private function notRegex(): string
    {
        return 'not_regex:/[<>";\`\\\\{}]/';
    }

    public function index()
    {
        $usuario = Auth::id();

        return response()->json([
            'habilidades'     => Habilidad::where('usuario_id', $usuario)->orderBy('nombre')->get(),
            'experiencias'    => Experiencia::where('usuario_id', $usuario)->orderByDesc('fecha_inicio')->get(),
            'formaciones'     => Formacion::where('usuario_id', $usuario)->orderByDesc('fecha_inicio')->get(),
            'certificaciones' => Certificacion::where('usuario_id', $usuario)->orderByDesc('fecha_obtencion')->get(),
        ]);
    }

    public function storeHabilidad(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100', $this->notRegex()],
            'nivel'  => ['required', Rule::in(['principiante', 'intermedio', 'avanzado'])],
        ], [
            'nombre.not_regex' => 'El nombre contiene caracteres no permitidos.',
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
            'nombre'     => $this->sanitize($data['nombre']),
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
            'empresa'      => ['required', 'string', 'max:150', $this->notRegex()],
            'cargo'        => ['required', 'string', 'max:150', $this->notRegex()],
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'actual'       => 'boolean',
            'descripcion'  => ['nullable', 'string', 'max:2000', $this->notRegex()],
        ], [
            'empresa.not_regex'     => 'La empresa contiene caracteres no permitidos.',
            'cargo.not_regex'       => 'El cargo contiene caracteres no permitidos.',
            'descripcion.not_regex' => 'La descripción contiene caracteres no permitidos.',
            'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser anterior a la de inicio.',
        ]);

        $experiencia = Experiencia::create([
            'usuario_id'   => Auth::id(),
            'empresa'      => $this->sanitize($data['empresa']),
            'cargo'        => $this->sanitize($data['cargo']),
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'    => ($data['actual'] ?? false) ? null : ($data['fecha_fin'] ?? null),
            'actual'       => $data['actual'] ?? false,
            'descripcion'  => $data['descripcion'] ? $this->sanitize($data['descripcion']) : null,
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
            'institucion'  => ['required', 'string', 'max:200', $this->notRegex()],
            'titulo'       => ['nullable', 'string', 'max:200', $this->notRegex()],
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
        ], [
            'institucion.not_regex' => 'La institución contiene caracteres no permitidos.',
            'titulo.not_regex'      => 'El título contiene caracteres no permitidos.',
            'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser anterior a la de inicio.',
        ]);

        $formacion = Formacion::create([
            'usuario_id'   => Auth::id(),
            'institucion'  => $this->sanitize($data['institucion']),
            'titulo'       => $data['titulo'] ? $this->sanitize($data['titulo']) : null,
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'    => $data['fecha_fin'] ?? null,
        ]);

        return response()->json($formacion, 201);
    }

    public function destroyFormacion($id)
    {
        $formacion = Formacion::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();
        $formacion->delete();
        return response()->json(['ok' => true]);
    }

    public function storeCertificacion(Request $request)
    {
        $data = $request->validate([
            'nombre'          => ['required', 'string', 'max:200', $this->notRegex()],
            'organizacion'    => ['nullable', 'string', 'max:200', $this->notRegex()],
            'fecha_obtencion' => 'nullable|date',
            'descripcion'     => ['nullable', 'string', 'max:1000', $this->notRegex()],
        ], [
            'nombre.not_regex'       => 'El nombre contiene caracteres no permitidos.',
            'organizacion.not_regex' => 'La organización contiene caracteres no permitidos.',
            'descripcion.not_regex'  => 'La descripción contiene caracteres no permitidos.',
        ]);

        $certificacion = Certificacion::create([
            'usuario_id'      => Auth::id(),
            'nombre'          => $this->sanitize($data['nombre']),
            'organizacion'    => $data['organizacion'] ? $this->sanitize($data['organizacion']) : null,
            'fecha_obtencion' => $data['fecha_obtencion'] ?? null,
            'descripcion'     => $data['descripcion'] ? $this->sanitize($data['descripcion']) : null,
        ]);

        return response()->json($certificacion, 201);
    }

    public function destroyCertificacion($id)
    {
        $certificacion = Certificacion::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();
        $certificacion->delete();
        return response()->json(['ok' => true]);
    }
}
