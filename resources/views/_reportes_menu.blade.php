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

    // Portafolios reales del usuario con sus proyectos
    $r_portafolios = $r_user
        ? \App\Models\Portafolio::where('usuario_id', $r_user->id)
              ->with('proyectos')
              ->orderBy('created_at', 'desc')
              ->get()
        : collect();
    // Portafolio seleccionado por defecto (el primero publicado, o el primero si no hay publicado)
    $r_pf_activo = $r_portafolios->firstWhere('estado', 'publicado') ?? $r_portafolios->first();
    // Proyectos del portafolio activo
    $r_proyectos = $r_pf_activo ? $r_pf_activo->proyectos : collect();

    $supabaseBase = rtrim(config('services.supabase.url'), '/')
                  . '/storage/v1/object/public/'
                  . config('services.supabase.bucket');

    $fotoCV = null;
    if ($r_user && $r_user->foto_perfil) {
        if (str_starts_with($r_user->foto_perfil, 'http')) {
            $fotoCV = $r_user->foto_perfil;
        } else {
            $fotoCV = $supabaseBase . '/' . ltrim($r_user->foto_perfil, '/');
        }
    }

    $nombreFormateado = urlencode(($r_user?->nombre ?? 'U') . ' ' . ($r_user?->apellido ?? ''));
    $fotoFallback = 'https://ui-avatars.com/api/?name=' . $nombreFormateado . '&background=3b82f6&color=fff&size=300';
@endphp

{{-- ── Barra superior ── --}}
<div class="content-bar">
    <div class="content-title">
        <h1>{{ __('app.reportes.titulo') }}</h1>
        <p>{{ __('app.reportes.subtitulo') }}</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
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

{{-- ── Pestañas de Reportes ── --}}
<div class="reportes-tabs" style="display:flex; gap:15px; margin-bottom:20px; border-bottom:1px solid #cbd5e1;">
    <button type="button" class="rep-tab active" onclick="switchRepTab('cv')">{{ __('Hoja de vida') ?? 'Hoja de Vida (Vertical)' }}</button>
    <button type="button" class="rep-tab" onclick="switchRepTab('portafolio')">Portafolio</button>
</div>

{{-- ── Selector de plantilla CV ── --}}
<div id="selector-cv" class="template-selector"
     style="display:flex;align-items:center;gap:12px;margin-bottom:25px;
            background:#f8fafc;padding:15px 20px;border-radius:12px;border:1px solid #e2e8f0;">
    <label style="font-size:14px;font-weight:600;color:#475569;margin:0;">
        Seleccionar diseño de Hoja de Vida:
    </label>
    <select id="cv-template-select" onchange="selectTemplate(this.value)"
            style="padding:10px 14px;border-radius:8px;border:1px solid #cbd5e1;font-size:14px;
                   font-weight:500;color:#1e293b;outline:none;cursor:pointer;flex:1;
                   max-width:320px;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
        <option value="cv-template-1">{{ __('app.reportes.plantilla_moderna') }}</option>
        <option value="cv-template-3">{{ __('app.reportes.plantilla_clasica') }}</option>
        <option value="cv-template-4">{{ __('app.reportes.plantilla_elegante') }}</option>
        <option value="cv-template-5">{{ __('app.reportes.plantilla_creativa') }}</option>
    </select>
</div>

{{-- ── Selector de plantilla Portafolio ── --}}
<div id="selector-portafolio" class="template-selector"
     style="display:none;flex-wrap:wrap;align-items:center;gap:12px;margin-bottom:0;
            background:#f8fafc;padding:15px 20px;border-radius:12px 12px 0 0;border:1px solid #e2e8f0;border-bottom:none;">
    <label style="font-size:14px;font-weight:600;color:#475569;margin:0;">
        Seleccionar diseño de Portafolio:
    </label>
    <select id="portafolio-select" onchange="selectTemplate(this.value); updatePortafolioColorPicker(this.value);"
            style="padding:10px 14px;border-radius:8px;border:1px solid #cbd5e1;font-size:14px;
                   font-weight:500;color:#1e293b;outline:none;cursor:pointer;flex:1;
                   max-width:320px;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
        <option value="cv-template-7">Portafolio Hexágonos</option>
        <option value="cv-template-8">Portafolio Timeline Azul</option>
        <option value="cv-template-9">Portafolio Elegante</option>
        <option value="cv-template-10">Portafolio Columnas Rosa</option>
    </select>
