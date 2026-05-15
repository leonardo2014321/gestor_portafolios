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
        if (!$path) return null;
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

    // Stats para el hero
    $totalPortafolios = Portafolio::where('estado', 'publicado')
        ->whereHas('usuario', fn($q) => $q->where('activo', true))
        ->count();
    $totalAutores = Portafolio::where('estado', 'publicado')
        ->whereHas('usuario', fn($q) => $q->where('activo', true))
        ->distinct('usuario_id')->count('usuario_id');
    $totalCategorias = 6;
@endphp

{{-- Hero banner --}}
<div class="porta-hero">
    <div class="porta-hero-bg"></div>
    <div class="porta-hero-inner">
        <div class="porta-hero-left">
            <div class="porta-hero-title">{{ __('app.menu.inspira') }}</div>
            <div class="porta-hero-sub">Explora portafolios publicados por la comunidad</div>
            <div class="porta-search-wrap">
                <svg class="porta-search-icon" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="portaHeroSearch" type="text"
                       class="porta-search-input"
                       placeholder="Buscar por nombre, profesión..."
                       oninput="portaHeroSearchFn()" />
                @if($totalPortafolios > 0)
                    <span class="porta-search-badge">{{ $totalPortafolios }} portafolios</span>
                @endif
            </div>
        </div>
        @if($totalPortafolios > 0)
        <div class="porta-hero-stats">
            <div class="porta-stat-pill">
                <div class="porta-stat-num">{{ $totalPortafolios }}</div>
                <div class="porta-stat-lbl">Portafolios</div>
            </div>
            <div class="porta-stat-pill">
                <div class="porta-stat-num">{{ $totalAutores }}</div>
                <div class="porta-stat-lbl">Autores</div>
            </div>
            <div class="porta-stat-pill">
                <div class="porta-stat-num">{{ $totalCategorias }}</div>
                <div class="porta-stat-lbl">Áreas</div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Filtros de categoría --}}
<div class="porta-filters" role="group" aria-label="Filtrar por categoría">

    {{-- Todos --}}
    <button class="porta-filter-btn porta-filter-active" data-filter="todos">
        <span class="porta-filter-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
        </span>
        Todos
    </button>

    {{-- Creativos --}}
    <button class="porta-filter-btn" data-filter="creativos">
        <span class="porta-filter-icon porta-filter-icon--pink">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
            </svg>
        </span>
        Creativos
    </button>

    {{-- Salud --}}
    <button class="porta-filter-btn" data-filter="salud">
        <span class="porta-filter-icon porta-filter-icon--green">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </span>
        Salud
    </button>

    {{-- Negocios --}}
    <button class="porta-filter-btn" data-filter="negocios">
        <span class="porta-filter-icon porta-filter-icon--blue">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
            </svg>
        </span>
        Negocios
    </button>

    {{-- Educación --}}
    <button class="porta-filter-btn" data-filter="educacion">
        <span class="porta-filter-icon porta-filter-icon--amber">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
        </span>
        Educación
    </button>

    {{-- Tecnología --}}
    <button class="porta-filter-btn" data-filter="tecnologia">
        <span class="porta-filter-icon porta-filter-icon--indigo">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
            </svg>
        </span>
        Tecnología
    </button>

</div>

{{-- Contador de resultados --}}
<div class="porta-results-bar">
    <span class="porta-results-count">
        {{ $portafoliosGrid->total() }} {{ __('app.menu.portafolios') }}
    </span>
    <span class="porta-results-divider"></span>
    <span class="porta-results-page">
        {{ __('app.menu.pagina') }} {{ $portafoliosGrid->currentPage() }} {{ __('app.menu.de') }} {{ $portafoliosGrid->lastPage() }}
    </span>
</div>

