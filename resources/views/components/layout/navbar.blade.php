@auth
@php
    $supabaseBase = rtrim(config('services.supabase.url'), '/')
                . '/storage/v1/object/public/'
                . config('services.supabase.bucket');
    $fotoNavbar = null;
    if (auth()->user()->foto_perfil) {
        if (str_starts_with(auth()->user()->foto_perfil, 'http')) {
            $fotoNavbar = auth()->user()->foto_perfil;
        } else {
            $fotoNavbar = $supabaseBase . '/' . ltrim(auth()->user()->foto_perfil, '/');
        }
    }
@endphp
@endauth

@php
    $currentLang = session('locale', config('app.locale'));
    $flags  = ['es' => '🇪🇸', 'en' => '🇬🇧', 'fr' => '🇫🇷'];
    $labels = ['es' => 'ES',   'en' => 'EN',   'fr' => 'FR'];
@endphp

<div class="topbar" style="background:#0f172a !important;border-color:rgba(255,255,255,0.06) !important;">

    {{-- ── Logo ── --}}
    <div class="tb-left">
        <a href="{{ url('/') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
            <img class="logo-img" src="{{ asset('images/logo.png') }}" alt="UMSS">
            <div class="sysname">Sansi<span>Folios</span></div>
        </a>
    </div>

    {{-- ── Nav central ── --}}
    @if (!request()->routeIs('admin') && !request()->is('admin*'))
    <nav class="tb-nav">

        <a href="#"
            onclick="spaNav('inicio'); return false;"
            data-nav="inicio"
            class="tb-nav-link"
            style="font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);
                text-decoration:none;transition:color .25s,text-shadow .25s;
                padding:4px 2px;position:relative;">
            {{ __('app.nav.inicio') }}
        </a>

        <a href="#"
            onclick="spaNav('caracteristicas'); return false;"
            data-nav="caracteristicas"
            class="tb-nav-link"
            style="font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);
                text-decoration:none;transition:color .25s,text-shadow .25s;
                padding:4px 2px;position:relative;">
            {{ __('app.nav.caracteristicas') }}
        </a>

        <a href="#"
            onclick="spaNav('portafolios'); return false;"
            data-nav="portafolios"
            class="tb-nav-link"
            style="font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);
                text-decoration:none;transition:color .25s,text-shadow .25s;
                padding:4px 2px;position:relative;">
            {{ __('app.nav.portafolios') }}
        </a>

        <a href="#"
            onclick="spaNav('explorador'); return false;"
            data-nav="explorador"
            class="tb-nav-link"
            style="font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);
                text-decoration:none;transition:color .25s,text-shadow .25s;
                padding:4px 2px;position:relative;">
            {{ __('app.nav.explorador') }}
        </a>

    </nav>
    @endif

    {{-- ── Lado derecho ── --}}
    <div class="tb-right" style="display:flex;align-items:center;gap:12px;">

        {{-- Botón menú izquierdo en móviles --}}
        <button class="mobile-toggle-btn mobile-toggle-left" onclick="if(typeof toggleSidebar === 'function') toggleSidebar()" style="margin-right:auto;">
            <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        {{-- ══════════════════════════════════════════════
             SELECTOR DE IDIOMA — cambio SPA sin reload visible
        ══════════════════════════════════════════════ --}}
        <div style="position:relative;" id="lang-wrap">

            <button onclick="langToggle()"
                style="display:flex;align-items:center;gap:6px;
                    background:rgba(255,255,255,0.08);
                    border:1px solid rgba(255,255,255,0.15);border-radius:10px;
                    padding:6px 12px;cursor:pointer;transition:background .2s;
                    font-family:'DM Sans',sans-serif;font-size:13px;color:#fff;font-weight:500;"
                onmouseover="this.style.background='rgba(255,255,255,0.14)'"
                onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                <span id="lang-flag">{{ $flags[$currentLang] ?? '🇪🇸' }}</span>
                <span id="lang-label">{{ $labels[$currentLang] ?? 'ES' }}</span>
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="lang-panel"
                style="display:none;position:absolute;top:calc(100% + 10px);right:0;
                    background:#fff;border-radius:12px;width:160px;
                    box-shadow:0 8px 30px rgba(0,0,0,0.18);
                    border:1px solid #e2e8f0;overflow:hidden;z-index:9999;">

                <button onclick="cambiarIdioma('es', '🇪🇸', 'ES')"
                    style="display:flex;align-items:center;gap:10px;padding:10px 14px;width:100%;
                        font-size:13px;font-family:'DM Sans',sans-serif;border:none;cursor:pointer;
                        color:#1e293b;text-align:left;
                        background:{{ $currentLang === 'es' ? '#eff6ff' : '#fff' }};"
                    onmouseover="this.style.background='#f1f5f9'"
                    onmouseout="this.style.background='{{ $currentLang === 'es' ? '#eff6ff' : '#fff' }}'">
                    <span style="font-size:18px;">🇪🇸</span> Español
                </button>

                <button onclick="cambiarIdioma('en', '🇬🇧', 'EN')"
                    style="display:flex;align-items:center;gap:10px;padding:10px 14px;width:100%;
                        font-size:13px;font-family:'DM Sans',sans-serif;border:none;cursor:pointer;
                        color:#1e293b;text-align:left;
                        background:{{ $currentLang === 'en' ? '#eff6ff' : '#fff' }};"
                    onmouseover="this.style.background='#f1f5f9'"
                    onmouseout="this.style.background='{{ $currentLang === 'en' ? '#eff6ff' : '#fff' }}'">
                    <span style="font-size:18px;">🇬🇧</span> English
                </button>

                <button onclick="cambiarIdioma('fr', '🇫🇷', 'FR')"
                    style="display:flex;align-items:center;gap:10px;padding:10px 14px;width:100%;
                        font-size:13px;font-family:'DM Sans',sans-serif;border:none;cursor:pointer;
                        color:#1e293b;text-align:left;
                        background:{{ $currentLang === 'fr' ? '#eff6ff' : '#fff' }};"
                    onmouseover="this.style.background='#f1f5f9'"
                    onmouseout="this.style.background='{{ $currentLang === 'fr' ? '#eff6ff' : '#fff' }}'">
                    <span style="font-size:18px;">🇫🇷</span> Français
                </button>
            </div>
        </div>
        {{-- /selector idioma --}}

        @auth
            {{-- ── Campanita ── --}}
            <div style="position:relative;" id="notif-wrap">
                <div class="tb-bell"
                     style="cursor:pointer;position:relative;border-color:rgba(255,255,255,0.1) !important;background:rgba(255,255,255,0.08) !important;"
                     onclick="notifToggle()" id="notif-btn">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span id="notif-badge"
                        style="display:none;position:absolute;top:-4px;right:-4px;
                               background:#ef4444;color:#fff;font-size:9px;font-weight:700;
                               border-radius:999px;padding:1px 5px;min-width:16px;
                               text-align:center;border:2px solid #0f172a;"></span>
                </div>

                <div id="notif-panel"
                    style="display:none;position:absolute;top:calc(100% + 10px);right:0;
                           width:340px;background:#fff;border-radius:14px;
                           box-shadow:0 8px 32px rgba(0,0,0,0.18);
                           border:1px solid #e2e8f0;z-index:9999;overflow:hidden;">
                    <div style="display:flex;align-items:center;justify-content:space-between;
                                padding:14px 18px;border-bottom:1px solid #f1f5f9;">
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;
                                     font-weight:700;color:#0f172a;">
                            {{ __('app.nav.notificaciones') }}
                        </span>
                        <button onclick="notifMarcarTodasLeidas()"
                            style="font-size:11px;color:#2563eb;background:none;border:none;
                                   cursor:pointer;font-weight:600;">
                            {{ __('app.nav.marcar_leidas') }}
                        </button>
                    </div>
                    <div id="notif-lista" style="max-height:360px;overflow-y:auto;">
                        <div style="padding:24px;text-align:center;color:#94a3b8;font-size:13px;">
                            {{ __('app.nav.cargando') }}
                        </div>
                    </div>
                    <div style="padding:10px 18px;border-top:1px solid #f1f5f9;text-align:center;">
                        <span style="font-size:11px;color:#94a3b8;">
                            {{ __('app.nav.solo_tus_notif') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── Menú de usuario ── --}}
            <div style="position:relative;" id="nav-user-wrap">
                <button onclick="navUserToggle()"
                    style="display:flex;align-items:center;gap:8px;
                        background:rgba(255,255,255,0.08);
                        border:1px solid rgba(255,255,255,0.15);border-radius:10px;
                        padding:6px 12px 6px 6px;cursor:pointer;transition:background .2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.14)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    <div class="sb-av" style="width:32px;height:32px;font-size:12px;">
                        @if($fotoNavbar)
                            <img src="{{ $fotoNavbar }}" alt=""
                                style="width:100%;height:100%;object-fit:cover;border-radius:50%"
                                onerror="this.style.display='none'">
                        @else
                            {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellido ?? '', 0, 1)) }}
                        @endif
                    </div>
                    <div style="text-align:left;">
                        <div style="font-size:13px;color:#fff;font-weight:600;white-space:nowrap;">
                            {{ auth()->user()->nombre }}
                        </div>
                        <div style="font-size:10px;color:#8ba5c8;">{{ __('app.nav.mi_cuenta') }} ▾</div>
                    </div>
                </button>

                <div id="navUserMenu"
                    style="display:none;position:absolute;top:calc(100% + 10px);right:0;
                           background:#fff;border-radius:14px;width:240px;
                           box-shadow:0 8px 30px rgba(0,0,0,0.18);
                           border:1px solid #e2e8f0;overflow:hidden;z-index:9999;">

                    <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;
                                display:flex;align-items:center;gap:10px;">
                        <div style="width:40px;height:40px;border-radius:50%;overflow:hidden;
                                    flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#0d9488);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:14px;font-weight:700;color:#fff;">
                            @if($fotoNavbar)
                                <img src="{{ $fotoNavbar }}" alt=""
                                    style="width:100%;height:100%;object-fit:cover;"
                                    onerror="this.style.display='none'">
                            @else
                                {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellido ?? '', 0, 1)) }}
                            @endif
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:13.5px;font-weight:700;color:#0f172a;
                                        overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                            </div>
                            <div style="font-size:11px;color:#64748b;
                                        overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->es_admin)

                        <div style="padding:6px;">
                            <a href="{{ route('admin') }}"
                                style="width:100%;display:flex;align-items:center;gap:10px;
                                       padding:9px 12px;border-radius:8px;
                                       cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;
                                       color:#4f46e5;text-align:left;text-decoration:none;background:none;"
                                onmouseover="this.style.background='#eef2ff'"
                                onmouseout="this.style.background='none'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                </svg>
                                {{ __('app.nav.panel_admin') }}
                            </a>
                        </div>

                    @else

                        <div style="padding:6px;">
                            <button onclick="if(typeof showView === 'function'){showView('perfil');cerrarNavMenu();}else{window.location.href='{{ url('/menu') }}'}"
                                style="width:100%;display:flex;align-items:center;gap:10px;
                                       padding:9px 12px;border-radius:8px;border:none;background:none;
                                       cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;
                                       color:#1e293b;text-align:left;"
                                onmouseover="this.style.background='#f1f5f9'"
                                onmouseout="this.style.background='none'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="#64748b" stroke-width="2" stroke-linecap="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                {{ __('app.nav.mi_perfil') }}
                            </button>

                            <button onclick="if(typeof showView === 'function'){showView('reportes');cerrarNavMenu();}else{window.location.href='{{ url('/menu') }}'}"
                                style="width:100%;display:flex;align-items:center;gap:10px;
                                       padding:9px 12px;border-radius:8px;border:none;background:none;
                                       cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;
                                       color:#1e293b;text-align:left;"
                                onmouseover="this.style.background='#f1f5f9'"
                                onmouseout="this.style.background='none'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="#64748b" stroke-width="2" stroke-linecap="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                </svg>
                                {{ __('app.nav.reportes') }}
                            </button>
                        </div>

                    @endif

                    <div style="height:1px;background:#f1f5f9;margin:0 6px;"></div>

                    <div style="padding:6px;">
                        <button onclick="confirmarLogout()"
                            style="width:100%;display:flex;align-items:center;gap:10px;
                                   padding:9px 12px;border-radius:8px;border:none;background:none;
                                   cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;
                                   color:#dc2626;text-align:left;"
                            onmouseover="this.style.background='#fef2f2'"
                            onmouseout="this.style.background='none'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="#dc2626" stroke-width="2" stroke-linecap="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            {{ __('app.nav.cerrar_sesion') }}
                        </button>
                    </div>
                </div>
            </div>

        @else
            <button id="openLoginModal"
                style="height:36px;padding:0 16px;background:rgba(255,255,255,0.1);
                       border:1px solid rgba(255,255,255,0.2);border-radius:9px;color:#fff;
                       font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;
                       cursor:pointer;transition:background .2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.18)'"
                onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                {{ __('app.nav.iniciar_sesion') }}
            </button>

            <button id="openRegisterModal"
                style="height:36px;padding:0 16px;background:#2563eb;
                       border:1px solid #2563eb;border-radius:9px;color:#fff;
                       font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;
                       cursor:pointer;transition:background .2s;"
                onmouseover="this.style.background='#1d4ed8'"
                onmouseout="this.style.background='#2563eb'">
                {{ __('app.nav.registrarse') }}
            </button>
        @endauth
        
        {{-- Botón menú derecho (calendario/notifs) en móviles --}}
        <button class="mobile-toggle-btn mobile-toggle-right" onclick="if(typeof toggleRpanel === 'function') toggleRpanel()">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </button>
    </div>{{-- fin tb-right --}}

    {{-- ══════════════════════════════════════════════
         SCRIPTS DEL NAVBAR
    ══════════════════════════════════════════════ --}}
    <script>
        /* ── Abrir/cerrar panel de idioma ── */
        function langToggle() {
            const panel = document.getElementById('lang-panel');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        }

        /* ══════════════════════════════════════════════
           CAMBIO DE IDIOMA — SPA-like
           1. Actualiza el botón visualmente al instante
           2. Muestra overlay suave que oculta el reload
           3. Guarda locale en sesión vía fetch
           4. Recarga la página con el nuevo idioma
        ══════════════════════════════════════════════ */
        function cambiarIdioma(lang, flag, label) {
            /* Cierra el panel */
            document.getElementById('lang-panel').style.display = 'none';

            /* Actualiza el botón del navbar al instante */
            document.getElementById('lang-flag').textContent  = flag;
            document.getElementById('lang-label').textContent = label;

            /* Mensaje de carga según el idioma elegido */
            const msgs = {
                es: 'Cambiando idioma…',
                en: 'Switching language…',
                fr: 'Changement de langue…'
            };

            /* Overlay con blur que tapa el parpadeo del reload */
            const overlay = document.createElement('div');
            overlay.id = 'lang-loading-overlay';
            overlay.style.cssText = [
                'position:fixed;inset:0;z-index:99999;',
                'background:rgba(15,23,42,0.35);',
                'backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);',
                'display:flex;align-items:center;justify-content:center;',
                'opacity:0;transition:opacity .18s ease;',
            ].join('');
            overlay.innerHTML = `
                <div style="background:#fff;border-radius:16px;padding:20px 32px;
                            display:flex;align-items:center;gap:14px;
                            box-shadow:0 12px 40px rgba(0,0,0,0.18);">
                    <svg style="width:22px;height:22px;flex-shrink:0;
                                animation:nb-spin .7s linear infinite;"
                         viewBox="0 0 24 24" fill="none"
                         stroke="#2563eb" stroke-width="2.5" stroke-linecap="round">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83
                                 M16.24 16.24l2.83 2.83M2 12h4M18 12h4
                                 M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    </svg>
                    <span style="font-family:'DM Sans',sans-serif;font-size:14px;
                                 font-weight:600;color:#1e293b;white-space:nowrap;">
                        ${msgs[lang] ?? msgs.es}
                    </span>
                </div>`;
            document.body.appendChild(overlay);

            /* Fade-in del overlay */
            requestAnimationFrame(() => {
                requestAnimationFrame(() => { overlay.style.opacity = '1'; });
            });

            /* Guarda el locale en sesión y recarga */
            fetch('{{ url("lang") }}/' + lang, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .finally(() => {
                /* Recarga en cuanto el servidor responda (con o sin error) */
                window.location.reload();
            });
        }

        /* ── Menú de usuario ── */
        function navUserToggle() {
            const menu = document.getElementById('navUserMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        function cerrarNavMenu() {
            const menu = document.getElementById('navUserMenu');
            if (menu) menu.style.display = 'none';
        }

        function confirmarLogout() {
            document.getElementById('modalLogout').style.display = 'flex';
            cerrarNavMenu();
        }

        function ejecutarLogoutGlobal(btn) {
            btn.disabled = true;
            document.getElementById('logoutSpinnerGlobal').style.display = 'block';
            document.getElementById('logoutBtnLabelGlobal').textContent = '{{ __("app.menu.cerrando") }}';
            btn.style.opacity = '0.85';
            document.getElementById('formLogoutGlobal').submit();
        }

        /* ── Actualización en vivo del navbar tras guardar perfil ──
           Llama esta función desde tu código de guardado de perfil:
           actualizarNavbar('Juan', 'Pérez', 'https://supabase.../foto.jpg')
           Si no hay foto nueva, pasa null como tercer argumento.
        ── */
        function actualizarNavbar(nombre, apellido, fotoUrl) {
            /* Nombre en el botón del topbar */
            const btnNombre = document.querySelector('#nav-user-wrap button > div > div:first-child');
            if (btnNombre) btnNombre.textContent = nombre;

            /* Nombre completo en el dropdown */
            const dropNombre = document.querySelector(
                '#navUserMenu div[style*="font-weight:700;color:#0f172a"]'
            );
            if (dropNombre) dropNombre.textContent = nombre + ' ' + apellido;

            /* Avatar en el botón del topbar */
            const avatarBtn = document.querySelector('#nav-user-wrap button .sb-av');
            if (avatarBtn) {
                avatarBtn.innerHTML = fotoUrl
                    ? `<img src="${fotoUrl}" alt=""
                           style="width:100%;height:100%;object-fit:cover;border-radius:50%"
                           onerror="this.style.display='none'">`
                    : (nombre || 'U').charAt(0).toUpperCase() +
                      (apellido || '').charAt(0).toUpperCase();
            }

            /* Avatar en el dropdown */
            const avatarDrop = document.querySelector(
                '#navUserMenu div[style*="border-radius:50%;overflow:hidden"]'
            );
            if (avatarDrop) {
                avatarDrop.innerHTML = fotoUrl
                    ? `<img src="${fotoUrl}" alt=""
                           style="width:100%;height:100%;object-fit:cover;">`
                    : (nombre || 'U').charAt(0).toUpperCase() +
                      (apellido || '').charAt(0).toUpperCase();
            }
        }

        /* ── Cierra dropdowns al click fuera ── */
        document.addEventListener('click', function(e) {
            const userWrap = document.getElementById('nav-user-wrap');
            if (userWrap && !userWrap.contains(e.target)) cerrarNavMenu();

            const langWrap = document.getElementById('lang-wrap');
            if (langWrap && !langWrap.contains(e.target)) {
                document.getElementById('lang-panel').style.display = 'none';
            }
        });

        /* ── Marcar enlace activo con turquesa ── */
        function setNavActivo(view) {
            document.querySelectorAll('.tb-nav-link').forEach(el => {
                el.classList.remove('nav-activo');
                el.style.color = 'rgba(255,255,255,0.65)';
            });
            const activo = document.querySelector('.tb-nav-link[data-nav="' + view + '"]');
            if (activo) {
                activo.classList.add('nav-activo');
                activo.style.color = '#2dd4bf';
            }
        }

        /* ── Navegación SPA entre vistas ── */
        function spaNav(view) {
            setNavActivo(view);

            const routes = {
                'inicio':          '{{ url("/") }}',
                'portafolios':     '{{ route("portafolios.index") }}',
                'explorador':      '{{ route("explorador") }}',
                'caracteristicas': '{{ route("caracteristicas") }}',
            };

            if (typeof esContextoAdmin !== 'undefined' && esContextoAdmin) {
                const mapaAdmin = {
                    'inicio':          'dashboard',
                    'caracteristicas': 'caracteristicas',
                    'portafolios':     'portafolios-menu',
                    'explorador':      'explorador',
                };
                if (mapaAdmin[view]) mostrarVista(mapaAdmin[view]);
                return;
            }

            if (typeof showView === 'function') {
                const spaView = view === 'inicio' ? 'menu' : view;
                showView(spaView);
                return;
            }

            const allViews = document.querySelectorAll('.spa-view');
            allViews.forEach(v => v.style.display = 'none');

            const target = document.getElementById('view-' + view);
            if (target) {
                target.style.display = 'block';
            } else {
                if (routes[view]) window.location.href = routes[view];
            }

        }

        /* ── Detección de sección activa ── */
        function detectarNavActivo() {
            const path = window.location.pathname;
            const hash = window.location.hash.replace('#', '');

            let vistaActiva = 'inicio';
            if (hash && document.getElementById('view-' + hash)) {
                vistaActiva = hash;
            } else if (path.includes('portafolios')) {
                vistaActiva = 'portafolios';
            } else if (path.includes('explorador')) {
                vistaActiva = 'explorador';
            } else if (path.includes('caracteristicas')) {
                vistaActiva = 'caracteristicas';
            }

            setNavActivo(vistaActiva);
        }

        /* ── Deep linking por hash ── */
        document.addEventListener('DOMContentLoaded', function() {
            /* Intento inmediato y un reintento por si el navbar se monta tarde */
            detectarNavActivo();
            setTimeout(detectarNavActivo, 50);
            setTimeout(detectarNavActivo, 200);
        });
    </script>

    {{-- ── Keyframes para el spinner del cambio de idioma ── --}}
    <style>
        @keyframes nb-spin { to { transform: rotate(360deg); } }

        /* ── Turquesa para el nav activo ── */
        .tb-nav-link:hover {
            color: #fff !important;
        }
        .tb-nav-link.nav-activo:hover {
            color: #5eead4 !important;
        }
    </style>

    {{-- ── Modal Logout Global ── --}}
    @auth
    <div id="modalLogout" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:99999;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:20px;padding:32px;width:90%;max-width:340px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
            <div style="width:52px;height:52px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </div>
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:#0f172a;margin-bottom:8px;">
                {{ __('app.menu.cerrar_sesion') }}
            </div>
            <div style="font-size:13px;color:#64748b;margin-bottom:24px;">
                {{ __('app.menu.cerrar_confirm') }}
            </div>
            <div style="display:flex;gap:10px;">
                <button onclick="document.getElementById('modalLogout').style.display='none'"
                    style="flex:1;padding:12px;border-radius:12px;border:1.5px solid #e2e8f0;
                           background:transparent;font-size:14px;font-weight:600;
                           cursor:pointer;font-family:'DM Sans',sans-serif;">
                    {{ __('app.menu.cancelar') }}
                </button>
                <button onclick="ejecutarLogoutGlobal(this)"
                    style="flex:1;padding:12px;border-radius:12px;border:none;background:#2563eb;
                           color:#fff;font-size:14px;font-weight:600;cursor:pointer;
                           font-family:'DM Sans',sans-serif;display:flex;align-items:center;
                           justify-content:center;gap:8px;">
                    <svg id="logoutSpinnerGlobal"
                        style="display:none;width:16px;height:16px;animation:nb-spin .7s linear infinite;"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    </svg>
                    <span id="logoutBtnLabelGlobal">{{ __('app.menu.si_salir') }}</span>
                </button>
            </div>
        </div>
    </div>

    <form id="formLogoutGlobal" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
    @endauth

</div>{{-- fin topbar --}}