</div>

{{-- ── Selectores de color por plantilla ── --}}
<div id="portafolio-color-panel"
     style="display:none;align-items:center;gap:14px;flex-wrap:wrap;
            background:#f0f7ff;padding:12px 20px;border-radius:0 0 12px 12px;
            border:1px solid #e2e8f0;border-top:1px dashed #bcd0e5;margin-bottom:25px;">

    {{-- Selector de portafolio real --}}
    @if($r_portafolios->count() > 0)
    <div class="pf-select-row" style="display:flex;align-items:center;gap:10px;width:100%;padding-bottom:10px;
                border-bottom:1px dashed #bcd0e5;margin-bottom:4px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
        <label style="font-size:13px;font-weight:600;color:#334155;">Portafolio a mostrar:</label>
        <select id="pf-reporte-select"
                onchange="aplicarPortafolioReporte(this.value)"
                style="padding:6px 12px;border-radius:7px;border:1px solid #cbd5e1;font-size:13px;
                       font-weight:500;color:#1e293b;outline:none;cursor:pointer;
                       background:#fff;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
            @foreach($r_portafolios as $pf)
                <option value="{{ $pf->id }}"
                        data-nombre="{{ e($pf->nombre) }}"
                        data-descripcion="{{ e($pf->descripcion ?? '') }}"
                        data-banner="{{ $pf->banner_url ?? '' }}"
                        data-logo="{{ $pf->logo_url ?? '' }}"
                        data-proyectos="{{ $pf->proyectos->map(function($p) { return ['nombre' => $p->nombre, 'descripcion' => $p->descripcion, 'banner' => $p->banner_url, 'repositorio_url' => $p->repositorio_url, 'deploy_url' => $p->deploy_url]; })->toJson() }}">
                    {{ $pf->nombre }}
                    @if($pf->estado === 'publicado')
                        &#10003;
                    @else
                        (borrador)
                    @endif
                </option>
            @endforeach
        </select>
    </div>
    @else
    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#64748b;width:100%;padding-bottom:10px;border-bottom:1px dashed #bcd0e5;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Sin portafolios creados aún. <a onclick="abrirModalCrearPf()" style="color:#2563eb;cursor:pointer;font-weight:600;">Crear portafolio</a>
    </div>
    @endif

    {{-- Color picker para Hexágonos (fondo) --}}
    <div id="color-ctrl-7" style="display:none;align-items:center;gap:10px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
        <label style="font-size:13px;font-weight:600;color:#334155;">Color de fondo:</label>
        <input type="color" id="color-bg-7" value="#fcd34d" title="Color del fondo"
               oninput="document.getElementById('cv-template-7').style.backgroundColor=this.value"
               style="width:38px;height:30px;border:1.5px solid #cbd5e1;border-radius:6px;padding:2px;cursor:pointer;background:#fff;">
        <button onclick="document.getElementById('cv-template-7').style.backgroundColor='#fcd34d'; document.getElementById('color-bg-7').value='#fcd34d';"
                style="font-size:11px;padding:4px 10px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;color:#475569;cursor:pointer;">Restablecer</button>
    </div>

    {{-- Color picker para Timeline Azul (área blanca derecha) --}}
    <div id="color-ctrl-8" style="display:none;align-items:center;gap:10px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
        <label style="font-size:13px;font-weight:600;color:#334155;">Color de área derecha:</label>
        <input type="color" id="color-bg-8" value="#ffffff" title="Color del área blanca"
               oninput="document.querySelector('#cv-template-8 .cv8-right').style.backgroundColor=this.value"
               style="width:38px;height:30px;border:1.5px solid #cbd5e1;border-radius:6px;padding:2px;cursor:pointer;background:#fff;">
        <button onclick="document.querySelector('#cv-template-8 .cv8-right').style.backgroundColor='#ffffff'; document.getElementById('color-bg-8').value='#ffffff';"
                style="font-size:11px;padding:4px 10px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;color:#475569;cursor:pointer;">Restablecer</button>
    </div>

    {{-- Color picker para Elegante (sección inferior) --}}
    <div id="color-ctrl-9" style="display:none;align-items:center;gap:10px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M3 7h18"/></svg>
        <label style="font-size:13px;font-weight:600;color:#334155;">Color de sección inferior:</label>
        <input type="color" id="color-bg-9" value="#1e3a8a" title="Color de la parte inferior"
               oninput="document.querySelector('#cv-template-9 .cv9-bottom').style.backgroundColor=this.value"
               style="width:38px;height:30px;border:1.5px solid #cbd5e1;border-radius:6px;padding:2px;cursor:pointer;background:#fff;">
        <button onclick="document.querySelector('#cv-template-9 .cv9-bottom').style.backgroundColor='#1e3a8a'; document.getElementById('color-bg-9').value='#1e3a8a';"
                style="font-size:11px;padding:4px 10px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;color:#475569;cursor:pointer;">Restablecer</button>
    </div>

    {{-- Color picker para Columnas Rosa (columna del medio) --}}
    <div id="color-ctrl-10" style="display:none;align-items:center;gap:10px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="3" width="6" height="18" rx="1"/></svg>
        <label style="font-size:13px;font-weight:600;color:#334155;">Color de columna central:</label>
        <input type="color" id="color-bg-10" value="#e0a59e" title="Color de la columna del medio"
               oninput="document.querySelector('#cv-template-10 .cv10-col-mid').style.backgroundColor=this.value"
               style="width:38px;height:30px;border:1.5px solid #cbd5e1;border-radius:6px;padding:2px;cursor:pointer;background:#fff;">
        <button onclick="document.querySelector('#cv-template-10 .cv10-col-mid').style.backgroundColor='#e0a59e'; document.getElementById('color-bg-10').value='#e0a59e';"
                style="font-size:11px;padding:4px 10px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;color:#475569;cursor:pointer;">Restablecer</button>
    </div>
