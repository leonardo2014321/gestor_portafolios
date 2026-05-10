{{-- ============================================================
     _reportes_menu.blade.php
     ============================================================ --}}

@php
    $r_user = auth()->user();
    $r_exp  = $r_user ? $r_user->experiencias()->orderBy('fecha_inicio', 'desc')->get()      : collect();
    $r_form = $r_user ? $r_user->formaciones()->orderBy('fecha_inicio', 'desc')->get()        : collect();
    $r_habF = $r_user ? $r_user->habilidades()->where('tipo', 'fuerte')->get()                : collect();
    $r_habB = $r_user ? $r_user->habilidades()->where('tipo', 'blanda')->get()                : collect();
    $r_cert = $r_user ? $r_user->certificaciones()->orderBy('fecha_obtencion', 'desc')->get() : collect();

    $supabaseBase = rtrim(config('services.supabase.url'), '/')
                  . '/storage/v1/object/public/'
                  . config('services.supabase.bucket');

    $fotoCV = $r_user?->foto_perfil
        ? $supabaseBase . '/' . ltrim($r_user->foto_perfil, '/')
        : null;

    $fotoFallback = 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop';
@endphp

{{-- ── Barra superior ── --}}
<div class="content-bar">
    <div class="content-title">
        <h1>{{ __('app.reportes.titulo') }}</h1>
        <p>{{ __('app.reportes.subtitulo') }}</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <button id="btn-edit-cv" class="btn-export"
                onclick="toggleEditCV()"
                style="background:#e2e8f0;color:#1e293b;border:none;">
            <svg viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            {{ __('app.reportes.editar_pantalla') }}
        </button>
        <button class="btn-export" onclick="window.print()">
            <svg viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            {{ __('app.reportes.exportar_pdf') }}
        </button>
    </div>
</div>

{{-- ── Selector de plantilla ── --}}
<div class="template-selector"
     style="display:flex;align-items:center;gap:12px;margin-bottom:25px;
            background:#f8fafc;padding:15px 20px;border-radius:12px;border:1px solid #e2e8f0;">
    <label for="cv-template-select"
           style="font-size:14px;font-weight:600;color:#475569;margin:0;">
        {{ __('app.reportes.seleccionar_plantilla') }}
    </label>
    <select id="cv-template-select"
            onchange="selectTemplate(this.value)"
            style="padding:10px 14px;border-radius:8px;border:1px solid #cbd5e1;font-size:14px;
                   font-weight:500;color:#1e293b;outline:none;cursor:pointer;flex:1;
                   max-width:320px;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
        <option value="cv-template-1">{{ __('app.reportes.plantilla_moderna') }}</option>
        <option value="cv-template-2">{{ __('app.reportes.plantilla_clasica') }}</option>
        <option value="cv-template-3">{{ __('app.reportes.plantilla_minimalista') }}</option>
        <option value="cv-template-4">{{ __('app.reportes.plantilla_elegante') }}</option>
        <option value="cv-template-5">{{ __('app.reportes.plantilla_creativa') }}</option>
        <option value="cv-template-6">{{ __('app.reportes.plantilla_malva') }}</option>
    </select>
</div>

