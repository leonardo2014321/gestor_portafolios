<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActividadService;
use App\Services\SupabaseStorageService;

class PerfilController extends Controller
{
    public function __construct(private SupabaseStorageService $supabase) {}

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
        if (!$request->ajax() && !$request->wantsJson()) {
            return response()->json(['error' => 'Solicitud no válida.'], 400);
        }

        $request->validate([
            'nombre'      => ['required', 'string', 'max:100', 'not_regex:/[<>";\`\\\\{}]/'],
            'apellido'    => ['required', 'string', 'max:100', 'not_regex:/[<>";\`\\\\{}]/'],
            'profesion'   => ['required', 'string', 'max:150', 'not_regex:/[<>";\`\\\\{}]/'],
            'biografia'   => ['nullable', 'string', 'max:1000', 'not_regex:/[<>";\`\\\\{}]/'],
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nombre.required'     => 'El nombre es obligatorio.',
            'nombre.not_regex'    => 'El nombre contiene caracteres no permitidos.',
            'apellido.required'   => 'El apellido es obligatorio.',
            'apellido.not_regex'  => 'El apellido contiene caracteres no permitidos.',
            'profesion.required'  => 'La profesión es obligatoria.',
            'profesion.not_regex' => 'La profesión contiene caracteres no permitidos.',
            'biografia.max'       => 'La biografía no puede superar los 1000 caracteres.',
            'biografia.not_regex' => 'La biografía contiene caracteres no permitidos.',
            'foto_perfil.image'   => 'Formato no soportado.',
            'foto_perfil.mimes'   => 'Solo se permiten JPG y PNG.',
            'foto_perfil.max'     => 'La imagen no puede pesar más de 2MB.',
        ]);

        $usuario = Auth::user();

        $data = [
            'nombre'    => $this->sanitize($request->nombre),
            'apellido'  => $this->sanitize($request->apellido),
            'profesion' => $this->sanitize($request->profesion),
            'biografia' => $request->biografia ? $this->sanitize($request->biografia) : null,
        ];

        $foto_url = null;

        if ($request->hasFile('foto_perfil')) {
            try {
                // 1. Eliminar foto anterior de Supabase si existe
                if ($usuario->foto_perfil) {
                    // foto_perfil en DB guarda la ruta relativa: "perfil/uuid.jpg"
                    $this->supabase->delete($usuario->foto_perfil);
                }

                // 2. Subir nueva foto a Supabase Storage → carpeta "perfil"
                $path = $this->supabase->upload('perfil', $request->file('foto_perfil'));

                // 3. Guardar solo la ruta relativa en DB (ej: "perfil/uuid.jpg")
                $data['foto_perfil'] = $path;

                // 4. URL pública para devolver al frontend
                $foto_url = $this->supabase->publicUrl($path);

            } catch (\Throwable $e) {
                \Log::error('Error subiendo foto a Supabase: ' . $e->getMessage());
                return response()->json([
                    'error' => 'No se pudo subir la imagen. Inténtalo de nuevo.'
                ], 500);
            }
        }

        $usuario->update($data);

        ActividadService::log($usuario->id, 'PERFIL_ACTUALIZADO');

        return response()->json([
            'ok'       => true,
            'message'  => 'Perfil actualizado correctamente.',
            'foto_url' => $foto_url,   // null si no cambió la foto
        ]);
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