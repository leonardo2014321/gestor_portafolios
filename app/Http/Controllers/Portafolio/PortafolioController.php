<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
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
                ->orderByDesc('updated_at')
                ->get()
        );
    }

    // Crea un proyecto (sin archivos; los archivos van en portafolio_proyecto)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'          => 'required|string|max:100',
            'descripcion'     => 'required|string|max:500',
            'repositorio_url' => 'nullable|url|max:500',
            'estado'          => ['required', Rule::in(['borrador', 'publicado'])],
        ]);

        $portafolio = Portafolio::create([
            'nombre'          => $data['nombre'],
            'descripcion'     => $data['descripcion'],
            'repositorio_url' => $data['repositorio_url'] ?? null,
            'estado'          => $data['estado'],
            'usuario_id'      => Auth::id(),
        ]);

        return response()->json(['ok' => true, 'portafolio' => $portafolio]);
    }

    // Crea un portafolio contenedor con banner y logo
    public function storePortafolio(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'estado'      => ['required', Rule::in(['borrador', 'publicado'])],
            'banner'      => 'nullable|image|max:5120|mimes:png,jpg,jpeg',
            'logo'        => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
        ]);

        $portafolio = Portafolio::create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'estado'      => $data['estado'],
            'usuario_id'  => Auth::id(),
        ]);

        if ($request->hasFile('banner')) {
            $portafolio->banner_ruta = $request->file('banner')
                ->store('portafolios/' . $portafolio->id . '/banner', 'public');
            $portafolio->save();
        }

        if ($request->hasFile('logo')) {
            $portafolio->logo_ruta = $request->file('logo')
                ->store('portafolios/' . $portafolio->id . '/logo', 'public');
            $portafolio->save();
        }

        return response()->json(['ok' => true, 'portafolio' => $portafolio]);
    }

    public function update(Request $request, $id)
    {
        $portafolio = Portafolio::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'nombre'          => 'required|string|max:100',
            'descripcion'     => 'required|string|max:500',
            'repositorio_url' => 'nullable|url|max:500',
            'estado'          => ['required', Rule::in(['borrador', 'publicado'])],
        ]);

        $portafolio->update([
            'nombre'          => $data['nombre'],
            'descripcion'     => $data['descripcion'],
            'repositorio_url' => $data['repositorio_url'] ?? null,
            'estado'          => $data['estado'],
        ]);

        return response()->json(['ok' => true, 'portafolio' => $portafolio]);
    }

    public function destroy($id)
    {
        $portafolio = Portafolio::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        // Eliminar banner y logo del storage si existen
        if ($portafolio->banner_ruta) {
            Storage::disk('public')->delete($portafolio->banner_ruta);
        }
        if ($portafolio->logo_ruta) {
            Storage::disk('public')->delete($portafolio->logo_ruta);
        }

        $portafolio->delete();

        return response()->json(['ok' => true]);
    }
}
