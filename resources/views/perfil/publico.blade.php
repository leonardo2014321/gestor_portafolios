{{-- ============================================================
     perfil/publico.blade.php
     Vista standalone — SIN navbar ni footer.
     Route: GET /perfil/{usuario_id}  → name: perfil.publico
     Controller: PerfilPublicoController@show
     ============================================================ --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($usuario->nombre ?? '') . ' ' . ($usuario->apellido ?? '') }} · Perfil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f0f4f8;
            font-family: 'DM Sans', sans-serif;
            color: #1e293b;
            min-height: 100vh;
        }

        :root {
            --pp-navy:   #0f172a;
            --pp-blue:   #2563eb;
            --pp-blue2:  #3b82f6;
            --pp-teal:   #0d9488;
            --pp-gray:   #f0f4f8;
            --pp-gray2:  #e2e8f0;
            --pp-text:   #1e293b;
            --pp-muted:  #64748b;
            --pp-radius: 20px;
        }

        /* ── Shell ── */
        .pp-shell {
            max-width: 960px;
            margin: 0 auto;
            padding: 2rem 1rem 4rem;
        }

        /* ── Hero ── */
        .pp-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0d4f4a 100%);
            border-radius: var(--pp-radius);
            padding: 2.5rem 2rem 2rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.2rem;
        }
        .pp-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .pp-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(37,99,235,0.15);
        }
        .pp-hero-inner {
            display: flex;
            align-items: flex-start;
            gap: 1.8rem;
            position: relative;
            z-index: 1;
        }
        .pp-avatar-wrap { position: relative; flex-shrink: 0; }
        .pp-avatar {
            width: 96px; height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.25);
        }
        .pp-avatar-initials {
            width: 96px; height: 96px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #0d9488);
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; font-weight: 800; color: #fff;
            border: 3px solid rgba(255,255,255,0.2);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .pp-hero-info { flex: 1; min-width: 0; }
        .pp-nombre {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 24px; font-weight: 800;
            color: #fff; line-height: 1.2; margin-bottom: 4px;
        }
        .pp-profesion {
            font-size: 14px; color: rgba(255,255,255,0.75);
            font-weight: 500; margin-bottom: 12px;
        }

        /* Redes en el hero */
        .pp-redes-row { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
        .pp-red-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 999px;
            font-size: 12px; font-weight: 600; text-decoration: none;
            transition: all .2s;
            border: 1.5px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.9);
            backdrop-filter: blur(4px);
        }
        .pp-red-badge:hover { background: rgba(255,255,255,0.18); transform: translateY(-1px); }
        .pp-red-badge svg { width: 13px; height: 13px; flex-shrink: 0; }

        /* Stats */
        .pp-stats { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; }
        .pp-stat { display: flex; align-items: center; gap: 5px; font-size: 12px; color: rgba(255,255,255,0.65); font-weight: 500; }
        .pp-stat svg { width: 13px; height: 13px; }

        /* Botón contactar */
        .pp-cta {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 26px; border-radius: 999px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff; font-size: 14px; font-weight: 700;
            text-decoration: none; transition: all .2s;
            box-shadow: 0 4px 14px rgba(37,99,235,0.3);
            font-family: 'DM Sans', sans-serif;
            border: none; cursor: pointer; white-space: nowrap;
        }
        .pp-cta:hover { box-shadow: 0 6px 20px rgba(37,99,235,0.45); transform: translateY(-1px); }
        .pp-cta svg { width: 16px; height: 16px; }

        /* Cards genéricas */
        .pp-bio-card {
            background: #fff; border-radius: var(--pp-radius);
            padding: 1.4rem 1.6rem; border: 1.5px solid var(--pp-gray2);
            margin-bottom: 1.2rem;
        }
        .pp-card {
            background: #fff; border-radius: var(--pp-radius);
            padding: 1.4rem 1.6rem; border: 1.5px solid var(--pp-gray2);
        }
        .pp-section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; font-weight: 800; letter-spacing: .8px;
            text-transform: uppercase; color: var(--pp-muted);
            margin-bottom: .9rem;
            display: flex; align-items: center; gap: 8px;
        }
        .pp-section-title::after { content: ''; flex: 1; height: 1px; background: var(--pp-gray2); }
        .pp-section-title svg { width: 15px; height: 15px; flex-shrink: 0; }
        .pp-bio-text { font-size: 14px; color: var(--pp-text); line-height: 1.75; white-space: pre-wrap; word-break: break-word; }

        /* Cols */
        .pp-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem; }

        /* Habilidades */
        .pp-skills-wrap { display: flex; flex-wrap: wrap; gap: 8px; }
        .pp-skill { display: inline-flex; align-items: center; gap: 6px; padding: 5px 13px; border-radius: 999px; font-size: 12.5px; font-weight: 600; }
        .pp-skill.fuerte { background: #dbeafe; color: #1d4ed8; }
        .pp-skill.blanda { background: #ccfbf1; color: #0f766e; }
        .pp-skill-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .pp-skill.fuerte .pp-skill-dot { background: #3b82f6; }
        .pp-skill.blanda .pp-skill-dot { background: #0d9488; }

        /* Timeline */
        .pp-timeline { display: flex; flex-direction: column; gap: .9rem; }
        .pp-tl-item { display: flex; gap: 12px; align-items: flex-start; }
        .pp-tl-dot-col { display: flex; flex-direction: column; align-items: center; padding-top: 5px; }
        .pp-tl-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--pp-blue); flex-shrink: 0; border: 2px solid #dbeafe; }
        .pp-tl-line { width: 2px; flex: 1; background: var(--pp-gray2); min-height: 24px; margin-top: 4px; }
        .pp-tl-item:last-child .pp-tl-line { display: none; }
        .pp-tl-body { flex: 1; min-width: 0; padding-bottom: 6px; }
        .pp-tl-title { font-size: 13.5px; font-weight: 700; color: var(--pp-text); line-height: 1.3; }
        .pp-tl-sub { font-size: 12.5px; color: var(--pp-blue); font-weight: 600; margin-top: 2px; }
        .pp-tl-date { font-size: 11.5px; color: var(--pp-muted); margin-top: 3px; display: flex; align-items: center; gap: 4px; }
        .pp-tl-desc { font-size: 12.5px; color: var(--pp-muted); margin-top: 5px; line-height: 1.6; }

        /* Certificaciones */
        .pp-cert-list { display: flex; flex-direction: column; gap: .75rem; }
        .pp-cert-item { background: var(--pp-gray); border-radius: 12px; padding: .85rem 1rem; display: flex; align-items: flex-start; gap: 12px; }
        .pp-cert-icon { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .pp-cert-icon svg { width: 17px; height: 17px; }
        .pp-cert-name { font-size: 13px; font-weight: 700; color: var(--pp-text); }
        .pp-cert-org { font-size: 12px; color: var(--pp-muted); margin-top: 2px; }

        /* Portafolios */
        .pp-porta-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.2rem; }
        .pp-porta-card { background: #fff; border: 1.5px solid var(--pp-gray2); border-radius: 16px; overflow: hidden; transition: all .25s; text-decoration: none; display: block; }
        .pp-porta-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,0.1); border-color: var(--pp-blue2); }
        .pp-porta-banner { height: 120px; object-fit: cover; width: 100%; background: linear-gradient(135deg, #dbeafe, #ccfbf1); }
        .pp-porta-info { padding: .9rem 1rem; }
        .pp-porta-name { font-size: 13.5px; font-weight: 700; color: var(--pp-text); }
        .pp-porta-desc { font-size: 12px; color: var(--pp-muted); margin-top: 4px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        /* Empty */
        .pp-empty { font-size: 13px; color: var(--pp-muted); font-style: italic; padding: .5rem 0; }

        /* Responsive */
        @media (max-width: 640px) {
            .pp-cols { grid-template-columns: 1fr; }
            .pp-hero-inner { flex-direction: column; align-items: center; text-align: center; }
            .pp-redes-row, .pp-stats { justify-content: center; }
            .pp-hero { padding: 1.8rem 1.2rem; }
        }
    </style>
</head>
<body>

@php
    $supabaseBase = rtrim(config('services.supabase.url'), '/')
                  . '/storage/v1/object/public/'
                  . config('services.supabase.bucket');

    $supabaseUrl = function(?string $path) use ($supabaseBase): ?string {
        if (!$path) return null;
        return str_starts_with($path, 'http')
            ? $path
            : $supabaseBase . '/' . ltrim($path, '/');
    };

    $fotoUrl = $supabaseUrl($usuario->foto_perfil);
@endphp

<div class="pp-shell">

    {{-- ── HERO ── --}}
    <div class="pp-hero">
        <div class="pp-hero-inner">

            <div class="pp-avatar-wrap">
                @if($fotoUrl)
                    <img class="pp-avatar" src="{{ $fotoUrl }}" alt="{{ $usuario->nombre }}">
                @else
                    <div class="pp-avatar-initials">
                        {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($usuario->apellido ?? '', 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="pp-hero-info">
                <div class="pp-nombre">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                @if($usuario->profesion)
                    <div class="pp-profesion">{{ $usuario->profesion }}</div>
                @endif

                <div class="pp-stats">
                    @if($experiencias->count())
                        <div class="pp-stat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                            {{ $experiencias->count() }} {{ trans_choice('app.perfil_publico.stat_experiencia', $experiencias->count()) }}
                        </div>
                    @endif
                    @if($habilidades->count())
                        <div class="pp-stat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            {{ $habilidades->count() }} {{ __('app.perfil_publico.stat_habilidades') }}
                        </div>
                    @endif
                    @if($portafolios->count())
                        <div class="pp-stat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                            {{ $portafolios->count() }} {{ trans_choice('app.perfil_publico.stat_portafolio', $portafolios->count()) }}
                        </div>
                    @endif
                </div>

                @if($redes->count())
                    <div class="pp-redes-row">
                        @foreach($redes as $red)
                            @php
                                $redMeta = [
                                    'linkedin'  => 'LinkedIn',
                                    'github'    => 'GitHub',
                                    'twitter'   => 'Twitter/X',
                                    'facebook'  => 'Facebook',
                                    'instagram' => 'Instagram',
                                    'tiktok'    => 'TikTok',
                                ];
                                $label = $redMeta[$red->tipo] ?? ucfirst($red->tipo);
                            @endphp
                            <a href="{{ $red->url }}" target="_blank" rel="noopener" class="pp-red-badge">
                                @if($red->tipo === 'linkedin')
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                @elseif($red->tipo === 'github')
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                                @elseif($red->tipo === 'twitter')
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.91-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                @elseif($red->tipo === 'facebook')
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                @elseif($red->tipo === 'instagram')
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                                @elseif($red->tipo === 'tiktok')
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                @endif
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div style="flex-shrink:0;">
                <a href="mailto:{{ $usuario->email }}" class="pp-cta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    {{ __('app.perfil_publico.btn_contactar') }}
                </a>
            </div>
        </div>
    </div>

    {{-- ── SOBRE MÍ ── --}}
    @if($usuario->biografia)
        <div class="pp-bio-card">
            <div class="pp-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                {{ __('app.perfil_publico.seccion_sobre_mi') }}
            </div>
            <div class="pp-bio-text">{{ $usuario->biografia }}</div>
        </div>
    @endif

    {{-- ── HABILIDADES + CERTIFICACIONES ── --}}
    <div class="pp-cols">
        <div class="pp-card">
            <div class="pp-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                {{ __('app.perfil_publico.seccion_habilidades') }}
            </div>
            @if($habilidades->count())
                <div class="pp-skills-wrap">
                    @foreach($habilidades as $h)
                        <span class="pp-skill {{ $h->tipo }}">
                            <span class="pp-skill-dot"></span>
                            {{ $h->nombre }}
                        </span>
                    @endforeach
                </div>
                @php $blandas = $habilidades->where('tipo','blanda')->count(); @endphp
                @if($blandas)
                    <div style="margin-top:10px;font-size:11.5px;color:var(--pp-muted);">
                        <span style="color:#3b82f6;font-weight:700;">●</span> {{ __('app.perfil_publico.leyenda_dominadas') }} &nbsp;
                        <span style="color:#f59e0b;font-weight:700;">●</span> {{ __('app.perfil_publico.leyenda_en_aprendizaje') }}
                    </div>
                @endif
            @else
                <div class="pp-empty">{{ __('app.perfil_publico.empty_habilidades') }}</div>
            @endif
        </div>

        <div class="pp-card">
            <div class="pp-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                {{ __('app.perfil_publico.seccion_certificaciones') }}
            </div>
            @if($certificaciones->count())
                <div class="pp-cert-list">
                    @foreach($certificaciones as $c)
                        <div class="pp-cert-item">
                            <div class="pp-cert-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                            </div>
                            <div class="pp-cert-body">
                                <div class="pp-cert-name">{{ $c->nombre }}</div>
                                @if($c->organizacion)
                                    <div class="pp-cert-org">{{ $c->organizacion }}
                                        @if($c->fecha_obtencion) · {{ \Carbon\Carbon::parse($c->fecha_obtencion)->format('M Y') }} @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pp-empty">{{ __('app.perfil_publico.empty_certificaciones') }}</div>
            @endif
        </div>
    </div>

    {{-- ── EXPERIENCIA + FORMACIÓN ── --}}
    <div class="pp-cols">
        <div class="pp-card">
            <div class="pp-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                {{ __('app.perfil_publico.seccion_experiencia') }}
            </div>
            @if($experiencias->count())
                <div class="pp-timeline">
                    @foreach($experiencias as $exp)
                        <div class="pp-tl-item">
                            <div class="pp-tl-dot-col">
                                <div class="pp-tl-dot"></div>
                                <div class="pp-tl-line"></div>
                            </div>
                            <div class="pp-tl-body">
                                <div class="pp-tl-title">{{ $exp->cargo }}</div>
                                <div class="pp-tl-sub">{{ $exp->empresa }}</div>
                                <div class="pp-tl-date">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ \Carbon\Carbon::parse($exp->fecha_inicio)->format('M Y') }} –
                                    {{ $exp->actual ? __('app.perfil_publico.actualidad') : ($exp->fecha_fin ? \Carbon\Carbon::parse($exp->fecha_fin)->format('M Y') : '') }}
                                </div>
                                @if($exp->descripcion)
                                    <div class="pp-tl-desc">{{ \Illuminate\Support\Str::limit($exp->descripcion, 120) }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pp-empty">{{ __('app.perfil_publico.empty_experiencia') }}</div>
            @endif
        </div>

        <div class="pp-card">
            <div class="pp-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                {{ __('app.perfil_publico.seccion_formacion') }}
            </div>
            @if($formaciones->count())
                <div class="pp-timeline">
                    @foreach($formaciones as $f)
                        <div class="pp-tl-item">
                            <div class="pp-tl-dot-col">
                                <div class="pp-tl-dot" style="background:#0d9488;border-color:#ccfbf1;"></div>
                                <div class="pp-tl-line"></div>
                            </div>
                            <div class="pp-tl-body">
                                <div class="pp-tl-title">{{ $f->titulo ?? $f->nivel }}</div>
                                <div class="pp-tl-sub" style="color:#0d9488;">{{ $f->institucion }}</div>
                                <div class="pp-tl-date">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ \Carbon\Carbon::parse($f->fecha_inicio)->format('Y') }}
                                    @if($f->fecha_fin) – {{ \Carbon\Carbon::parse($f->fecha_fin)->format('Y') }} @endif
                                </div>
                                @if($f->nivel && $f->titulo)
                                    <div class="pp-tl-desc">{{ $f->nivel }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pp-empty">{{ __('app.perfil_publico.empty_formacion') }}</div>
            @endif
        </div>
    </div>

    {{-- ── PORTAFOLIOS ── --}}
    @if($portafolios->count())
        <div class="pp-card" style="margin-bottom:1.2rem;">
            <div class="pp-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                {{ __('app.perfil_publico.seccion_portafolios') }}
            </div>
            <div class="pp-porta-grid">
                @foreach($portafolios as $p)
                    <a href="{{ route('portafolio.publico', $p->id) }}" target="_blank" rel="noopener" class="pp-porta-card">
                        @if($p->banner_ruta)
                            <img class="pp-porta-banner" src="{{ $supabaseUrl($p->banner_ruta) }}" alt="{{ $p->nombre }}">
                        @else
                            <div class="pp-porta-banner" style="display:flex;align-items:center;justify-content:center;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                            </div>
                        @endif
                        <div class="pp-porta-info">
                            <div class="pp-porta-name">{{ $p->nombre }}</div>
                            @if($p->descripcion)
                                <div class="pp-porta-desc">{{ $p->descripcion }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

</body>
</html>