{{-- ============================================================
     portafolio/publico.blade.php  — ventana independiente
     Route: GET /portafolio/{portafolio_id}  → portafolio.publico
     Variables: $portafolio (con ->usuario), $proyectos (collection)
     ============================================================ --}}

@php
    $u = $portafolio->usuario;

    /* ── Supabase URL helper ─────────────────────────────────────── */
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

    /* ── Detectar categoría por profesión ───────────────────────── */
    $prof = mb_strtolower($u->profesion ?? '');

    $categoria = match(true) {
        str_contains($prof, 'arquitect') || str_contains($prof, 'interior') || str_contains($prof, 'urban')
            => 'arquitectura',
        str_contains($prof, 'diseñ') || str_contains($prof, 'graphic') || str_contains($prof, 'illustr') || str_contains($prof, 'ux') || str_contains($prof, 'ui')
            => 'diseño',
        str_contains($prof, 'program') || str_contains($prof, 'sistem') || str_contains($prof, 'ingenier') || str_contains($prof, 'software') || str_contains($prof, 'developer') || str_contains($prof, 'fullstack') || str_contains($prof, 'backend') || str_contains($prof, 'frontend')
            => 'tecnologia',
        str_contains($prof, 'médic') || str_contains($prof, 'salud') || str_contains($prof, 'fisioterap') || str_contains($prof, 'odont') || str_contains($prof, 'enfermer') || str_contains($prof, 'nutri')
            => 'salud',
        str_contains($prof, 'contad') || str_contains($prof, 'financ') || str_contains($prof, 'economis') || str_contains($prof, 'consult') || str_contains($prof, 'auditor')
            => 'negocios',
        str_contains($prof, 'docen') || str_contains($prof, 'profes') || str_contains($prof, 'educat') || str_contains($prof, 'pedagog')
            => 'educacion',
        str_contains($prof, 'market') || str_contains($prof, 'mercado') || str_contains($prof, 'publicist') || str_contains($prof, 'comunicac')
            => 'marketing',
        str_contains($prof, 'fotograf') || str_contains($prof, 'video') || str_contains($prof, 'cinemat') || str_contains($prof, 'audiovisual')
            => 'audiovisual',
        default => 'general',
    };

    /* ── Paleta por categoría ────────────────────────────────────── */
    $temas = [
        'tecnologia' => [
            'accent'      => '#6366f1',
            'accent2'     => '#8b5cf6',
            'banner_from' => '#0f0f1a',
            'banner_to'   => '#1e1b4b',
            'badge_bg'    => '#ede9fe',
            'badge_text'  => '#4c1d95',
            'thumb_from'  => '#ede9fe',
            'thumb_to'    => '#dbeafe',
            'icon'        => '⚙️',
            'label'       => 'Tecnología & Desarrollo',
            'grid'        => 'masonry',
            'pattern'     => 'dots',
        ],
        'diseño' => [
            'accent'      => '#ec4899',
            'accent2'     => '#f97316',
            'banner_from' => '#1a0a17',
            'banner_to'   => '#3b0764',
            'badge_bg'    => '#fce7f3',
            'badge_text'  => '#9d174d',
            'thumb_from'  => '#fce7f3',
            'thumb_to'    => '#fef3c7',
            'icon'        => '🎨',
            'label'       => 'Diseño & Creatividad',
            'grid'        => 'gallery',
            'pattern'     => 'lines',
        ],
        'arquitectura' => [
            'accent'      => '#78716c',
            'accent2'     => '#a8a29e',
            'banner_from' => '#0c0a09',
            'banner_to'   => '#1c1917',
            'badge_bg'    => '#f5f5f4',
            'badge_text'  => '#44403c',
            'thumb_from'  => '#f5f5f4',
            'thumb_to'    => '#e7e5e4',
            'icon'        => '🏛️',
            'label'       => 'Arquitectura & Espacio',
            'grid'        => 'wide',
            'pattern'     => 'grid',
        ],
        'salud' => [
            'accent'      => '#10b981',
            'accent2'     => '#06b6d4',
            'banner_from' => '#022c22',
            'banner_to'   => '#065f46',
            'badge_bg'    => '#d1fae5',
            'badge_text'  => '#064e3b',
            'thumb_from'  => '#d1fae5',
            'thumb_to'    => '#cffafe',
            'icon'        => '🩺',
            'label'       => 'Salud & Bienestar',
            'grid'        => 'list',
            'pattern'     => 'circles',
        ],
        'negocios' => [
            'accent'      => '#3b82f6',
            'accent2'     => '#0ea5e9',
            'banner_from' => '#0a0f1e',
            'banner_to'   => '#1e3a5f',
            'badge_bg'    => '#dbeafe',
            'badge_text'  => '#1e3a8a',
            'thumb_from'  => '#dbeafe',
            'thumb_to'    => '#e0f2fe',
            'icon'        => '💼',
            'label'       => 'Negocios & Finanzas',
            'grid'        => 'list',
            'pattern'     => 'circles',
        ],
        'educacion' => [
            'accent'      => '#f59e0b',
            'accent2'     => '#fbbf24',
            'banner_from' => '#1c1200',
            'banner_to'   => '#451a03',
            'badge_bg'    => '#fef3c7',
            'badge_text'  => '#92400e',
            'thumb_from'  => '#fef3c7',
            'thumb_to'    => '#fde68a',
            'icon'        => '🎓',
            'label'       => 'Educación & Pedagogía',
            'grid'        => 'list',
            'pattern'     => 'dots',
        ],
        'marketing' => [
            'accent'      => '#f97316',
            'accent2'     => '#ef4444',
            'banner_from' => '#1c0a00',
            'banner_to'   => '#431407',
            'badge_bg'    => '#ffedd5',
            'badge_text'  => '#9a3412',
            'thumb_from'  => '#ffedd5',
            'thumb_to'    => '#fee2e2',
            'icon'        => '📣',
            'label'       => 'Marketing & Comunicación',
            'grid'        => 'gallery',
            'pattern'     => 'lines',
        ],
        'audiovisual' => [
            'accent'      => '#a855f7',
            'accent2'     => '#ec4899',
            'banner_from' => '#0d0010',
            'banner_to'   => '#2e1065',
            'badge_bg'    => '#f3e8ff',
            'badge_text'  => '#581c87',
            'thumb_from'  => '#f3e8ff',
            'thumb_to'    => '#fce7f3',
            'icon'        => '🎬',
            'label'       => 'Fotografía & Audiovisual',
            'grid'        => 'gallery',
            'pattern'     => 'lines',
        ],
        'general' => [
            'accent'      => '#2563eb',
            'accent2'     => '#0d9488',
            'banner_from' => '#0f172a',
            'banner_to'   => '#1e3a5f',
            'badge_bg'    => '#dbeafe',
            'badge_text'  => '#1e3a8a',
            'thumb_from'  => '#dbeafe',
            'thumb_to'    => '#ccfbf1',
            'icon'        => '📁',
            'label'       => 'Portafolio Profesional',
            'grid'        => 'masonry',
            'pattern'     => 'circles',
        ],
    ];

    $t = $temas[$categoria];

    $fotoUrl   = $sbUrl($u->foto_perfil ?? null);
    $bannerUrl = $sbUrl($portafolio->banner_ruta ?? null);
    $logoUrl   = $sbUrl($portafolio->logo_ruta ?? null);
    $imgExts   = ['jpg','jpeg','png','gif','webp','svg'];

    $gridClass = match($t['grid']) {
        'gallery' => 'pv-grid-gallery',
        'wide'    => 'pv-grid-wide',
        'list'    => 'pv-grid-list',
        default   => 'pv-grid-masonry',
    };
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portafolio->nombre }} · Portafolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --accent:      {{ $t['accent'] }};
            --accent2:     {{ $t['accent2'] }};
            --navy:        #0f172a;
            --gray:        #f1f5f9;
            --gray2:       #e2e8f0;
            --text:        #1e293b;
            --muted:       #64748b;
            --radius:      20px;
            --badge-bg:    {{ $t['badge_bg'] }};
            --badge-text:  {{ $t['badge_text'] }};
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f8fafc;
            color: var(--text);
            min-height: 100vh;
        }

        .shell {
            max-width: 980px;
            margin: 0 auto;
            padding: 1.5rem 1rem 5rem;
        }

        /* ── BANNER ── */
        .banner {
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
            min-height: 220px;
            background: linear-gradient(135deg, {{ $t['banner_from'] }} 0%, {{ $t['banner_to'] }} 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            margin-bottom: 1.2rem;
        }
        .banner-img {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; opacity: .32;
        }
        .banner-pattern {
            position: absolute; inset: 0; opacity: .06;
            width: 100%; height: 100%;
        }
        .banner-overlay {
            position: relative; z-index: 1;
            padding: 2rem 2rem 1.8rem;
            display: flex;
            align-items: flex-end;
            gap: 1.4rem;
            background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 100%);
        }
        .logo {
            width: 76px; height: 76px; border-radius: 18px;
            object-fit: cover; flex-shrink: 0;
            border: 2.5px solid rgba(255,255,255,0.2);
        }
        .logo-placeholder {
            width: 76px; height: 76px; border-radius: 18px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 800; color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            flex-shrink: 0;
            border: 2.5px solid rgba(255,255,255,0.15);
            box-shadow: 0 8px 24px rgba(0,0,0,0.35);
        }
        .banner-info { flex: 1; min-width: 0; }
        .banner-cat {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--accent);
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.14);
            padding: 3px 12px; border-radius: 999px;
            margin-bottom: 8px;
        }
        .banner-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 27px; font-weight: 800;
            color: #fff; line-height: 1.2; margin-bottom: 6px;
        }
        .banner-desc {
            font-size: 13.5px; color: rgba(255,255,255,0.68);
            line-height: 1.6; max-width: 520px;
        }
        .banner-meta {
            display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px;
        }
        .banner-tag {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12px; color: rgba(255,255,255,0.65);
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.11);
            padding: 4px 10px; border-radius: 999px;
            font-weight: 500; text-decoration: none;
            transition: background .2s;
        }
        .banner-tag:hover { background: rgba(255,255,255,0.14); }
        .banner-tag svg { width: 12px; height: 12px; flex-shrink: 0; }

        /* ── AUTOR ── */
        .autor {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid var(--gray2);
            padding: .9rem 1.4rem;
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 1.6rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .autor-avatar {
            width: 46px; height: 46px; border-radius: 50%;
            object-fit: cover; flex-shrink: 0;
            border: 2px solid var(--gray2);
        }
        .autor-initials {
            width: 46px; height: 46px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 800; color: #fff;
            flex-shrink: 0; font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .autor-info { flex: 1; min-width: 0; }
        .autor-nombre {
            font-size: 14px; font-weight: 700; color: var(--text);
            display: flex; align-items: center; flex-wrap: wrap; gap: 6px;
        }
        .autor-prof { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .cat-badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 700;
            background: var(--badge-bg); color: var(--badge-text);
            padding: 2px 9px; border-radius: 999px;
        }
        .btn-perfil {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border-radius: 999px;
            background: var(--gray); color: var(--text);
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            border: 1.5px solid var(--gray2);
            transition: all .2s; white-space: nowrap;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-perfil:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
        .btn-perfil svg { width: 13px; height: 13px; }

        /* ── SECTION LABEL ── */
        .section-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px; font-weight: 800;
            letter-spacing: .9px; text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 1.1rem;
            display: flex; align-items: center; gap: 8px;
        }
        .section-label::after {
            content: ''; flex: 1; height: 1px; background: var(--gray2);
        }
        .section-label svg { width: 15px; height: 15px; flex-shrink: 0; }

        /* ══ GRIDS ══ */
        .pv-grid-masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.2rem;
        }
        .pv-grid-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 1rem;
        }
        .pv-grid-gallery .proj-thumb { height: 200px; }
        .pv-grid-gallery .proj-body  { padding: .85rem 1rem 1rem; }

        .pv-grid-wide {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
        }
        .pv-grid-wide .proj-card:first-child       { grid-column: 1 / -1; }
        .pv-grid-wide .proj-card:first-child .proj-thumb { height: 300px; }
        .pv-grid-wide .proj-thumb { height: 210px; }

        .pv-grid-list { display: flex; flex-direction: column; gap: 1rem; }
        .pv-grid-list .proj-card { display: flex; flex-direction: row; }
        .pv-grid-list .proj-thumb {
            width: 200px; height: 148px; flex-shrink: 0;
            border-radius: 14px 0 0 14px;
        }
        .pv-grid-list .proj-body {
            flex: 1; padding: 1.1rem 1.4rem;
            display: flex; flex-direction: column; justify-content: center;
        }

        /* ── Tarjeta proyecto ── */
        .proj-card {
            background: #fff;
            border-radius: 18px;
            border: 1.5px solid var(--gray2);
            overflow: hidden;
            transition: all .25s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .proj-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(0,0,0,0.1);
            border-color: var(--accent);
        }
        .proj-thumb {
            height: 165px; overflow: hidden;
            background: linear-gradient(135deg, {{ $t['thumb_from'] }} 0%, {{ $t['thumb_to'] }} 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .proj-thumb img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .4s;
        }
        .proj-card:hover .proj-thumb img { transform: scale(1.06); }
        .proj-thumb-icon { font-size: 38px; opacity: .45; }

        .proj-body { padding: 1.1rem 1.2rem 1.2rem; }
        .proj-name {
            font-size: 15px; font-weight: 700; color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            line-height: 1.3; margin-bottom: 6px;
        }
        .proj-desc {
            font-size: 13px; color: var(--muted);
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 14px;
        }
        .proj-links { display: flex; gap: 8px; flex-wrap: wrap; }
        .proj-link {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 12px; border-radius: 8px;
            font-size: 12px; font-weight: 600;
            text-decoration: none; transition: all .18s;
        }
        .proj-link.repo {
            background: var(--gray); color: var(--text);
            border: 1.5px solid var(--gray2);
        }
        .proj-link.repo:hover { background: #1e293b; color: #fff; border-color: #1e293b; }
        .proj-link.demo {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .proj-link.demo:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.22); transform: translateY(-1px); }
        .proj-link svg { width: 12px; height: 12px; }

        .proj-files { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
        .file-chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 8px;
            font-size: 11.5px; font-weight: 600;
            background: var(--badge-bg); color: var(--badge-text);
            border: 1px solid rgba(0,0,0,.06);
            text-decoration: none; transition: opacity .15s;
        }
        .file-chip:hover { opacity: .75; }
        .file-chip svg { width: 11px; height: 11px; }

        .estado {
            display: inline-block; padding: 3px 10px; border-radius: 999px;
            font-size: 10px; font-weight: 700; letter-spacing: .5px;
            text-transform: uppercase; margin-bottom: 8px;
        }
        .estado.publicado { background: #dcfce7; color: #15803d; }
        .estado.borrador  { background: #fef9c3; color: #92400e; }
        .estado.archivado { background: var(--gray); color: var(--muted); }

        .empty { text-align: center; padding: 3rem 1rem; color: var(--muted); font-size: 14px; }
        .empty-icon { font-size: 44px; margin-bottom: 12px; }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .pv-grid-masonry,
            .pv-grid-gallery,
            .pv-grid-wide { grid-template-columns: 1fr; }
            .pv-grid-wide .proj-card:first-child { grid-column: auto; }
            .pv-grid-wide .proj-card:first-child .proj-thumb { height: 200px; }
            .pv-grid-list .proj-card { flex-direction: column; }
            .pv-grid-list .proj-thumb { width: 100%; border-radius: 14px 14px 0 0; }
            .banner-overlay { flex-direction: column; align-items: flex-start; padding: 1.4rem; }
            .banner-title   { font-size: 21px; }
            .autor          { flex-wrap: wrap; }
            .btn-perfil     { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="shell">

    {{-- ══ BANNER ══ --}}
    <div class="banner">

        @if($bannerUrl)
            <img class="banner-img" src="{{ $bannerUrl }}" alt="{{ $portafolio->nombre }}">
        @else
            <svg class="banner-pattern" xmlns="http://www.w3.org/2000/svg"
                 preserveAspectRatio="xMidYMid slice" viewBox="0 0 980 220">
                <defs>
                    @if($t['pattern'] === 'dots')
                        <pattern id="pat" width="30" height="30" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.5" fill="white"/>
                        </pattern>
                    @elseif($t['pattern'] === 'lines')
                        <pattern id="pat" width="40" height="40" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                            <line x1="0" y1="0" x2="0" y2="40" stroke="white" stroke-width="1"/>
                        </pattern>
                    @elseif($t['pattern'] === 'grid')
                        <pattern id="pat" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width=".8"/>
                        </pattern>
                    @endif
                </defs>
                @if(in_array($t['pattern'], ['dots','lines','grid']))
                    <rect width="100%" height="100%" fill="url(#pat)"/>
                @else
                    <circle cx="870" cy="40"  r="180" fill="none" stroke="white" stroke-width=".7"/>
                    <circle cx="870" cy="40"  r="120" fill="none" stroke="white" stroke-width=".7"/>
                    <circle cx="870" cy="40"  r="60"  fill="none" stroke="white" stroke-width=".7"/>
                    <circle cx="100" cy="210" r="130" fill="none" stroke="white" stroke-width=".7"/>
                    <circle cx="100" cy="210" r="80"  fill="none" stroke="white" stroke-width=".7"/>
                @endif
            </svg>
        @endif

        <div class="banner-overlay">
            @if($logoUrl)
                <img class="logo" src="{{ $logoUrl }}" alt="Logo">
            @else
                <div class="logo-placeholder">
                    {{ strtoupper(substr($portafolio->nombre, 0, 1)) }}
                </div>
            @endif

            <div class="banner-info">
                <div class="banner-cat">{{ $t['icon'] }} {{ $t['label'] }}</div>
                <div class="banner-title">{{ $portafolio->nombre }}</div>
                @if($portafolio->descripcion)
                    <div class="banner-desc">{{ $portafolio->descripcion }}</div>
                @endif
                <div class="banner-meta">
                    @if($portafolio->repositorio_url)
                        <a href="{{ $portafolio->repositorio_url }}" target="_blank" rel="noopener"
                           class="banner-tag" style="color:rgba(255,255,255,0.82)">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                            Repositorio
                        </a>
                    @endif
                    <span class="banner-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        {{ $proyectos->count() }} {{ $proyectos->count() == 1 ? 'proyecto' : 'proyectos' }}
                    </span>
                    <span class="banner-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ \Carbon\Carbon::parse($portafolio->created_at)->translatedFormat('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ AUTOR ══ --}}
    @if($u)
        <div class="autor">
            @if($fotoUrl)
                <img class="autor-avatar" src="{{ $fotoUrl }}" alt="{{ $u->nombre }}">
            @else
                <div class="autor-initials">
                    {{ strtoupper(substr($u->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($u->apellido ?? '', 0, 1)) }}
                </div>
            @endif
            <div class="autor-info">
                <div class="autor-nombre">
                    {{ $u->nombre }} {{ $u->apellido }}
                    <span class="cat-badge">{{ $t['icon'] }} {{ $t['label'] }}</span>
                </div>
                @if($u->profesion)
                    <div class="autor-prof">{{ $u->profesion }}</div>
                @endif
            </div>
            <a href="{{ route('perfil.publico', $u->id) }}"
               target="_blank" rel="noopener"
               class="btn-perfil">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Ver perfil
            </a>
        </div>
    @endif

    {{-- ══ PROYECTOS ══ --}}
    <div class="section-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
        Proyectos
    </div>

    @if($proyectos->count())
        <div class="{{ $gridClass }}">
            @foreach($proyectos as $proj)
                @php
                    $imgFile = $proj->archivos->first(fn($a) =>
                        in_array(strtolower(pathinfo($a->nombre_original, PATHINFO_EXTENSION)), $imgExts)
                    );
                    $imgSrc    = $imgFile ? $sbUrl($imgFile->ruta) : null;
                    $descFiles = $proj->archivos->filter(fn($a) =>
                        !in_array(strtolower(pathinfo($a->nombre_original, PATHINFO_EXTENSION)), $imgExts)
                    );
                @endphp

                <div class="proj-card">
                    <div class="proj-thumb">
                        @if($imgSrc)
                            <img src="{{ $imgSrc }}" alt="{{ $proj->nombre }}">
                        @else
                            <div class="proj-thumb-icon">{{ $t['icon'] }}</div>
                        @endif
                    </div>

                    <div class="proj-body">
                        @if($proj->estado !== 'publicado')
                            <div class="estado {{ $proj->estado }}">{{ ucfirst($proj->estado) }}</div>
                        @endif

                        <div class="proj-name">{{ $proj->nombre }}</div>
                        <div class="proj-desc">{{ $proj->descripcion }}</div>
                        <div class="proj-links">
                            @if($proj->repositorio_url)
                                <a href="{{ $proj->repositorio_url }}" target="_blank" rel="noopener"
                                   class="proj-link repo">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="13" height="13"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                                    GitHub
                                </a>
                            @endif
                            @if($proj->deploy_url)
                                <a href="{{ $proj->deploy_url }}" target="_blank" rel="noopener"
                                   class="proj-link demo">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="13" height="13"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    Demo
                                </a>
                            @endif
                        </div>
 
                        {{-- ✅ BOTÓN NUEVO: Ver detalle del proyecto --}}
                        <a href="{{ route('proyecto.publico', $proj->id) }}"
                           class="proj-link-detalle">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                 stroke-linecap="round" stroke-linejoin="round" width="13" height="13">
                                <rect x="2" y="3" width="20" height="14" rx="2"/>
                                <path d="M8 21h8m-4-4v4"/>
                            </svg>
                            Ver detalle completo
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                 stroke-linecap="round" stroke-linejoin="round" width="11" height="11"
                                 style="margin-left:auto;">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>

                        @if($descFiles->count())
                            <div class="proj-files">
                                @foreach($descFiles as $f)
                                    <a href="{{ $sbUrl($f->ruta) }}"
                                       target="_blank" rel="noopener"
                                       class="file-chip"
                                       download="{{ $f->nombre_original }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        {{ \Illuminate\Support\Str::limit($f->nombre_original, 22) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="empty">
            <div class="empty-icon">{{ $t['icon'] }}</div>
            Este portafolio aún no tiene proyectos publicados.
        </div>
    @endif

</div>

</body>
</html>
<style>
.proj-link-detalle {
    display: flex;
    align-items: center;
    gap: 6px;
    width: 100%;
    margin-top: 10px;
    padding: 9px 12px;
    border-radius: 12px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: all .25s;
    box-shadow: 0 2px 10px rgba(99,102,241,.3);
}
.proj-link-detalle:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    box-shadow: 0 4px 16px rgba(99,102,241,.45);
    transform: translateY(-1px);
}
</style>