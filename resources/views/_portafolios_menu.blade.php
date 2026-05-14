{{-- ============================================================
     _portafolios_menu.blade.php
     Uso: @include('_portafolios_menu')
     Obtiene datos directamente de la BD, sin necesitar controlador.
     ============================================================ --}}

@php
    use App\Models\Portafolio;

    $supabaseBase = rtrim(config('services.supabase.url'), '/')
                  . '/storage/v1/object/public/'
                  . config('services.supabase.bucket');

    $sbUrl = function(?string $path) use ($supabaseBase): ?string {
        $path = trim((string) $path);
        if (!$path) return null;  // cubre NULL, "", "  "
        return str_starts_with($path, 'http')
            ? $path
            : $supabaseBase . '/' . ltrim($path, '/');
    };

    $portafoliosGrid = Portafolio::with('usuario')
        ->where('estado', 'publicado')
        ->whereHas('usuario', fn($q) => $q->where('activo', true))
        ->latest()
        ->paginate(12);

    $badgeColor = function(string $profesion): string {
        $map = [
            'arquitect' => '#ec4899', 'diseñ'    => '#ec4899',
            'fisioterap'=> '#10b981', 'salud'    => '#10b981', 'méd' => '#10b981',
            'contad'    => '#3b82f6', 'financ'   => '#3b82f6', 'consult' => '#3b82f6',
            'docen'     => '#f59e0b', 'educat'   => '#f59e0b', 'profes'  => '#f59e0b',
            'ingenier'  => '#6366f1', 'sistem'   => '#6366f1', 'program' => '#6366f1',
            'mercado'   => '#f97316', 'market'   => '#f97316',
        ];
        $lower = mb_strtolower($profesion);
        foreach ($map as $key => $color) {
            if (str_contains($lower, $key)) return $color;
        }
        return '#64748b';
    };
@endphp

<div class="content-bar">
    <div class="content-title">
        <h1>{{ __('app.menu.inspira') }}</h1>
        <p>{{ __('app.menu.inspira_desc') }}</p>
    </div>
</div>

