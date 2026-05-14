{{-- ============================================================
     resources/views/proyecto/publico.blade.php
     Vista pública de un proyecto individual
     Variables: $proyecto, $portafolio, $usuario, $otrosProyectos
     ============================================================ --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $proyecto->nombre }} — {{ $portafolio->nombre }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --accent:       #6366f1;
            --accent-dark:  #4f46e5;
            --accent-light: #ede9fe;
            --accent-text:  #4c1d95;
            --gray-50:  #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --green-bg:   #d1fae5;
            --green-text: #065f46;
            --blue-bg:    #dbeafe;
            --blue-text:  #1e3a8a;
            --red-bg:     #fee2e2;
            --red-text:   #991b1b;
            --amber-bg:   #fef3c7;
            --amber-text: #92400e;
            --radius-sm:  8px;
            --radius-md:  12px;
            --radius-lg:  18px;
            --radius-xl:  24px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
        }

        /* ══════════════════════════════════════
           HERO HEADER
        ══════════════════════════════════════ */
        .hero {
            background: linear-gradient(135deg, #0f0f1a 0%, #1e1b4b 60%, #312e81 100%);
            padding: 0;
            position: relative;
            overflow: hidden;
        }
        .hero-pattern {
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .hero-glow-1 {
            position: absolute;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,.25) 0%, transparent 70%);
            top: -150px; right: -100px;
        }
        .hero-glow-2 {
            position: absolute;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,.2) 0%, transparent 70%);
            bottom: -80px; left: 60px;
        }

        /* Barra top */
        .hero-topbar {
            position: relative; z-index: 2;
            display: flex; align-items: center; gap: 10px;
            padding: 1.2rem 2.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .back-btn {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; color: rgba(255,255,255,.65);
            text-decoration: none; padding: 6px 12px;
            border: 1px solid rgba(255,255,255,.15);
            border-radius: var(--radius-sm);
            transition: all .2s;
        }
        .back-btn:hover { color: #fff; background: rgba(255,255,255,.08); }
        .breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: rgba(255,255,255,.45);
        }
        .breadcrumb span { color: rgba(255,255,255,.7); }
        .breadcrumb .sep { color: rgba(255,255,255,.25); }

        /* Contenido hero */
        .hero-body {
            position: relative; z-index: 2;
            max-width: 1100px; margin: 0 auto;
            padding: 3rem 2.5rem 2.5rem;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: end;
        }
        .hero-icon-row {
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 1.2rem;
        }
        .proj-icon-box {
            width: 72px; height: 72px; border-radius: var(--radius-lg);
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 32px;
            border: 2px solid rgba(255,255,255,.25);
            box-shadow: 0 8px 32px rgba(99,102,241,.4);
            flex-shrink: 0;
        }
        .hero-badges { display: flex; flex-wrap: wrap; gap: 6px; }
        .hbadge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 600;
            letter-spacing: .05em; text-transform: uppercase;
            padding: 4px 10px; border-radius: 999px;
        }
        .hbadge-pub { background: #d1fae5; color: #065f46; }
        .hbadge-cat { background: rgba(255,255,255,.12); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.2); }

        .hero-title {
            font-family: 'DM Serif Display', serif;
            font-size: 38px; font-weight: 400;
            color: #fff; line-height: 1.15;
            margin-bottom: .8rem;
        }
        .hero-desc {
            font-size: 15px; color: rgba(255,255,255,.65);
            line-height: 1.7; max-width: 620px;
            margin-bottom: 1.6rem;
        }
        .hero-meta {
            display: flex; flex-wrap: wrap; gap: 1.4rem;
        }
        .hero-meta-item {
            display: flex; align-items: center; gap: 7px;
            font-size: 12px; color: rgba(255,255,255,.55);
        }
        .hero-meta-item strong { color: rgba(255,255,255,.85); font-weight: 500; }

        /* Botones hero */
        .hero-actions { display: flex; flex-direction: column; gap: 8px; align-items: flex-end; }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 11px 20px; border-radius: var(--radius-md);
            background: #fff; color: var(--gray-900);
            font-size: 13px; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 4px 14px rgba(0,0,0,.25);
            transition: all .2s;
        }
        .btn-hero-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,.3); }
        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 11px 20px; border-radius: var(--radius-md);
            background: rgba(255,255,255,.1); color: rgba(255,255,255,.85);
            font-size: 13px; font-weight: 500;
            border: 1px solid rgba(255,255,255,.2); cursor: pointer;
            white-space: nowrap;
            transition: all .2s;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,.18); color: #fff; }

        /* ══════════════════════════════════════
           STATS BAR
        ══════════════════════════════════════ */
        .stats-bar {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
        }
        .stats-bar-inner {
            max-width: 1100px; margin: 0 auto;
            padding: 0 2.5rem;
            display: flex; align-items: stretch;
        }
        .stat-cell {
            flex: 1;
            display: flex; flex-direction: column;
            padding: 1.1rem 1.4rem;
            border-right: 1px solid var(--gray-200);
        }
        .stat-cell:last-child { border-right: none; }
        .stat-label {
            font-size: 10px; font-weight: 600;
            letter-spacing: .07em; text-transform: uppercase;
            color: var(--gray-400); margin-bottom: 4px;
        }
        .stat-value {
            font-size: 15px; font-weight: 600; color: var(--gray-800);
        }
        .stat-sub { font-size: 11px; color: var(--gray-400); margin-top: 2px; }

        /* ══════════════════════════════════════
           LAYOUT PRINCIPAL
        ══════════════════════════════════════ */
        .main {
            max-width: 1100px; margin: 0 auto;
            padding: 2rem 2.5rem;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 1.8rem;
            align-items: start;
        }

        /* Sección genérica */
        .section {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            margin-bottom: 1.4rem;
            overflow: hidden;
        }
        .section-head {
            display: flex; align-items: center; gap: 9px;
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid var(--gray-100);
            background: var(--gray-50);
        }
        .section-head-icon {
            width: 28px; height: 28px; border-radius: var(--radius-sm);
            background: var(--accent-light);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
        }
        .section-head h2 {
            font-size: 13px; font-weight: 600; color: var(--gray-800);
            flex: 1;
        }
        .section-count {
            font-size: 11px; font-weight: 600;
            background: var(--accent-light); color: var(--accent-text);
            padding: 2px 8px; border-radius: 999px;
        }
        .section-body { padding: 1.4rem; }

        /* Descripción */
        .desc-text {
            font-size: 14px; color: var(--gray-600);
            line-height: 1.8; white-space: pre-wrap;
        }

        /* Archivos */
        .file-table { width: 100%; border-collapse: collapse; }
        .file-table thead tr { border-bottom: 1px solid var(--gray-100); }
        .file-table th {
            font-size: 10px; font-weight: 600;
            letter-spacing: .07em; text-transform: uppercase;
            color: var(--gray-400);
            padding: 0 .75rem 10px;
            text-align: left;
        }
        .file-table tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: background .15s;
        }
        .file-table tbody tr:last-child { border-bottom: none; }
        .file-table tbody tr:hover { background: var(--gray-50); }
        .file-table td {
            padding: 11px .75rem;
            font-size: 13px; color: var(--gray-700);
            vertical-align: middle;
        }
        .file-name-cell { display: flex; align-items: center; gap: 10px; }
        .ext-badge {
            font-size: 9px; font-weight: 700;
            padding: 3px 6px; border-radius: 5px;
            text-transform: uppercase; letter-spacing: .05em;
            flex-shrink: 0;
        }
        .ext-pdf   { background: var(--red-bg);   color: var(--red-text); }
        .ext-png,
        .ext-jpg,
        .ext-jpeg  { background: var(--green-bg);  color: var(--green-text); }
        .ext-zip,
        .ext-rar   { background: var(--amber-bg);  color: var(--amber-text); }
        .ext-xlsx  { background: var(--green-bg);  color: var(--green-text); }
        .ext-docx  { background: var(--blue-bg);   color: var(--blue-text); }
        .ext-default { background: var(--gray-100); color: var(--gray-600); }
        .file-size { font-size: 12px; color: var(--gray-400); }
        .btn-dl {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 500;
            padding: 5px 12px; border-radius: var(--radius-sm);
            background: var(--gray-100); color: var(--gray-700);
            border: 1px solid var(--gray-200);
            cursor: pointer; text-decoration: none;
            transition: all .15s;
        }
        .btn-dl:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

        /* Sin archivos */
        .empty-state {
            text-align: center; padding: 2rem;
            color: var(--gray-400); font-size: 13px;
        }
        .empty-icon { font-size: 36px; margin-bottom: .6rem; }

        /* SIDEBAR */
        .sidebar-section {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 1.2rem;
        }
        .sidebar-head {
            padding: .9rem 1.2rem;
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-100);
            font-size: 12px; font-weight: 600;
            color: var(--gray-600);
            display: flex; align-items: center; gap: 7px;
        }
        .sidebar-body { padding: 1rem 1.2rem; }

        /* Tabla info */
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table tr { border-bottom: 1px solid var(--gray-100); }
        .info-table tr:last-child { border-bottom: none; }
        .info-table td { padding: 9px 0; font-size: 12px; vertical-align: top; }
        .info-table .lbl { color: var(--gray-400); font-weight: 500; width: 46%; }
        .info-table .val { color: var(--gray-800); font-weight: 500; text-align: right; }

        /* Estado badge */
        .estado-pub {
            display: inline-flex; align-items: center; gap: 4px;
            background: var(--green-bg); color: var(--green-text);
            font-size: 11px; font-weight: 600;
            padding: 3px 9px; border-radius: 999px;
        }
        .dot-green {
            width: 6px; height: 6px; border-radius: 50%;
            background: #10b981; display: inline-block;
        }

        /* Autor card */
        .autor-card {
            display: flex; align-items: center; gap: 10px;
            padding: 12px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            margin-bottom: 10px;
            background: var(--gray-50);
        }
        .autor-av {
            width: 42px; height: 42px; border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 600; color: #fff; flex-shrink: 0;
        }
        .autor-name { font-size: 13px; font-weight: 600; color: var(--gray-800); }
        .autor-prof { font-size: 11px; color: var(--gray-400); margin-top: 2px; }
        .btn-see-profile {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            width: 100%; padding: 9px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            background: #fff; color: var(--gray-700);
            font-size: 12px; font-weight: 500;
            text-decoration: none; cursor: pointer;
            transition: all .15s;
        }
        .btn-see-profile:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

        /* Links */
        .link-row {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-100);
        }
        .link-row:last-child { border-bottom: none; }
        .link-icon {
            width: 32px; height: 32px; border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; flex-shrink: 0;
        }
        .link-icon.gh   { background: #f0f0f0; }
        .link-icon.demo { background: var(--blue-bg); }
        .link-info { flex: 1; overflow: hidden; }
        .link-lbl { font-size: 11px; color: var(--gray-400); }
        .link-url { font-size: 12px; color: var(--accent); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; }
        .btn-open {
            font-size: 10px; font-weight: 600;
            padding: 4px 10px; border-radius: var(--radius-sm);
            border: 1px solid var(--gray-200);
            background: #fff; color: var(--gray-700);
            cursor: pointer; text-decoration: none;
            transition: all .15s;
        }
        .btn-open:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

        /* Responsive */
        @media (max-width: 760px) {
            .main { grid-template-columns: 1fr; padding: 1rem; }
            .hero-body { grid-template-columns: 1fr; padding: 2rem 1.2rem 1.8rem; }
            .hero-actions { flex-direction: row; align-items: flex-start; }
            .hero-title { font-size: 26px; }
            .stats-bar-inner { flex-wrap: wrap; padding: 0 1rem; }
            .stat-cell { flex: 0 0 50%; border-right: none; border-bottom: 1px solid var(--gray-200); }
        }
    </style>
</head>
<body>

{{-- ══ HERO ══ --}}
<div class="hero">
    <div class="hero-pattern"></div>
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    {{-- Breadcrumb / volver --}}
    <div class="hero-topbar">
        <a href="{{ url('/portafolio/' . $portafolio->id) }}" class="back-btn">
            ← Volver al portafolio
        </a>
        <div class="breadcrumb">
            <span>{{ $usuario->nombre ?? $usuario->name }}</span>
            <span class="sep">/</span>
            <span>{{ $portafolio->nombre }}</span>
            <span class="sep">/</span>
            <span>{{ $proyecto->nombre }}</span>
        </div>
    </div>

    <div class="hero-body">
        <div>
            <div class="hero-icon-row">
                <div class="proj-icon-box">💻</div>
                <div class="hero-badges">
                    <span class="hbadge hbadge-pub">● Publicado</span>
                    <span class="hbadge hbadge-cat">📁 {{ $portafolio->nombre }}</span>
                </div>
            </div>

            <h1 class="hero-title">{{ $proyecto->nombre }}</h1>

            @if($proyecto->descripcion)
                <p class="hero-desc">{{ Str::limit($proyecto->descripcion, 200) }}</p>
            @endif

            <div class="hero-meta">
                <div class="hero-meta-item">
                    📎 Archivos: <strong>{{ $proyecto->archivos->count() }}</strong>
                </div>
                @if($proyecto->created_at)
                <div class="hero-meta-item">
                    📅 Creado: <strong>{{ $proyecto->created_at->format('M Y') }}</strong>
                </div>
                @endif
            </div>
        </div>

        <div class="hero-actions">
            @if($proyecto->deploy_url)
                <a href="{{ $proyecto->deploy_url }}" target="_blank" rel="noopener" class="btn-hero-primary">
                    🔗 Ver demo en vivo
                </a>
            @endif
            @if($proyecto->repositorio_url)
                <a href="{{ $proyecto->repositorio_url }}" target="_blank" rel="noopener" class="btn-hero-secondary">
                    &lt;/&gt; Ver repositorio
                </a>
            @endif
        </div>
    </div>
</div>

{{-- ══ STATS BAR ══ --}}
<div class="stats-bar">
    <div class="stats-bar-inner">
        <div class="stat-cell">
            <span class="stat-label">Estado</span>
            <span class="stat-value" style="color:#059669;">● Publicado</span>
        </div>
        <div class="stat-cell">
            <span class="stat-label">Portafolio</span>
            <span class="stat-value">{{ Str::limit($portafolio->nombre, 20) }}</span>
        </div>
        <div class="stat-cell">
            <span class="stat-label">Archivos adjuntos</span>
            <span class="stat-value">{{ $proyecto->archivos->count() }}</span>
        </div>
        <div class="stat-cell">
            <span class="stat-label">Otros proyectos</span>
            <span class="stat-value">{{ $otrosProyectos->count() }}</span>
        </div>
        @if($proyecto->created_at)
        <div class="stat-cell">
            <span class="stat-label">Creado</span>
            <span class="stat-value">{{ $proyecto->created_at->format('d M Y') }}</span>
        </div>
        @endif
    </div>
</div>

{{-- ══ MAIN ══ --}}
<div class="main">

    {{-- Columna principal --}}
    <div>

        {{-- Descripción --}}
        @if($proyecto->descripcion)
        <div class="section">
            <div class="section-head">
                <div class="section-head-icon">📋</div>
                <h2>Descripción del proyecto</h2>
            </div>
            <div class="section-body">
                <div class="desc-text">{{ $proyecto->descripcion }}</div>
            </div>
        </div>
        @endif

        {{-- Archivos adjuntos --}}
        <div class="section">
            <div class="section-head">
                <div class="section-head-icon">📎</div>
                <h2>Archivos adjuntos</h2>
                <span class="section-count">{{ $proyecto->archivos->count() }} archivos</span>
            </div>

            @if($proyecto->archivos->isEmpty())
                <div class="section-body">
                    <div class="empty-state">
                        <div class="empty-icon">📂</div>
                        Este proyecto no tiene archivos adjuntos.
                    </div>
                </div>
            @else
                <div style="padding: .5rem 0;">
                    <table class="file-table">
                        <thead>
                            <tr>
                                <th style="padding-left:1.4rem;">Nombre del archivo</th>
                                <th>Tamaño</th>
                                <th>Subido</th>
                                <th style="padding-right:1.4rem;text-align:right;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proyecto->archivos as $archivo)
                                @php
                                    $ext = strtolower(pathinfo($archivo->nombre_original, PATHINFO_EXTENSION));
                                    $extClass = in_array($ext, ['pdf','png','jpg','jpeg','zip','rar','xlsx','docx'])
                                        ? "ext-{$ext}"
                                        : 'ext-default';
                                    $tamano = $archivo->tamanio
                                        ? ($archivo->tamanio >= 1048576
                                            ? round($archivo->tamanio / 1048576, 1) . ' MB'
                                            : round($archivo->tamanio / 1024, 0) . ' KB')
                                        : '—';
                                @endphp
                                <tr>
                                    <td style="padding-left:1.4rem;">
                                        <div class="file-name-cell">
                                            <span class="ext-badge {{ $extClass }}">{{ strtoupper($ext) ?: 'FILE' }}</span>
                                            {{ $archivo->nombre_original }}
                                        </div>
                                    </td>
                                    <td><span class="file-size">{{ $tamano }}</span></td>
                                    <td><span class="file-size">{{ $archivo->created_at?->format('d M Y') ?? '—' }}</span></td>
                                    <td style="padding-right:1.4rem;text-align:right;">
                                        <a href="{{ asset('storage/' . $archivo->ruta) }}"
                                           download="{{ $archivo->nombre_original }}"
                                           class="btn-dl">
                                            ↓ Descargar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>{{-- fin columna principal --}}

    {{-- SIDEBAR --}}
    <div>

        {{-- Info general --}}
        <div class="sidebar-section">
            <div class="sidebar-head">📋 Información del proyecto</div>
            <div class="sidebar-body">
                <table class="info-table">
                    <tr>
                        <td class="lbl">Estado</td>
                        <td class="val">
                            <span class="estado-pub">
                                <span class="dot-green"></span> Publicado
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="lbl">Portafolio</td>
                        <td class="val">{{ Str::limit($portafolio->nombre, 22) }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Archivos</td>
                        <td class="val">{{ $proyecto->archivos->count() }}</td>
                    </tr>
                    @if($proyecto->created_at)
                    <tr>
                        <td class="lbl">Creado</td>
                        <td class="val">{{ $proyecto->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                    @if($proyecto->updated_at && $proyecto->updated_at->ne($proyecto->created_at))
                    <tr>
                        <td class="lbl">Actualizado</td>
                        <td class="val">{{ $proyecto->updated_at->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Autor --}}
        <div class="sidebar-section">
            <div class="sidebar-head">👤 Creado por</div>
            <div class="sidebar-body">
                @php
                    $nombreCompleto = $usuario->nombre ?? $usuario->name ?? 'Usuario';
                    $iniciales = collect(explode(' ', $nombreCompleto))
                        ->take(2)
                        ->map(fn($p) => strtoupper($p[0] ?? ''))
                        ->implode('');
                @endphp
                <div class="autor-card">
                    <div class="autor-av">{{ $iniciales }}</div>
                    <div>
                        <div class="autor-name">{{ $nombreCompleto }}</div>
                        @if(isset($usuario->email))
                        <div class="autor-prof">{{ $usuario->email }}</div>
                        @endif
                    </div>
                </div>
                <a href="{{ url('/portafolio/' . $portafolio->id) }}" class="btn-see-profile">
                    Ver portafolio completo →
                </a>
            </div>
        </div>

        {{-- Links del proyecto --}}
        @if($proyecto->repositorio_url || $proyecto->deploy_url)
        <div class="sidebar-section">
            <div class="sidebar-head">🔗 Links del proyecto</div>
            <div class="sidebar-body">
                @if($proyecto->repositorio_url)
                <div class="link-row">
                    <div class="link-icon gh">⬛</div>
                    <div class="link-info">
                        <div class="link-lbl">Repositorio</div>
                        <div class="link-url">{{ $proyecto->repositorio_url }}</div>
                    </div>
                    <a href="{{ $proyecto->repositorio_url }}" target="_blank" rel="noopener" class="btn-open">Abrir</a>
                </div>
                @endif
                @if($proyecto->deploy_url)
                <div class="link-row">
                    <div class="link-icon demo">🌐</div>
                    <div class="link-info">
                        <div class="link-lbl">Demo en vivo</div>
                        <div class="link-url">{{ $proyecto->deploy_url }}</div>
                    </div>
                    <a href="{{ $proyecto->deploy_url }}" target="_blank" rel="noopener" class="btn-open">Abrir</a>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Más proyectos del portafolio --}}
        @if($otrosProyectos->isNotEmpty())
        <div class="sidebar-section">
            <div class="sidebar-head">📁 Más proyectos</div>
            <div class="sidebar-body" style="padding: .5rem 0;">
                @foreach($otrosProyectos as $otro)
                <a href="{{ url('/proyecto/' . $otro->id) }}"
                   style="display:flex;align-items:center;gap:10px;padding:10px 1.2rem;border-bottom:1px solid var(--gray-100);text-decoration:none;transition:background .15s;"
                   onmouseover="this.style.background='var(--gray-50)'"
                   onmouseout="this.style.background=''">
                    <span style="font-size:20px;">📄</span>
                    <span style="font-size:12px;font-weight:500;color:var(--gray-700);flex:1;line-height:1.4;">
                        {{ $otro->nombre }}
                    </span>
                    <span style="font-size:10px;background:var(--green-bg);color:var(--green-text);padding:2px 7px;border-radius:999px;font-weight:600;">✓</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>{{-- fin sidebar --}}

</div>{{-- fin main --}}

</body>
</html>