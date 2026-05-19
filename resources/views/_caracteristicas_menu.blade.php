{{-- ============================================================
     _caracteristicas_menu.blade.php
     Partial: contenido de la vista "Características" para menu.blade.php
     Uso: @include('_caracteristicas_menu')
     ============================================================ --}}

{{-- ══ Hero ══ --}}
<div class="caract-hero">
    <div class="caract-hero-bg"></div>
    <div class="caract-hero-inner">
        <div class="caract-hero-left">
            <div class="caract-hero-eyebrow">SansiFolios · UMSS</div>
            <div class="caract-hero-title">{{ __('app.menu.caracteristicas') }}</div>
            <div class="caract-hero-sub">{{ __('app.menu.caract_subtitulo') }}</div>
        </div>
        <div class="caract-hero-badges">
            <span class="caract-hbadge caract-hbadge--blue">{{ __('app.caracteristicas.badge_perfil') }}</span>
            <span class="caract-hbadge caract-hbadge--indigo">{{ __('app.caracteristicas.badge_portafolios') }}</span>
            <span class="caract-hbadge caract-hbadge--pink">{{ __('app.caracteristicas.badge_explorador') }}</span>
            <span class="caract-hbadge caract-hbadge--green">{{ __('app.caracteristicas.badge_multiidioma') }}</span>
        </div>
    </div>
</div>

{{-- ══ Sección: Tu perfil ══ --}}
<div class="caract-section-label">
    <span class="caract-section-dot" style="background:#2563eb;"></span>
    {{ __('app.caracteristicas.seccion_perfil') }}
</div>
<div class="caract-grid caract-grid--4">

    <div class="cc cc--blue">
        <div class="cc-ico cc-ico--blue">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.perfil_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.perfil_desc') }}</div>
    </div>

    <div class="cc cc--purple">
        <div class="cc-ico cc-ico--purple">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.experiencia_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.experiencia_desc') }}</div>
    </div>

    <div class="cc cc--amber">
        <div class="cc-ico cc-ico--amber">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.formacion_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.formacion_desc') }}</div>
    </div>

    <div class="cc cc--green">
        <div class="cc-ico cc-ico--green">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.habilidades_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.habilidades_desc') }}</div>
        <div class="cc-tags">
            <span class="cc-tag">{{ __('app.caracteristicas.tag_fuerte') }}</span>
            <span class="cc-tag">{{ __('app.caracteristicas.tag_en_desarrollo') }}</span>
        </div>
    </div>

    <div class="cc cc--gold">
        <div class="cc-ico cc-ico--gold">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.certificaciones_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.certificaciones_desc') }}</div>
        <div class="cc-tags"><span class="cc-tag">Badge</span></div>
    </div>

    <div class="cc cc--pink">
        <div class="cc-ico cc-ico--pink">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.redes_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.redes_desc') }}</div>
    </div>

    <div class="cc cc--teal">
        <div class="cc-ico cc-ico--teal">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        </div>
        <div class="cc-title">{{ __('app.menu.enlace') }}</div>
        <div class="cc-desc">{{ __('app.menu.enlace_desc') }}</div>
    </div>

</div>

{{-- ══ Sección: Portafolios ══ --}}
<div class="caract-section-label" style="margin-top:2.5rem;">
    <span class="caract-section-dot" style="background:#6366f1;"></span>
    {{ __('app.caracteristicas.seccion_portafolios') }}
