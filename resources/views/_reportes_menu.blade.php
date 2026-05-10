{{-- ============================================================
     _reportes_menu.blade.php
     Partial: contenido de la vista "Reportes" para menu.blade.php
     Uso: @include('_reportes_menu')
     ============================================================ --}}

@php
    $r_user = auth()->user();
    $r_exp  = $r_user ? $r_user->experiencias()->orderBy('fecha_inicio', 'desc')->get()          : collect();
    $r_form = $r_user ? $r_user->formaciones()->orderBy('fecha_inicio', 'desc')->get()            : collect();
    $r_habF = $r_user ? $r_user->habilidades()->where('tipo', 'fuerte')->get()                    : collect();
    $r_habB = $r_user ? $r_user->habilidades()->where('tipo', 'blanda')->get()                    : collect();
    $r_cert = $r_user ? $r_user->certificaciones()->orderBy('fecha_obtencion', 'desc')->get()     : collect();

    $supabaseBase = rtrim(config('services.supabase.url'), '/')
                  . '/storage/v1/object/public/'
                  . config('services.supabase.bucket');

    $fotoCV = $r_user?->foto_perfil
        ? $supabaseBase . '/' . ltrim($r_user->foto_perfil, '/')
        : null;

    $fotoFallback = 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop';
@endphp

{{-- ── Barra superior de la vista ── --}}
<div class="content-bar">
    <div class="content-title">
        <h1>Reportes y Documentos</h1>
        <p>Genera y exporta planillas, hojas de vida y curriculum vitae en formato PDF.</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <button id="btn-edit-cv" class="btn-export"
                onclick="toggleEditCV()"
                style="background:#e2e8f0;color:#1e293b;border:none;">
            <svg viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Editar en pantalla
        </button>
        <button class="btn-export" onclick="window.print()">
            <svg viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Exportar PDF
        </button>
    </div>
</div>

{{-- ── Selector de plantilla ── --}}
<div class="template-selector"
     style="display:flex;align-items:center;gap:12px;margin-bottom:25px;
            background:#f8fafc;padding:15px 20px;border-radius:12px;border:1px solid #e2e8f0;">
    <label for="cv-template-select"
           style="font-size:14px;font-weight:600;color:#475569;margin:0;">
        Seleccionar Plantilla:
    </label>
    <select id="cv-template-select"
            onchange="selectTemplate(this.value)"
            style="padding:10px 14px;border-radius:8px;border:1px solid #cbd5e1;font-size:14px;
                   font-weight:500;color:#1e293b;outline:none;cursor:pointer;flex:1;
                   max-width:320px;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
        <option value="cv-template-1">Moderno (Azul)</option>
        <option value="cv-template-2">Clásico (Formal)</option>
        <option value="cv-template-3">Minimalista</option>
        <option value="cv-template-4">Elegante (Gris)</option>
        <option value="cv-template-5">Creativo (Verde/Rosa)</option>
        <option value="cv-template-6">Moderno (Malva)</option>
    </select>
</div>