{{-- Grid de tarjetas --}}
<div class="porta-grid" id="porta-grid">

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
             data-categoria="{{ mb_strtolower($usuario->profesion ?? '') }}">

            {{-- ── Cuadro grande: foto cubre todo el área con overlay ── --}}
            <div class="porta-card-cover">

                @if($fotoUrl)
                    <img src="{{ $fotoUrl }}"
                         class="porta-cover-bg"
                         alt="">
                    <div class="porta-cover-overlay"></div>
                    <img src="{{ $fotoUrl }}"
                         class="porta-cover-avatar"
                         alt="{{ $usuario->nombre }}">
                    <div class="porta-cover-name">
                        <span>{{ $usuario->nombre }} {{ $usuario->apellido }}</span>
                    </div>
                @else
                    <div class="porta-cover-gradient">
                        <div class="porta-cover-dots"></div>
                        <div class="porta-cover-initials-wrap">
                            <div class="porta-cover-initials">
                                {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($usuario->apellido ?? '', 0, 1)) }}
                            </div>
                            <span class="porta-cover-initials-name">
                                {{ $usuario->nombre }} {{ $usuario->apellido }}
                            </span>
                        </div>
                    </div>
                @endif

                {{-- Badge profesión --}}
                <div class="porta-badge" style="background:{{ $color }};">
                    {{ $badge }}
                </div>
            </div>

            {{-- ── Info inferior ── --}}
            <div class="porta-card-body">

                <div class="porta-card-portafolio-name">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    {{ $portafolio->nombre }}
                </div>

                <div class="porta-card-user">
                    <div class="porta-card-user-name">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                    @if($usuario->profesion)
                        <div class="porta-card-user-prof">
                            <span class="porta-prof-dot" style="background:{{ $color }};"></span>
                            <span>{{ $usuario->profesion }}</span>
                        </div>
                    @endif
                </div>

                <div class="porta-card-actions">
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
        <div class="porta-empty">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/>
            </svg>
            <p>Aún no hay portafolios publicados.</p>
        </div>
    @endforelse

</div>

{{-- Paginación --}}
@if($portafoliosGrid->hasPages())
    <div class="porta-pagination">
        {{ $portafoliosGrid->links() }}
    </div>
@endif

<style>
/* ── Hero ── */
.porta-hero {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    padding: 1.4rem 1.8rem;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1a56db 100%);
}
.porta-hero-bg {
    position: absolute; inset: 0; pointer-events: none;
    background:
        radial-gradient(ellipse at 80% 50%, rgba(99,102,241,.18) 0%, transparent 60%),
        radial-gradient(ellipse at 20% 80%, rgba(59,130,246,.12) 0%, transparent 50%);
}
.porta-hero-inner {
    position: relative;
    display: flex; align-items: center;
    gap: 1.5rem; flex-wrap: wrap;
}
.porta-hero-left { flex: 1; min-width: 240px; }
.porta-hero-title {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 1.45rem; font-weight: 800;
    color: #fff; margin-bottom: .3rem;
    line-height: 1.2;
}
.porta-hero-sub {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; color: rgba(255,255,255,.65);
    margin-bottom: .9rem;
}
.porta-search-wrap {
    position: relative; display: flex; align-items: center;
    background: rgba(255,255,255,.10);
    border: 1.5px solid rgba(255,255,255,.18);
    border-radius: 12px; padding: 0 12px;
    backdrop-filter: blur(8px);
    max-width: 420px;
}
.porta-search-icon { color: rgba(255,255,255,.5); flex-shrink: 0; }
.porta-search-input {
    flex: 1; background: transparent; border: none; outline: none;
    font-family: 'DM Sans', sans-serif; font-size: 13px;
    color: #fff; padding: 10px 8px;
}
.porta-search-input::placeholder { color: rgba(255,255,255,.45); }
.porta-search-badge {
    font-family: 'DM Sans', sans-serif;
    font-size: 10.5px; font-weight: 700;
    color: rgba(255,255,255,.7);
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    padding: 2px 8px; border-radius: 20px;
    white-space: nowrap; flex-shrink: 0;
}
.porta-hero-stats {
    display: flex; gap: 10px; flex-wrap: wrap;
}
.porta-stat-pill {
    background: rgba(255,255,255,.10);
    border: 1.5px solid rgba(255,255,255,.15);
    border-radius: 12px; padding: 10px 18px;
    text-align: center; backdrop-filter: blur(6px);
    min-width: 72px;
}
.porta-stat-num {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1;
}
.porta-stat-lbl {
    font-family: 'DM Sans', sans-serif;
    font-size: 10px; color: rgba(255,255,255,.6);
    margin-top: 3px; text-transform: uppercase; letter-spacing: .5px;
}