</div>

<script>
// ── Configuración de proyectos máximos por página por template ──
const PF_LIMITS = {
    t7:  { first: 0, extra: 1 },  // T7: portada limpia, 1 proyecto por página extra
    t8:  { first: 4, extra: 2 },  // T8 Timeline
    t9:  { first: 3, extra: 2 },  // T9 Elegante
    t10: { first: 3, extra: 4 },  // T10 Columnas
};

// ── Genera el HTML de un proyecto para páginas extra ──
function pfExtraProyectoHtml(p, isSingle) {
    const imgHtml = p.banner
        ? `<div class="pf-xproject-img-wrap"><img src="${p.banner}" alt="${p.nombre}"></div>`
        : `<div class="pf-xproject-no-img">📦</div>`;
    const links = [];
    if (p.deploy_url)      links.push(`<a href="${p.deploy_url}" class="pf-xproject-link" target="_blank">🌐 Demo</a>`);
    if (p.repositorio_url) links.push(`<a href="${p.repositorio_url}" class="pf-xproject-link" target="_blank">📁 Repositorio</a>`);
    const cardClass = isSingle ? 'pf-xproject pf-xproject-full' : 'pf-xproject';
    return `<div class="${cardClass}">
        ${imgHtml}
        <div class="pf-xproject-info">
            <div class="pf-xproject-title">${p.nombre}</div>
            <div class="pf-xproject-desc">${p.descripcion || 'Sin descripción'}</div>
            ${links.length ? `<div class="pf-xproject-links">${links.join('')}</div>` : ''}
        </div>
    </div>`;
}

