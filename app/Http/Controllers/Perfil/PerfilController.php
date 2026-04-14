<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index', ['usuario' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'apellido'    => 'required|string|max:100',
            'profesion'   => 'required|string|max:150',
            'biografia'   => 'nullable|string|max:1000',
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nombre.required'    => 'El nombre es obligatorio.',
            'apellido.required'  => 'El apellido es obligatorio.',
            'profesion.required' => 'La profesión es obligatoria.',
            'biografia.max'      => 'La biografía no puede superar los 1000 caracteres.',
            'foto_perfil.image'  => 'Formato no soportado.',
            'foto_perfil.mimes'  => 'Formato no soportado. Solo se permiten JPG y PNG.',
            'foto_perfil.max'    => 'La imagen no puede pesar más de 2MB.',
        ]);

        $usuario = Auth::user();

        $data = [
            'nombre'    => strip_tags($request->nombre),
            'apellido'  => strip_tags($request->apellido),
            'profesion' => strip_tags($request->profesion),
            'biografia' => $request->biografia ? strip_tags($request->biografia) : null,
        ];

        if ($request->hasFile('foto_perfil')) {
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('fotos_perfil', 'public');
        }

        $usuario->update($data);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
