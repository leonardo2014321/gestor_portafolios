{{-- ============================================================
     _explorador_menu.blade.php  (v4 — búsqueda de talento)
     Uso: @include('_explorador_menu')
     Espera: $usuarios (Collection mapeada desde ExploradorController)
     Filtros: todos | con_certificacion | con_portafolio | con_experiencia | categoria
     ============================================================ --}}
 
{{-- ══ Hero ══ --}}
@php
    $totalPerfiles   = count($usuarios);
    $conPortafolio   = collect($usuarios)->where('tiene_portafolio', true)->count();
    $areas           = \App\Models\Categoria::where('activa', true)->count();
@endphp
<div class="exp-hero">
    <div class="exp-hero-bg"></div>
    <div class="exp-hero-inner">
 
        {{-- Izquierda: título + buscador --}}
        <div class="exp-hero-left">
            <div class="exp-hero-title">{{ __('app.explorador.hero_titulo') }}</div>
            <div class="exp-hero-sub">{{ __('app.explorador.hero_subtitulo') }}</div>
 
            <div class="exp-search-wrap">
                <svg class="exp-search-icon" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="expSearch" type="text"
                       class="exp-search-input"
                       placeholder="{{ __('app.explorador.buscador_placeholder') }}"
                       oninput="expApply()" />
                @if($totalPerfiles > 0)
                    <span class="exp-search-badge">{{ $totalPerfiles }} {{ __('app.explorador.badge_talentos') }}</span>
                @endif
            </div>
        </div>
 
        {{-- Derecha: stats --}}
        @if($totalPerfiles > 0)
        <div class="exp-hero-stats">
            <div class="exp-stat-pill">
                <div class="exp-stat-num">{{ $totalPerfiles }}</div>
                <div class="exp-stat-lbl">{{ __('app.explorador.stat_perfiles') }}</div>
            </div>
            <div class="exp-stat-pill">
                <div class="exp-stat-num">{{ $conPortafolio }}</div>
                <div class="exp-stat-lbl">{{ __('app.explorador.stat_con_portafolio') }}</div>
            </div>
            <div class="exp-stat-pill">
                <div class="exp-stat-num">{{ $areas }}</div>
                <div class="exp-stat-lbl">{{ __('app.explorador.stat_areas') }}</div>
            </div>
        </div>
        @endif
 
    </div>
</div>
 