// ── Genera páginas extra para un template ──
function pfGenerarPaginasExtra(wrapId, tClass, nombre, proyectosExtra, proyectosPorPagina) {
    const wrap = document.getElementById(wrapId);
    if (!wrap) return;
    wrap.innerHTML = '';
    if (!proyectosExtra.length) {
        wrap.classList.remove('active-extras');
        return;
    }
    wrap.classList.add('active-extras');
    // Dividir en grupos
    const isSingle = proyectosPorPagina === 1;
    let pagina = 2;
    for (let i = 0; i < proyectosExtra.length; i += proyectosPorPagina) {
        const chunk = proyectosExtra.slice(i, i + proyectosPorPagina);
        const proyHtml = chunk.map(p => pfExtraProyectoHtml(p, isSingle)).join('');
        const page = document.createElement('div');
        page.className = `pf-extra-page ${tClass}`;
        page.innerHTML = `
            <div class="pf-xhdr">
                <span class="pf-xhdr-name">${nombre}</span>
                <span class="pf-xhdr-page">Página ${pagina}</span>
            </div>
            <div class="pf-xbody ${isSingle ? 'pf-xbody-single' : ''}">${proyHtml}</div>`;
        wrap.appendChild(page);
        pagina++;
    }
}

// ── Oculta TODOS los wrappers de páginas extra ──
function pfOcultarTodasExtras() {
    document.querySelectorAll('.pf-extra-pages-wrap').forEach(w => {
        w.classList.remove('active-extras');
    });
}