/* ── Variables ── */
:root {
    --porta-pink:   #ec4899;
    --porta-green:  #10b981;
    --porta-blue:   #3b82f6;
    --porta-amber:  #f59e0b;
    --porta-indigo: #6366f1;
}

/* ── Filtros ── */
.porta-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 1.2rem;
    align-items: center;
}

.porta-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 14px;
    font-size: 12.5px;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #475569;
    transition: all .2s ease;
    letter-spacing: .01em;
    line-height: 1;
}
.porta-filter-btn:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
    color: #1e293b;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(0,0,0,.07);
}
.porta-filter-active {
    background: #1e293b !important;
    color: #fff !important;
    border-color: #1e293b !important;
    box-shadow: 0 4px 14px rgba(30,41,59,.22) !important;
}
.porta-filter-active .porta-filter-icon {
    background: rgba(255,255,255,.15) !important;
    color: #fff !important;
}

/* Icono dentro del filtro */
.porta-filter-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 7px;
    background: #f1f5f9;
    color: #64748b;
    flex-shrink: 0;
    transition: background .2s, color .2s;
}
.porta-filter-icon--pink   { background: #fdf2f8; color: var(--porta-pink); }
.porta-filter-icon--green  { background: #f0fdf9; color: var(--porta-green); }
.porta-filter-icon--blue   { background: #eff6ff; color: var(--porta-blue); }
.porta-filter-icon--amber  { background: #fffbeb; color: var(--porta-amber); }
.porta-filter-icon--indigo { background: #eef2ff; color: var(--porta-indigo); }

.porta-filter-btn:hover .porta-filter-icon--pink   { background: #fce7f3; }
.porta-filter-btn:hover .porta-filter-icon--green  { background: #d1fae5; }
.porta-filter-btn:hover .porta-filter-icon--blue   { background: #dbeafe; }
.porta-filter-btn:hover .porta-filter-icon--amber  { background: #fef3c7; }
.porta-filter-btn:hover .porta-filter-icon--indigo { background: #e0e7ff; }

/* ── Barra de resultados ── */
.porta-results-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1.1rem;
    font-size: 12px;
    color: #94a3b8;
    font-family: 'DM Sans', sans-serif;
}
.porta-results-count {
    font-weight: 700;
    color: #475569;
}
.porta-results-divider {
    width: 1px;
    height: 12px;
    background: #e2e8f0;
    display: inline-block;
}

/* ── Grid ── */
.porta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.2rem;
}

/* ── Tarjeta ── */
.porta-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    transition: transform .3s ease, box-shadow .3s ease;
    cursor: default;
}
.porta-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.13);
}

/* Cover */
.porta-card-cover {
    position: relative;
    height: 186px;
    overflow: hidden;
}
.porta-cover-bg {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    filter: blur(18px) brightness(0.75) saturate(1.3);
    transform: scale(1.15);
    transition: transform .5s ease;
}
.porta-card:hover .porta-cover-bg {
    transform: scale(1.21);
}
.porta-cover-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.08) 0%, rgba(0,0,0,0.45) 100%);
}
.porta-cover-avatar {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -54%);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.95);
    box-shadow: 0 4px 20px rgba(0,0,0,0.35);
    transition: transform .35s ease;
}
.porta-card:hover .porta-cover-avatar {
    transform: translate(-50%, -54%) scale(1.08);
}
.porta-cover-name {
    position: absolute;
    bottom: 10px;
    left: 12px;
    right: 12px;
    text-align: center;
}
.porta-cover-name span {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    text-shadow: 0 1px 6px rgba(0,0,0,.6);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}

