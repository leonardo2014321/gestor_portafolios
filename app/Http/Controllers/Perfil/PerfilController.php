<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\ActividadService;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index', ['usuario' => Auth::user()]);
    }

    private function sanitize(string $value): string
    {
        return preg_replace('/[<>";\`\\\\{}]/', '', strip_tags($value));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:100', 'not_regex:/[<>";\`\\\\{}]/'],
            'apellido'    => ['required', 'string', 'max:100', 'not_regex:/[<>";\`\\\\{}]/'],
            'profesion'   => ['required', 'string', 'max:150', 'not_regex:/[<>";\`\\\\{}]/'],
            'biografia'   => ['nullable', 'string', 'max:1000', 'not_regex:/[<>";\`\\\\{}]/'],
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'nombre.not_regex'     => 'El nombre contiene caracteres no permitidos.',
            'apellido.required'    => 'El apellido es obligatorio.',
            'apellido.not_regex'   => 'El apellido contiene caracteres no permitidos.',
            'profesion.required'   => 'La profesión es obligatoria.',
            'profesion.not_regex'  => 'La profesión contiene caracteres no permitidos.',
            'biografia.max'        => 'La biografía no puede superar los 1000 caracteres.',
            'biografia.not_regex'  => 'La biografía contiene caracteres no permitidos.',
            'foto_perfil.image'    => 'Formato no soportado.',
            'foto_perfil.mimes'    => 'Formato no soportado. Solo se permiten JPG y PNG.',
            'foto_perfil.max'      => 'La imagen no puede pesar más de 2MB.',
        ]);

        $usuario = Auth::user();

        $data = [
            'nombre'    => $this->sanitize($request->nombre),
            'apellido'  => $this->sanitize($request->apellido),
            'profesion' => $this->sanitize($request->profesion),
            'biografia' => $request->biografia ? $this->sanitize($request->biografia) : null,
        ];

        if ($request->hasFile('foto_perfil')) {
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('fotos_perfil', 'public');
        }

        $usuario->update($data);

        ActividadService::log($usuario->id, 'PERFIL_ACTUALIZADO');

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function desactivar(Request $request)
    {
        $usuario = Auth::user();
        $usuario->update(['activo' => false]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        ActividadService::log($usuario->id, 'CUENTA_DESACTIVADA');

        return response()->json(['ok' => true]);
    }
}