function aplicarPortafolioReporte(pfId) {
    const sel = document.getElementById('pf-reporte-select');
    if (!sel) return;
    const opt = sel.querySelector('option[value="' + pfId + '"]');
    if (!opt) return;

    const nombre    = opt.dataset.nombre || '';
    const desc      = opt.dataset.descripcion || '';
    const logo      = opt.dataset.logo || '{{ $fotoCV ?? $fotoFallback }}';
    const proyectos = JSON.parse(opt.dataset.proyectos || '[]');

    pfOcultarTodasExtras();

    // ── Template 7 (Hexágonos) — portada limpia + todas las proyectos en extra pages ──
    const lim7 = PF_LIMITS.t7;
    const p7first = proyectos.slice(0, lim7.first);   // [] porque first=0
    const p7extra = proyectos.slice(lim7.first);       // todos los proyectos
    if (document.getElementById('t7-name'))   document.getElementById('t7-name').textContent   = nombre;
    if (document.getElementById('t7-desc'))   document.getElementById('t7-desc').textContent   = desc;
    if (document.getElementById('t7-logo'))   document.getElementById('t7-logo').src            = logo;
    if (document.getElementById('t7-author')) document.getElementById('t7-author').textContent  =
        (document.getElementById('t7-author').dataset.autor || document.getElementById('t7-author').textContent);
    if (document.getElementById('t7-footer')) document.getElementById('t7-footer').textContent  = nombre + ' — Portafolio';
    // La primera página NO muestra proyectos (first:0)
    pfGenerarPaginasExtra('t7-extra-pages', 'pf-extra-t7', nombre, p7extra, lim7.extra);

    // ── Template 8 (Timeline Azul) ──
    const lim8 = PF_LIMITS.t8;
    const p8first = proyectos.slice(0, lim8.first);
    const p8extra = proyectos.slice(lim8.first);
    if (document.getElementById('t8-name'))        document.getElementById('t8-name').textContent        = nombre;
    if (document.getElementById('t8-desc'))        document.getElementById('t8-desc').textContent        = desc;
    if (document.getElementById('t8-logo'))        document.getElementById('t8-logo').src                 = logo;
    if (document.getElementById('t8-header-name')) document.getElementById('t8-header-name').textContent  = nombre;
    const t8proj = document.getElementById('t8-projects');
    if (t8proj) {
        t8proj.innerHTML = p8first.length
            ? p8first.map(p => `<div class="cv8-time-item"><div class="cv8-time-date">${p.deploy_url || p.repositorio_url ? 'Público' : 'Destacado'}</div><div class="cv8-time-title">${p.nombre}</div>${p.banner ? `<img src="${p.banner}" style="width:100%; height:140px; object-fit:cover; border-radius:6px; margin:8px 0;" alt="${p.nombre}">` : ''}<div class="cv8-time-desc">${p.descripcion || ''}</div></div>`).join('')
            : `<div class="cv8-time-item"><div class="cv8-time-title">Sin proyectos</div><div class="cv8-time-desc">Añade proyectos a tu portafolio.</div></div>`;
    }
    pfGenerarPaginasExtra('t8-extra-pages', 'pf-extra-t8', nombre, p8extra, lim8.extra);

    // ── Template 9 (Elegante) ──
    const lim9 = PF_LIMITS.t9;
    const p9first = proyectos.slice(0, lim9.first);
    const p9extra = proyectos.slice(lim9.first);
    if (document.getElementById('t9-name')) document.getElementById('t9-name').textContent = nombre;
    if (document.getElementById('t9-desc')) document.getElementById('t9-desc').textContent = desc;
    if (document.getElementById('t9-logo')) document.getElementById('t9-logo').src          = logo;
    const t9proj = document.getElementById('t9-projects');
    if (t9proj) {
        t9proj.innerHTML = p9first.length
            ? p9first.map(p => `<div class="cv9-project" style="padding:0; overflow:hidden; display:flex; flex-direction:row; min-height:120px; background:rgba(255,255,255,0.05); border-radius:8px;">${p.banner ? `<img src="${p.banner}" style="width:130px; object-fit:cover; flex-shrink:0; align-self:stretch;" alt="${p.nombre}">` : `<div style="width:130px; background:rgba(255,255,255,0.02); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.2); flex-shrink:0; align-self:stretch;">📦</div>`}<div style="padding:15px; flex:1; display:flex; flex-direction:column; justify-content:center;"><h3 class="cv9-proj-title" style="margin-bottom:6px; font-size:15px; font-weight:bold; color:#fff;">${p.nombre}</h3><p class="cv9-proj-desc" style="margin:0; font-size:12px; line-height:1.4; color:rgba(255,255,255,0.8);">${p.descripcion || ''}</p></div></div>`).join('')
            : `<div class="cv9-project"><h3 class="cv9-proj-title">Sin proyectos</h3><p class="cv9-proj-desc">Añade proyectos a tu portafolio.</p></div>`;
    }
    pfGenerarPaginasExtra('t9-extra-pages', 'pf-extra-t9', nombre, p9extra, lim9.extra);

    // ── Template 10 (Columnas Rosa) ──
    const lim10 = PF_LIMITS.t10;
    const p10first = proyectos.slice(0, lim10.first);
    const p10extra = proyectos.slice(lim10.first);
    if (document.getElementById('t10-name')) document.getElementById('t10-name').textContent = nombre;
    if (document.getElementById('t10-desc')) document.getElementById('t10-desc').textContent = desc;
    if (document.getElementById('t10-logo')) document.getElementById('t10-logo').src          = logo;
    const t10proj = document.getElementById('t10-projects');
    if (t10proj) {
        t10proj.innerHTML = p10first.length
            ? p10first.map(p => `<div class="cv10-item" style="display:flex; flex-direction:row; background:#fff; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden; margin-bottom:12px; min-height:100px; padding:0;">${p.banner ? `<img src="${p.banner}" style="width:120px; object-fit:cover; flex-shrink:0; align-self:stretch;" alt="${p.nombre}">` : `<div style="width:120px; background:#fce7f3; display:flex; align-items:center; justify-content:center; color:#fda4af; font-size:24px; flex-shrink:0; align-self:stretch;">📦</div>`}<div style="padding:15px; flex:1; display:flex; flex-direction:column; justify-content:center;"><h3 class="cv10-item-title" style="margin-bottom:6px; font-size:15px; font-weight:bold;">${p.nombre}</h3><p class="cv10-item-desc" style="margin:0; font-size:12px; line-height:1.4;">${p.descripcion || ''}</p></div></div>`).join('')
            : `<div class="cv10-item"><h3 class="cv10-item-title">Sin proyectos</h3><p class="cv10-item-desc">Añade proyectos a tu portafolio.</p></div>`;
    }
    pfGenerarPaginasExtra('t10-extra-pages', 'pf-extra-t10', nombre, p10extra, lim10.extra);

    // ── Activar los wrappers extra del template ACTIVO actual ──
    pfActivarExtrasDelTemplateActivo();
}

