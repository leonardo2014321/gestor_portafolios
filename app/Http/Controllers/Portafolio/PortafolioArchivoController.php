<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\PortafolioArchivo;
use App\Models\PortafolioProyecto;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortafolioArchivoController extends Controller
{
    public function __construct(private SupabaseStorageService $supabase) {}

    public function store(Request $request)
    {
        $request->validate([
            'proyecto_id' => 'required|integer',
            'archivos'    => 'required|array|min:1',
            'archivos.*'  => 'required|file|max:20480',
        ]);

        $proyecto = PortafolioProyecto::where('id', $request->proyecto_id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $creados = [];
        foreach ($request->file('archivos') as $file) {
            $ruta = $this->supabase->upload(
                'proyectos/' . $proyecto->id . '/archivos',
                $file
            );
            $creados[] = PortafolioArchivo::create([
                'proyecto_id'     => $proyecto->id,
                'nombre_original' => $file->getClientOriginalName(),
                'ruta'            => $ruta,
                'tamanio'         => $file->getSize(),
            ]);
        }

        return response()->json(['ok' => true, 'archivos' => $creados]);
    }

    public function destroy($id)
    {
        $archivo = PortafolioArchivo::whereHas('proyecto', function ($q) {
            $q->where('usuario_id', Auth::id());
        })->where('id', $id)->firstOrFail();

        $this->supabase->delete($archivo->ruta);
        $archivo->delete();

        return response()->json(['ok' => true]);
    }
}