{{-- ════════════════════════════════════════════════════════════
     CONTENEDOR DE PLANTILLAS CV
     ════════════════════════════════════════════════════════════ --}}
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
                <div class="cv-title-left">APTITUDES</div>
                <ul class="cv-list-left">
                    @forelse($r_habB as $hab)
                        <li>{{ $hab->nombre }}</li>
                    @empty
                        <li>Trabajo en equipo.</li>
                        <li>Iniciativa.</li>
                        <li>Resolución de problemas.</li>
                        <li>Aprendizaje fluido.</li>
                        <li>Comunicación efectiva.</li>
                    @endforelse
                </ul>
            </div>

            <div class="cv-section-left">
                <div class="cv-title-left">RESUMEN PROFESIONAL</div>
                <div class="cv-text-left">
                    {{ $r_user?->biografia ?? 'Programadora web con más de 5 años de trayectoria desarrolladas en el eCommerce.' }}
                </div>
            </div>
        </div>

        <div class="cv-right">
            <h1 class="cv-name">
                {{ $r_user?->nombre ?? 'Eva' }}<br>{{ $r_user?->apellido ?? 'Sánchez Linares' }}
            </h1>

            <div class="cv-section-right">
                <div class="cv-title-right">HABILIDADES INFORMÁTICAS</div>
                <ul class="cv-list-right">
                    @forelse($r_habF as $hab)
                        <li>{{ $hab->nombre }}{{ $hab->nivel ? ' ('.$hab->nivel.')' : '' }}</li>
                    @empty
                        <li>Programación con JavaScript, CSS, HTML, C#, SQL.</li>
                        <li>Conocimientos avanzados de Prestashop.</li>
                        <li>Manejo de MySQL, MariaDB, Mongodb.</li>
                        <li>Desarrollo de aplicaciones móviles.</li>
                    @endforelse
                </ul>
            </div>

            <div class="cv-section-right">
                <div class="cv-title-right">CURSOS Y CERTIFICADOS</div>
                <ul class="cv-list-right">
                    @forelse($r_cert as $cert)
                        <li>
                            {{ $cert->nombre }}
                            ({{ $cert->fecha_obtencion?->format('Y') }})
                            - {{ $cert->organizacion }}
                        </li>
                    @empty
                        <li>Programación avanzada en JavaScript (200 horas) - Edx</li>
                        <li>Adobe Illustrator para diseño gráfico (140 horas) - Domestika</li>
                    @endforelse
                </ul>
            </div>

            <div class="cv-section-right">
                <div class="cv-title-right">HISTORIAL LABORAL</div>
                @forelse($r_exp as $exp)
                    <div class="cv-job-container">
                        <div class="cv-job-date">
                            {{ $exp->fecha_inicio?->format('M Y') }}
                            - {{ $exp->actual ? 'Actualidad' : $exp->fecha_fin?->format('M Y') }}
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
                        <div class="cv-job-date">Junio 2017 - Marzo 2020</div>
                        <div class="cv-job-title">Desarrolladora web eCommerce · Hays Response, Zaragoza</div>
                        <ul class="cv-job-desc">
                            <li>Maquetación mediante CSS.</li>
                            <li>Optimización de SEO on page.</li>
                            <li>Programación con JavaScript.</li>
                        </ul>
                    </div>
                @endforelse
            </div>

            <div class="cv-section-right" style="margin-bottom:0;">
                <div class="cv-title-right">FORMACIÓN</div>
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
                        <div style="font-size:12px;">Grado Superior en Desarrollo de Aplicaciones Web</div>
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
            <div class="cv2-title">Resumen Profesional</div>
            <div style="font-size:13px;line-height:1.5;color:#334155;">
                {{ $r_user?->biografia ?? 'Programadora web con más de 5 años de trayectoria desarrolladas en el eCommerce.' }}
            </div>
        </div>

        <div class="cv2-section">
            <div class="cv2-title">Experiencia Laboral</div>
            @forelse($r_exp as $exp)
                <div class="cv2-item">
                    <div class="cv2-item-header">
                        <div class="cv2-item-title">{{ $exp->cargo }} - {{ $exp->empresa }}</div>
                        <div class="cv2-item-date">
                            {{ $exp->fecha_inicio?->format('M Y') }}
                            - {{ $exp->actual ? 'Actualidad' : $exp->fecha_fin?->format('M Y') }}
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
                        <div class="cv2-item-title">Desarrolladora web eCommerce - Hays Response</div>
                        <div class="cv2-item-date">Junio 2017 - Marzo 2020</div>
                    </div>
                    <ul>
                        <li>Maquetación mediante CSS y Optimización SEO on page.</li>
                        <li>Programación con JavaScript e implementación de BBDD.</li>
                        <li>Incremento en un 30% del tráfico de clientes.</li>
                    </ul>
                </div>
            @endforelse
        </div>

        <div class="cv2-section">
            <div class="cv2-title">Formación Académica</div>
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
                        <div class="cv2-item-title">Grado Superior en Desarrollo de Aplicaciones Web</div>
                        <div class="cv2-item-date">2015</div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="cv2-section">
            <div class="cv2-title">Habilidades e Idiomas</div>
            <div style="display:flex;gap:40px;font-size:13px;color:#334155;line-height:1.5;">
                <div>
                    <strong>Competencias:</strong><br>
                    @forelse($r_habB as $hab)
                        {{ $hab->nombre }}<br>
                    @empty
                        Trabajo en equipo<br>Iniciativa
                    @endforelse
                </div>
                <div>
                    <strong>Informática:</strong><br>
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
                {{ $r_user?->profesion ?? 'Programadora Web' }}
            </div>

            <div class="cv3-section-title">Contacto</div>
            <div class="cv3-contact-item">Avda. de Andalucía, 41</div>
            <div class="cv3-contact-item">692 454 731</div>
            <div class="cv3-contact-item">{{ $r_user?->email ?? 'evasanchezlinares@gmail.com' }}</div>

            <div class="cv3-section-title">Habilidades</div>
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
            <div class="cv3-section-title" style="margin-top:0;">Perfil</div>
            <div style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:30px;">
                {{ $r_user?->biografia ?? 'Programadora web con más de 5 años de trayectoria en el eCommerce.' }}
            </div>

            <div class="cv3-section-title">Experiencia</div>
            @forelse($r_exp as $exp)
                <div class="cv3-job">
                    <div class="cv3-job-date">
                        {{ $exp->fecha_inicio?->format('M Y') }}
                        - {{ $exp->actual ? 'Actualidad' : $exp->fecha_fin?->format('M Y') }}
                    </div>
                    <div class="cv3-job-title">{{ $exp->cargo }} · {{ $exp->empresa }}</div>
                    @if($exp->descripcion)
                        <div class="cv3-job-desc" style="white-space:pre-line;">{{ $exp->descripcion }}</div>
                    @endif
                </div>
            @empty
                <div class="cv3-job">
                    <div class="cv3-job-date">Junio 2017 - Marzo 2020</div>
                    <div class="cv3-job-title">Desarrolladora web eCommerce · Hays Response</div>
                    <div class="cv3-job-desc">Maquetación mediante CSS y Optimización SEO on page.</div>
                </div>
            @endforelse

            <div class="cv3-section-title">Educación</div>
            @forelse($r_form as $form)
                <div class="cv3-job" style="margin-bottom:15px;">
                    <div class="cv3-job-date">{{ $form->fecha_inicio?->format('Y') }}</div>
                    <div class="cv3-job-title">{{ $form->titulo }} · {{ $form->institucion }}</div>
                </div>
            @empty
                <div class="cv3-job" style="margin-bottom:0;">
                    <div class="cv3-job-date">2015</div>
                    <div class="cv3-job-title">Grado Superior en Desarrollo de Aplicaciones Web</div>
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
                <div class="cv4-role">{{ $r_user?->profesion ?? 'Puesto Ocupado' }}</div>
            </div>
        </div>

        <img src="{{ $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv4-photo">

        <div class="cv4-left">
            <div class="cv4-title" style="margin-top:0;">Contacto</div>
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

            <div class="cv4-title">Idiomas</div>
            <div class="cv4-text">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                    <span>Inglés</span>
                    <div style="width:60%;height:6px;background:#475a68;border-radius:3px;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                    <span>Francés</span>
                    <div style="width:40%;height:6px;background:#475a68;border-radius:3px;"></div>
                </div>
            </div>

            <div class="cv4-title">Habilidades</div>
            <ul class="cv4-list">
                @forelse(array_merge($r_habF->all(), $r_habB->all()) as $hab)
                    <li>{{ $hab->nombre }}</li>
                @empty
                    <li>Trabajo en equipo</li>
                    <li>Comunicación</li>
                    <li>Capacidad de adaptación</li>
                    <li>Creatividad</li>
                    <li>Liderazgo</li>
                @endforelse
            </ul>

            <div class="cv4-title">Intereses</div>
            <ul class="cv4-list">
                <li>Lectura</li>
                <li>Arte</li>
                <li>Deportes</li>
            </ul>
        </div>

        <div class="cv4-right">
            <div class="cv4-title" style="margin-top:0;">Perfil</div>
            <div class="cv4-text">
                {{ $r_user?->biografia ?? 'En este apartado de tu hoja de vida debes escribir tu experiencia profesional y habilidades más importantes.' }}
            </div>

            <div class="cv4-title">Experiencia Profesional</div>
            @forelse($r_exp as $exp)
                <div class="cv4-job">
                    <div class="cv4-job-title">{{ $exp->cargo }}</div>
                    <div class="cv4-job-meta">
                        <strong>{{ $exp->empresa }}</strong>
                        | {{ $exp->fecha_inicio?->format('Y') }}
                        - {{ $exp->actual ? 'Actualidad' : $exp->fecha_fin?->format('Y') }}
                    </div>
                    @if($exp->descripcion)
                        <ul class="cv4-list-bullet"><li>{{ $exp->descripcion }}</li></ul>
                    @endif
                </div>
            @empty
                <div class="cv4-job">
                    <div class="cv4-job-title">Puesto ocupado</div>
                    <div class="cv4-job-meta"><strong>NOMBRE DE LA EMPRESA</strong> | 20XX - 20XX</div>
                    <ul class="cv4-list-bullet"><li>Descripción de las actividades realizadas.</li></ul>
                </div>
            @endforelse

            <div class="cv4-title">Formación</div>
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
                    <div class="cv4-job-title">Nombre del grado o título obtenido</div>
                    <div class="cv4-job-meta"><strong>Nombre de la institución</strong> | 20XX</div>
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
                {{ $r_user?->profesion ?? 'Lic. Ingeniería de Sistemas' }}
            </div>
        </div>

        <img src="{{ $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv5-photo">

        <div class="cv5-left">
            <div class="cv5-title-left">Perfil</div>
            <div class="cv5-text-left" style="margin-bottom:30px;">
                {{ $r_user?->biografia ?? 'Ingeniero de Sistemas, responsable y comprometido con el aprendizaje continuo.' }}
            </div>

            <div class="cv5-title-left">Contacto</div>
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
            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Educación</div>
            @forelse($r_form as $form)
                <ul class="cv5-list" style="margin-bottom:10px;list-style:disc;">
                    <li><strong>{{ $form->institucion }}</strong><br>{{ $form->titulo }}</li>
                </ul>
            @empty
                <ul class="cv5-list" style="margin-bottom:10px;list-style:disc;">
                    <li><strong>UNIVERSIDAD MAYOR DE SAN SIMON</strong><br>Carrera en licenciatura de ingeniería de sistemas</li>
                </ul>
            @endforelse

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Lenguaje</div>
            <ul class="cv5-list" style="list-style:disc;">
                <li>Español: Nativo</li>
                <li>Inglés: Básico</li>
            </ul>

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Habilidades (Técnicas)</div>
            <ul class="cv5-list" style="list-style:disc;">
                @forelse($r_habF as $hab)
                    <li><strong>{{ $hab->nombre }}</strong>: Nivel {{ $hab->nivel ?: 'Básico' }}</li>
                @empty
                    <li><strong>Curso de Python básico</strong>: manejo básico de lenguaje.</li>
                    <li><strong>Java</strong>: manejo de fundamentos de programación.</li>
                @endforelse
            </ul>

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Certificados</div>
            <ul class="cv5-list" style="list-style:disc;">
                @forelse($r_cert as $cert)
                    <li>Certificado de {{ $cert->nombre }}</li>
                @empty
                    <li>Certificado de participación de agente censal</li>
                @endforelse
            </ul>

            <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Experiencia Laboral</div>
            <ul class="cv5-list" style="list-style:disc;">
                @forelse($r_exp as $exp)
                    <li><strong>{{ $exp->empresa }}</strong><br>{{ $exp->cargo }}</li>
                @empty
                    <li><strong>SISTEMA DE INVENTARIO Y VENTAS</strong><br>Desarrollador</li>
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
            <div class="cv6-role">{{ $r_user?->profesion ?? 'ESTUDIANTE' }}</div>
            <div class="cv6-banner-text">
                {{ $r_user?->biografia ?? 'Estudiante de Administración de Empresas. Me considero una persona responsable y ordenada.' }}
            </div>
        </div>

        <img src="{{ $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv6-photo">

        <div class="cv6-left">
            <div class="cv6-title">Educación</div>
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
                        <li>Universidad Borcelle<br>
                            <span style="color:#64748b;">2019-2023</span><br>
                            Carrera de Derecho, en Curso.
                        </li>
                    </ul>
                </div>
            @endforelse

            <div class="cv6-title">Idiomas</div>
            <ul class="cv6-list">
                <li>Idioma Inglés Avanzado<br>
                    <span style="color:#64748b;">Nivel Oral: Bilingüe</span>
                </li>
            </ul>

            <div class="cv6-title" style="margin-top:40px;">Contacto</div>
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
                Celular: 1234-5678
            </div>
        </div>

        <div class="cv6-right">
            <div class="cv6-title" style="margin-top:0;">Experiencia Laboral</div>
            @forelse($r_exp as $exp)
                <div class="cv6-item">
                    <div class="cv6-item-title">{{ $exp->cargo }}</div>
                    <div class="cv6-item-meta">
                        En {{ $exp->empresa }},
                        {{ $exp->fecha_inicio?->format('M Y') }}
                        - {{ $exp->actual ? 'presente' : $exp->fecha_fin?->format('M Y') }}
                    </div>
                    @if($exp->descripcion)
                        <ul class="cv6-list" style="margin-top:8px;"><li>{{ $exp->descripcion }}</li></ul>
                    @endif
                </div>
            @empty
                <div class="cv6-item">
                    <div class="cv6-item-title">Vendedora, Atención al cliente.</div>
                    <div class="cv6-item-meta">En Casa Colombia, marzo 2021 - presente</div>
                    <ul class="cv6-list" style="margin-top:8px;">
                        <li>Atención al cliente.</li>
                        <li>Control de caja.</li>
                    </ul>
                </div>
            @endforelse

            <div class="cv6-title">Habilidades y Conocimientos</div>
            <ul class="cv6-list">
                @forelse(array_merge($r_habF->all(), $r_habB->all()) as $hab)
                    <li>{{ $hab->nombre }}</li>
                @empty
                    <li>Procesador de texto, hoja de cálculos y presentación de Diapositivas.</li>
                @endforelse
            </ul>
        </div>
    </div>{{-- /cv-template-6 --}}

</div>{{-- /cv-wrapper --}}