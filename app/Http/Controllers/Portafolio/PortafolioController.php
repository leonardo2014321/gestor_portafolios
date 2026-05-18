<?php

namespace App\Http\Controllers\Portafolio;

use App\Http\Controllers\Controller;
use App\Models\Portafolio;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PortafolioController extends Controller
{
    public function __construct(private SupabaseStorageService $supabase) {}

    public function index()
    {
        return response()->json(
            Portafolio::where('usuario_id', Auth::id())
                ->orderByDesc('updated_at')
                ->get()
        );
    }

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

    public function storePortafolio(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'estado'      => ['required', Rule::in(['borrador', 'publicado'])],
            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'banner'       => 'nullable|image|max:5120|mimes:png,jpg,jpeg',
            'logo'         => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
        ]);

        $portafolio = Portafolio::create([
            'nombre'       => $data['nombre'],
            'descripcion'  => $data['descripcion'],
            'estado'       => $data['estado'],
            'categoria_id' => $data['categoria_id'] ?? null,
            'usuario_id'   => Auth::id(),
        ]);

        if ($request->hasFile('banner')) {
            $portafolio->banner_ruta = $this->supabase->upload(
                'portafolios/' . $portafolio->id . '/banner',
                $request->file('banner')
            );
            $portafolio->save();
        }

        if ($request->hasFile('logo')) {
            $portafolio->logo_ruta = $this->supabase->upload(
                'portafolios/' . $portafolio->id . '/logo',
                $request->file('logo')
            );
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
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'estado'      => ['required', Rule::in(['borrador', 'publicado'])],
            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'banner'       => 'nullable|image|max:5120|mimes:png,jpg,jpeg',
            'logo'         => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
        ]);

        $portafolio->nombre       = $data['nombre'];
        $portafolio->descripcion  = $data['descripcion'];
        $portafolio->estado       = $data['estado'];
        $portafolio->categoria_id = $data['categoria_id'] ?? null;

        if ($request->hasFile('banner')) {
            if ($portafolio->banner_ruta) $this->supabase->delete($portafolio->banner_ruta);
            $portafolio->banner_ruta = $this->supabase->upload(
                'portafolios/' . $portafolio->id . '/banner',
                $request->file('banner')
            );
        }

        if ($request->hasFile('logo')) {
            if ($portafolio->logo_ruta) $this->supabase->delete($portafolio->logo_ruta);
            $portafolio->logo_ruta = $this->supabase->upload(
                'portafolios/' . $portafolio->id . '/logo',
                $request->file('logo')
            );
        }

        $portafolio->save();

        return response()->json(['ok' => true, 'portafolio' => $portafolio]);
    }

    public function destroy($id)
    {
        $portafolio = Portafolio::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        if ($portafolio->banner_ruta) $this->supabase->delete($portafolio->banner_ruta);
        if ($portafolio->logo_ruta)   $this->supabase->delete($portafolio->logo_ruta);

        $portafolio->delete();

        return response()->json(['ok' => true]);
    }
}