// ── Activa sólo el wrapper de páginas extra que corresponde al template activo ──
function pfActivarExtrasDelTemplateActivo() {
    pfOcultarTodasExtras();
    const activeTpl = document.querySelector('.cv-template-view.active-tpl');
    if (!activeTpl) return;
    const tId = activeTpl.id; // ej: 'cv-template-7'
    const wrapId = tId.replace('cv-template-', 't') + '-extra-pages'; // → 't7-extra-pages'
    const wrap = document.getElementById(wrapId);
    if (wrap && wrap.children.length > 0) {
        wrap.classList.add('active-extras');
    }
}

function updatePortafolioColorPicker(tplId) {
    const panel = document.getElementById('portafolio-color-panel');
    [7,8,9,10].forEach(n => {
        const ctrl = document.getElementById('color-ctrl-' + n);
        if (ctrl) ctrl.style.display = 'none';
    });
    const num = tplId ? tplId.replace('cv-template-', '') : null;
    const ctrl = num ? document.getElementById('color-ctrl-' + num) : null;
    if (ctrl) {
        panel.style.display = 'flex';
        ctrl.style.display = 'flex';
    } else {
        panel.style.display = 'none';
    }
}
function initializeCustomSelects() {
    const selects = document.querySelectorAll('#cv-template-select, #portafolio-select, #pf-reporte-select');
    selects.forEach(select => {
        // If already has a custom wrapper next to it
        if (select.nextElementSibling && select.nextElementSibling.classList.contains('custom-select-wrapper')) {
            const wrapper = select.nextElementSibling;
            const triggerText = wrapper.querySelector('.custom-select-val');
            const selectedOpt = select.options[select.selectedIndex];
            if (triggerText && selectedOpt) {
                triggerText.textContent = selectedOpt.textContent.trim();
            }
            wrapper.querySelectorAll('.custom-option').forEach(opt => {
                opt.classList.toggle('selected', opt.dataset.value === select.value);
            });
            return;
        }

        // Hide the original select
        select.style.display = 'none';

        const wrapper = document.createElement('div');
        wrapper.className = 'custom-select-wrapper';
        if (select.id === 'pf-reporte-select') {
            wrapper.classList.add('custom-select-sm');
        }

        const trigger = document.createElement('div');
        trigger.className = 'custom-select-trigger';
        
        const selectedOpt = select.options[select.selectedIndex];
        const valSpan = document.createElement('span');
        valSpan.className = 'custom-select-val';
        valSpan.textContent = selectedOpt ? selectedOpt.textContent.trim() : '';
        
        trigger.innerHTML = `
            <span class="custom-select-val">${valSpan.textContent}</span>
            <svg class="custom-select-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        `;
        
        const optionsContainer = document.createElement('div');
        optionsContainer.className = 'custom-select-options';
        
        Array.from(select.options).forEach(opt => {
            const customOpt = document.createElement('div');
            customOpt.className = 'custom-option';
            if (opt.value === select.value) {
                customOpt.classList.add('selected');
            }
            customOpt.dataset.value = opt.value;
            customOpt.textContent = opt.textContent.trim();
            
            customOpt.addEventListener('click', (e) => {
                e.stopPropagation();
                select.value = opt.value;
                select.dispatchEvent(new Event('change'));
                
                trigger.querySelector('.custom-select-val').textContent = opt.textContent.trim();
                optionsContainer.querySelectorAll('.custom-option').forEach(o => o.classList.remove('selected'));
                customOpt.classList.add('selected');
                wrapper.classList.remove('open');
            });
            
            optionsContainer.appendChild(customOpt);
        });
        
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('.custom-select-wrapper').forEach(w => {
                if (w !== wrapper) w.classList.remove('open');
            });
            wrapper.classList.toggle('open');
        });
        
        wrapper.appendChild(trigger);
        wrapper.appendChild(optionsContainer);
        select.parentNode.insertBefore(wrapper, select.nextSibling);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const pfSel = document.getElementById('pf-reporte-select');
    if (pfSel && pfSel.options.length > 0) {
        aplicarPortafolioReporte(pfSel.value);
    }
    initializeCustomSelects();
});

// Click outside to close dropdowns
document.addEventListener('click', function() {
    document.querySelectorAll('.custom-select-wrapper').forEach(w => w.classList.remove('open'));
});

