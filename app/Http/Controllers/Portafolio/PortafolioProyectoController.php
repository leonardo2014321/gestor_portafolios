<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Models\PortafolioProyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PortafolioProyectoController extends Controller
{
    public function byPortafolio($portafolioId)
    {
        Portafolio::where('id', $portafolioId)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $proyectos = PortafolioProyecto::where('portafolio_id', $portafolioId)
            ->where('usuario_id', Auth::id())
            ->with('archivos')
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($p) {
                $arr = $p->toArray();
                $arr['archivos'] = $p->archivos->map(fn ($a) => [
                    'id'              => $a->id,
                    'nombre_original' => $a->nombre_original,
                    'tamanio'         => $a->tamanio,
                    'url'             => asset('storage/' . $a->ruta),
                ])->values();
                return $arr;
            });

        return response()->json(['ok' => true, 'proyectos' => $proyectos]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'portafolio_id'   => 'required|integer',
            'nombre'          => 'required|string|max:100',
            'descripcion'     => 'required|string|max:500',
            'estado'          => ['required', Rule::in(['borrador', 'publicado'])],
            'repositorio_url' => 'nullable|url|max:500',
            'deploy_url'      => 'nullable|url|max:500',
        ]);

        // Verificar que el portafolio pertenece al usuario
        $portafolio = Portafolio::where('id', $data['portafolio_id'])
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $proyecto = PortafolioProyecto::create([
            'portafolio_id'   => $portafolio->id,
            'usuario_id'      => Auth::id(),
            'nombre'          => $data['nombre'],
            'descripcion'     => $data['descripcion'],
            'estado'          => $data['estado'],
            'repositorio_url' => $data['repositorio_url'] ?? null,
            'deploy_url'      => $data['deploy_url'] ?? null,
        ]);

        return response()->json(['ok' => true, 'proyecto' => $proyecto]);
    }

    public function update(Request $request, $id)
    {
        $proyecto = PortafolioProyecto::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'estado'      => ['required', Rule::in(['borrador', 'publicado'])],
        ]);

        $proyecto->update($data);

        return response()->json(['ok' => true, 'proyecto' => $proyecto]);
    }

    public function destroy($id)
    {
        $proyecto = PortafolioProyecto::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $proyecto->delete();

        return response()->json(['ok' => true]);
    }
}
