<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\PortafolioArchivo;
use App\Models\PortafolioProyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortafolioArchivoController extends Controller
{
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
            $ruta = $file->store('proyectos/' . $proyecto->id . '/archivos', 'public');
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

        Storage::disk('public')->delete($archivo->ruta);
        $archivo->delete();

        return response()->json(['ok' => true]);
    }
}
