<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Carbon\Carbon;

class ExploradorController extends Controller
{
    public function home()
    {
        $usuarios = $this->getUsuariosMapeados();

        return response()->view('home', compact('usuarios'))->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
            'Expires'       => '0',
        ]);
    }

    public function menu()
    {
        $usuario = auth()->user();

        // Redes con visible = true
        $redes = $usuario->redesPerfil()
            ->where('visible', true)
            ->whereNotNull('url')
            ->where('url', '!=', '')
            ->get();

        $habilidades     = $usuario->habilidades()->orderBy('tipo')->orderBy('nombre')->get();
        $experiencias    = $usuario->experiencias()->orderByDesc('fecha_inicio')->get();
        $formaciones     = $usuario->formaciones()->orderByDesc('fecha_inicio')->get();
        $certificaciones = $usuario->certificaciones()->orderByDesc('fecha_obtencion')->get();

        $portafolios      = \App\Models\Portafolio::where('usuario_id', auth()->id())
                               ->orderByDesc('updated_at')->get();
        $totalPortafolios = $portafolios->count();
        $totalDocumentos  = \App\Models\PortafolioProyecto::whereIn('portafolio_id', $portafolios->pluck('id'))->count();
        $totalAprobados   = $portafolios->where('estado', 'publicado')->count();
        $usuarios         = $this->getUsuariosMapeados();
        $categorias       = \App\Models\Categoria::where('activa', true)->orderBy('orden')->get();

        return view('menu', compact(
            'portafolios',
            'totalPortafolios',
            'totalDocumentos',
            'totalAprobados',
            'usuarios',
            'categorias',
            'redes',
            'habilidades',
            'experiencias',
            'formaciones',
            'certificaciones'
        ));
    }

    public function admin()
    {
        $stats = [
            'total_usuarios'     => Usuario::count(),
            'usuarios_activos'   => Usuario::where('activo', true)->count(),
            'usuarios_inactivos' => Usuario::where('activo', false)->count(),
            'total_admins'       => Usuario::where('es_admin', true)->count(),
            'usuarios_hoy'       => Usuario::whereDate('created_at', Carbon::today())->count(),
            'usuarios_semana'    => Usuario::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
        ];

        $portafolios_stats = [
            'total'              => \App\Models\Portafolio::count(),
            'con_usuarios'       => \App\Models\Portafolio::whereNotNull('usuario_id')->count(),
            'sin_usuarios'       => \App\Models\Portafolio::whereNull('usuario_id')->count(),
            'portafolios_hoy'    => \App\Models\Portafolio::whereDate('created_at', Carbon::today())->count(),
            'portafolios_semana' => \App\Models\Portafolio::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
        ];

        $total_documentos      = \App\Models\PortafolioArchivo::count();
        $usuarios_recientes    = Usuario::orderBy('created_at', 'desc')->limit(5)->get();
        $todos_usuarios        = Usuario::orderBy('created_at', 'desc')->get();
        $todos_portafolios     = \App\Models\Portafolio::with('usuario')->orderBy('created_at', 'desc')->get();
        
        $actividades_recientes = \App\Models\Actividad::with('usuario')
            ->where('accion', 'login')
            ->whereHas('usuario', function($query) {
                $query->where('es_admin', true);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $usuarios              = $this->getUsuariosMapeados();

        return view('admin', compact(
            'stats', 'portafolios_stats', 'total_documentos',
            'usuarios_recientes', 'todos_usuarios', 'todos_portafolios',
            'actividades_recientes', 'usuarios'
        ));
    }

    public function index()
    {
        $usuarios = $this->getUsuariosMapeados();
        return view('explorador', compact('usuarios'));
    }

    public function getUsuariosMapeados(): \Illuminate\Support\Collection
    {
        return Usuario::query()
            ->where('activo', true)
            ->where('email_verificado', true)
            ->where('es_admin', false)          // ← excluir administradores
            ->with([
                'habilidades'     => fn($q) => $q->limit(4),
                'formaciones'     => fn($q) => $q->orderByDesc('fecha_fin')->limit(1),
                'experiencias'    => fn($q) => $q->where('actual', true)->limit(1),
                'certificaciones' => fn($q) => $q->orderByDesc('fecha_obtencion'),
                'redesPerfil'     => fn($q) => $q->where('visible', true),
                'portafolios'     => fn($q) => $q->where('estado', 'publicado')->with('categoria')->limit(1),
            ])
            ->get()
            ->map(function (Usuario $u) {
                $supabaseBase = rtrim(config('services.supabase.url'), '/')
                              . '/storage/v1/object/public/'
                              . config('services.supabase.bucket');

                $fotoUrl = null;
                if ($u->foto_perfil) {
                    $fotoUrl = str_starts_with($u->foto_perfil, 'http')
                        ? $u->foto_perfil
                        : $supabaseBase . '/' . ltrim($u->foto_perfil, '/');
                }

                $formacion       = $u->formaciones->first();
                $experiencia     = $u->experiencias->first();

                return [
                    'id'                => $u->id,
                    'nombre'            => trim($u->nombre . ' ' . $u->apellido),
                    'profesion'         => $u->profesion ?? '',
                    'biografia'         => $u->biografia ?? '',
                    'foto_url'          => $fotoUrl,
                    'inicial'           => strtoupper(substr($u->nombre ?? 'U', 0, 1)),
                    'categoria'         => $u->portafolios->first()?->categoria?->slug
                                            ?? $this->resolverCategoria($u->profesion ?? ''),
                    'tags'              => $u->habilidades->pluck('nombre')
                                            ->map(fn($n) => '#' . strtoupper(str_replace(' ', '', $n)))
                                            ->take(3)->values()->toArray(),
                    'formacion'         => $formacion
                                            ? ($formacion->nivel ? ucfirst($formacion->nivel) . ' · ' : '') . $formacion->institucion
                                            : null,
                    'experiencia'       => $experiencia
                                            ? $experiencia->cargo . ' en ' . $experiencia->empresa
                                            : null,
                    'redes'             => $u->redesPerfil->map(fn($r) => [
                                            'tipo' => $r->tipo,
                                            'url'  => $r->url,
                                          ])->values()->toArray(),
                    'certificaciones'   => $u->certificaciones->count(),
                    'tiene_portafolio'  => $u->portafolios->isNotEmpty(),
                    'portafolio_id'     => $u->portafolios->first()?->id,
                    'total_habilidades' => $u->habilidades->count(),
                ];
            });
    }

    private function resolverCategoria(string $profesion): string
    {
        $lower = mb_strtolower($profesion);
        $map   = [
            'tecnologia' => ['ingenier', 'sistem', 'program', 'software', 'desarroll', 'tecnolog', 'devops'],
            'diseno'     => ['diseñ', 'arquitect', 'ilustr', 'fotograf', 'creativ', 'ux', 'ui', 'product'],
            'negocios'   => ['contad', 'financ', 'consult', 'mercado', 'market', 'administr', 'comerc', 'emprend'],
            'educacion'  => ['docen', 'educat', 'profes', 'tutor', 'maestr', 'capacit'],
            'salud'      => ['salud', 'méd', 'médic', 'fisioterap', 'enfermer', 'nutri', 'psicol', 'odont'],
            'arte'       => ['artis', 'músic', 'actor', 'actriz', 'cine', 'teatro', 'danza', 'escult', 'pintor'],
        ];
        foreach ($map as $cat => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($lower, $kw)) return $cat;
            }
        }
        return 'otros';
    }
}