</div>
<div class="caract-grid caract-grid--3">

    <div class="cc cc--indigo cc--featured">
        <div class="cc-ico cc-ico--indigo">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.diseno_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.diseno_desc') }}</div>
        <div class="cc-tags">
            <span class="cc-tag">{{ __('app.caracteristicas.tag_banner') }}</span>
            <span class="cc-tag">{{ __('app.caracteristicas.tag_logo') }}</span>
            <span class="cc-tag">{{ __('app.caracteristicas.tag_archivos') }}</span>
        </div>
    </div>

    <div class="cc cc--blue cc--featured">
        <div class="cc-ico cc-ico--blue">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
        </div>
        <div class="cc-title">{{ __('app.caracteristicas.gestion_titulo') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.gestion_desc') }}</div>
        <div class="cc-tags">
            <span class="cc-tag">{{ __('app.caracteristicas.tag_borrador') }}</span>
            <span class="cc-tag">{{ __('app.caracteristicas.tag_publicado') }}</span>
        </div>
    </div>

    <div class="cc cc--orange cc--featured">
        <div class="cc-ico cc-ico--orange">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        </div>
        <div class="cc-title">{{ __('app.menu.exportacion') }}</div>
        <div class="cc-desc">{{ __('app.caracteristicas.exportacion_desc_completa') }}</div>
        <div class="cc-tags">
            <span class="cc-tag">{{ __('app.caracteristicas.tag_pdf') }}</span>
            <span class="cc-tag">{{ __('app.caracteristicas.tag_adjuntos') }}</span>
        </div>
    </div>

</div>

{{-- ══ Sección: Explorador + Cuenta ══ --}}
<div class="caract-two-col" style="margin-top:2.5rem;">

    <div>
        <div class="caract-section-label">
            <span class="caract-section-dot" style="background:#ec4899;"></span>
            {{ __('app.caracteristicas.seccion_explorador') }}
        </div>
        <div class="caract-grid caract-grid--2">

            <div class="cc cc--pink">
                <div class="cc-ico cc-ico--pink">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="14" y2="12"/><line x1="4" y1="18" x2="17" y2="18"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.filtros_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.filtros_desc') }}</div>
            </div>

            <div class="cc cc--pink">
                <div class="cc-ico cc-ico--pink">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.busqueda_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.busqueda_desc') }}</div>
            </div>

            <div class="cc cc--pink">
                <div class="cc-ico cc-ico--pink">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.ordenamiento_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.ordenamiento_desc') }}</div>
            </div>

            <div class="cc cc--pink">
                <div class="cc-ico cc-ico--pink">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.acceso_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.acceso_desc') }}</div>
            </div>

        </div>
    </div>

    <div>
        <div class="caract-section-label">
            <span class="caract-section-dot" style="background:#10b981;"></span>
            {{ __('app.caracteristicas.seccion_cuenta') }}
        </div>
        <div class="caract-grid caract-grid--2">

            <div class="cc cc--green">
                <div class="cc-ico cc-ico--green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.registro_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.registro_desc') }}</div>
            </div>

            <div class="cc cc--green">
                <div class="cc-ico cc-ico--green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.google_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.google_desc') }}</div>
            </div>

            <div class="cc cc--green">
                <div class="cc-ico cc-ico--green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.recuperacion_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.recuperacion_desc') }}</div>
            </div>

            <div class="cc cc--green">
                <div class="cc-ico cc-ico--green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div class="cc-title">{{ __('app.caracteristicas.idiomas_titulo') }}</div>
                <div class="cc-desc">{{ __('app.caracteristicas.idiomas_desc') }}</div>
            </div>

        </div>
    </div>

</div>

<style>
/* ══ Hero ══ */
.caract-hero {
    position: relative; border-radius: 16px; overflow: hidden;
    padding: 1.4rem 1.8rem; margin-bottom: 2rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1a56db 100%);
}
.caract-hero-bg {
    position: absolute; inset: 0; pointer-events: none;
    background:
        radial-gradient(ellipse at 80% 50%, rgba(139,92,246,.2) 0%, transparent 60%),
        radial-gradient(ellipse at 20% 80%, rgba(59,130,246,.12) 0%, transparent 50%);
}
.caract-hero-inner {
    position: relative; display: flex;
    align-items: center; gap: 1.5rem; flex-wrap: wrap;
}
.caract-hero-left { flex: 1; min-width: 220px; }
.caract-hero-eyebrow {
    font-family: 'DM Sans', sans-serif; font-size: 10.5px;
    font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
    color: rgba(255,255,255,.5); margin-bottom: .4rem;
}
.caract-hero-title {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 1.45rem; font-weight: 800; color: #fff;
    line-height: 1.2; margin-bottom: .3rem;
}
.caract-hero-sub {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; color: rgba(255,255,255,.65);
}
.caract-hero-badges { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
.caract-hbadge {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'DM Sans', sans-serif; font-size: 11px; font-weight: 700;
    padding: 5px 11px; border-radius: 20px;
    border: 1.5px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.10);
    backdrop-filter: blur(6px); color: #fff; white-space: nowrap;
}
.caract-hbadge--blue   { border-color: rgba(59,130,246,.4);  background: rgba(59,130,246,.15); }
.caract-hbadge--indigo { border-color: rgba(99,102,241,.4);  background: rgba(99,102,241,.15); }
.caract-hbadge--pink   { border-color: rgba(236,72,153,.4);  background: rgba(236,72,153,.15); }
.caract-hbadge--green  { border-color: rgba(16,185,129,.4);  background: rgba(16,185,129,.15); }

/* ══ Section label ══ */
.caract-section-label {
    display: flex; align-items: center; gap: 8px;
    font-family: 'DM Sans', sans-serif; font-size: 11px;
    font-weight: 700; text-transform: uppercase; letter-spacing: .8px;
    color: #64748b; margin-bottom: 1rem;
}
.caract-section-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

/* ══ Grids ══ */
.caract-grid {
    display: grid;
    gap: 12px;
}
.caract-grid--4 { grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); }
.caract-grid--3 { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); }
.caract-grid--2 { grid-template-columns: repeat(2, 1fr); }

