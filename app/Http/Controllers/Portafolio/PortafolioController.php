<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Models\PortafolioArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PortafolioController extends Controller
{
    public function index()
    {
        return response()->json(
            Portafolio::where('usuario_id', Auth::id())
                ->with('archivos')
                ->orderByDesc('updated_at')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'required|string',
            'repositorio_url' => 'nullable|url|max:500',
            'estado'          => ['required', Rule::in(['borrador', 'publicado'])],
            'archivos.*'      => 'nullable|file|max:10240|mimes:pdf,zip,png,jpg,jpeg',
        ]);

        $portafolio = Portafolio::create([
            'nombre'          => $data['nombre'],
            'descripcion'     => $data['descripcion'],
            'repositorio_url' => $data['repositorio_url'] ?? null,
            'estado'          => $data['estado'],
            'usuario_id'      => Auth::id(),
        ]);

        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $ruta = $archivo->store('portafolios/' . $portafolio->id, 'public');
                PortafolioArchivo::create([
                    'portafolio_id'   => $portafolio->id,
                    'nombre_original' => $archivo->getClientOriginalName(),
                    'ruta'            => $ruta,
                    'tamanio'         => $archivo->getSize(),
                ]);
            }
        }

        return response()->json(['ok' => true, 'portafolio' => $portafolio->load('archivos')]);
    }

    public function destroy($id)
    {
        $portafolio = Portafolio::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        foreach ($portafolio->archivos as $archivo) {
            Storage::disk('public')->delete($archivo->ruta);
        }

        $portafolio->delete();

        return response()->json(['ok' => true]);
    }
}