<div class="cv-wrapper">

    {{-- ── TEMPLATE 1 · Moderno (Azul) ── --}}
    <div class="cv-container cv-template-view active-tpl" id="cv-template-1">
        <div class="cv-left">
            <div class="cv-bg-pattern"></div>
            <div class="cv-photo-box">
                <img src="{{ $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv-photo">
            </div>

            <div class="cv-section-left">
                <div class="cv-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>Avda. de Andalucía, 41,<br>Archidona 29300</span>
                </div>
                <div class="cv-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                        <line x1="12" y1="18" x2="12.01" y2="18"/>
                    </svg>
                    <span>692 454 731</span>
                </div>
                <div class="cv-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <span>{{ $r_user?->email ?? 'evasanchezlinares@gmail.com' }}</span>
                </div>
            </div>

            <div class="cv-section-left">
                <div class="cv-title-left">{{ __('app.reportes.aptitudes') }}</div>
                <ul class="cv-list-left">
                    @forelse($r_habB as $hab)
                        <li>{{ $hab->nombre }}</li>
                    @empty
                        <li>{{ __('app.reportes.empty_trabajo_equipo') }}</li>
                        <li>{{ __('app.reportes.empty_iniciativa') }}</li>
                        <li>{{ __('app.reportes.empty_resolucion') }}</li>
                        <li>{{ __('app.reportes.empty_aprendizaje') }}</li>
                        <li>{{ __('app.reportes.empty_comunicacion') }}</li>
                    @endforelse
                </ul>
            </div>

            <div class="cv-section-left">
                <div class="cv-title-left">{{ __('app.reportes.resumen_profesional') }}</div>
                <div class="cv-text-left">
                    {{ $r_user?->biografia ?? __('app.reportes.empty_biografia') }}
                </div>
            </div>
        </div>

        <div class="cv-right">
            <h1 class="cv-name">
                {{ $r_user?->nombre ?? 'Eva' }}<br>{{ $r_user?->apellido ?? 'Sánchez Linares' }}
            </h1>

            <div class="cv-section-right">
                <div class="cv-title-right">{{ __('app.reportes.habilidades_informaticas') }}</div>
                <ul class="cv-list-right">
                    @forelse($r_habF as $hab)
                        <li>{{ $hab->nombre }}{{ $hab->nivel ? ' ('.$hab->nivel.')' : '' }}</li>
                    @empty
                        <li>{{ __('app.reportes.empty_hab_info') }}</li>
                    @endforelse
                </ul>
            </div>

            <div class="cv-section-right">
                <div class="cv-title-right">{{ __('app.reportes.cursos_certificados') }}</div>
                <ul class="cv-list-right">
                    @forelse($r_cert as $cert)
                        <li>
                            {{ $cert->nombre }}
                            ({{ $cert->fecha_obtencion?->format('Y') }})
                            - {{ $cert->organizacion }}
                        </li>
                    @empty
                        <li>{{ __('app.reportes.empty_cert') }}</li>
                    @endforelse
                </ul>
            </div>

            <div class="cv-section-right">
                <div class="cv-title-right">{{ __('app.reportes.historial_laboral') }}</div>
                @forelse($r_exp as $exp)
                    <div class="cv-job-container">
                        <div class="cv-job-date">
                            {{ $exp->fecha_inicio?->format('M Y') }}
                            - {{ $exp->actual ? __('app.reportes.actualidad') : $exp->fecha_fin?->format('M Y') }}
                        </div>
                        <div class="cv-job-title">{{ $exp->cargo }} · {{ $exp->empresa }}</div>
                        @if($exp->descripcion)
                            <div class="cv-job-desc" style="white-space:pre-line;line-height:1.5;">
                                {{ $exp->descripcion }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="cv-job-container">
                        <div class="cv-job-date">{{ __('app.reportes.empty_exp_fecha') }}</div>
                        <div class="cv-job-title">{{ __('app.reportes.empty_exp_titulo') }}</div>
                    </div>
                @endforelse
            </div>

            <div class="cv-section-right" style="margin-bottom:0;">
                <div class="cv-title-right">{{ __('app.reportes.formacion') }}</div>
                @forelse($r_form as $form)
                    <div class="cv-job-container" style="margin-bottom:10px;">
                        <div class="cv-job-date" style="color:#1e293b;font-weight:700;margin-bottom:2px;">
                            {{ $form->fecha_inicio?->format('Y') }}
                        </div>
                        <div style="font-size:12px;">{{ $form->titulo }} - {{ $form->institucion }}</div>
                    </div>
                @empty
                    <div class="cv-job-container" style="margin-bottom:0;">
                        <div class="cv-job-date" style="color:#1e293b;font-weight:700;margin-bottom:2px;">2015</div>
                        <div style="font-size:12px;">{{ __('app.reportes.empty_formacion') }}</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>{{-- /cv-template-1 --}}

    {{-- ── TEMPLATE 2 · Clásico (Formal) ── --}}
    <div class="cv-container cv-template-view" id="cv-template-2">
        <div class="cv2-header">
            <div class="cv2-name">
                {{ $r_user?->nombre ?? 'Eva' }} {{ $r_user?->apellido ?? 'Sánchez Linares' }}
            </div>
            <div class="cv2-contact">
                <span>Avda. de Andalucía, 41</span>
                <span>|</span>
                <span>692 454 731</span>
                <span>|</span>
                <span>{{ $r_user?->email ?? 'evasanchezlinares@gmail.com' }}</span>
            </div>
        </div>

        <div class="cv2-section">
            <div class="cv2-title">{{ __('app.reportes.resumen_profesional') }}</div>
            <div style="font-size:13px;line-height:1.5;color:#334155;">
                {{ $r_user?->biografia ?? __('app.reportes.empty_biografia') }}
            </div>
        </div>

        <div class="cv2-section">
            <div class="cv2-title">{{ __('app.reportes.exp_laboral') }}</div>
            @forelse($r_exp as $exp)
                <div class="cv2-item">
                    <div class="cv2-item-header">
                        <div class="cv2-item-title">{{ $exp->cargo }} - {{ $exp->empresa }}</div>
                        <div class="cv2-item-date">
                            {{ $exp->fecha_inicio?->format('M Y') }}
                            - {{ $exp->actual ? __('app.reportes.actualidad') : $exp->fecha_fin?->format('M Y') }}
                        </div>
                    </div>
                    @if($exp->descripcion)
                        <div style="font-size:13px;color:#334155;line-height:1.5;white-space:pre-line;padding-left:10px;">
                            {{ $exp->descripcion }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="cv2-item">
                    <div class="cv2-item-header">
                        <div class="cv2-item-title">{{ __('app.reportes.empty_exp_titulo') }}</div>
                        <div class="cv2-item-date">{{ __('app.reportes.empty_exp_fecha') }}</div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="cv2-section">
            <div class="cv2-title">{{ __('app.reportes.educacion') }}</div>
            @forelse($r_form as $form)
                <div class="cv2-item">
                    <div class="cv2-item-header">
                        <div class="cv2-item-title">{{ $form->titulo }} - {{ $form->institucion }}</div>
                        <div class="cv2-item-date">{{ $form->fecha_inicio?->format('Y') }}</div>
                    </div>
                </div>
            @empty
                <div class="cv2-item">
                    <div class="cv2-item-header">
                        <div class="cv2-item-title">{{ __('app.reportes.empty_formacion') }}</div>
                        <div class="cv2-item-date">2015</div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="cv2-section">
            <div class="cv2-title">{{ __('app.reportes.habilidades_conocimientos') }}</div>
            <div style="display:flex;gap:40px;font-size:13px;color:#334155;line-height:1.5;">
                <div>
                    <strong>{{ __('app.reportes.competencias') }}</strong><br>
                    @forelse($r_habB as $hab)
                        {{ $hab->nombre }}<br>
                    @empty
                        {{ __('app.reportes.empty_trabajo_equipo') }}<br>{{ __('app.reportes.empty_iniciativa') }}
                    @endforelse
                </div>
                <div>
                    <strong>{{ __('app.reportes.informatica') }}</strong><br>
                    @forelse($r_habF as $hab)
                        {{ $hab->nombre }}{{ $hab->nivel ? ' ('.$hab->nivel.')' : '' }}<br>
                    @empty
                        JavaScript, CSS, HTML, SQL<br>MySQL, MariaDB
                    @endforelse
                </div>
            </div>
        </div>
    </div>{{-- /cv-template-2 --}}

    {{-- ── TEMPLATE 3 · Minimalista ── --}}
    <div class="cv-container cv-template-view" id="cv-template-3">
        <div class="cv3-left">
            <div class="cv3-name">
                {{ $r_user?->nombre ?? 'Eva' }}<br>{{ $r_user?->apellido ?? 'Sánchez' }}
            </div>
            <div class="cv3-role">
                {{ $r_user?->profesion ?? __('app.reportes.empty_profesion') }}
            </div>

            <div class="cv3-section-title">{{ __('app.reportes.contacto') }}</div>
            <div class="cv3-contact-item">Avda. de Andalucía, 41</div>
            <div class="cv3-contact-item">692 454 731</div>
            <div class="cv3-contact-item">{{ $r_user?->email ?? 'evasanchezlinares@gmail.com' }}</div>

            <div class="cv3-section-title">{{ __('app.reportes.habilidades') }}</div>
            <div>
                @forelse(array_merge($r_habF->all(), $r_habB->all()) as $hab)
                    <span class="cv3-skill">{{ $hab->nombre }}</span>
                @empty
                    <span class="cv3-skill">JavaScript</span>
                    <span class="cv3-skill">CSS</span>
                    <span class="cv3-skill">HTML</span>
                    <span class="cv3-skill">SQL</span>
                @endforelse
            </div>
        </div>

        <div style="padding-left:20px;">
            <div class="cv3-section-title" style="margin-top:0;">{{ __('app.reportes.perfil') }}</div>
            <div style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:30px;">
                {{ $r_user?->biografia ?? __('app.reportes.empty_biografia') }}
            </div>

            <div class="cv3-section-title">{{ __('app.reportes.exp_laboral') }}</div>
            @forelse($r_exp as $exp)
                <div class="cv3-job">
                    <div class="cv3-job-date">
                        {{ $exp->fecha_inicio?->format('M Y') }}
                        - {{ $exp->actual ? __('app.reportes.actualidad') : $exp->fecha_fin?->format('M Y') }}
                    </div>
                    <div class="cv3-job-title">{{ $exp->cargo }} · {{ $exp->empresa }}</div>
                    @if($exp->descripcion)
                        <div class="cv3-job-desc" style="white-space:pre-line;">{{ $exp->descripcion }}</div>
                    @endif
                </div>
            @empty
                <div class="cv3-job">
                    <div class="cv3-job-date">{{ __('app.reportes.empty_exp_fecha') }}</div>
                    <div class="cv3-job-title">{{ __('app.reportes.empty_exp_titulo') }}</div>
                </div>
            @endforelse

            <div class="cv3-section-title">{{ __('app.reportes.educacion') }}</div>
            @forelse($r_form as $form)
                <div class="cv3-job" style="margin-bottom:15px;">
                    <div class="cv3-job-date">{{ $form->fecha_inicio?->format('Y') }}</div>
                    <div class="cv3-job-title">{{ $form->titulo }} · {{ $form->institucion }}</div>
                </div>
            @empty
                <div class="cv3-job" style="margin-bottom:0;">
                    <div class="cv3-job-date">2015</div>
                    <div class="cv3-job-title">{{ __('app.reportes.empty_formacion') }}</div>
                </div>
            @endforelse
        </div>
    </div>{{-- /cv-template-3 --}}

    {{-- ── TEMPLATE 4 · Elegante (Gris) ── --}}
    <div class="cv-container cv-template-view" id="cv-template-4">
        <div class="cv4-header">
            <div class="cv4-name-box">
                <div class="cv4-name">
                    {{ $r_user?->nombre ?? 'Nombres' }} {{ $r_user?->apellido ?? 'Apellidos' }}
                </div>
                <div class="cv4-role">{{ $r_user?->profesion ?? __('app.reportes.empty_profesion') }}</div>
            </div>
        </div>

        <img src="{{ $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv4-photo">

        <div class="cv4-left">
            <div class="cv4-title" style="margin-top:0;">{{ __('app.reportes.contacto') }}</div>
            <div class="cv4-text">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    692 454 731
                </div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;word-break:break-all;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    {{ $r_user?->email ?? 'nombre.apellido@mail.com' }}
                </div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Ciudad, País
                </div>
            </div>

            <div class="cv4-title">{{ __('app.reportes.idiomas') }}</div>
            <div class="cv4-text">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                    <span>{{ __('app.reportes.idioma_ingles') }}</span>
                    <div style="width:60%;height:6px;background:#475a68;border-radius:3px;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                    <span>{{ __('app.reportes.idioma_frances') }}</span>
                    <div style="width:40%;height:6px;background:#475a68;border-radius:3px;"></div>
                </div>
            </div>

            <div class="cv4-title">{{ __('app.reportes.habilidades') }}</div>
            <ul class="cv4-list">
                @forelse(array_merge($r_habF->all(), $r_habB->all()) as $hab)
                    <li>{{ $hab->nombre }}</li>
                @empty
                    <li>{{ __('app.reportes.empty_trabajo_equipo') }}</li>
                    <li>{{ __('app.reportes.empty_comunicacion') }}</li>
                    <li>{{ __('app.reportes.empty_adaptacion') }}</li>
                    <li>{{ __('app.reportes.empty_creatividad') }}</li>
                    <li>{{ __('app.reportes.empty_liderazgo') }}</li>
                @endforelse
            </ul>

            <div class="cv4-title">{{ __('app.reportes.intereses') }}</div>
            <ul class="cv4-list">
                <li>{{ __('app.reportes.interes_lectura') }}</li>
                <li>{{ __('app.reportes.interes_arte') }}</li>
                <li>{{ __('app.reportes.interes_deportes') }}</li>
            </ul>
        </div>

        <div class="cv4-right">
            <div class="cv4-title" style="margin-top:0;">{{ __('app.reportes.perfil') }}</div>
            <div class="cv4-text">
                {{ $r_user?->biografia ?? __('app.reportes.empty_biografia_larga') }}
            </div>

            <div class="cv4-title">{{ __('app.reportes.experiencia_profesional') }}</div>
            @forelse($r_exp as $exp)
                <div class="cv4-job">
                    <div class="cv4-job-title">{{ $exp->cargo }}</div>
                    <div class="cv4-job-meta">
                        <strong>{{ $exp->empresa }}</strong>
                        | {{ $exp->fecha_inicio?->format('Y') }}
                        - {{ $exp->actual ? __('app.reportes.actualidad') : $exp->fecha_fin?->format('Y') }}
                    </div>
                    @if($exp->descripcion)
                        <ul class="cv4-list-bullet"><li>{{ $exp->descripcion }}</li></ul>
                    @endif
                </div>
            @empty
                <div class="cv4-job">
                    <div class="cv4-job-title">{{ __('app.reportes.empty_puesto') }}</div>
                    <div class="cv4-job-meta"><strong>{{ __('app.reportes.empty_empresa') }}</strong> | 20XX - 20XX</div>
                </div>
            @endforelse

            <div class="cv4-title">{{ __('app.reportes.formacion') }}</div>
            @forelse($r_form as $form)
                <div class="cv4-job">
                    <div class="cv4-job-title">{{ $form->titulo }}</div>
                    <div class="cv4-job-meta">
                        <strong>{{ $form->institucion }}</strong>
                        | {{ $form->fecha_inicio?->format('Y') }}
                    </div>
                </div>
            @empty
                <div class="cv4-job">
                    <div class="cv4-job-title">{{ __('app.reportes.empty_formacion') }}</div>
                    <div class="cv4-job-meta"><strong>{{ __('app.reportes.empty_institucion') }}</strong> | 20XX</div>
                </div>
            @endforelse
        </div>
    </div>{{-- /cv-template-4 --}}

    {{-- ── TEMPLATE 5 · Creativo (Verde/Rosa) ── --}}
    <div class="cv-container cv-template-view" id="cv-template-5">
        <div class="cv5-banner">
            <div class="cv5-name">
                {{ $r_user?->nombre ?? 'Nombres' }}<br>{{ $r_user?->apellido ?? 'Apellidos' }}
            </div>
            <div class="cv5-role">
                {{ $r_user?->profesion ?? __('app.reportes.empty_profesion') }}
            </div>
        </div>

        <img src="{{ $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv5-photo">

        <div class="cv5-left">
            <div class="cv5-title-left">{{ __('app.reportes.perfil') }}</div>
            <div class="cv5-text-left" style="margin-bottom:30px;">
                {{ $r_user?->biografia ?? __('app.reportes.empty_biografia') }}
            </div>

            <div class="cv5-title-left">{{ __('app.reportes.contacto') }}</div>
            <div class="cv5-contact-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                692 454 731
            </div>
            <div class="cv5-contact-item" style="word-break:break-all;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                {{ $r_user?->email ?? 'correo@ejemplo.com' }}
            </div>
            <div class="cv5-contact-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                Cochabamba, Bolivia
            </div>
        </div>

        <div class="cv5-right">
            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> {{ __('app.reportes.educacion') }}</div>
            @forelse($r_form as $form)
                <ul class="cv5-list" style="margin-bottom:10px;list-style:disc;">
                    <li><strong>{{ $form->institucion }}</strong><br>{{ $form->titulo }}</li>
                </ul>
            @empty
                <ul class="cv5-list" style="margin-bottom:10px;list-style:disc;">
                    <li><strong>UNIVERSIDAD MAYOR DE SAN SIMON</strong><br>{{ __('app.reportes.empty_formacion') }}</li>
                </ul>
            @endforelse

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> {{ __('app.reportes.lenguaje') }}</div>
            <ul class="cv5-list" style="list-style:disc;">
                <li>{{ __('app.reportes.idioma_espanol_nativo') }}</li>
                <li>{{ __('app.reportes.idioma_ingles_basico') }}</li>
            </ul>

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> {{ __('app.reportes.hab_tecnicas') }}</div>
            <ul class="cv5-list" style="list-style:disc;">
                @forelse($r_habF as $hab)
                    <li><strong>{{ $hab->nombre }}</strong>: {{ __('app.reportes.nivel') }} {{ $hab->nivel ?: __('app.reportes.nivel_basico') }}</li>
                @empty
                    <li>{{ __('app.reportes.empty_hab_tec') }}</li>
                @endforelse
            </ul>

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> {{ __('app.reportes.certificados') }}</div>
            <ul class="cv5-list" style="list-style:disc;">
                @forelse($r_cert as $cert)
                    <li>{{ __('app.reportes.certificado_de') }} {{ $cert->nombre }}</li>
                @empty
                    <li>{{ __('app.reportes.empty_cert_simple') }}</li>
                @endforelse
            </ul>

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> {{ __('app.reportes.exp_laboral') }}</div>
            <ul class="cv5-list" style="list-style:disc;">
                @forelse($r_exp as $exp)
                    <li><strong>{{ $exp->empresa }}</strong><br>{{ $exp->cargo }}</li>
                @empty
                    <li>{{ __('app.reportes.empty_exp_simple') }}</li>
                @endforelse
            </ul>
        </div>
    </div>{{-- /cv-template-5 --}}

    {{-- ── TEMPLATE 6 · Moderno (Malva) ── --}}
    <div class="cv-container cv-template-view" id="cv-template-6">
        <div class="cv6-banner">
            <div class="cv6-name">
                {{ $r_user?->nombre ?? 'Emilia' }} {{ $r_user?->apellido ?? 'Ramírez' }}
            </div>
            <div class="cv6-role">{{ $r_user?->profesion ?? __('app.reportes.empty_profesion_upper') }}</div>
            <div class="cv6-banner-text">
                {{ $r_user?->biografia ?? __('app.reportes.empty_biografia') }}
            </div>
        </div>

        <img src="{{ $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv6-photo">

        <div class="cv6-left">
            <div class="cv6-title">{{ __('app.reportes.educacion') }}</div>
            @forelse($r_form as $form)
                <div class="cv6-item">
                    <ul class="cv6-list">
                        <li>
                            {{ $form->institucion }}<br>
                            <span style="color:#64748b;">{{ $form->fecha_inicio?->format('Y') }}</span><br>
                            {{ $form->titulo }}
                        </li>
                    </ul>
                </div>
            @empty
                <div class="cv6-item">
                    <ul class="cv6-list">
                        <li>{{ __('app.reportes.empty_universidad') }}<br>
                            <span style="color:#64748b;">2019-2023</span><br>
                            {{ __('app.reportes.empty_formacion') }}
                        </li>
                    </ul>
                </div>
            @endforelse

            <div class="cv6-title">{{ __('app.reportes.idiomas') }}</div>
            <ul class="cv6-list">
                <li>{{ __('app.reportes.idioma_ingles_avanzado') }}<br>
                    <span style="color:#64748b;">{{ __('app.reportes.nivel_oral_bilingue') }}</span>
                </li>
            </ul>

            <div class="cv6-title" style="margin-top:40px;">{{ __('app.reportes.contacto') }}</div>
            <div class="cv6-contact-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                {{ $r_user?->email ?? 'hola@sitio.com' }}
            </div>
            <div class="cv6-contact-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                {{ __('app.reportes.celular') }}: 1234-5678
            </div>
        </div>

        <div class="cv6-right">
            <div class="cv6-title" style="margin-top:0;">{{ __('app.reportes.exp_laboral') }}</div>
            @forelse($r_exp as $exp)
                <div class="cv6-item">
                    <div class="cv6-item-title">{{ $exp->cargo }}</div>
                    <div class="cv6-item-meta">
                        {{ __('app.reportes.en') }} {{ $exp->empresa }},
                        {{ $exp->fecha_inicio?->format('M Y') }}
                        - {{ $exp->actual ? __('app.reportes.presente') : $exp->fecha_fin?->format('M Y') }}
                    </div>
                    @if($exp->descripcion)
                        <ul class="cv6-list" style="margin-top:8px;"><li>{{ $exp->descripcion }}</li></ul>
                    @endif
                </div>
            @empty
                <div class="cv6-item">
                    <div class="cv6-item-title">{{ __('app.reportes.empty_exp_titulo') }}</div>
                    <div class="cv6-item-meta">{{ __('app.reportes.empty_exp_meta') }}</div>
                </div>
            @endforelse

            <div class="cv6-title">{{ __('app.reportes.habilidades_conocimientos') }}</div>
            <ul class="cv6-list">
                @forelse(array_merge($r_habF->all(), $r_habB->all()) as $hab)
                    <li>{{ $hab->nombre }}</li>
                @empty
                    <li>{{ __('app.reportes.empty_hab_ofice') }}</li>
                @endforelse
            </ul>
        </div>
    </div>{{-- /cv-template-6 --}}

</div>{{-- /cv-wrapper --}}