// Initialize immediately if script is loaded dynamically (via fetch/innerHTML)
initializeCustomSelects();
(function() {
    const pfSel = document.getElementById('pf-reporte-select');
    if (pfSel && pfSel.options.length > 0) {
        aplicarPortafolioReporte(pfSel.value);
    }
})();
</script>

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



    {{-- ── TEMPLATE 7 · Portafolio Hexágonos (Amarillo/Naranja) ── --}}
    <div class="cv-container cv-template-view landscape-layout" id="cv-template-7">
        <div class="cv7-bg">
            <div class="cv7-hex-big"></div>
            <div class="cv7-hex-photo-wrap">
                <img src="{{ $r_pf_activo?->logo_url ?? $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv7-photo" id="t7-logo">
            </div>
            <div class="cv7-hex-small1"></div>
            <div class="cv7-hex-small2"></div>
        </div>
        <div class="cv7-content">
            <div class="cv7-header">
                <h1 class="cv7-name" id="t7-name">{{ $r_pf_activo?->nombre ?? 'Mi Portafolio' }}</h1>
                <h2 class="cv7-role" id="t7-desc">{{ $r_pf_activo?->descripcion ?? 'Descripción de mi portafolio' }}</h2>
            </div>
        </div>
        <div class="cv7-footer" id="t7-footer">
            {{ $r_pf_activo?->nombre ?? 'Portafolio' }} — Portafolio
        </div>
        {{-- Nombre del autor – esquina inferior derecha --}}
        <div class="cv7-author" id="t7-author">
            <span class="cv7-author-label">Autor</span>
            <span class="cv7-author-name" id="t7-author-name">{{ $r_user?->nombre }} {{ $r_user?->apellido }}</span>
        </div>
    </div>{{-- /cv-template-7 --}}
    {{-- ── Páginas extra T7 ── --}}
    <div class="pf-extra-pages-wrap" id="t7-extra-pages"></div>

    {{-- ── TEMPLATE 8 · Portafolio Timeline Azul ── --}}

    <div class="cv-container cv-template-view landscape-layout" id="cv-template-8">
        <div class="cv8-left">
            <div class="cv8-photo-container">
                <img src="{{ $r_pf_activo?->logo_url ?? $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv8-photo" id="t8-logo">
            </div>
            <h1 class="cv8-name" id="t8-name">{{ $r_pf_activo?->nombre ?? 'Portafolio' }}</h1>
            <p class="cv8-bio" id="t8-desc">{{ $r_pf_activo?->descripcion ?? 'Descripción de mi portafolio' }}</p>
            <div class="cv8-ribbon-tail"></div>
        </div>
        <div class="cv8-right">
            <div class="cv8-header">
                <h2 id="t8-header-name">{{ $r_pf_activo?->nombre ?? 'Portafolio' }}</h2>
            </div>
            <div class="cv8-main-title">PROYECTOS DESTACADOS</div>
            <div class="cv8-timeline-container">
                <div class="cv8-col" style="width: 100%">
                    <div class="cv8-timeline" id="t8-projects">
                        @forelse($r_proyectos as $proy)
                        <div class="cv8-time-item">
                            <div class="cv8-time-date">{{ $proy->deploy_url || $proy->repositorio_url ? 'Público' : 'Destacado' }}</div>
                            <div class="cv8-time-title">{{ $proy->nombre }}</div>
                            <div class="cv8-time-desc">{{ $proy->descripcion }}</div>
                        </div>
                        @empty
                        <div class="cv8-time-item">
                            <div class="cv8-time-title">Sin proyectos</div>
                            <div class="cv8-time-desc">Añade proyectos a tu portafolio.</div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- /cv-template-8 --}}
    {{-- ── Páginas extra T8 ── --}}
    <div class="pf-extra-pages-wrap" id="t8-extra-pages"></div>

    {{-- ── TEMPLATE 9 · Portafolio Elegante (Círculos Azul/Gris) ── --}}
    <div class="cv-container cv-template-view landscape-layout" id="cv-template-9">
        <div class="cv9-top">
            <div class="cv9-top-text">
                Portafolio de proyectos<br>
                <span id="t9-name" style="font-weight:700;">{{ $r_pf_activo?->nombre ?? 'Mi Portafolio' }}</span>
            </div>
            <div class="cv9-photo-wrapper">
                <img src="{{ $r_pf_activo?->logo_url ?? $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv9-photo" id="t9-logo">
            </div>
        </div>
        <div class="cv9-bottom">
            <div class="cv9-bottom-left">
                <div class="cv9-contact">
                    <div class="cv9-contact-row"><span class="cv9-label">Descripción:</span></div>
                    <div class="cv9-contact-row" style="margin-top:10px;"><span class="cv9-val" id="t9-desc" style="white-space:normal;line-height:1.4;">{{ $r_pf_activo?->descripcion ?? 'Descripción de mi portafolio' }}</span></div>
                    <div class="cv9-contact-row" style="margin-top:20px;"><span class="cv9-label">Autor:</span></div>
                    <div class="cv9-contact-row"><span class="cv9-val">{{ $r_user?->nombre }} {{ $r_user?->apellido }}</span></div>
                </div>
            </div>
            <div class="cv9-bottom-right">
                <div class="cv9-name-box">
                    <h1 class="cv9-name">Proyectos</h1>
                </div>
                <div class="cv9-projects" id="t9-projects">
                    @forelse($r_proyectos as $proy)
                        <div class="cv9-project">
                            <h3 class="cv9-proj-title">{{ $proy->nombre }}</h3>
                            <p class="cv9-proj-desc">{{ $proy->descripcion }}</p>
                        </div>
                    @empty
                        <div class="cv9-project">
                            <h3 class="cv9-proj-title">Sin proyectos</h3>
                            <p class="cv9-proj-desc">Añade proyectos a tu portafolio.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>{{-- /cv-template-9 --}}
    {{-- ── Páginas extra T9 ── --}}
    <div class="pf-extra-pages-wrap" id="t9-extra-pages"></div>

    {{-- ── TEMPLATE 10 · Portafolio Columnas Minimalista ── --}}
    <div class="cv-container cv-template-view landscape-layout" id="cv-template-10">
        <div class="cv10-col-left">
            <div class="cv10-photo-wrap">
                <img src="{{ $r_pf_activo?->logo_url ?? $fotoCV ?? $fotoFallback }}" alt="Foto" class="cv10-photo" id="t10-logo">
            </div>
            <h1 class="cv10-name" id="t10-name">{{ $r_pf_activo?->nombre ?? 'Mi Portafolio' }}</h1>
            <p style="font-size:12px; color:var(--muted); text-align:center; padding: 0 15px;" id="t10-desc">{{ $r_pf_activo?->descripcion ?? 'Descripción de mi portafolio' }}</p>
        </div>
        <div class="cv10-col-mid" style="width:45%">
            <h2 class="cv10-title">Proyectos <br><small>Destacados</small></h2>
            <div class="cv10-timeline" id="t10-projects">
                @forelse($r_proyectos as $proy)
                    <div class="cv10-item">
                        <h3 class="cv10-item-title">{{ $proy->nombre }}</h3>
                        <p class="cv10-item-desc">{{ $proy->descripcion }}</p>
                    </div>
                @empty
                    <div class="cv10-item">
                        <h3 class="cv10-item-title">Sin proyectos</h3>
                        <p class="cv10-item-desc">Añade proyectos a tu portafolio.</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="cv10-col-right" style="width:30%">
            <h2 class="cv10-title">Autor</h2>
            <div class="cv10-box">
                <h3 class="cv10-box-title">{{ $r_user?->nombre }}</h3>
                <ul class="cv10-list" style="word-break: break-word;">
                    <li>{{ $r_user?->profesion }}</li>
                    <li>{{ $r_user?->email }}</li>
                </ul>
            </div>
        </div>
    </div>{{-- /cv-template-10 --}}
    {{-- ── Páginas extra T10 ── --}}
    <div class="pf-extra-pages-wrap" id="t10-extra-pages"></div>

</div>{{-- /cv-wrapper --}}
