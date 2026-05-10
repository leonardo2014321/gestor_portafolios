{{-- ============================================================
     _portafolios_menu.blade.php
     Partial: contenido de la vista "Portafolios" para menu.blade.php
     Uso: @include('_portafolios_menu')
     ============================================================ --}}

<div class="content-bar">
    <div class="content-title">
        <h1>{{ __('app.menu.inspira') }}</h1>
        <p>{{ __('app.menu.inspira_desc') }}</p>
    </div>
</div>

{{-- ── Filtros ── --}}
<div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:1.4rem;">
    <button style="padding:7px 20px;border-radius:999px;background:var(--blue);color:#fff;border:none;
                   font-size:13px;font-weight:600;cursor:pointer;">
        {{ __('app.menu.todos') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);
                   color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        🎨 {{ __('app.menu.creativos') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);
                   color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        🩺 {{ __('app.menu.salud') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);
                   color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        💼 {{ __('app.menu.negocios') }}
    </button>
    <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);
                   color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">
        🎓 {{ __('app.menu.educacion') }}
    </button>
</div>

{{-- ── Grid de tarjetas ── --}}
<div class="porta-grid">

    @php
        $cards = [
            [
                'img'      => 'arqui.png',
                'badge'    => 'Arquitectura',
                'color'    => '#ec4899',
                'nombre'   => 'Arq. Roberto Méndez',
                'sub'      => 'Diseño Sostenible • Cochabamba',
            ],
            [
                'img'      => 'fisio.png',
                'badge'    => 'Fisioterapia',
                'color'    => '#10b981',
                'nombre'   => 'Dra. Elena Vargas',
                'sub'      => 'Rehabilitación Deportiva • La Paz',
            ],
            [
                'img'      => 'contador.png',
                'badge'    => 'Consultoría',
                'color'    => '#3b82f6',
                'nombre'   => 'Lic. Carlos Duarte',
                'sub'      => 'Estrategia Financiera • Santa Cruz',
            ],
            [
                'img'      => 'prof.png',
                'badge'    => 'Docencia',
                'color'    => '#f59e0b',
                'nombre'   => 'Msc. Ana Jiménez',
                'sub'      => 'Metodologías Activas • Sucre',
            ],
        ];
    @endphp

    @foreach($cards as $card)
        <div style="background:#D9EBFF;border-radius:24px;overflow:hidden;border:1px solid #e2e8f0;
                    box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;"
             onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'"
             onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'">

            <div style="position:relative;height:180px;overflow:hidden;">
                <img src="{{ asset('images/' . $card['img']) }}"
                     style="width:100%;height:100%;object-fit:cover;transition:transform .5s;"
                     onmouseover="this.style.transform='scale(1.08)'"
                     onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute;top:10px;left:10px;background:{{ $card['color'] }};color:#fff;
                            font-size:9px;font-weight:700;padding:3px 10px;border-radius:999px;
                            letter-spacing:1px;text-transform:uppercase;">
                    {{ $card['badge'] }}
                </div>
            </div>

            <div style="padding:1rem;">
                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:#1e293b;">
                    {{ $card['nombre'] }}
                </div>
                <div style="font-size:11.5px;color:var(--muted);margin-top:3px;">
                    {{ $card['sub'] }}
                </div>
                <button style="margin-top:10px;width:100%;padding:9px;background:#f8fafc;color:#1e293b;
                               border:none;border-radius:14px;font-size:12.5px;font-weight:700;
                               cursor:pointer;transition:all .3s;"
                        onmouseover="this.style.background='#2563eb';this.style.color='#fff'"
                        onmouseout="this.style.background='#f8fafc';this.style.color='#1e293b'">
                    {{ __('app.menu.ver_perfil') }} →
                </button>
            </div>
        </div>
    @endforeach

</div>