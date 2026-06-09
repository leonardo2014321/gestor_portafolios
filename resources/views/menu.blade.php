<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SansiFolios - UMSS' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('_styles_menu')
</head>
<body class="app-locked">
<div class="app">

    {{-- ══ TOPBAR ══ --}}
    @include('components.layout.navbar')

    <div class="body-row">

        {{-- ══ SIDEBAR ══ --}}
        <aside id="main-sidebar">
            <div class="sb-top">
                <div class="sb-label">{{ __('app.menu.menu_principal') }}</div>
                
                <button class="sb-close-btn" onclick="toggleSidebar()">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>

                <button id="btn-menu" class="sb-item active" onclick="showView('menu'); if(window.innerWidth <= 992) toggleSidebar();">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>{{ __('app.menu.mis_portafolios') }}</span>
                </button>



                <button id="btn-reportes" class="sb-item" onclick="showView('reportes'); if(window.innerWidth <= 992) toggleSidebar();">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>{{ __('app.menu.reportes') }}</span>
                </button>

                <button id="btn-perfil" class="sb-item" onclick="showView('perfil'); if(window.innerWidth <= 992) toggleSidebar();">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>{{ __('app.menu.mi_perfil') }}</span>
                </button>
            </div>
        </aside>

        <div class="content-wrapper">

            {{-- ══ MAIN: VISTAS ══ --}}
            <main>
                <div class="main-inner">

                    {{-- Vista: Menú principal --}}
                    <div class="view active" id="view-menu">
                        @include('_view_mis_portafolios')
                    </div>

                    {{-- Vista: Explorador (HTML + JS en _explorador_menu) --}}
                    <div class="view" id="view-explorador">
                        @include('_explorador_menu')
                    </div>

                    {{-- Vista: Características --}}
                    <div class="view" id="view-caracteristicas">
                        @include('_caracteristicas_menu')
                    </div>

                    {{-- Formulario logout (oculto, usado por ejecutarLogout) --}}
                    <form method="POST" action="{{ route('logout') }}" id="formLogout" style="display:none;">
                        @csrf
                    </form>

                    {{-- Vista: Portafolios --}}
                    <div class="view" id="view-portafolios">
                        @include('_portafolios_menu')
                    </div>

                    {{-- Vista: Reportes / CV (JS en _reportes_menu) --}}
                    <div class="view" id="view-reportes">
                        @include('_reportes_menu')
                    </div>

                    {{-- Vista: Mi Perfil --}}
                    <div class="view" id="view-perfil">
                        @include('perfil.index')
                    </div>

                </div>
            </main>

            {{-- ══ RIGHT PANEL ══
                 Calendario → _calendario_menu (HTML + JS + modal)
                 Notificaciones dinámicas → _notificaciones_menu (solo JS)
            ══ --}}
            <div id="right-panel" class="rpanel">
                <button class="rp-close-btn" onclick="toggleRpanel()">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
                @include('_calendario_menu')

                {{-- Bandeja de notificaciones --}}
                <div class="rp-sec" id="rp-bandeja-sec" style="padding:0;overflow:hidden;">

                    {{-- Header campanita (siempre visible, toggle) --}}
                    <div id="rp-notif-toggle-btn"
                        style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border-bottom:1px solid #f1f5f9;cursor:pointer;transition:background .15s;user-select:none;"
                        onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background='none'"
                        onclick="rpToggleBandeja()">
                        {{-- Lado izquierdo: campanita + texto + badge --}}
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="position:relative;display:inline-flex;align-items:center;">
                                <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:#374151;stroke-width:2;display:block;">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                </svg>
                                <span id="rp-notif-dot"
                                    style="display:none;position:absolute;top:-3px;right:-3px;width:8px;height:8px;background:#ef4444;border-radius:50%;border:1.5px solid #fff;"></span>
                            </span>
                            <span style="font-size:12px;font-weight:600;color:#374151;line-height:1;">Notificaciones</span>
                            <span id="rp-notif-count-badge"
                                style="display:none;font-size:9px;font-weight:700;padding:1px 6px;border-radius:999px;background:#ef4444;color:#fff;line-height:1.6;"></span>
                        </div>
                        {{-- Lado derecho: marcar leídas + chevron --}}
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span id="rp-marcar-btn" onclick="event.stopPropagation(); rpNotifMarcarTodas()"
                                style="display:none;font-size:10px;color:#2563eb;cursor:pointer;font-weight:600;line-height:1;">
                                ✓ Todas leídas
                            </span>
                            <svg id="rp-notif-chevron" viewBox="0 0 24 24"
                                style="width:13px;height:13px;fill:none;stroke:#94a3b8;stroke-width:2.5;transition:transform .25s;display:block;flex-shrink:0;">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Contenedor colapsable con slide --}}
                    <div id="rp-notif-collapsible" style="overflow:hidden;max-height:0;transition:max-height .35s cubic-bezier(.4,0,.2,1);">

                    {{-- Vista: Lista --}}
                    <div id="rp-vista-lista">
                        <div id="rp-notif-loading" style="padding:20px;text-align:center;">
                            <div style="display:inline-block;width:18px;height:18px;border:2px solid #e2e8f0;border-top-color:#2563eb;border-radius:50%;animation:rp-spin 0.7s linear infinite;"></div>
                        </div>
                        <div id="rp-notif-lista" style="display:none;max-height:340px;overflow-y:auto;"></div>
                    </div>

                    {{-- Vista: Detalle (bandeja de entrada) --}}
                    <div id="rp-vista-detalle" style="display:none;">
                        <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;border-bottom:1px solid #f1f5f9;">
                            <button onclick="rpVolverLista()" style="background:none;border:none;cursor:pointer;padding:4px;color:#64748b;display:flex;align-items:center;gap:4px;font-size:12px;font-weight:600;">
                                <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2.5"><polyline points="15 18 9 12 15 6"/></svg>
                                Volver
                            </button>
                            <span id="rp-det-badge" style="display:none;font-size:9px;font-weight:700;padding:2px 7px;border-radius:999px;background:#fef3c7;color:#92400e;">✉ Mensaje</span>
                        </div>
                        <div style="padding:16px 14px;">
                            <div id="rp-det-titulo" style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:4px;"></div>
                            <div id="rp-det-meta" style="font-size:11px;color:#94a3b8;margin-bottom:14px;"></div>
                            <div id="rp-det-mensaje" style="font-size:13px;color:#334155;line-height:1.65;white-space:pre-wrap;word-break:break-word;"></div>
                        </div>
                        <div style="display:flex;gap:8px;padding:12px 14px;border-top:1px solid #f1f5f9;">
                            <button id="rp-det-eliminar" onclick="rpEliminarActual()"
                                style="flex:1;font-size:12px;font-weight:600;color:#ef4444;background:#fff5f5;border:1px solid #fecaca;border-radius:8px;padding:7px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px;">
                                <svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                Eliminar
                            </button>
                        </div>
                    </div>

                    </div>{{-- /rp-notif-collapsible --}}

                </div>

                {{-- Enlaces rápidos --}}
                <div class="rp-sec">
                    <div class="rp-ttl">
                        <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 1 7.54.54l3 3a5 5 0 0 1-7.07 7.07l-1.72-1.71"/><path d="M14 11a5 5 0 0 1-7.54-.54l-3-3A5 5 0 0 1 10.54.39l1.71 1.71"/></svg>
                        {{ __('app.menu.enlaces') }}
                    </div>
                    @include('_contactar_admin')
                    <a href="https://www.umss.edu.bo/" target="_blank" rel="noopener" class="enlace">
                        <div class="en-ico blue"><svg viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg></div>
                        <div class="en-lbl">{{ __('app.menu.portal_umss') }}</div>
                    </a>
                </div>

                <style>
                    @keyframes rp-spin { to { transform: rotate(360deg); } }
                    @keyframes rp-fadein { from { opacity:0; transform:translateY(4px); } to { opacity:1; transform:translateY(0); } }

                    .rp-notif-item {
                        display: flex;
                        gap: 10px;
                        padding: 11px 14px;
                        border-bottom: 1px solid #f1f5f9;
                        transition: background .2s;
                        animation: rp-fadein .25s ease;
                        cursor: default;
                    }
                    .rp-notif-item:last-child { border-bottom: none; }
                    .rp-notif-item.unread { background: #eff6ff; border-left: 3px solid #2563eb; }
                    .rp-notif-item.unread.contacto { background: #fffbeb; border-left-color: #d97706; }

                    .rp-notif-dot {
                        width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; margin-top: 5px;
                    }
                    .rp-notif-item.unread       .rp-notif-dot { background: #2563eb; }
                    .rp-notif-item.unread.contacto .rp-notif-dot { background: #d97706; }
                    .rp-notif-item:not(.unread) .rp-notif-dot { background: #e2e8f0; }

                    .rp-notif-badge {
                        display: inline-flex; align-items: center; gap: 3px;
                        font-size: 9px; font-weight: 700; padding: 2px 6px;
                        border-radius: 999px; margin-bottom: 4px;
                        background: #fef3c7; color: #92400e;
                    }
                    .rp-notif-titulo {
                        font-size: 12px; color: #0f172a; margin-bottom: 3px;
                        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
                    }
                    .rp-notif-titulo.bold { font-weight: 700; }
                    .rp-notif-preview { font-size: 11px; color: #64748b; line-height: 1.4; }
                    .rp-notif-footer {
                        display: flex; align-items: center; justify-content: space-between; margin-top: 5px;
                    }
                    .rp-notif-time { font-size: 10px; color: #94a3b8; }
                    .rp-notif-ver {
                        font-size: 10px; font-weight: 600; background: none; border: none;
                        cursor: pointer; padding: 0; color: #2563eb;
                    }
                    .rp-notif-ver.contacto { color: #d97706; }

                    /* ── Responsive: right panel en móvil ── */
                    @media (max-width: 768px) {
                        #right-panel.rpanel {
                            position: fixed !important;
                            top: 0 !important;
                            right: 0 !important;
                            width: 100vw !important;
                            max-width: 100vw !important;
                            height: 100dvh !important;
                            z-index: 999 !important;
                            overflow-y: auto !important;
                            transform: translateX(100%);
                            transition: transform .28s cubic-bezier(.4,0,.2,1);
                            border-radius: 0 !important;
                        }
                        #right-panel.rpanel.show {
                            transform: translateX(0) !important;
                        }
                        .rp-notif-item { padding: 13px 16px; }
                        .rp-notif-titulo { font-size: 13px; }
                        .rp-notif-preview { font-size: 12px; }
                        .rp-notif-time, .rp-notif-ver { font-size: 11px; }
                    }
                    @media (min-width: 769px) and (max-width: 1100px) {
                        #right-panel.rpanel { width: 280px !important; }
                    }
                </style>

                <script>
                (function () {
                    let rpDatos = [];
                    let rpDetalleId = null;

                    /* ── Utilidades ── */
                    function rpFecha(str) {
                        const d = new Date(str), ahora = new Date();
                        const diffMin = Math.floor((ahora - d) / 60000);
                        if (diffMin < 1)  return 'Ahora';
                        if (diffMin < 60) return `Hace ${diffMin} min`;
                        const diffH = Math.floor(diffMin / 60);
                        if (diffH < 24)   return `Hace ${diffH}h`;
                        return d.toLocaleDateString('es-BO', { day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit' });
                    }
                    function rpEscape(s) {
                        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    }

                    /* ── rpRender: único punto de entrada de datos al panel derecho ──
                       Lo llama notifCargar() (navbar) en cada polling y en la carga inicial.
                       El right-panel nunca hace fetch propio. */
                    window.rpRender = function(notifs) {
                        // Apuntar al array global compartido para que los cambios de leída
                        // en cualquier lado se reflejen en ambos sin necesidad de sync manual
                        rpDatos = notifs;

                        /* punto rojo + badge conteo */
                        const noLeidas = notifs.filter(n => !n.leida).length;
                        const dot      = document.getElementById('rp-notif-dot');
                        const cbadge   = document.getElementById('rp-notif-count-badge');
                        const marcBtn  = document.getElementById('rp-marcar-btn');
                        if (dot)    dot.style.display    = noLeidas ? 'block' : 'none';
                        if (cbadge) { cbadge.style.display = noLeidas ? 'inline-flex' : 'none'; cbadge.textContent = noLeidas > 9 ? '9+' : noLeidas; }
                        if (marcBtn) marcBtn.style.display = noLeidas ? 'block' : 'none';

                        /* ocultar spinner, mostrar lista */
                        const loading = document.getElementById('rp-notif-loading');
                        const lista   = document.getElementById('rp-notif-lista');
                        if (loading) loading.style.display = 'none';
                        if (!lista)  return;
                        lista.style.display = 'block';

                        if (!notifs.length) {
                            lista.innerHTML = `
                                <div style="padding:32px 16px;text-align:center;">
                                    <svg viewBox="0 0 24 24" style="width:36px;height:36px;fill:none;stroke:#cbd5e1;stroke-width:1.5;margin:0 auto 10px;display:block">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                    </svg>
                                    <p style="color:#94a3b8;font-size:12px;margin:0;font-weight:500;">Sin notificaciones</p>
                                    <p style="color:#cbd5e1;font-size:11px;margin:4px 0 0;">Todo al día ✓</p>
                                </div>`;
                            setTimeout(rpRefreshHeight, 30);
                            return;
                        }

                        lista.innerHTML = notifs.map(n => {
                            const esContacto  = n.es_contacto === true;
                            const accentColor = esContacto ? '#d97706' : '#2563eb';
                            const clases = ['rp-notif-item', !n.leida ? 'unread' : '', esContacto ? 'contacto' : ''].filter(Boolean).join(' ');
                            const preview = n.mensaje.length > 55 ? n.mensaje.substring(0, 55) + '…' : n.mensaje;
                            return `<div class="${clases}" id="rp-ni-${n.id}" onclick="rpAbrirDetalle(${n.id})" style="cursor:pointer;">
                                <div class="rp-notif-dot"></div>
                                <div style="flex:1;min-width:0;">
                                    ${esContacto ? `<div class="rp-notif-badge">✉ ${n.remitente ? rpEscape(n.remitente) : 'Usuario'}</div>` : ''}
                                    <div class="rp-notif-titulo ${!n.leida ? 'bold' : ''}">${rpEscape(n.titulo)}</div>
                                    <div class="rp-notif-preview">${rpEscape(preview)}</div>
                                    <div class="rp-notif-footer">
                                        <span class="rp-notif-time">${rpFecha(n.created_at)}</span>
                                        <svg viewBox="0 0 24 24" style="width:11px;height:11px;fill:none;stroke:${accentColor};stroke-width:2.5;flex-shrink:0;"><polyline points="9 18 15 12 9 6"/></svg>
                                    </div>
                                </div>
                            </div>`;
                        }).join('');
                        setTimeout(rpRefreshHeight, 30);
                    };

                    /* ── Toggle colapsable ── */
                    let rpBandejaAbierta = false;
                    window.rpToggleBandeja = function() {
                        const col     = document.getElementById('rp-notif-collapsible');
                        const chevron = document.getElementById('rp-notif-chevron');
                        rpBandejaAbierta = !rpBandejaAbierta;
                        if (rpBandejaAbierta) {
                            col.style.maxHeight = col.scrollHeight + 400 + 'px';
                            chevron.style.transform = 'rotate(180deg)';
                        } else {
                            col.style.maxHeight = '0';
                            chevron.style.transform = 'rotate(0deg)';
                        }
                    };
                    function rpRefreshHeight() {
                        if (!rpBandejaAbierta) return;
                        const col = document.getElementById('rp-notif-collapsible');
                        col.style.maxHeight = col.scrollHeight + 400 + 'px';
                    }

                    /* ── Abrir detalle ── */
                    window.rpAbrirDetalle = async function(id) {
                        const n = rpDatos.find(x => x.id === id);
                        if (!n) return;
                        rpDetalleId = id;

                        const esContacto = n.es_contacto === true;

                        // Rellenar detalle
                        document.getElementById('rp-det-titulo').textContent  = n.titulo;
                        document.getElementById('rp-det-mensaje').textContent = n.mensaje;
                        const badge = document.getElementById('rp-det-badge');
                        if (esContacto) {
                            badge.textContent = '✉ ' + (n.remitente || 'Usuario');
                            badge.style.display = 'inline-flex';
                        } else {
                            badge.style.display = 'none';
                        }
                        const meta = document.getElementById('rp-det-meta');
                        meta.textContent = rpFecha(n.created_at) + (n.leida ? '  ·  Leída' : '  ·  No leída');

                        // Cambiar vista con animación
                        const vLista   = document.getElementById('rp-vista-lista');
                        const vDetalle = document.getElementById('rp-vista-detalle');
                        vLista.style.transition   = 'opacity .15s';
                        vLista.style.opacity      = '0';
                        setTimeout(() => {
                            vLista.style.display   = 'none';
                            vDetalle.style.display = 'block';
                            vDetalle.style.opacity = '0';
                            vDetalle.style.transition = 'opacity .15s';
                            requestAnimationFrame(() => vDetalle.style.opacity = '1');
                            setTimeout(rpRefreshHeight, 30);
                        }, 150);

                        // Marcar como leída automáticamente
                        if (!n.leida) {
                            n.leida = true;

                            // Sincronizar también el array del navbar
                            if (typeof notifDatos !== 'undefined') {
                                const nNavbar = notifDatos.find(x => x.id === id);
                                if (nNavbar) nNavbar.leida = true;
                            }

                            const token = document.querySelector('meta[name="csrf-token"]').content;
                            await fetch(`/mis-notificaciones/${id}/leida`, {
                                method: 'POST', headers: { 'X-CSRF-TOKEN': token }
                            });

                            // Actualizar badge navbar
                            const badge2 = document.getElementById('notif-badge');
                            if (badge2) {
                                let c = Math.max(0, (parseInt(badge2.textContent) || 0) - 1);
                                badge2.textContent = c > 9 ? '9+' : c;
                                if (c === 0) badge2.style.display = 'none';
                            }
                            // Actualizar punto rojo y badge del panel derecho
                            const noLeidas = rpDatos.filter(x => !x.leida).length;
                            const dot    = document.getElementById('rp-notif-dot');
                            const cbadge = document.getElementById('rp-notif-count-badge');
                            const marcBtn = document.getElementById('rp-marcar-btn');
                            if (dot)    dot.style.display    = noLeidas ? 'block' : 'none';
                            if (cbadge) { cbadge.style.display = noLeidas ? 'inline-flex' : 'none'; cbadge.textContent = noLeidas > 9 ? '9+' : noLeidas; }
                            if (marcBtn) marcBtn.style.display = noLeidas ? 'block' : 'none';
                        }
                    };

                    /* ── Volver a lista ── */
                    window.rpVolverLista = function() {
                        const vLista   = document.getElementById('rp-vista-lista');
                        const vDetalle = document.getElementById('rp-vista-detalle');
                        vDetalle.style.transition = 'opacity .15s';
                        vDetalle.style.opacity    = '0';
                        setTimeout(() => {
                            vDetalle.style.display = 'none';
                            vLista.style.display   = 'block';
                            vLista.style.opacity   = '0';
                            vLista.style.transition = 'opacity .15s';
                            requestAnimationFrame(() => vLista.style.opacity = '1');
                            rpRender(rpDatos); // refrescar por si cambió leída
                            setTimeout(rpRefreshHeight, 50);
                        }, 150);
                        rpDetalleId = null;
                    };

                    /* ── Eliminar notificación actual ── */
                    window.rpEliminarActual = async function() {
                        if (!rpDetalleId) return;
                        const btn = document.getElementById('rp-det-eliminar');
                        btn.disabled = true;
                        btn.innerHTML = `<svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;animation:rp-spin .7s linear infinite"><circle cx="12" cy="12" r="10"/></svg> Eliminando...`;

                        const token = document.querySelector('meta[name="csrf-token"]').content;
                        try {
                            const res = await fetch(`/mis-notificaciones/${rpDetalleId}`, {
                                method: 'DELETE', headers: { 'X-CSRF-TOKEN': token }
                            });
                            if (!res.ok) throw new Error();
                            // Quitar de ambos arrays
                            rpDatos = rpDatos.filter(n => n.id !== rpDetalleId);
                            if (typeof notifDatos !== 'undefined') {
                                notifDatos.splice(0, notifDatos.length, ...notifDatos.filter(n => n.id !== rpDetalleId));
                                // Actualizar badge navbar
                                const noLeidas = notifDatos.filter(n => !n.leida).length;
                                const badge = document.getElementById('notif-badge');
                                if (badge) { badge.textContent = noLeidas > 9 ? '9+' : noLeidas; badge.style.display = noLeidas ? 'block' : 'none'; }
                            }
                            rpVolverLista();
                        } catch(e) {
                            btn.disabled = false;
                            btn.innerHTML = `<svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg> Eliminar`;
                            alert('No se pudo eliminar. Inténtalo de nuevo.');
                        }
                    };

                    /* ── Cargar desde API ── */
                    async function rpCargar() {
                        const loading = document.getElementById('rp-notif-loading');
                        const lista   = document.getElementById('rp-notif-lista');
                        loading.style.display = 'block';
                        lista.style.display   = 'none';
                        loading.innerHTML = `<div style="padding:20px;text-align:center;"><div style="display:inline-block;width:18px;height:18px;border:2px solid #e2e8f0;border-top-color:#2563eb;border-radius:50%;animation:rp-spin 0.7s linear infinite;"></div></div>`;

                        const controller = new AbortController();
                        const timer = setTimeout(() => controller.abort(), 8000);
                        try {
                            const res = await fetch('/mis-notificaciones', {
                                signal: controller.signal,
                                headers: { 'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                            });
                            clearTimeout(timer);
                            const data = await res.json();
                            loading.style.display = 'none';
                            lista.style.display   = 'block';
                            window.rpRender(data.notificaciones || []);
                        } catch(e) {
                            clearTimeout(timer);
                            const msg = e.name === 'AbortError' ? 'La solicitud tardó demasiado.' : 'No se pudieron cargar.';
                            loading.innerHTML = `
                                <div style="padding:20px 16px;text-align:center;">
                                    <svg viewBox="0 0 24 24" style="width:26px;height:26px;fill:none;stroke:#fca5a5;stroke-width:1.5;margin:0 auto 8px;display:block"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    <p style="color:#94a3b8;font-size:11px;margin:0 0 10px;">${msg}</p>
                                    <button onclick="rpCargar()" style="font-size:11px;color:#2563eb;background:none;border:1px solid #bfdbfe;border-radius:6px;padding:4px 12px;cursor:pointer;font-weight:600;">↺ Reintentar</button>
                                </div>`;
                        }
                    }

                    window.rpNotifMarcarTodas = async function() {
                        if (typeof notifMarcarTodasLeidas === 'function') {
                            await notifMarcarTodasLeidas();
                            // notifCargar() del polling actualizará rpRender automáticamente
                        }
                    };

                    // toggleRpanel: solo muestra el panel, los datos ya vienen del polling
                    const _origToggle = window.toggleRpanel;
                    window.toggleRpanel = function() {
                        if (typeof _origToggle === 'function') _origToggle();
                    };

                })();
                </script>

            </div>{{-- /rpanel --}}

        </div>{{-- /content-wrapper --}}
    </div>{{-- /body-row --}}

    @include('components.layout.footer')

    <!-- Modal para leer notificaciones -->
<div id="modal-notificacion" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; max-width:500px; width:90%; max-height:80%; overflow:auto; padding:24px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 id="modal-titulo" style="margin:0; font-size:18px; color:#0f172a;">Título</h3>
            <button onclick="cerrarModalNotificacion()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#94a3b8;">&times;</button>
        </div>
        <div id="modal-mensaje" style="font-size:14px; line-height:1.6; color:#334155; white-space:pre-wrap; word-break:break-word;"></div>
        <div style="margin-top:20px; text-align:right;">
            <button onclick="cerrarModalNotificacion()" style="background:#2563eb; color:#fff; border:none; padding:8px 20px; border-radius:8px; cursor:pointer;">Cerrar</button>
        </div>
    </div>
</div>

</div>{{-- /app --}}

{{-- ══ MODALES ══ --}}
@include('_modales_crear_portafolio')

{{-- ══ SCRIPTS PRINCIPALES ══ --}}
<script>
    /* ── Navegación entre vistas ── */
    function showView(name) {
        if (name === 'reportes') {
            const targetView = document.getElementById('view-reportes');
            if (targetView && targetView.classList.contains('active')) {
                return;
            }

            const activeTpl = document.querySelector('.cv-template-view.active-tpl');
            const activeId = activeTpl ? activeTpl.id : 'cv-template-1';
            
            const pfSel = document.getElementById('pf-reporte-select');
            const activePfId = pfSel ? pfSel.value : null;

            fetch('{{ route("reportes") }}')
                .then(res => res.text())
                .then(html => {
                    document.getElementById('view-reportes').innerHTML = html;
                    if (typeof switchRepTab === 'function') {
                        const isPf = ['cv-template-7', 'cv-template-8', 'cv-template-9', 'cv-template-10'].includes(activeId);
                        switchRepTab(isPf ? 'portafolio' : 'cv', activeId);

                        const newPfSel = document.getElementById('pf-reporte-select');
                        if (newPfSel && activePfId) {
                            newPfSel.value = activePfId;
                            if (typeof aplicarPortafolioReporte === 'function') {
                                aplicarPortafolioReporte(activePfId);
                            }
                        } else if (newPfSel && newPfSel.options.length > 0) {
                            if (typeof aplicarPortafolioReporte === 'function') {
                                aplicarPortafolioReporte(newPfSel.value);
                            }
                        }
                    }
                    if (typeof initializeCustomSelects === 'function') {
                        initializeCustomSelects();
                    }
                });
        }
        document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
        document.getElementById('view-' + name).classList.add('active');
        document.querySelectorAll('.sb-item').forEach(b => b.classList.remove('active'));
        const btn = document.getElementById('btn-' + name);
        if (btn) btn.classList.add('active');
        document.querySelector('main').scrollTop = 0;
    }

    /* ── Atajos de teclado ──
       Ctrl+K  → abre el explorador y enfoca el buscador
       Escape  → limpia el buscador si está activo
    ── */
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            showView('explorador');
            document.getElementById('expSearch').focus();
        }
        if (e.key === 'Escape') {
            const input = document.getElementById('expSearch');
            if (document.activeElement === input) {
                input.value = '';
                expFilter();
                input.blur();
                document.getElementById('expHistory').style.display = 'none';
            }
        }
    });

    /* ── Marcar menú principal como activo al cargar ── */
    document.getElementById('btn-menu').classList.add('active');

    /*
     * LOGOUT: el modal y el spinner están definidos en navbar.blade.php.
     * confirmarLogout() y ejecutarLogoutGlobal() vienen del navbar compartido,
     * no hace falta redefinirlos aquí.
     */

    /* ── CV / Reportes ──
       selectTemplate → cambia la plantilla visible
       toggleEditCV   → activa/desactiva edición inline del CV
    ── */
    function selectTemplate(tplId) {
        document.querySelectorAll('.cv-template-view').forEach(el => el.classList.remove('active-tpl'));
        const tpl = document.getElementById(tplId);
        if (tpl) {
            tpl.classList.add('active-tpl');
            let styleEl = document.getElementById('print-page-style');
            if (!styleEl) {
                styleEl = document.createElement('style');
                styleEl.id = 'print-page-style';
                document.head.appendChild(styleEl);
            }
            if (tpl.classList.contains('landscape-layout')) {
                document.body.classList.add('print-landscape');
                styleEl.innerHTML = '@media print { @page { size: landscape; margin: 0; } }';
            } else {
                document.body.classList.remove('print-landscape');
                styleEl.innerHTML = '@media print { @page { size: portrait; margin: 0; } }';
            }
        }
    }

    /* ── Pestañas Reportes ── */
    function switchRepTab(tab, targetTemplateId) {
        document.querySelectorAll('.rep-tab').forEach(b => b.classList.remove('active'));
        if (tab === 'cv') {
            document.querySelector('.rep-tab[onclick*="cv"]').classList.add('active');
            document.getElementById('selector-cv').style.display = 'flex';
            document.getElementById('selector-portafolio').style.display = 'none';
            const colorPanel = document.getElementById('portafolio-color-panel');
            if (colorPanel) colorPanel.style.display = 'none';
            const select = document.querySelector('#selector-cv select');
            if (select) {
                const tplId = targetTemplateId || select.value;
                select.value = tplId;
                selectTemplate(tplId);
            }
        } else {
            document.querySelector('.rep-tab[onclick*="portafolio"]').classList.add('active');
            document.getElementById('selector-cv').style.display = 'none';
            document.getElementById('selector-portafolio').style.display = 'flex';
            const select = document.querySelector('#selector-portafolio select');
            if (select) {
                const tplId = targetTemplateId || select.value;
                select.value = tplId;
                selectTemplate(tplId);
                if (typeof updatePortafolioColorPicker === 'function') {
                    updatePortafolioColorPicker(tplId);
                }
            }
        }
        if (typeof initializeCustomSelects === 'function') {
            initializeCustomSelects();
        }
    }


    function toggleNavMenu() {
        const menu = document.getElementById('navUserMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    function cerrarNavMenu() {
        const menu = document.getElementById('navUserMenu');
        if(menu) menu.style.display = 'none';
    }
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('navUserMenu');
        const btn  = menu?.previousElementSibling;
        if (menu && !menu.contains(e.target) && btn && !btn.contains(e.target)) {
            cerrarNavMenu();
        }
    });

    /* ── Toggles Responsive ── */
    function toggleSidebar() {
        document.getElementById('main-sidebar').classList.toggle('show');
    }
    function toggleRpanel() {
        document.getElementById('right-panel').classList.toggle('show');
    }
</script>

{{-- ══ TRADUCCIONES PARA JS ══ --}}
<script>
    window.trans = {
        cerrando: "{{ __('app.menu.cerrando') }}"
    };
</script>

{{-- ══ NOTIFICACIONES DINÁMICAS (campanita) ══ --}}
@include('_notificaciones_menu')

</body>
</html>