<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Models\PortafolioProyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PortafolioProyectoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'portafolio_id' => 'required|integer',
            'nombre'        => 'required|string|max:100',
            'descripcion'   => 'required|string|max:500',
            'estado'        => ['required', Rule::in(['borrador', 'publicado'])],
        ]);

        // Verificar que el portafolio pertenece al usuario
        $portafolio = Portafolio::where('id', $data['portafolio_id'])
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $proyecto = PortafolioProyecto::create([
            'portafolio_id' => $portafolio->id,
            'usuario_id'    => Auth::id(),
            'nombre'        => $data['nombre'],
            'descripcion'   => $data['descripcion'],
            'estado'        => $data['estado'],
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