{{-- Filtros decorativos --}}
<div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:1.4rem;">
    <button style="padding:7px 20px;border-radius:999px;background:var(--blue);color:#fff;border:none;font-size:13px;font-weight:600;cursor:pointer;">
        {{ __('app.menu.todos') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        🎨 {{ __('app.menu.creativos') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        🩺 {{ __('app.menu.salud') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        💼 {{ __('app.menu.negocios') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        🎓 {{ __('app.menu.educacion') }}
    </button>
</div>

{{-- Grid de tarjetas --}}
<div class="porta-grid">

    @forelse($portafoliosGrid as $portafolio)
        @php
            $usuario   = $portafolio->usuario;
            $fotoUrl   = $sbUrl($usuario->foto_perfil ?? null);
            $color     = $badgeColor($usuario->profesion ?? '');
            $badge     = $usuario->profesion
                            ? \Illuminate\Support\Str::limit($usuario->profesion, 22)
                            : 'Profesional';
        @endphp

        <div class="porta-card"
             onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.13)'"
             onmouseout="this.style.transform='';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.07)'">

            {{-- ── Cuadro grande: foto cubre todo el área con overlay ── --}}
            <div style="position:relative;height:186px;overflow:hidden;">

                @if($fotoUrl)
                    {{-- Foto ocupa todo el cuadro con blur sutil --}}
                    <img src="{{ $fotoUrl }}"
                         class="porta-cover-img"
                         style="width:100%;height:100%;object-fit:cover;object-position:center top;
                                filter:blur(18px) brightness(0.75) saturate(1.3);
                                transform:scale(1.15);"
                         alt="">
                    {{-- Overlay degradado --}}
                    <div style="position:absolute;inset:0;
                                background:linear-gradient(to bottom, rgba(0,0,0,0.08) 0%, rgba(0,0,0,0.45) 100%);"></div>
                    {{-- Foto nítida centrada encima --}}
                    <img src="{{ $fotoUrl }}"
                         style="position:absolute;top:50%;left:50%;
                                transform:translate(-50%,-54%);
                                width:80px;height:80px;border-radius:50%;object-fit:cover;
                                border:3px solid rgba(255,255,255,0.95);
                                box-shadow:0 4px 20px rgba(0,0,0,0.35);
                                transition:transform .35s ease;"
                         onmouseover="this.style.transform='translate(-50%,-54%) scale(1.08)'"
                         onmouseout="this.style.transform='translate(-50%,-54%) scale(1)'"
                         alt="{{ $usuario->nombre }}">
                    {{-- Nombre sobre el overlay abajo --}}
                    <div style="position:absolute;bottom:10px;left:12px;right:12px;text-align:center;">
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;
                                     color:#fff;text-shadow:0 1px 6px rgba(0,0,0,.6);
                                     white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;">
                            {{ $usuario->nombre }} {{ $usuario->apellido }}
                        </span>
                    </div>
                @else
                    {{-- Sin foto → degradado vibrante + iniciales --}}
                    <div style="position:absolute;inset:0;
                                background:linear-gradient(135deg,#1e40af 0%,#0d9488 50%,#7c3aed 100%);"></div>
                    {{-- Patrón decorativo --}}
                    <div style="position:absolute;inset:0;opacity:0.15;
                                background-image:radial-gradient(circle at 20% 50%, #fff 1px, transparent 1px),
                                                 radial-gradient(circle at 80% 20%, #fff 1px, transparent 1px),
                                                 radial-gradient(circle at 60% 80%, #fff 1px, transparent 1px);
                                background-size:40px 40px;"></div>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;
                                align-items:center;justify-content:center;gap:8px;">
                        <div style="width:72px;height:72px;border-radius:50%;
                                    background:rgba(255,255,255,0.2);
                                    border:2.5px solid rgba(255,255,255,0.6);
                                    backdrop-filter:blur(4px);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:28px;font-weight:800;color:#fff;
                                    font-family:'Plus Jakarta Sans',sans-serif;
                                    text-shadow:0 2px 8px rgba(0,0,0,0.3);">
                            {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($usuario->apellido ?? '', 0, 1)) }}
                        </div>
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;
                                     color:rgba(255,255,255,0.9);text-shadow:0 1px 4px rgba(0,0,0,.4);">
                            {{ $usuario->nombre }} {{ $usuario->apellido }}
                        </span>
                    </div>
                @endif

                {{-- Badge de profesión — siempre arriba a la izquierda --}}
                <div style="position:absolute;top:10px;left:10px;background:{{ $color }};color:#fff;
                            font-size:9px;font-weight:700;padding:3px 10px;border-radius:999px;
                            letter-spacing:.8px;text-transform:uppercase;
                            box-shadow:0 2px 8px rgba(0,0,0,.22);backdrop-filter:blur(4px);">
                    {{ $badge }}
                </div>
            </div>

            {{-- ── Info inferior de la tarjeta ── --}}
            <div style="padding:1rem;">

                {{-- Nombre del portafolio --}}
                <div style="margin-bottom:10px;">
                    <span style="display:flex;align-items:center;gap:5px;
                                 font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;
                                 color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        </svg>
                        {{ $portafolio->nombre }}
                    </span>
                </div>

                {{-- Avatar pequeño + nombre + profesión (solo cuando NO hay banner, para evitar redundancia) --}}
                {{-- Nombre + profesión --}}
                <div style="margin-bottom:10px;">
                    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;
                                font-size:13.5px;color:#1e293b;
                                white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $usuario->nombre }} {{ $usuario->apellido }}
                    </div>
                    @if($usuario->profesion)
                        <div style="font-size:11px;color:var(--muted);
                                    display:flex;align-items:center;gap:4px;margin-top:3px;">
                            <span style="width:5px;height:5px;border-radius:50%;background:{{ $color }};flex-shrink:0;display:inline-block;"></span>
                            <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $usuario->profesion }}</span>
                        </div>
                    @endif
                </div>

                {{-- Botones --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    <a href="{{ route('portafolio.publico', $portafolio->id) }}"
                       target="_blank" rel="noopener"
                       class="porta-btn porta-btn-primary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                        {{ __('app.menu.ver_portafolio') }}
                    </a>
                    <a href="{{ route('perfil.publico', $usuario->id) }}"
                       target="_blank" rel="noopener"
                       class="porta-btn porta-btn-secondary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        {{ __('app.menu.ver_perfil') }}
                    </a>
                </div>
            </div>
        </div>

    @empty
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--muted);font-size:14px;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                 style="margin:0 auto 12px;display:block;opacity:.4;">
                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/>
            </svg>
            Aún no hay portafolios publicados.
        </div>
    @endforelse

</div>

{{-- Paginación --}}
@if($portafoliosGrid->hasPages())
    <div style="margin-top:2rem;display:flex;justify-content:center;">
        {{ $portafoliosGrid->links() }}
    </div>
@endif

<style>
.porta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.2rem;
}
.porta-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    transition: transform .3s ease, box-shadow .3s ease;
    cursor: default;
}
.porta-cover-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}
.porta-card:hover .porta-cover-img {
    transform: scale(1.06);
}
.porta-cover-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.52) 0%, rgba(0,0,0,0.0) 55%);
}
.porta-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 9px 10px;
    border-radius: 14px;
    font-size: 12px;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: all .25s;
    border: none;
    cursor: pointer;
}
.porta-btn-primary {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff;
    box-shadow: 0 2px 8px rgba(37,99,235,0.25);
}
.porta-btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
    box-shadow: 0 4px 14px rgba(37,99,235,0.4);
    transform: translateY(-1px);
}
.porta-btn-secondary {
    background: #f1f5f9;
    color: #1e293b;
    border: 1.5px solid #e2e8f0;
}
.porta-btn-secondary:hover {
    background: #1e293b;
    color: #fff;
    border-color: #1e293b;
    transform: translateY(-1px);
}
</style>