/* ══ Cards nuevas ══ */
.cc {
    background: #fff;
    border: 1.5px solid #e9edf3;
    border-radius: 16px;
    padding: 1.25rem 1.3rem;
    display: flex; flex-direction: column; gap: .55rem;
    transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .22s ease;
    position: relative; overflow: hidden;
}
.cc::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    border-radius: 16px 16px 0 0;
    opacity: 0; transition: opacity .22s;
}
.cc:hover { transform: translateY(-5px); }
.cc:hover::before { opacity: 1; }

/* Featured: cards de portafolios más altas */
.cc--featured { padding: 1.5rem; }

/* Línea top por color */
.cc--blue::before   { background: #2563eb; }
.cc--indigo::before { background: #6366f1; }
.cc--purple::before { background: #7c3aed; }
.cc--pink::before   { background: #db2777; }
.cc--green::before  { background: #16a34a; }
.cc--teal::before   { background: #0d9488; }
.cc--amber::before  { background: #d97706; }
.cc--gold::before   { background: #ca8a04; }
.cc--orange::before { background: #ea580c; }
.cc--slate::before  { background: #334155; }

/* Hover shadow por color */
.cc--blue:hover   { box-shadow: 0 12px 36px rgba(37,99,235,.14); border-color: #bfdbfe; }
.cc--indigo:hover { box-shadow: 0 12px 36px rgba(99,102,241,.14); border-color: #c7d2fe; }
.cc--purple:hover { box-shadow: 0 12px 36px rgba(124,58,237,.14); border-color: #ddd6fe; }
.cc--pink:hover   { box-shadow: 0 12px 36px rgba(219,39,119,.14); border-color: #fbcfe8; }
.cc--green:hover  { box-shadow: 0 12px 36px rgba(22,163,74,.14);  border-color: #bbf7d0; }
.cc--teal:hover   { box-shadow: 0 12px 36px rgba(13,148,136,.14); border-color: #99f6e4; }
.cc--amber:hover  { box-shadow: 0 12px 36px rgba(217,119,6,.14);  border-color: #fde68a; }
.cc--gold:hover   { box-shadow: 0 12px 36px rgba(202,138,4,.14);  border-color: #fef08a; }
.cc--orange:hover { box-shadow: 0 12px 36px rgba(234,88,12,.14);  border-color: #fed7aa; }
.cc--slate:hover  { box-shadow: 0 12px 36px rgba(51,65,85,.14);   border-color: #cbd5e1; }

/* ══ Icono ══ */
.cc-ico {
    width: 48px; height: 48px; border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-bottom: .1rem;
}
.cc-ico--blue   { background: #eff6ff; color: #2563eb; }
.cc-ico--indigo { background: #eef2ff; color: #6366f1; }
.cc-ico--purple { background: #f5f3ff; color: #7c3aed; }
.cc-ico--pink   { background: #fdf2f8; color: #db2777; }
.cc-ico--green  { background: #f0fdf4; color: #16a34a; }
.cc-ico--teal   { background: #f0fdfa; color: #0d9488; }
.cc-ico--amber  { background: #fffbeb; color: #d97706; }
.cc-ico--gold   { background: #fefce8; color: #ca8a04; }
.cc-ico--orange { background: #fff7ed; color: #ea580c; }
.cc-ico--slate  { background: #f8fafc; color: #475569; }

/* ══ Texto ══ */
.cc-title {
    font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
    font-size: 13.5px; font-weight: 800; color: #1e293b; line-height: 1.25;
}
.cc-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px; color: #64748b; line-height: 1.6;
}

/* ══ Tags ══ */
.cc-tags { display: flex; gap: 5px; flex-wrap: wrap; margin-top: .25rem; }
.cc-tag {
    font-family: 'DM Sans', sans-serif;
    font-size: 10px; font-weight: 700;
    padding: 3px 9px; border-radius: 999px;
    background: #f1f5f9; color: #475569;
    border: 1px solid #e2e8f0;
}

/* ══ Dos columnas ══ */
.caract-two-col {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}
</style>