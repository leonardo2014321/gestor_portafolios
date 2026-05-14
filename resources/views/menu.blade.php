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
        <aside>
            <div class="sb-top">
                <div class="sb-label">{{ __('app.menu.menu_principal') }}</div>

                <button id="btn-menu" class="sb-item active" onclick="showView('menu')">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>{{ __('app.menu.mis_portafolios') }}</span>
                </button>

                <a href="{{ route('academico') }}" class="sb-item {{ request()->routeIs('academico') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    <span>{{ __('app.menu.academico') }}</span>
                </a>

                <button id="btn-reportes" class="sb-item" onclick="showView('reportes')">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>{{ __('app.menu.reportes') }}</span>
                </button>

                <button id="btn-perfil" class="sb-item" onclick="showView('perfil')">
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
            <div class="rpanel">

                @include('_calendario_menu')

                {{-- Notificaciones estáticas del sistema --}}
                <div class="rp-sec">
                    <div class="rp-ttl">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ __('app.menu.notif_actualizacion') }}
                    </div>
                    <div class="notif">
                        <div class="ni-icon green"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div>
                        <div><div class="ntxt">{{ __('app.menu.nueva_actualizacion') }}</div></div>
                    </div>
                    <div class="notif">
                        <div class="ni-icon blue"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <div><div class="ntxt">{{ __('app.menu.informe_subido') }}</div><div class="ntime">13:10</div></div>
                    </div>
                </div>

                {{-- Enlaces rápidos --}}
                <div class="rp-sec">
                    <div class="rp-ttl">
                        <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 1 7.54.54l3 3a5 5 0 0 1-7.07 7.07l-1.72-1.71"/><path d="M14 11a5 5 0 0 1-7.54-.54l-3-3A5 5 0 0 1 10.54.39l1.71 1.71"/></svg>
                        {{ __('app.menu.enlaces') }}
                    </div>
                    <a href="#" class="enlace"><div class="en-ico yellow"><svg viewBox="0 0 24 24"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div><div class="en-lbl">{{ __('app.menu.repositorio') }}</div></a>
                    <a href="#" class="enlace"><div class="en-ico gray"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div><div class="en-lbl">{{ __('app.menu.ayuda') }}</div></a>
                    <a href="#" class="enlace"><div class="en-ico blue"><svg viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg></div><div class="en-lbl">{{ __('app.menu.portal_umss') }}</div></a>
                    <a href="#" class="enlace"><div class="en-ico blue"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div><div class="en-lbl">{{ __('app.menu.aula_virtual') }}</div></a>
                </div>

            </div>{{-- /rpanel --}}

        </div>{{-- /content-wrapper --}}
    </div>{{-- /body-row --}}

    @include('components.layout.footer')

</div>{{-- /app --}}

{{-- ══ MODALES ══ --}}
@include('_modales_crear_portafolio')

{{-- ══ SCRIPTS PRINCIPALES ══ --}}
<script>
    /* ── Navegación entre vistas ── */
    function showView(name) {
        if (name === 'reportes') {
            const activeTpl = document.querySelector('.cv-template-view.active-tpl');
            const activeId = activeTpl ? activeTpl.id : 'cv-template-1';
            fetch('{{ route("reportes") }}')
                .then(res => res.text())
                .then(html => {
                    document.getElementById('view-reportes').innerHTML = html;
                    if (typeof selectTemplate === 'function') {
                        selectTemplate(activeId);
                        const select = document.getElementById('cv-template-select');
                        if (select) select.value = activeId;
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
    function switchRepTab(tab) {
        document.querySelectorAll('.rep-tab').forEach(b => b.classList.remove('active'));
        if (tab === 'cv') {
            document.querySelector('.rep-tab[onclick*="cv"]').classList.add('active');
            document.getElementById('selector-cv').style.display = 'flex';
            document.getElementById('selector-portafolio').style.display = 'none';
            const select = document.querySelector('#selector-cv select');
            if(select) selectTemplate(select.value);
        } else {
            document.querySelector('.rep-tab[onclick*="portafolio"]').classList.add('active');
            document.getElementById('selector-cv').style.display = 'none';
            document.getElementById('selector-portafolio').style.display = 'flex';
            const select = document.querySelector('#selector-portafolio select');
            if(select) selectTemplate(select.value);
        }
    }


    /* ── Menú de usuario (navbar) ── */
    function toggleNavMenu() {
        const menu = document.getElementById('navUserMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    function cerrarNavMenu() {
        document.getElementById('navUserMenu').style.display = 'none';
    }
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('navUserMenu');
        const btn  = menu?.previousElementSibling;
        if (menu && !menu.contains(e.target) && btn && !btn.contains(e.target)) {
            cerrarNavMenu();
        }
    });
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