{{-- ══ Filtros: Fila 1 = Área, Fila 2 = Mostrar ══ --}}
@php
    use App\Models\Categoria;
    $expCategorias = Categoria::where('activa', true)->orderBy('orden')->get();
 
    $expCatIcons = [
        'tecnologia' => ['svg' => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',      'color' => 'exp-filter-icon--indigo'],
        'diseno'     => ['svg' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>',        'color' => 'exp-filter-icon--pink'],
        'negocios'   => ['svg' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>', 'color' => 'exp-filter-icon--blue'],
        'salud'      => ['svg' => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',  'color' => 'exp-filter-icon--green'],
        'educacion'  => ['svg' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',    'color' => 'exp-filter-icon--amber'],
        'arte'       => ['svg' => '<circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>',  'color' => 'exp-filter-icon--purple'],
    ];
    $expDefaultIcon = '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>';
@endphp
<div class="exp-filters-wrap">
 
    {{-- Fila 1: Área / categoría (dinámica desde BD) --}}
    <div class="exp-filters-row">
        <span class="exp-filters-label">{{ __('app.explorador.filtro_area') }}</span>
        <div class="exp-filters exp-filters--category" role="group" aria-label="{{ __('app.explorador.aria_filtrar_area') }}">
 
            <button class="exp-filter-btn exp-filter-cat-active" data-cat-filter="todas">
                <span class="exp-filter-icon">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>
                {{ __('app.explorador.filtro_todos') }}
            </button>
 
            @foreach($expCategorias as $expCat)
            @php
                $expIcon  = $expCatIcons[$expCat->slug] ?? ['svg' => $expDefaultIcon, 'color' => ''];
            @endphp
            <button class="exp-filter-btn" data-cat-filter="{{ $expCat->slug }}">
                <span class="exp-filter-icon {{ $expIcon['color'] }}">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $expIcon['svg'] !!}
                    </svg>
                </span>
                {{ $expCat->nombre }}
            </button>
            @endforeach
 
        </div>
    </div>
 
    <div class="exp-filters-divider"></div>
 
    {{-- Fila 2: Mostrar / capacidad --}}
    <div class="exp-filters-row">
        <span class="exp-filters-label">{{ __('app.explorador.filtro_mostrar') }}</span>
        <div class="exp-filters exp-filters--capacity" role="group" aria-label="{{ __('app.explorador.aria_filtrar_capacidad') }}">
 
            <button class="exp-filter-btn exp-filter-active" data-cap="todos">
                <span class="exp-filter-icon">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                </span>
                {{ __('app.explorador.filtro_todos') }}
            </button>
 
            <button class="exp-filter-btn" data-cap="con_certificacion">
                <span class="exp-filter-icon exp-filter-icon--amber">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                </span>
                {{ __('app.explorador.filtro_con_certificaciones') }}
            </button>
 
            <button class="exp-filter-btn" data-cap="con_portafolio">
                <span class="exp-filter-icon exp-filter-icon--blue">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                </span>
                {{ __('app.explorador.filtro_con_portafolio') }}
            </button>
 
            <button class="exp-filter-btn" data-cap="con_experiencia">
                <span class="exp-filter-icon exp-filter-icon--green">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    </svg>
                </span>
                {{ __('app.explorador.filtro_con_experiencia') }}
            </button>
 
        </div>
    </div>
 
</div>{{-- /exp-filters-wrap --}}
 
{{-- ══ Barra de resultados ══ --}}
<div class="exp-results-bar">
    <span class="exp-count">
        <span id="expCountNum">{{ count($usuarios) }}</span>
        {{ count($usuarios) === 1 ? __('app.explorador.perfil_encontrado') : __('app.explorador.perfiles_encontrados') }}
    </span>
 
    <div id="sortContainer" style="position:relative;display:inline-block;margin-left:auto;">
        <button class="exp-sort-btn"
                onclick="document.getElementById('sortMenu').style.display = document.getElementById('sortMenu').style.display==='block'?'none':'block'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="6" y1="12" x2="18" y2="12"/><line x1="9" y1="18" x2="15" y2="18"/>
            </svg>
            <span id="sortLabel">{{ __('app.explorador.sort_relevancia') }}</span>
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div id="sortMenu" class="exp-sort-menu" style="display:none;">
            <div class="exp-sort-item" onclick="expSetSort('relevancia','{{ __('app.explorador.sort_relevancia') }}')">{{ __('app.explorador.sort_relevancia') }}</div>
            <div class="exp-sort-item" onclick="expSetSort('az','A → Z')">A → Z</div>
            <div class="exp-sort-item" onclick="expSetSort('za','Z → A')">Z → A</div>
            <div class="exp-sort-item" onclick="expSetSort('certificaciones','{{ __('app.explorador.sort_mas_certificaciones') }}')">{{ __('app.explorador.sort_mas_certificaciones') }}</div>
            <div class="exp-sort-item" onclick="expSetSort('habilidades','{{ __('app.explorador.sort_mas_habilidades') }}')">{{ __('app.explorador.sort_mas_habilidades') }}</div>
        </div>
    </div>
</div>
 
{{-- ══ Grid de tarjetas ══ --}}
<div class="exp-grid" id="expGrid">
 
    @forelse($usuarios as $u)
        @php
            $avatarColors = [
                'tecnologia' => 'av-indigo',
                'diseno'     => 'av-pink',
                'negocios'   => 'av-blue',
                'salud'      => 'av-green',
                'educacion'  => 'av-amber',
                'arte'       => 'av-purple',
                'otros'      => 'av-teal',
            ];
            $accentColors = [
                'tecnologia' => '#6366f1',
                'diseno'     => '#ec4899',
                'negocios'   => '#3b82f6',
                'salud'      => '#22c55e',
                'educacion'  => '#f59e0b',
                'arte'       => '#7c3aed',
                'otros'      => '#14b8a6',
            ];
            $avClass = $avatarColors[$u['categoria']] ?? 'av-teal';
            $accent  = $accentColors[$u['categoria']] ?? '#14b8a6';
 
            $redIcons = [
                'github'    => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>',
                'linkedin'  => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
                'twitter'   => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>',
                'instagram' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
                'web'       => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
            ];
 
            // Atributos de filtro para JS
            $filterAttrs = implode(' ', array_filter([
                'data-cat="' . $u['categoria'] . '"',
                $u['certificaciones'] > 0 ? 'data-cert="1"' : '',
                $u['tiene_portafolio']   ? 'data-porta="1"' : '',
                $u['experiencia']        ? 'data-exp="1"' : '',
            ]));
 
            // Texto buscable
            $searchText = strtolower(implode(' ', array_filter([
                $u['nombre'],
                $u['apellido'] ?? '',
                $u['profesion'],
                $u['biografia'],
                $u['formacion'],
                $u['experiencia'],
                implode(' ', $u['tags']),
            ])));
        @endphp
 
        <div class="exp-card"
             {!! $filterAttrs !!}
             data-user-id="{{ $u['id'] }}"
             data-habilidades="{{ $u['total_habilidades'] }}"
             data-certificaciones="{{ $u['certificaciones'] }}"
             data-nombre="{{ strtolower($u['nombre']) }}"
             data-search="{{ $searchText }}">
 
            {{-- Acento lateral --}}
            <div class="exp-card-accent" style="background:{{ $accent }};"></div>
 
            {{-- Top: avatar + nombre/profesión --}}
            <div class="exp-card-top">
                @if($u['foto_url'])
                    <img src="{{ $u['foto_url'] }}" class="exp-av exp-av-foto" alt="{{ $u['nombre'] }}">
                @else
                    <div class="exp-av {{ $avClass }}" data-iniciales="{{ $u['inicial'] }}">{{ $u['inicial'] }}</div>
                @endif
 
                <div class="exp-card-info">
                    <div class="exp-card-nombre">{{ $u['nombre'] }}</div>
                    @if($u['profesion'])
                        <div class="exp-card-profesion">
                            <span class="exp-prof-dot" style="background:{{ $accent }};"></span>
                            {{ $u['profesion'] }}
                        </div>
                    @endif
                </div>
            </div>
 
            {{-- Experiencia actual destacada --}}
            @if($u['experiencia'])
                <div class="exp-card-exp-actual">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    </svg>
                    <span>{{ $u['experiencia'] }}</span>
                </div>
            @endif
 
            {{-- Tags de habilidades --}}
            @if(count($u['tags']) > 0)
                <div class="exp-card-tags">
                    @foreach($u['tags'] as $tag)
                        <span class="exp-tag" style="border-color:{{ $accent }}20;color:{{ $accent }};">{{ $tag }}</span>
                    @endforeach
                    @if($u['total_habilidades'] > 3)
                        <span class="exp-tag exp-tag-more">+{{ $u['total_habilidades'] - 3 }}</span>
                    @endif
                </div>
            @endif
 
            {{-- Formación --}}
            @if($u['formacion'])
                <div class="exp-meta-row">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                    <span>{{ $u['formacion'] }}</span>
                </div>
            @endif
 
            {{-- Footer: certificaciones + portafolio + redes + ver perfil --}}
            <div class="exp-card-footer">
 
                {{-- Badges de capacidades --}}
                <div class="exp-card-badges">
                    @if($u['certificaciones'] > 0)
                        <span class="exp-badge-cert" title="{{ $u['certificaciones'] }} {{ __('app.explorador.certificaciones_title') }}">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                            </svg>
                            {{ $u['certificaciones'] }} {{ __('app.explorador.cert_abrev') }}
                        </span>
                    @endif
 
                    @if($u['tiene_portafolio'])
                        <a href="{{ route('portafolio.publico', $u['portafolio_id']) }}"
                           target="_blank" rel="noopener" class="exp-badge-porta">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            </svg>
                            {{ __('app.explorador.badge_portafolio') }}
                        </a>
                    @endif
                </div>
 
                {{-- Redes sociales --}}
                <div class="exp-card-redes">
                    @foreach(array_slice($u['redes'], 0, 3) as $red)
                        @php $tipoKey = strtolower($red['tipo']); @endphp
                        <a href="{{ $red['url'] }}" target="_blank" rel="noopener"
                           class="exp-red-btn" title="{{ $red['tipo'] }}">
                            {!! $redIcons[$tipoKey] ?? $redIcons['web'] !!}
                        </a>
                    @endforeach
                </div>
 
                {{-- Ver perfil --}}
                <a href="{{ route('perfil.publico', $u['id']) }}"
                   target="_blank" rel="noopener"
                   class="exp-btn-perfil">
                    {{ __('app.explorador.ver_perfil') }}
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
 
            </div>
 
            {{-- Gráfica decorativa --}}
            <svg class="exp-trend-bg" width="80" height="40" viewBox="0 0 80 40" fill="none"
                 stroke="{{ $accent }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="2,32 18,20 30,26 48,10 68,18"/>
            </svg>
 
        </div>
 
    @empty
        <div class="exp-empty">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <p>
                <strong>{{ __('app.explorador.empty_titulo') }}</strong>
                {{ __('app.explorador.empty_descripcion') }}
            </p>
        </div>
    @endforelse
 
    {{-- Empty state de filtros (oculto por defecto, JS lo muestra) --}}
    <div class="exp-empty exp-empty-filter" id="expEmptyFilter" style="display:none;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <p>
            <strong>{{ __('app.explorador.empty_filtro_titulo') }}</strong>
            {{ __('app.explorador.empty_filtro_descripcion') }}
        </p>
    </div>
 
</div>

<style>
/* ══ Hero ══ */
.exp-hero {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    padding: 1.4rem 1.8rem;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1a56db 100%);
}
.exp-hero-bg {
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse at 80% 30%, rgba(59,130,246,.22) 0%, transparent 55%),
        radial-gradient(ellipse at 10% 80%, rgba(99,102,241,.18) 0%, transparent 50%);
    pointer-events: none;
}
.exp-hero-inner {
    position: relative;
    display: flex; align-items: center;
    justify-content: space-between; gap: 16px;
}
.exp-hero-left { flex: 1; min-width: 0; }
.exp-hero-title {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 18px; font-weight: 800; color: #fff;
    line-height: 1.25; margin-bottom: 4px; letter-spacing: -.3px;
}
.exp-hero-sub {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px; color: rgba(255,255,255,.6);
    line-height: 1.5; margin-bottom: 14px;
}
/* Stats pills */
.exp-hero-stats { display: flex; gap: 10px; flex-shrink: 0; }
.exp-stat-pill {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 12px; padding: 8px 14px;
    text-align: center; min-width: 66px;
}
.exp-stat-num {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 20px; font-weight: 800; color: #fff; line-height: 1;
}
.exp-stat-lbl {
    font-family: 'DM Sans', sans-serif;
    font-size: 10px; color: rgba(255,255,255,.55);
    margin-top: 3px; line-height: 1.3;
}

/* ══ Buscador hero ══ */
.exp-search-wrap {
    display: flex; align-items: center; gap: 10px;
    background: rgba(255,255,255,.1);
    border: 1.5px solid rgba(255,255,255,.18);
    border-radius: 14px;
    padding: 8px 14px;
    max-width: 520px;
    backdrop-filter: blur(8px);
    transition: border-color .2s, background .2s;
}
.exp-search-wrap:focus-within {
    border-color: rgba(255,255,255,.45);
    background: rgba(255,255,255,.15);
}
.exp-search-icon { color: rgba(255,255,255,.5); flex-shrink: 0; }
.exp-search-input {
    flex: 1; background: transparent; border: none; outline: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px; color: #fff;
}
.exp-search-input::placeholder { color: rgba(255,255,255,.45); }
.exp-search-badge {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px; font-weight: 700;
    background: rgba(255,255,255,.15);
    color: rgba(255,255,255,.8);
    padding: 3px 9px; border-radius: 20px;
    white-space: nowrap;
}

/* ══ Filtros — dos filas ══ */
.exp-filters-wrap {
    display: flex; flex-direction: column; gap: 0;
    margin-bottom: 1rem;
    background: #fff;
    border: 1.5px solid #e9edf3;
    border-radius: 14px;
    overflow: hidden;
}
.exp-filters-row {
    display: grid;
    grid-template-columns: 52px 1fr;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
}
.exp-filters-divider {
    height: 1px; background: #f1f5f9; margin: 0;
}
.exp-filters-label {
    font-family: 'DM Sans', sans-serif;
    font-size: 10.5px; font-weight: 700;
    color: #94a3b8; text-transform: uppercase; letter-spacing: .6px;
    min-width: 46px; flex-shrink: 0;
}
.exp-filters {
    display: flex; flex-wrap: wrap; gap: 5px;
}
.exp-filter-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 12px;
    border: 1.5px solid #e2e8f0; background: #fff;
    font-size: 12.5px; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    color: #475569; cursor: pointer; transition: all .2s;
    white-space: nowrap;
}
.exp-filter-btn:hover { border-color: #3b82f6; color: #2563eb; background: #eff6ff; }
.exp-filter-btn.exp-filter-active { background: #1e293b; border-color: #1e293b; color: #fff; }
.exp-filter-btn.exp-filter-cat-active { background: #1e293b; border-color: #1e293b; color: #fff; }
.exp-filter-btn.exp-filter-cat-active .exp-filter-icon { background: rgba(255,255,255,.15); }
.exp-filter-btn.exp-filter-active .exp-filter-icon { background: rgba(255,255,255,.15); }
.exp-filter-icon {
    display: inline-flex; align-items: center; justify-content: center;
    width: 22px; height: 22px; border-radius: 7px; background: #f1f5f9;
    flex-shrink: 0; transition: background .2s;
}
.exp-filter-icon--indigo { background: #eef2ff; color: #4f46e5; }
.exp-filter-icon--pink   { background: #fdf2f8; color: #db2777; }
.exp-filter-icon--blue   { background: #eff6ff; color: #2563eb; }
.exp-filter-icon--green  { background: #f0fdf4; color: #16a34a; }
.exp-filter-icon--amber  { background: #fffbeb; color: #d97706; }
.exp-filter-icon--purple { background: #f5f3ff; color: #7c3aed; }

/* ══ Barra resultados ══ */
.exp-results-bar {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 1rem; padding: 0 2px;
}
.exp-count {
    font-family: 'DM Sans', sans-serif;
    font-size: 12.5px; font-weight: 600; color: #64748b;
}
.exp-sort-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: 10px;
    border: 1.5px solid #e2e8f0; background: #fff;
    font-size: 12px; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    color: #475569; cursor: pointer; transition: all .2s;
}
.exp-sort-btn:hover { border-color: #94a3b8; color: #1e293b; }
.exp-sort-menu {
    position: absolute; right: 0; top: calc(100% + 6px);
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,.1);
    z-index: 20; min-width: 180px; overflow: hidden;
}
.exp-sort-item {
    padding: 9px 16px; font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; color: #334155; transition: background .15s;
}
.exp-sort-item:hover { background: #f8fafc; }

/* ══ Grid ══ */
.exp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 14px;
}

/* ══ Tarjeta ══ */
.exp-card {
    position: relative;
    background: #fff; border: 1.5px solid #e9edf3;
    border-radius: 18px; padding: 1.1rem 1.1rem 0.9rem 1.3rem;
    overflow: hidden; display: flex; flex-direction: column;
    gap: 9px; transition: box-shadow .22s, transform .22s, border-color .22s;
}
.exp-card:hover {
    box-shadow: 0 6px 24px rgba(30,41,59,.09);
    transform: translateY(-2px); border-color: #c7d4e8;
}
.exp-card.exp-hidden { display: none; }
.exp-card-accent {
    position: absolute; left: 0; top: 16px; bottom: 16px;
    width: 3px; border-radius: 0 3px 3px 0;
}

/* Avatar */
.exp-av {
    width: 44px; height: 44px; border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 18px; font-weight: 800; flex-shrink: 0; color: #fff;
}
.exp-av-foto { object-fit: cover; }
.av-blue   { background: linear-gradient(135deg,#2563eb,#3b82f6); }
.av-green  { background: linear-gradient(135deg,#16a34a,#22c55e); }
.av-orange { background: linear-gradient(135deg,#ea580c,#f97316); }
.av-teal   { background: linear-gradient(135deg,#0d9488,#14b8a6); }
.av-pink   { background: linear-gradient(135deg,#db2777,#ec4899); }
.av-indigo { background: linear-gradient(135deg,#4f46e5,#6366f1); }
.av-amber  { background: linear-gradient(135deg,#d97706,#f59e0b); }
.av-purple { background: linear-gradient(135deg,#6d28d9,#7c3aed); }

/* Top */
.exp-card-top { display: flex; align-items: center; gap: 11px; }
.exp-card-info { flex: 1; min-width: 0; }
.exp-card-nombre {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 14.5px; font-weight: 700; color: #1e293b;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.exp-card-profesion {
    display: flex; align-items: center; gap: 5px;
    font-size: 11.5px; color: #64748b;
    font-family: 'DM Sans', sans-serif; margin-top: 2px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.exp-prof-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }

/* Experiencia actual */
.exp-card-exp-actual {
    display: flex; align-items: center; gap: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 11.5px; color: #475569;
    background: #f8fafc; border-radius: 8px;
    padding: 5px 10px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.exp-card-exp-actual svg { flex-shrink: 0; color: #94a3b8; }

/* Tags */
.exp-card-tags { display: flex; flex-wrap: wrap; gap: 5px; }
.exp-tag {
    font-size: 10.5px; font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    padding: 3px 9px; border-radius: 8px;
    background: #f8fafc;
    border: 1.5px solid #e9edf3;
    letter-spacing: .3px;
}
.exp-tag-more { background: #f1f5f9; color: #64748b; border-color: #e2e8f0; }

/* Formación */
.exp-meta-row {
    display: flex; align-items: center; gap: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 11.5px; color: #475569;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.exp-meta-row svg { flex-shrink: 0; color: #94a3b8; }

/* Footer */
.exp-card-footer {
    display: flex; align-items: center; gap: 6px;
    padding-top: 8px; border-top: 1px solid #f1f5f9;
    margin-top: auto; flex-wrap: wrap;
}
.exp-card-redes { display: flex; align-items: center; gap: 4px; }
.exp-red-btn {
    display: flex; align-items: center; justify-content: center;
    width: 28px; height: 28px; border-radius: 8px;
    border: 1.5px solid #e9edf3; background: #f8fafc;
    color: #64748b; text-decoration: none; transition: all .18s;
}
.exp-red-btn:hover { border-color: #3b82f6; color: #2563eb; background: #eff6ff; }

.exp-card-badges { display: flex; align-items: center; gap: 5px; }
.exp-badge-cert {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10.5px; font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    padding: 3px 8px; border-radius: 8px;
    background: #fef9c3; color: #854d0e;
}
.exp-badge-porta {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10.5px; font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    padding: 3px 8px; border-radius: 8px;
    background: #eff6ff; color: #1d4ed8;
    text-decoration: none; transition: background .15s;
}
.exp-badge-porta:hover { background: #dbeafe; }

.exp-btn-perfil {
    display: inline-flex; align-items: center; justify-content: center; gap: 5px;
    margin-left: auto; padding: 7px 14px; border-radius: 14px;
    background: #f1f5f9; color: #1e293b;
    border: 1.5px solid #e2e8f0;
    font-size: 12px; font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none; transition: all .25s;
    white-space: nowrap; cursor: pointer;
    flex-shrink: 0; position: relative; z-index: 2;
    pointer-events: all;
}
.exp-btn-perfil *, .exp-btn-perfil svg { pointer-events: none; }
.exp-btn-perfil:hover { background: #1e293b; color: #fff; border-color: #1e293b; transform: translateY(-1px); }
.exp-btn-perfil:active { transform: translateY(0); }

/* Gráfica decorativa */
.exp-trend-bg {
    position: absolute; bottom: 6px; right: 6px;
    opacity: .06; pointer-events: none;
}

/* Empty */
.exp-empty {
    grid-column: 1 / -1;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 4rem 2rem; color: #94a3b8; text-align: center; gap: 12px;
}
.exp-empty svg { opacity: .35; }
.exp-empty p { font-family: 'DM Sans', sans-serif; font-size: 13px; margin: 0; }
.exp-empty strong { font-size: 15px; color: #475569; display: block; margin-bottom: 4px; }

/* ══ RESPONSIVE ══ */

/* ── Tablet (≤ 768px) ── */
@media (max-width: 768px) {

    /* Hero: stats debajo del buscador */
    .exp-hero { padding: 1.1rem 1.2rem; }
    .exp-hero-inner { flex-direction: column; align-items: flex-start; gap: 12px; }
    .exp-hero-title { font-size: 16px; }
    .exp-hero-sub   { font-size: 11.5px; margin-bottom: 10px; }
    .exp-hero-stats { width: 100%; justify-content: flex-start; }
    .exp-stat-pill  { flex: 1; min-width: 0; padding: 7px 10px; }
    .exp-stat-num   { font-size: 17px; }
    .exp-search-wrap { max-width: 100%; }

    /* Filtros: label encima, botones scroll horizontal */
    .exp-filters-row {
        grid-template-columns: 1fr;
        gap: 6px;
        padding: 10px 12px;
    }
    .exp-filters {
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 2px;
    }
    .exp-filters::-webkit-scrollbar { display: none; }
    .exp-filter-btn { flex-shrink: 0; padding: 6px 12px; font-size: 12px; }

    /* Barra resultados */
    .exp-results-bar { flex-wrap: wrap; gap: 8px; }

    /* Grid: 2 columnas en tablet */
    .exp-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }

    /* Tarjeta: footer en dos líneas si hace falta */
    .exp-card-footer { flex-wrap: wrap; gap: 6px; }
    .exp-btn-perfil { margin-left: auto; }
}

/* ── Móvil (≤ 480px) ── */
@media (max-width: 480px) {

    /* Hero */
    .exp-hero { padding: 1rem; border-radius: 12px; margin-bottom: .75rem; }
    .exp-hero-title { font-size: 15px; }
    .exp-hero-sub   { font-size: 11px; }
    .exp-hero-stats { gap: 6px; }
    .exp-stat-num   { font-size: 15px; }
    .exp-stat-lbl   { font-size: 9.5px; }
    .exp-search-wrap { padding: 7px 11px; border-radius: 11px; }
    .exp-search-input { font-size: 13px; }
    .exp-search-badge { display: none; } /* evita overflow en pantallas pequeñas */

    /* Filtros */
    .exp-filters-wrap { border-radius: 11px; margin-bottom: .75rem; }
    .exp-filters-row  { padding: 8px 10px; }
    .exp-filters-label { font-size: 10px; }
    .exp-filter-btn { padding: 5px 10px; font-size: 11.5px; }
    .exp-filter-icon { width: 19px; height: 19px; border-radius: 6px; }

    /* Grid: 1 columna en móvil */
    .exp-grid { grid-template-columns: 1fr; gap: 8px; }

    /* Tarjeta */
    .exp-card { border-radius: 14px; padding: 1rem 1rem 0.85rem 1.2rem; gap: 8px; }
    .exp-av   { width: 40px; height: 40px; border-radius: 11px; font-size: 16px; }
    .exp-card-nombre  { font-size: 13.5px; }
    .exp-card-profesion { font-size: 11px; }
    .exp-card-exp-actual { font-size: 11px; padding: 4px 9px; }

    /* Footer: badges + redes en una línea, botón debajo */
    .exp-card-footer {
        flex-wrap: wrap;
        row-gap: 6px;
    }
    .exp-card-badges { flex-shrink: 0; }
    .exp-card-redes  { flex-shrink: 0; }
    .exp-btn-perfil  {
        width: 100%;
        margin-left: 0;
        justify-content: center;
        padding: 8px 14px;
    }

    /* Sort menu */
    .exp-sort-menu { right: 0; min-width: 160px; }

    /* Empty state */
    .exp-empty { padding: 2.5rem 1rem; }
}
</style>

<script>
(function () {
    const grid    = document.getElementById('expGrid');
    const countEl = document.getElementById('expCountNum');
    const emptyEl = document.getElementById('expEmptyFilter');

    // Estado de los dos ejes de filtrado (independientes y combinables)
    let activeCap = 'todos';   // capacidad: todos | con_certificacion | con_portafolio | con_experiencia
    let activeCat = 'todas';   // categoria: todas | tecnologia | creativos | negocios | salud | educacion

    // ── Botones fila 1: capacidad ──
    document.querySelectorAll('.exp-filters--capacity .exp-filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.exp-filters--capacity .exp-filter-btn')
                .forEach(b => b.classList.remove('exp-filter-active'));
            btn.classList.add('exp-filter-active');
            activeCap = btn.dataset.cap;
            expApply();
        });
    });

    // ── Botones fila 2: categoría ──
    document.querySelectorAll('.exp-filters--category .exp-filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.exp-filters--category .exp-filter-btn')
                .forEach(b => b.classList.remove('exp-filter-cat-active'));
            btn.classList.add('exp-filter-cat-active');
            activeCat = btn.dataset.catFilter;
            expApply();
        });
    });

    function expApply() {
        const q     = (document.getElementById('expSearch')?.value ?? '').toLowerCase().trim();
        const cards = grid.querySelectorAll('.exp-card');
        let visible = 0;

        cards.forEach(card => {
            // Filtro capacidad
            let matchCap = true;
            if      (activeCap === 'con_certificacion') matchCap = card.dataset.cert  === '1';
            else if (activeCap === 'con_portafolio')    matchCap = card.dataset.porta === '1';
            else if (activeCap === 'con_experiencia')   matchCap = card.dataset.exp   === '1';

            // Filtro categoría
            const matchCat = (activeCat === 'todas') || (card.dataset.cat === activeCat);

            // Filtro búsqueda de texto (nombre, profesion, habilidades, etc.)
            const matchSearch = !q || (card.dataset.search || '').includes(q);

            if (matchCap && matchCat && matchSearch) {
                card.classList.remove('exp-hidden');
                visible++;
            } else {
                card.classList.add('exp-hidden');
            }
        });

        if (countEl) countEl.textContent = visible;
        if (emptyEl) {
            emptyEl.style.display = (visible === 0 && cards.length > 0) ? 'flex' : 'none';
        }
    }

    // Exponer para el input del hero
    window.expApply = expApply;

    // Ordenar
    window.expSetSort = function(mode, label) {
        document.getElementById('sortLabel').innerText = label;
        document.getElementById('sortMenu').style.display = 'none';

        const cards = Array.from(grid.querySelectorAll('.exp-card'));
        cards.sort((a, b) => {
            if (mode === 'az')              return (a.dataset.nombre || '').localeCompare(b.dataset.nombre || '');
            if (mode === 'za')              return (b.dataset.nombre || '').localeCompare(a.dataset.nombre || '');
            if (mode === 'certificaciones') return parseInt(b.dataset.certificaciones || 0) - parseInt(a.dataset.certificaciones || 0);
            if (mode === 'habilidades')     return parseInt(b.dataset.habilidades || 0) - parseInt(a.dataset.habilidades || 0);
            return 0;
        });
        cards.forEach(c => grid.appendChild(c));
        expApply();
    };

    // Cerrar sort al click fuera
    document.addEventListener('click', e => {
        const sc = document.getElementById('sortContainer');
        if (sc && !sc.contains(e.target)) {
            const m = document.getElementById('sortMenu');
            if (m) m.style.display = 'none';
        }
    });

    expApply();
})();
</script>