/* Gradient fallback */
.porta-cover-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #1e40af 0%, #0d9488 50%, #7c3aed 100%);
}
.porta-cover-dots {
    position: absolute;
    inset: 0;
    opacity: 0.15;
    background-image:
        radial-gradient(circle at 20% 50%, #fff 1px, transparent 1px),
        radial-gradient(circle at 80% 20%, #fff 1px, transparent 1px),
        radial-gradient(circle at 60% 80%, #fff 1px, transparent 1px);
    background-size: 40px 40px;
}
.porta-cover-initials-wrap {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.porta-cover-initials {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: 2.5px solid rgba(255,255,255,0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}
.porta-cover-initials-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,0.9);
    text-shadow: 0 1px 4px rgba(0,0,0,.4);
}

/* Badge */
.porta-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
    letter-spacing: .8px;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(0,0,0,.22);
    backdrop-filter: blur(4px);
}

/* Card body */
.porta-card-body {
    padding: 1rem;
}
.porta-card-portafolio-name {
    display: flex;
    align-items: center;
    gap: 5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 10px;
}
.porta-card-user {
    margin-bottom: 10px;
}
.porta-card-user-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 13.5px;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.porta-card-user-prof {
    font-size: 11px;
    color: var(--muted, #94a3b8);
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 3px;
}
.porta-prof-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
    display: inline-block;
}

/* Acciones */
.porta-card-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
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

/* Empty */
.porta-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: var(--muted, #94a3b8);
    font-size: 14px;
}
.porta-empty svg {
    margin: 0 auto 12px;
    display: block;
    opacity: .4;
}

/* Paginación */
.porta-pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* ── JS filter highlight ── */
.porta-card.porta-hidden {
    display: none;
}
</style>

<script>
(function () {
    const btns  = document.querySelectorAll('.porta-filter-btn');
    const grid  = document.getElementById('porta-grid');
    const count = document.querySelector('.porta-results-count');

    if (!grid) return;

    // Estado compartido — el buscador lo lee/escribe también
    window.portaGridState = {
        activeFilter: 'todos',
        searchQuery:  '',
    };

    const categoryMap = {
        creativos:  ['diseñ', 'arquitect', 'ilustr', 'fotograf', 'artis', 'creativ'],
        salud:      ['salud', 'méd', 'médic', 'fisioterap', 'enfermer', 'nutri'],
        negocios:   ['contad', 'financ', 'consult', 'mercado', 'market', 'administr', 'comerc'],
        educacion:  ['docen', 'educat', 'profes', 'tutor', 'maestr'],
        tecnologia: ['ingenier', 'sistem', 'program', 'software', 'desarroll', 'tecnolog', 'devops'],
    };

    function matchesCategory(cat, filter) {
        if (filter === 'todos') return true;
        return (categoryMap[filter] ?? []).some(kw => cat.includes(kw));
    }

    // Función central: aplica AMBOS filtros a la vez
    window.portaApplyFilters = function () {
        const { activeFilter, searchQuery } = window.portaGridState;
        const q = searchQuery.trim().toLowerCase();
        const cards = grid.querySelectorAll('.porta-card');
        let visible = 0;

        cards.forEach(card => {
            const cat  = (card.dataset.categoria ?? '').toLowerCase();
            const text = card.textContent.toLowerCase();

            const okCat    = matchesCategory(cat, activeFilter);
            const okSearch = !q || text.includes(q);

            if (okCat && okSearch) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        if (count) count.textContent = visible + ' portafolios';
        return visible;
    };

    // Buscador del hero
    window.portaHeroSearchFn = function () {
        const q = document.getElementById('portaHeroSearch')?.value ?? '';
        window.portaGridState.searchQuery = q;
        window.portaApplyFilters();
    };

    // Botones de categoría
    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            btns.forEach(b => b.classList.remove('porta-filter-active'));
            btn.classList.add('porta-filter-active');
            window.portaGridState.activeFilter = btn.dataset.filter;
            window.portaApplyFilters();
        });
    });
})();
</script>