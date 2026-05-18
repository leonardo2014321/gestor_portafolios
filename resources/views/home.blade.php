<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SansiFolios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @include('_styles_menu')

    <style>
        /* ── Reset específico del home (sobreescribe lo del menú) ── */
        html, body {
            height: auto !important;
            overflow: auto !important;
            background: #f5f5f5;
        }

        /* ── SPA vistas: idéntico al original, sin tocar ── */
        .spa-view        { display: none; }
        .spa-view.active { display: block; }

        /* ── Topbar del home (sticky) ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
        }

        /* ── Las vistas del menú incluidas en el home necesitan scroll ── */
        #view-caracteristicas,
        #view-portafolios,
        #view-explorador {
            min-height: 100vh;
            overflow-y: auto;
            padding: 1.6rem 1.8rem;
            background: #f1f5f9;
        }

        /* ── El explorador necesita su padding propio ── */
        #view-explorador {
            padding: 1.6rem 1.8rem;
        }

        /* ── Spinner logout ── */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* ══════════════════════════════════════
           HERO
        ══════════════════════════════════════ */
        .home-hero-section {
            padding: 5rem 0 4rem;
            background: #f8faff;
            position: relative;
            overflow: hidden;
        }
        .home-hero-section::before {
            content: '';
            position: absolute;
            top: -140px; right: -80px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .home-hero-section::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -40px;
            width: 360px; height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(219,39,119,.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #eef2ff;
            border: 1.5px solid #c7d2fe;
            color: #4f46e5;
            font-family: 'DM Sans', sans-serif;
            font-size: 11.5px;
            font-weight: 700;
            padding: 5px 14px 5px 8px;
            border-radius: 999px;
            margin-bottom: 1.2rem;
        }
        .hero-pill-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #6366f1;
            animation: pillPulse 2s ease infinite;
        }
        @keyframes pillPulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.4; transform:scale(.65); }
        }

        .hero-cta-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #2563eb;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 700;
            padding: 13px 26px;
            border-radius: 14px;
            border: none; cursor: pointer;
            box-shadow: 0 4px 18px rgba(37,99,235,.32);
            transition: background .2s, transform .2s, box-shadow .2s;
            text-decoration: none;
        }
        .hero-cta-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 26px rgba(37,99,235,.42);
        }
        .hero-cta-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #fff;
            color: #374151;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 600;
            padding: 13px 26px;
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            transition: border-color .2s, color .2s, transform .2s, box-shadow .2s;
            text-decoration: none;
        }
        .hero-cta-secondary:hover {
            border-color: #2563eb; color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0,0,0,.06);
        }

        .hero-tags {
            display: flex; align-items: center;
            gap: 8px; flex-wrap: wrap;
            margin-top: 1.4rem;
        }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 5px;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px; font-weight: 600;
            color: #64748b; background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 5px 12px; border-radius: 999px;
            cursor: pointer; transition: all .18s;
        }
        .hero-tag:hover { background: #e0e7ff; border-color: #a5b4fc; color: #4f46e5; }

        .hero-img {
            border-radius: 1.5rem;
            box-shadow: 0 24px 64px rgba(0,0,0,.13), 0 0 0 1px rgba(0,0,0,.04);
        }

        /* ── Título hero: "Sin Límites." degradado azul-violeta nítido ── */
        .hero-title-glow {
            background: linear-gradient(100deg, #1d4ed8 0%, #60a5fa 50%, #1d4ed8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% auto;
            animation: shimmerBlue 8s ease-in-out infinite;
        }
        @keyframes shimmerBlue {
            0%   { background-position: 0% center; }
            50%  { background-position: 100% center; }
            100% { background-position: 0% center; }
        }

        /* ── Footer estático en el home (las otras vistas lo manejan por su propio layout) ── */
        footer, [class*="footer"] {
            position: static !important;
            bottom: auto !important;
        }
        body { padding-bottom: 0; }

        /* ══════════════════════════════════════
           TARJETAS BENTO — glassmorphism integrado
        ══════════════════════════════════════ */
        .bento-section {
            padding: 6rem 1.5rem;
            background: linear-gradient(145deg, #0f0320 0%, #3b0764 30%, #6b21a8 55%, #9d174d 78%, #db2777 100%);
            position: relative;
            overflow: hidden;
        }
        /* Orbes de ambiente */
        .bento-section::before {
            content: '';
            position: absolute; top: -120px; right: -80px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(251,113,133,.20) 0%, transparent 65%);
            pointer-events: none;
        }
        .bento-section::after {
            content: '';
            position: absolute; bottom: -80px; left: 5%;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,.22) 0%, transparent 65%);
            pointer-events: none;
        }
        /* Orbe extra al centro */
        .bento-orb-center {
            position: absolute; top: 40%; left: 50%;
            transform: translate(-50%, -50%);
            width: 700px; height: 700px; border-radius: 50%;
            background: radial-gradient(circle, rgba(219,39,119,.08) 0%, transparent 60%);
            pointer-events: none;
        }

        .bento-inner { max-width: 1120px; margin: 0 auto; position: relative; z-index: 1; }

        .bento-header { text-align: center; margin-bottom: 3.5rem; }
        .bento-eyebrow {
            display: inline-flex; align-items: center; gap: 7px;
            font-family: 'DM Sans', sans-serif; font-size: 11px;
            font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
            color: rgba(255,255,255,.5); margin-bottom: 1rem;
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12);
            padding: 6px 14px; border-radius: 999px;
        }
        .bento-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(1.7rem, 3.5vw, 2.5rem);
            font-weight: 800; color: #fff; line-height: 1.15;
        }
        .bento-sub {
            margin-top: .65rem; font-family: 'DM Sans', sans-serif;
            font-size: 14.5px; color: rgba(255,255,255,.45); letter-spacing: .2px;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-auto-rows: auto;
            gap: 1.1rem;
        }
        /* Fila 1 */
        .bc-slot-1 { grid-column: span 4; }
        .bc-slot-2 { grid-column: span 2; }
        /* Fila 2 */
        .bc-slot-3 { grid-column: span 2; }
        .bc-slot-4 { grid-column: span 2; }
        .bc-slot-5 { grid-column: span 2; }
        /* Fila 3 */
        .bc-slot-6 { grid-column: span 2; }
        .bc-slot-7 { grid-column: span 4; }

        @media (max-width: 860px) {
            .bento-grid { grid-template-columns: 1fr; }
            .bc-slot-1, .bc-slot-2, .bc-slot-3,
            .bc-slot-4, .bc-slot-5, .bc-slot-6, .bc-slot-7 { grid-column: 1; }
        }

        /* ── Card base: vidrio oscuro con tinte de color ── */
        .bc {
            border-radius: 1.6rem;
            padding: 1.8rem;
            position: relative; overflow: hidden;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: transform .28s cubic-bezier(.34,1.56,.64,1), box-shadow .28s ease;
            cursor: default;
        }
        /* Brillo interno sutil en cada card */
        .bc::before {
            content: '';
            position: absolute; inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(255,255,255,.10) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .bc > * { position: relative; z-index: 1; }

        .bc:hover { transform: translateY(-8px) scale(1.01); }

        /* Paleta glassmorphism por color */
        .bc-rose    {
            background: linear-gradient(135deg, rgba(225,29,72,.22) 0%, rgba(159,18,57,.14) 100%);
            border: 1px solid rgba(253,164,175,.30);
            box-shadow: 0 0 0 1px rgba(253,164,175,.10), 0 8px 40px rgba(225,29,72,.22), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .bc-rose:hover    { box-shadow: 0 0 0 1px rgba(253,164,175,.40), 0 24px 60px rgba(225,29,72,.38), inset 0 1px 0 rgba(255,255,255,.16); }

        .bc-violet  {
            background: linear-gradient(135deg, rgba(124,58,237,.25) 0%, rgba(91,33,182,.16) 100%);
            border: 1px solid rgba(196,181,253,.28);
            box-shadow: 0 0 0 1px rgba(196,181,253,.10), 0 8px 40px rgba(124,58,237,.22), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .bc-violet:hover  { box-shadow: 0 0 0 1px rgba(196,181,253,.40), 0 24px 60px rgba(124,58,237,.38), inset 0 1px 0 rgba(255,255,255,.16); }

        .bc-sky     {
            background: linear-gradient(135deg, rgba(2,132,199,.22) 0%, rgba(7,89,133,.14) 100%);
            border: 1px solid rgba(125,211,252,.28);
            box-shadow: 0 0 0 1px rgba(125,211,252,.10), 0 8px 40px rgba(2,132,199,.22), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .bc-sky:hover     { box-shadow: 0 0 0 1px rgba(125,211,252,.40), 0 24px 60px rgba(2,132,199,.38), inset 0 1px 0 rgba(255,255,255,.16); }

        .bc-teal    {
            background: linear-gradient(135deg, rgba(13,148,136,.22) 0%, rgba(15,118,110,.14) 100%);
            border: 1px solid rgba(94,234,212,.28);
            box-shadow: 0 0 0 1px rgba(94,234,212,.10), 0 8px 40px rgba(13,148,136,.22), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .bc-teal:hover    { box-shadow: 0 0 0 1px rgba(94,234,212,.40), 0 24px 60px rgba(13,148,136,.38), inset 0 1px 0 rgba(255,255,255,.16); }

        .bc-indigo  {
            background: linear-gradient(135deg, rgba(79,70,229,.25) 0%, rgba(55,48,163,.16) 100%);
            border: 1px solid rgba(165,180,252,.28);
            box-shadow: 0 0 0 1px rgba(165,180,252,.10), 0 8px 40px rgba(79,70,229,.22), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .bc-indigo:hover  { box-shadow: 0 0 0 1px rgba(165,180,252,.40), 0 24px 60px rgba(79,70,229,.38), inset 0 1px 0 rgba(255,255,255,.16); }

        .bc-emerald {
            background: linear-gradient(135deg, rgba(5,150,105,.22) 0%, rgba(6,95,70,.14) 100%);
            border: 1px solid rgba(110,231,183,.28);
            box-shadow: 0 0 0 1px rgba(110,231,183,.10), 0 8px 40px rgba(5,150,105,.22), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .bc-emerald:hover { box-shadow: 0 0 0 1px rgba(110,231,183,.40), 0 24px 60px rgba(5,150,105,.38), inset 0 1px 0 rgba(255,255,255,.16); }

        .bc-amber   {
            background: linear-gradient(135deg, rgba(217,119,6,.22) 0%, rgba(146,64,14,.14) 100%);
            border: 1px solid rgba(252,211,77,.28);
            box-shadow: 0 0 0 1px rgba(252,211,77,.10), 0 8px 40px rgba(217,119,6,.22), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .bc-amber:hover   { box-shadow: 0 0 0 1px rgba(252,211,77,.40), 0 24px 60px rgba(217,119,6,.38), inset 0 1px 0 rgba(255,255,255,.16); }

        /* ── Icono grande con glow ── */
        .bc-ico {
            width: 56px; height: 56px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.15rem;
            position: relative;
        }
        .bc-ico::after {
            content: '';
            position: absolute; inset: -4px;
            border-radius: 20px;
            opacity: .35;
            filter: blur(8px);
            z-index: -1;
        }
        .i-rose    { background: rgba(253,164,175,.28); color: #fda4af; border: 1px solid rgba(253,164,175,.35); }
        .i-rose::after    { background: #e11d48; }
        .i-violet  { background: rgba(196,181,253,.25); color: #c4b5fd; border: 1px solid rgba(196,181,253,.35); }
        .i-violet::after  { background: #7c3aed; }
        .i-sky     { background: rgba(125,211,252,.22); color: #7dd3fc; border: 1px solid rgba(125,211,252,.35); }
        .i-sky::after     { background: #0284c7; }
        .i-teal    { background: rgba(94,234,212,.22); color: #5eead4; border: 1px solid rgba(94,234,212,.35); }
        .i-teal::after    { background: #0d9488; }
        .i-indigo  { background: rgba(165,180,252,.25); color: #a5b4fc; border: 1px solid rgba(165,180,252,.35); }
        .i-indigo::after  { background: #4f46e5; }
        .i-emerald { background: rgba(110,231,183,.22); color: #6ee7b7; border: 1px solid rgba(110,231,183,.35); }
        .i-emerald::after { background: #059669; }
        .i-amber   { background: rgba(252,211,77,.22); color: #fcd34d; border: 1px solid rgba(252,211,77,.35); }
        .i-amber::after   { background: #d97706; }

        /* ── Texto ── */
        .bc-lbl {
            font-family: 'DM Sans', sans-serif;
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: rgba(255,255,255,.38); margin-bottom: .35rem;
        }
        .bc-ttl {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.08rem; font-weight: 800; color: rgba(255,255,255,.92);
            line-height: 1.25; margin-bottom: .5rem;
        }
        .bc-dsc {
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px; color: rgba(255,255,255,.52); line-height: 1.65;
        }

        /* ── Subcards dentro de card grande ── */
        .bc-subcards {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: .7rem; margin-top: 1rem;
        }
        .bc-sub {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.14);
            border-radius: 1rem; padding: .8rem 1rem;
            backdrop-filter: blur(4px);
        }
        .bc-sub-t {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11.5px; font-weight: 700; color: rgba(255,255,255,.85); margin-bottom: .25rem;
        }
        .bc-sub-d { font-family: 'DM Sans', sans-serif; font-size: 10.5px; color: rgba(255,255,255,.42); line-height: 1.5; }
        .accent-rose { color: #fda4af; }

        /* ── Tags ── */
        .bc-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-top: .9rem; }
        .bc-tag {
            font-family: 'DM Sans', sans-serif;
            font-size: 10.5px; font-weight: 600;
            padding: 4px 11px; border-radius: 999px;
            background: rgba(255,255,255,.10); color: rgba(255,255,255,.70);
            border: 1px solid rgba(255,255,255,.16);
        }
        .bc-violet  .bc-tag { background: rgba(196,181,253,.18); color: #c4b5fd; border-color: rgba(196,181,253,.30); }
        .bc-sky     .bc-tag { background: rgba(125,211,252,.18); color: #7dd3fc; border-color: rgba(125,211,252,.30); }
        .bc-emerald .bc-tag { background: rgba(110,231,183,.18); color: #6ee7b7; border-color: rgba(110,231,183,.30); }
        .bc-indigo  .bc-tag { background: rgba(165,180,252,.18); color: #a5b4fc; border-color: rgba(165,180,252,.30); }

        /* ── Stats en card grande ── */
        .bc-row {
            display: flex; align-items: center;
            justify-content: space-between; gap: 1rem;
        }
        .bc-stats { display: flex; flex-direction: column; gap: .6rem; flex-shrink: 0; }
        .bc-stat {
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.16);
            border-radius: .85rem; padding: .6rem 1rem; text-align: center; min-width: 72px;
        }
        .bc-stat-n { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.15rem; font-weight: 800; color: #a5b4fc; }
        .bc-stat-l { font-family: 'DM Sans', sans-serif; font-size: 9px; color: rgba(255,255,255,.38); text-transform: uppercase; letter-spacing: .5px; margin-top: 2px; }

        /* CTA pie bento */
        .bento-cta { text-align: center; margin-top: 3rem; }
        .bento-cta-btn {
            display: inline-flex; align-items: center; gap: 9px;
            padding: 14px 32px; border-radius: 16px;
            font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 700;
            background: rgba(255,255,255,.12); color: #fff;
            border: 1px solid rgba(255,255,255,.22);
            backdrop-filter: blur(12px); cursor: pointer;
            transition: all .22s; text-decoration: none;
            box-shadow: 0 4px 24px rgba(0,0,0,.18);
        }
        .bento-cta-btn:hover {
            background: rgba(255,255,255,.20); border-color: rgba(255,255,255,.45);
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0,0,0,.25);
        }
    </style>
</head>

<body class="bg-[#f5f5f5]">

<x-layout.navbar />

{{-- ══ VISTA: INICIO ══ --}}
<div id="view-inicio" class="spa-view active">

    {{-- ─── HERO ─── --}}
    <section class="home-hero-section">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center px-6 md:px-10">
            <div>

                <h2 class="text-4xl md:text-[3.4rem] font-bold text-[#0f172a] leading-[1.1] mb-5"
                    style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Tu Portafolio,<br>
                    Tu Futuro.<br>
                    <span class="hero-title-glow">Sin Límites.</span>
                </h2>

                <p class="text-gray-500 text-base leading-relaxed mb-7"
                   style="font-family:'DM Sans',sans-serif; max-width:430px;">
                    Crea tu perfil, publica portafolios y sé descubierto por reclutadores y colaboradores. Todo en un solo lugar.
                </p>

                <div class="flex flex-col sm:flex-row gap-3">
                    @auth
                        @if(auth()->user()->es_admin)
                            <a href="{{ route('admin') }}" class="hero-cta-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                                Panel de control
                            </a>
                        @else
                            <a href="{{ route('menu') }}" class="hero-cta-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Mi perfil
                            </a>
                        @endif
                    @else
                        <button id="openLoginModalHero" class="hero-cta-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Empezar gratis
                        </button>
                    @endauth

                    <a href="#" onclick="spaNav('portafolios'); return false;" class="hero-cta-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        Ver portafolios
                    </a>
                </div>

                <div class="hero-tags">
                    <span style="font-family:'DM Sans',sans-serif;font-size:11px;color:#94a3b8;font-weight:600;">Explorar →</span>
                    <button class="hero-tag" onclick="spaNav('caracteristicas')">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Características
                    </button>
                    <button class="hero-tag" onclick="spaNav('portafolios')"
                            style="background:#f0f9ff;border-color:#bae6fd;color:#0284c7;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        Portafolios
                    </button>
                    <button class="hero-tag" onclick="spaNav('explorador')"
                            style="background:#fdf2f8;border-color:#fbcfe8;color:#db2777;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Explorador
                    </button>
                </div>
            </div>

            <div class="flex justify-center md:justify-end mt-8 md:mt-0">
                <img src="{{ asset('images/imagen-hero.jpeg') }}"
                     class="hero-img w-full max-w-sm md:max-w-[520px]"
                     alt="SansiFolios hero">
            </div>
        </div>
    </section>

    {{-- ─── BENTO: características reales de la plataforma ─── --}}
    <section class="bento-section">
        <div class="bento-orb-center"></div>
        <div class="bento-inner">

            <div class="bento-header">
                <div class="bento-eyebrow">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Todo lo que necesitas
                </div>
                <h3 class="bento-title">Tu portafolio profesional,<br>completo desde el primer día</h3>
                <p class="bento-sub">Perfil · Portafolios · Explorador · Multiidioma — diseñado en SansiFolios</p>
            </div>

            <div class="bento-grid">

                {{-- ── Slot 1 (4col): Perfil profesional ── --}}
                <div class="bc bc-slot-1 bc-rose">
                    <div class="bc-ico i-rose">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="bc-lbl">Tu perfil</div>
                    <div class="bc-ttl">Perfil profesional completo</div>
                    <div class="bc-dsc">Nombre, profesión, biografía y foto en una URL única que puedes compartir en cualquier red social. Visible públicamente al instante.</div>
                    <div class="bc-subcards">
                        <div class="bc-sub">
                            <div class="bc-sub-t">Experiencia laboral</div>
                            <div class="bc-sub-d">Empresa, cargo y fechas. Marca si es tu trabajo actual — aparece destacada.</div>
                        </div>
                        <div class="bc-sub">
                            <div class="bc-sub-t accent-rose">Formación académica</div>
                            <div class="bc-sub-d">Institución, título y nivel. Compatible con estudios en curso.</div>
                        </div>
                    </div>
                </div>

                {{-- ── Slot 2 (2col): Habilidades ── --}}
                <div class="bc bc-slot-2 bc-violet">
                    <div class="bc-ico i-violet">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                    <div class="bc-lbl">Capacidades</div>
                    <div class="bc-ttl">Habilidades y certificaciones</div>
                    <div class="bc-dsc">Nivel fuerte o en desarrollo. Un badge especial destaca tus certificaciones en el explorador de talento.</div>
                    <div class="bc-tags">
                        <span class="bc-tag">Nivel</span>
                        <span class="bc-tag">Badge</span>
                        <span class="bc-tag">Explorador</span>
                    </div>
                </div>

                {{-- ── Slot 3 (2col): Portafolios ── --}}
                <div class="bc bc-slot-3 bc-sky">
                    <div class="bc-ico i-sky">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="bc-lbl">Proyectos</div>
                    <div class="bc-ttl">Portafolios de proyectos</div>
                    <div class="bc-dsc">Nombre, banner, logo y archivos adjuntos. URL de repositorio y deploy por proyecto. Exportable a PDF.</div>
                    <div class="bc-tags">
                        <span class="bc-tag">Borrador</span>
                        <span class="bc-tag">Publicado</span>
                        <span class="bc-tag">PDF</span>
                    </div>
                </div>

                {{-- ── Slot 4 (2col): Redes ── --}}
                <div class="bc bc-slot-4 bc-teal">
                    <div class="bc-ico i-teal">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    </div>
                    <div class="bc-lbl">Visibilidad</div>
                    <div class="bc-ttl">Redes y enlace público</div>
                    <div class="bc-dsc">Vincula GitHub, LinkedIn, Twitter e Instagram. Los íconos aparecen en tu tarjeta del explorador.</div>
                </div>

                {{-- ── Slot 5 (2col): Multiidioma ── --}}
                <div class="bc bc-slot-5 bc-amber">
                    <div class="bc-ico i-amber">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <div class="bc-lbl">Idioma</div>
                    <div class="bc-ttl">Español · English · Français</div>
                    <div class="bc-dsc">Cambia el idioma desde cualquier pantalla. Toda la interfaz se adapta al instante.</div>
                </div>

                {{-- ── Slot 6 (2col): Cuenta segura ── --}}
                <div class="bc bc-slot-6 bc-emerald">
                    <div class="bc-ico i-emerald">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div class="bc-lbl">Acceso</div>
                    <div class="bc-ttl">Cuenta segura</div>
                    <div class="bc-dsc">Registro con email verificado o Google OAuth. Recuperación de contraseña con token seguro enviado al correo.</div>
                    <div class="bc-tags">
                        <span class="bc-tag">Google OAuth</span>
                        <span class="bc-tag">Verificación</span>
                    </div>
                </div>

                {{-- ── Slot 7 (4col): Explorador de talento ── --}}
                <div class="bc bc-slot-7 bc-indigo">
                    <div class="bc-row">
                        <div>
                            <div class="bc-ico i-indigo" style="margin-bottom:.8rem;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </div>
                            <div class="bc-lbl">Descubrimiento</div>
                            <div class="bc-ttl">Explorador de talento</div>
                            <div class="bc-dsc">Filtra por área (tecnología, creativos, salud, negocios, educación) y capacidad. Búsqueda en tiempo real por nombre, profesión o habilidades — sin recargar la página.</div>
                        </div>
                        <div class="bc-stats">
                            <div class="bc-stat">
                                <div class="bc-stat-n">5+</div>
                                <div class="bc-stat-l">Áreas</div>
                            </div>
                            <div class="bc-stat">
                                <div class="bc-stat-n">⚡</div>
                                <div class="bc-stat-l">Tiempo real</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bento-cta">
                <a href="#" onclick="spaNav('caracteristicas'); return false;" class="bento-cta-btn">
                    Ver todas las características
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>

        </div>
    </section>

</div>{{-- fin #view-inicio --}}


{{-- ══ VISTA: CARACTERÍSTICAS ══ --}}
<div id="view-caracteristicas" class="spa-view">
    @include('_caracteristicas_menu')
</div>


{{-- ══ VISTA: PORTAFOLIOS ══ --}}
<div id="view-portafolios" class="spa-view">
    @include('_portafolios_menu')
</div>


{{-- ══ VISTA: EXPLORADOR ══ --}}
<div id="view-explorador" class="spa-view">
    @include('_explorador_menu')
</div>


<x-layout.footer />

@guest
    @include('Auth.login')
    @include('Auth.registro')
    @include('Auth.recuperar')
@endguest

@guest
<script>
    const modal       = document.getElementById('loginModal');
    const closeButton = document.getElementById('closeModal');
    const openButtons = [
        document.getElementById('openLoginModal'),
        document.getElementById('openLoginModalMobile'),
        document.getElementById('openLoginModalHero'),
    ];
    const toggleModal = () => {
        if (!modal) return;
        const isClosing = !modal.classList.contains('hidden');
        modal.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
        @if(session('success_reactivacion') || session('cuenta_desactivada'))
            if (isClosing) {
                window.location.href = '/home';
            }
        @endif
    };
    openButtons.forEach(btn => { if (btn) btn.addEventListener('click', toggleModal); });
    if (closeButton) closeButton.addEventListener('click', toggleModal);
    if (modal) modal.addEventListener('click', e => { if (e.target === modal) toggleModal(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) toggleModal();
    });

    const registerModal   = document.getElementById('registerModal');
    const registerButtons = [
        document.getElementById('openRegisterModal'),
        document.getElementById('openRegisterModalMobile'),
    ];
    const toggleRegister = () => {
        if (!registerModal) return;
        registerModal.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    };
    registerButtons.forEach(btn => { if (btn) btn.addEventListener('click', toggleRegister); });
    if (registerModal) registerModal.addEventListener('click', e => { if (e.target === registerModal) toggleRegister(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && registerModal && !registerModal.classList.contains('hidden')) toggleRegister();
    });

    const modalRecuperar   = document.getElementById('modalRecuperar');
    const recuperarButtons = [ document.getElementById('openRecuperarModal') ];
    const toggleRecuperar = () => {
        if (!modalRecuperar) return;
        modalRecuperar.classList.toggle('hidden');
        document.body.style.overflow = modalRecuperar.classList.contains('hidden') ? 'auto' : 'hidden';
    };
    recuperarButtons.forEach(btn => { if (btn) btn.addEventListener('click', toggleRecuperar); });
    if (modalRecuperar) modalRecuperar.addEventListener('click', e => {
        if (e.target === modalRecuperar && !modalRecuperar.getAttribute('data-no-close')) toggleRecuperar();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modalRecuperar && !modalRecuperar.classList.contains('hidden') && !modalRecuperar.getAttribute('data-no-close')) toggleRecuperar();
    });
</script>
@endguest

@if ($errors->any() || session('cuenta_desactivada') || session('success_reactivacion'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('loginModal');
        if (modal) { modal.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
    });
</script>
@endif

@guest
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);

        if (params.get('login') === '1') {
            window.history.replaceState({}, '', '/');
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        if (params.get('verificado') === '1') {
            window.history.replaceState({}, '', '/');
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            const msg = document.getElementById('loginMensaje');
            if (msg) {
                msg.innerHTML = '✔ Cuenta verificada. Ya puedes iniciar sesión.';
                msg.className = 'mt-3 text-sm text-green-600';
            }
        }

        if (params.get('registro') === '1') {
            window.history.replaceState({}, '', '/');
            const registerModal = document.getElementById('registerModal');
            if (registerModal) {
                registerModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }
    });

    window.addEventListener('storage', function(event) {
        if (event.key === 'email_verificado') {
            localStorage.removeItem('email_verificado');
            const registerModal = document.getElementById('registerModal');
            if (registerModal) registerModal.classList.add('hidden');
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            const msg = document.getElementById('loginMensaje');
            if (msg) {
                msg.innerHTML = '✔ Cuenta verificada. Ya puedes iniciar sesión.';
                msg.className = 'mt-3 text-sm text-green-600';
            }
        }
    });
</script>
@endguest

{{-- ══ SPA: función de navegación ══ --}}
<script>
function spaNav(view) {
    // Marcar el enlace activo en el navbar
    if (typeof setNavActivo === 'function') setNavActivo(view);

    // Quitar active de todas
    document.querySelectorAll('.spa-view').forEach(v => v.classList.remove('active'));
    // Activar la pedida
    const target = document.getElementById('view-' + view);
    if (target) {
        target.classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// Marcar "inicio" al cargar — reintentos por si el navbar carga después
function _marcarInicio() {
    if (typeof setNavActivo === 'function') { setNavActivo('inicio'); return; }
    setTimeout(_marcarInicio, 50);
}
document.addEventListener('DOMContentLoaded', _marcarInicio);
</script>

</body>
</html>