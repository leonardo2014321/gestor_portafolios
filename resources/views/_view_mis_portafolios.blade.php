{{-- ============================================================
     _view_mis_portafolios.blade.php
     Partial: contenido de la vista "Menú Principal" para menu.blade.php
     Uso: @include('_view_mis_portafolios')
     ============================================================ --}}

<div class="content-bar">
    <div class="content-title">
        <h1>{{ __('app.menu.titulo') }}</h1>
        <p>{{ __('app.menu.subtitulo') }}</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        <button onclick="abrirModalPortafolio()"
                style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;
                       background:#fff;color:var(--blue);border-radius:10px;font-size:13px;
                       font-weight:600;border:1.5px solid var(--blue);cursor:pointer;">
            <svg viewBox="0 0 24 24"
                 style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            {{ __('app.menu.crear') }}
        </button>
        <button onclick="abrirModalCrearPf()"
                style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;
                       background:var(--blue);color:#fff;border-radius:10px;font-size:13px;
                       font-weight:600;border:none;cursor:pointer;">
            <svg viewBox="0 0 24 24"
                 style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round">
                <rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/>
                <rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/>
            </svg>
            Crear portafolio
        </button>
    </div>
</div>

{{-- ── Stats ── --}}
<div class="stats">
    <div class="stat s-blue">
        <div class="stat-ico">
            <svg viewBox="0 0 24 24" stroke="#fff">
                <rect x="2" y="2" width="9" height="9"/>
                <rect x="13" y="2" width="9" height="9"/>
                <rect x="2" y="13" width="9" height="9"/>
                <rect x="13" y="13" width="9" height="9"/>
            </svg>
        </div>
        <div>
            <div class="stat-num">{{ $totalPortafolios ?? 0 }}</div>
            <div class="stat-lbl">{{ __('app.menu.portafolios') }}</div>
        </div>
    </div>
    <div class="stat s-white">
        <div class="stat-ico">
            <svg viewBox="0 0 24 24" stroke="#2563eb">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        <div>
            <div class="stat-num">{{ $totalDocumentos ?? 0 }}</div>
            <div class="stat-lbl">{{ __('app.menu.documentos') }}</div>
        </div>
    </div>
    <div class="stat s-teal">
        <div class="stat-ico">
            <svg viewBox="0 0 24 24">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
        </div>
        <div>
            <div class="stat-num">{{ $totalAprobados ?? 0 }}</div>
            <div class="stat-lbl">{{ __('app.menu.aprobados') }}</div>
        </div>
    </div>
</div>

{{-- ── Label sección ── --}}
<div class="sec-lbl">
    <svg viewBox="0 0 24 24">
        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
        <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
        <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
    </svg>
    {{ __('app.menu.recientes') }}
</div>

{{-- ── Grid de portafolios ── --}}
@if(isset($portafolios) && $portafolios->count() > 0)
    <div class="pgrid">
        @foreach($portafolios as $portafolio)
            @php
                $publicado = $portafolio->estado === 'publicado';
                $hasBanner = !empty($portafolio->banner_ruta);
                $hasLogo   = !empty($portafolio->logo_ruta);
            @endphp

            @if($hasBanner)
                {{-- Portafolio con banner/logo --}}
                <div class="pcard-pf {{ $publicado ? 'pcard-pf-pub' : 'pcard-pf-bor' }}"
                     onclick="verPortafolio({{ $portafolio->id }})">
                    <div class="pcard-pf-top">
                        <img src="{{ asset('storage/' . $portafolio->banner_ruta) }}"
                             class="pcard-pf-banner-img" alt="">
                        <div class="pcard-pf-overlay"></div>
                        @if($hasLogo)
                            <div class="pcard-pf-logo">
                                <img src="{{ asset('storage/' . $portafolio->logo_ruta) }}" alt="">
                            </div>
                        @else
                            <div class="pcard-pf-logo pcard-pf-logo-ico">
                                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:#fff;stroke-width:2">
                                    <rect x="3" y="3" width="7" height="7"/>
                                    <rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/>
                                    <rect x="3" y="14" width="7" height="7"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="pcard-pf-body">
                        <div>
                            <div class="pcard-pf-name">{{ $portafolio->nombre }}</div>
                            <div class="pcard-pf-desc">{{ $portafolio->descripcion }}</div>
                        </div>
                        <div class="pcard-pf-footer">
                            <div class="pcard-st">
                                <span class="dot {{ $publicado ? 'dg' : 'dy' }}"></span>
                                {{ $publicado ? __('app.menu.publicado') : __('app.menu.borrador') }}
                            </div>
                            <a href="#" class="{{ $publicado ? 'btn-ver' : 'btn-ver-dk' }}"
                               onclick="event.stopPropagation();verPortafolio({{ $portafolio->id }});return false;">
                                {{ __('app.menu.ver_panel') }}
                            </a>
                        </div>
                    </div>
                </div>
            @elseif($publicado)
                <div class="pcard-teal">
                    <div class="pcard-top">
                        <div class="pcard-ico">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                        </div>
                        <div>
                            <div class="pcard-name">{{ $portafolio->nombre }}</div>
                            <div class="pcard-sub">{{ Str::limit($portafolio->descripcion, 60) }}</div>
                        </div>
                    </div>
                    <div class="pcard-bot">
                        <div class="pcard-st">
                            <span class="dot dg"></span>
                            {{ __('app.menu.publicado') }}
                        </div>
                        <a href="#" class="btn-ver"
                           onclick="verPortafolio({{ $portafolio->id }});return false;">
                            {{ __('app.menu.ver_panel') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="pcard-light">
                    <div class="pcard-top">
                        <div class="pcard-ico">
                            <svg viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div>
                            <div class="pcard-name">{{ $portafolio->nombre }}</div>
                            <div class="pcard-sub">{{ Str::limit($portafolio->descripcion, 60) }}</div>
                        </div>
                    </div>
                    <div class="pcard-bot">
                        <div class="pcard-st">
                            <span class="dot dy"></span>
                            {{ __('app.menu.borrador') }}
                        </div>
                        <a href="#" class="btn-ver-dk"
                           onclick="verPortafolio({{ $portafolio->id }});return false;">
                            {{ __('app.menu.ver_panel') }}
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@else
    <div style="text-align:center;padding:3rem 1rem;color:var(--muted)">
        <svg viewBox="0 0 24 24"
             style="width:48px;height:48px;fill:none;stroke:var(--gray3);stroke-width:1.5;
                    stroke-linecap:round;stroke-linejoin:round;margin:0 auto 1rem;display:block">
            <rect x="2" y="2" width="9" height="9"/>
            <rect x="13" y="2" width="9" height="9"/>
            <rect x="2" y="13" width="9" height="9"/>
            <rect x="13" y="13" width="9" height="9"/>
        </svg>
        <p style="font-size:15px;font-weight:600;color:var(--text);margin-bottom:6px">
            {{ __('app.menu.sin_portafolios') }}
        </p>
        <p style="font-size:13px">{{ __('app.menu.sin_desc') }}</p>
        <button onclick="abrirModalCrearPf()"
                style="display:inline-block;margin-top:1rem;padding:9px 22px;background:var(--blue);
                       color:#fff;border-radius:10px;font-size:13px;font-weight:600;
                       text-decoration:none;border:none;cursor:pointer">
            Crear portafolio
        </button>
    </div>
@endif
