<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.admin.titulo_pagina') }}</title>
    @include('_styles_menu')
    @include('_styles_admin')
    <style>
        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
    </style>

</head>
<body class="app-locked">
<div class="app">

    {{-- Navbar compartido --}}
    @include('components.layout.navbar')

    <!-- Modal confirmación cambio de rol -->
    <div id="modal-user-role" onclick="if(event.target===this)cerrarModalRole()" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:24px;padding:2.2rem 2rem 1.8rem;width:400px;max-width:92vw;box-shadow:0 24px 64px rgba(0,0,0,0.22);text-align:center;animation:fadeInScale .2s ease;">
            <div style="width:60px;height:60px;border-radius:18px;background:#eef2ff;display:flex;align-items:center;justify-content:center;margin:0 auto 1.3rem;">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
            </div>
            <h3 id="modal-role-title" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:#0f172a;margin-bottom:8px;">{{ __('app.admin.modal_rol_titulo') }}</h3>
            <p id="modal-role-text" style="font-size:13.5px;color:#64748b;line-height:1.65;margin-bottom:1.5rem;">{{ __('app.admin.modal_rol_texto') }}</p>

            <div style="text-align:left;margin-bottom:1.5rem">
                <label style="display:block;font-size:12px;font-weight:700;color:var(--muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:1px">{{ __('app.admin.confirma_contrasena') }}</label>
                <input type="password" id="admin-role-pass" placeholder="{{ __('app.admin.placeholder_contrasena') }}" style="width:100%;padding:12px 16px;border-radius:12px;border:2px solid var(--gray2);outline:none;font-family:'DM Sans',sans-serif;font-size:14px;transition:border-color 0.2s;" onfocus="this.style.borderColor='var(--admin-purple)'" onblur="this.style.borderColor='var(--gray2)'">
            </div>

            <div style="display:flex;gap:10px;">
                <button onclick="cerrarModalRole()" style="flex:1;padding:12px;border-radius:14px;border:2px solid #e2e8f0;background:#fff;font-size:13.5px;font-weight:600;color:#64748b;cursor:pointer;font-family:'DM Sans',sans-serif;">{{ __('app.admin.cancelar') }}</button>
                <button id="btn-confirm-role" style="flex:1;padding:12px;border-radius:14px;border:none;background:linear-gradient(135deg,#1428c6,#1e3adb);color:#fff;font-size:13.5px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;box-shadow:0 4px 14px rgba(20,40,198,0.3);">{{ __('app.admin.confirmar_cambio') }}</button>
            </div>
        </div>
    </div>

    <div class="body-row">
        <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside>
            <div class="sb-top">
                <div class="sb-label">{{ __('app.admin.menu_principal') }}</div>
                <button id="btn-dashboard" class="sb-item active" onclick="mostrarVista('dashboard')">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>{{ __('app.admin.panel_control') }}</span>
                </button>
                <button id="btn-usuarios" class="sb-item" onclick="mostrarVista('usuarios')">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>{{ __('app.admin.usuarios') }}</span>
                </button>
                <button id="btn-portafolios" class="sb-item" onclick="mostrarVista('portafolios')">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span>{{ __('app.admin.portafolios') }}</span>
                </button>
                <button id="btn-notificaciones" class="sb-item" onclick="mostrarVista('notificaciones')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span>{{ __('app.admin.notificaciones') }}</span>
                </button>
            </div>
        </aside>

        <!-- Main content -->
        <main>
            <div class="main-inner">

                <!-- ═══ VISTA: DASHBOARD ═══ -->
                <div id="view-dashboard" class="admin-view" style="display:block">

                    <!-- Hero -->
                    <div class="admin-hero">
                        <div class="hero-content">
                            <h1 class="hero-title">{{ __('app.admin.panel_control') }}</h1>
                            <p class="hero-sub">{{ __('app.admin.panel_control_sub') }}</p>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
                        <div class="stat-card">
                            <div class="stat-info">
                                <div class="stat-label">{{ __('app.admin.stat_usuarios_totales') }}</div>
                                <div class="stat-val">{{ number_format($stats['total_usuarios']) }}</div>
                                <div class="stat-trend trend-up">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                    {{ $stats['usuarios_activos'] }} {{ __('app.admin.stat_activos') }}
                                </div>
                            </div>
                            <div class="stat-icon icon-purple">
                                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-info">
                                <div class="stat-label">{{ __('app.admin.stat_portafolios_registrados') }}</div>
                                <div class="stat-val">{{ number_format($portafolios_stats['total']) }}</div>
                                <div class="stat-trend trend-up">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                    {{ $portafolios_stats['con_usuarios'] }} {{ __('app.admin.stat_con_vinculacion') }}
                                </div>
                            </div>
                            <div class="stat-icon icon-blue">
                                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-info">
                                <div class="stat-label">{{ __('app.admin.stat_documentos_subidos') }}</div>
                                <div class="stat-val">{{ number_format($total_documentos) }}</div>
                                <div class="stat-trend trend-up">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                    {{ __('app.admin.stat_archivos_proyectos') }}
                                </div>
                            </div>
                            <div class="stat-icon icon-teal">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-info">
                                <div class="stat-label">{{ __('app.admin.stat_administradores') }}</div>
                                <div class="stat-val">{{ $stats['total_admins'] }}</div>
                                <div class="stat-trend trend-down">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                                    {{ __('app.admin.stat_personal_gestion') }}
                                </div>
                            </div>
                            <div class="stat-icon icon-rose">
                                <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Main Grid -->
                    <div class="dash-grid" style="grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));">

                        <!-- Últimos Usuarios -->
                        <div class="panel">
                            <div class="panel-header">
                                <h2 class="panel-title">{{ __('app.admin.usuarios_recientes') }}</h2>
                                <a href="#" onclick="mostrarVista('usuarios'); return false;" class="panel-action">{{ __('app.admin.ver_todos') }}</a>
                            </div>
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>{{ __('app.admin.th_usuario') }}</th>
                                            <th>{{ __('app.admin.th_registro') }}</th>
                                            <th>{{ __('app.admin.th_estado') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usuarios_recientes as $usuario)
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <div class="u-avatar" style="{{ $usuario->activo ? '' : 'background: #f1f5f9; color: #475569;' }}">
                                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                                                    </div>
                                                    <div class="u-info">
                                                        <span class="u-name">{{ $usuario->nombre }} {{ $usuario->apellido }}</span>
                                                        <span class="u-email">{{ $usuario->email }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $usuario->created_at->diffForHumans() }}</td>
                                            <td>
                                                <span class="status-badge {{ $usuario->activo ? 'st-active' : 'st-inactive' }}" id="status-{{ $usuario->id }}">
                                                    {{ $usuario->activo ? __('app.admin.activo') : __('app.admin.inactivo') }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Últimos Portafolios -->
                        <div class="panel">
                            <div class="panel-header">
                                <h2 class="panel-title">{{ __('app.admin.portafolios_recientes') }}</h2>
                                <a href="#" onclick="mostrarVista('portafolios'); return false;" class="panel-action">{{ __('app.admin.ver_todos') }}</a>
                            </div>
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>{{ __('app.admin.th_portafolio') }}</th>
                                            <th>{{ __('app.admin.th_autor') }}</th>
                                            <th>{{ __('app.admin.th_fecha') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($todos_portafolios->take(5) as $portafolio)
                                        <tr>
                                            <td>
                                                <div class="user-cell">
                                                    <div class="u-avatar" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff;">
                                                        {{ strtoupper(substr($portafolio->nombre, 0, 1)) }}
                                                    </div>
                                                    <div class="u-info">
                                                        <span class="u-name" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $portafolio->nombre }}</span>
                                                        <span class="u-email" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($portafolio->descripcion, 30) ?: __('app.admin.sin_descripcion') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($portafolio->usuario)
                                                    <span style="font-weight: 500;">{{ $portafolio->usuario->nombre }}</span>
                                                @else
                                                    <span style="color: var(--muted); font-size: 12px; font-style: italic;">{{ __('app.admin.sin_usuario') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $portafolio->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                        @endforeach
                                        @if($todos_portafolios->isEmpty())
                                        <tr>
                                            <td colspan="3" style="text-align: center; padding: 2rem; color: var(--muted); font-size: 13.5px;">{{ __('app.admin.empty_portafolios_recientes') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div><!-- /view-dashboard -->

                @include('usuarios_admin')

                {{--
                    VISTA: PORTAFOLIOS DEL SIDEBAR (panel admin)
                    Se activa desde el botón "Portafolios" del sidebar izquierdo.
                    El archivo portafolios_admin.blade.php ya incluye su propio
                    <div id="view-portafolios" class="admin-view">, no se envuelve aquí.
                --}}
                @include('portafolios_admin')

                {{--
                    VISTA: PORTAFOLIOS DE LA NAVBAR
                    Se activa cuando el admin hace clic en "Portafolios" en la navbar superior.
                    Muestra la misma vista pública que ve el usuario normal en su menú.
                --}}
                <div id="view-portafolios-menu" class="admin-view" style="display:none">
                    @include('_portafolios_menu')
                </div>

                {{--
                    VISTA: CARACTERÍSTICAS
                    Reutiliza el mismo include que usa el menú de usuario.
                    Se activa cuando el admin hace clic en "Características" en la navbar.
                --}}
                <div id="view-caracteristicas" class="admin-view" style="display:none">
                    @include('_caracteristicas_menu')
                </div>

                {{--
                    VISTA: EXPLORADOR
                    Reutiliza el mismo include que usa el menú de usuario.
                    Se activa cuando el admin hace clic en "Explorador" en la navbar.
                --}}
                <div id="view-explorador" class="admin-view" style="display:none">
                    @include('_explorador_menu')
                </div>

                @include('notificaciones_admin')

            </div><!-- /.main-inner -->

        <!-- Right panel (Calendario) -->
        <div class="rpanel">
            <div class="rp-sec">
                <div class="cal-hd" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                    <div class="cal-month" id="cal-title" style="flex:1;">{{ __('app.admin.cal_mes') }}</div>
                    <select class="cal-view-selector" id="cal-view-sel" onchange="changeCalView(this.value)" style="margin:0;">
                        <option value="dias">{{ __('app.admin.cal_dias') }}</option>
                        <option value="semanas">{{ __('app.admin.cal_semanas') }}</option>
                        <option value="meses">{{ __('app.admin.cal_meses') }}</option>
                        <option value="anios">{{ __('app.admin.cal_anios') }}</option>
                    </select>
                    <div class="cal-navs">
                        <button class="cal-nav" onclick="changeMonth(-1)">‹</button>
                        <button class="cal-nav" onclick="changeMonth(1)">›</button>
                    </div>
                </div>
                <div id="cal-grid-container">
                    <div class="cal-grid" id="cal-grid"></div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div style="padding: 1rem;">
                <div class="panel">
                    <div class="panel-header" style="padding: 1rem; display: flex; justify-content: space-between; align-items: center;">
                        <h2 class="panel-title" style="margin: 0;">{{ __('app.admin.actividad_reciente') }}</h2>
                        @if($actividades_recientes->count() > 0)
                            <form action="{{ route('admin.actividad.limpiar') }}" method="POST" onsubmit="return confirm('{{ __('app.admin.confirm_limpiar_actividad') }}');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="{{ __('app.admin.limpiar_historial') }}" style="background: none; border: none; color: var(--rose); cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center; border-radius: 4px; transition: background 0.2s;" onmouseover="this.style.background='rgba(244, 63, 94, 0.1)'" onmouseout="this.style.background='none'">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="activity-list">
                        @forelse($actividades_recientes as $act)
                            @php
                                $titulo = __('app.admin.act_accion') . ': ' . $act->accion;
                                $iconClass = "icon-purple";
                                $svg = '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>';

                                switch($act->accion) {
                                    case 'login':
                                        $titulo = __('app.admin.act_login');
                                        $iconClass = "icon-teal";
                                        $svg = '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>';
                                        break;
                                    case 'logout':
                                        $titulo = __('app.admin.act_logout');
                                        $iconClass = "icon-rose";
                                        $svg = '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>';
                                        break;
                                    case 'registro_usuario':
                                        $titulo = __('app.admin.act_registro_usuario');
                                        $iconClass = "icon-purple";
                                        $svg = '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>';
                                        break;
                                    case 'PASSWORD_ACTUALIZADO':
                                        $titulo = __('app.admin.act_password_actualizado');
                                        $iconClass = "icon-teal";
                                        $svg = '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>';
                                        break;
                                    case 'SOLICITAR_RECUPERACION':
                                        $titulo = __('app.admin.act_solicitar_recuperacion');
                                        $iconClass = "icon-blue";
                                        $svg = '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>';
                                        break;
                                    case 'reactivacion_cuenta':
                                        $titulo = __('app.admin.act_reactivacion_cuenta');
                                        $iconClass = "icon-teal";
                                        $svg = '<path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>';
                                        break;
                                    case 'SOLICITUD_REGISTRO':
                                        $titulo = __('app.admin.act_solicitud_registro');
                                        $iconClass = "icon-purple";
                                        $svg = '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>';
                                        break;
                                    case 'RECUPERACION_EMAIL_NO_EXISTE':
                                        $titulo = __('app.admin.act_email_no_existe');
                                        $iconClass = "icon-rose";
                                        $svg = '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>';
                                        break;
                                    case 'TOKEN_INVALIDO':
                                        $titulo = __('app.admin.act_token_invalido');
                                        $iconClass = "icon-rose";
                                        $svg = '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
                                        break;
                                    case 'ERROR_RECUPERACION':
                                        $titulo = __('app.admin.act_error_recuperacion');
                                        $iconClass = "icon-rose";
                                        $svg = '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>';
                                        break;
                                    case 'PERFIL_ACTUALIZADO':
                                        $titulo = __('app.admin.act_perfil_actualizado');
                                        $iconClass = "icon-blue";
                                        $svg = '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>';
                                        break;
                                    case 'CUENTA_DESACTIVADA':
                                        $titulo = __('app.admin.act_cuenta_desactivada');
                                        $iconClass = "icon-rose";
                                        $svg = '<path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/>';
                                        break;
                                }
                            @endphp
                            <div class="act-item" style="padding: 1rem; gap: 10px;">
                                <div class="act-icon {{ $iconClass }}" style="width: 32px; height: 32px;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $svg !!}</svg>
                                </div>
                                <div class="act-content">
                                    <div class="act-title" style="font-size: 12px;">
                                        {{ $titulo }} <br>
                                        <span>{{ $act->usuario ? $act->usuario->nombre . ' ' . $act->usuario->apellido : __('app.admin.act_sistema_invitado') }}</span>
                                    </div>
                                    <div class="act-time" style="font-size: 10px;">{{ $act->created_at ? $act->created_at->diffForHumans() : __('app.admin.act_recientemente') }}</div>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 2rem; text-align: center; color: var(--muted); font-size: 13px;">
                                {{ __('app.admin.empty_actividad') }}
                            </div>
                        @endforelse

                        <a href="#" style="display: block; text-align: center; padding: 1rem; font-size: 12px; font-weight: 600; color: var(--admin-purple); text-decoration: none; border-top: 1px solid var(--gray2);">{{ __('app.admin.ver_registro_completo') }}</a>
                    </div>
                </div>
            </div>

        </div><!-- /.rpanel -->

        </main>

    </div><!-- /.body-row -->

    {{-- Footer compartido --}}
    @include('components.layout.footer')

</div><!-- /.app -->

<script>
    function abrirLogoutAdmin() {
        document.getElementById('modal-logout-confirm').style.display = 'flex';
        document.getElementById('admin-dropdown').style.display = 'none';
    }
    function cerrarLogoutAdmin() {
        document.getElementById('modal-logout-confirm').style.display = 'none';
    }

    /*
     * Le indica a spaNav() (en navbar.blade.php) que estamos en el panel admin.
     * Con este flag los links de la navbar llaman a mostrarVista() en lugar
     * de intentar redirigir a rutas externas o llamar showView().
     */
    var esContextoAdmin = true;

    /*
     * NAVEGACIÓN INTERNA DEL PANEL ADMIN
     * Oculta todas las secciones (.admin-view) y muestra solo la solicitada.
     * También marca el botón correspondiente como activo en el sidebar.
     *
     * Vistas disponibles: dashboard, usuarios, portafolios, notificaciones,
     *                     caracteristicas, explorador
     */
    function mostrarVista(nombre) {
        document.querySelectorAll('.admin-view').forEach(v => v.style.display = 'none');
        var vista = document.getElementById('view-' + nombre);
        if (vista) vista.style.display = 'block';
        document.querySelectorAll('.sb-item').forEach(b => b.classList.remove('active'));
        var btn = document.getElementById('btn-' + nombre);
        if (btn) btn.classList.add('active');
    }

    /* ══ Buscar y filtrar usuarios ══ */
    function filtrarUsuarios() {
        var q     = (document.getElementById('buscar-usuario').value || '').toLowerCase();
        var est   = (document.getElementById('filtro-estado').value || '').toLowerCase();
        document.querySelectorAll('#tabla-usuarios tbody tr').forEach(function(fila) {
            var texto  = fila.textContent.toLowerCase();
            var estado = (fila.getAttribute('data-estado') || '').toLowerCase();
            var okQ    = !q || texto.includes(q);
            var okEst  = !est || estado === est;
            fila.style.display = (okQ && okEst) ? '' : 'none';
        });
    }

    function filtrarPortafolios() {
        var q = (document.getElementById('buscar-portafolio').value || '').toLowerCase();
        document.querySelectorAll('#tabla-portafolios tbody tr').forEach(function(fila) {
            var texto = fila.textContent.toLowerCase();
            fila.style.display = (!q || texto.includes(q)) ? '' : 'none';
        });
    }

    function toggleSidebar() {
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        const adminDropdown = document.getElementById('admin-dropdown');
        if (adminDropdown && e.target.closest('.tb-right') === null) {
            adminDropdown.style.display = 'none';
        }
        if (!e.target.closest('.action-dropdown-container')) {
            document.querySelectorAll('.action-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });

    function toggleActionMenu(btn) {
        document.querySelectorAll('.action-menu').forEach(menu => {
            if (menu !== btn.nextElementSibling) {
                menu.style.display = 'none';
                menu.classList.remove('menu-up');
            }
        });
        const menu = btn.nextElementSibling;
        if (menu.style.display === 'flex') {
            menu.style.display = 'none';
            menu.classList.remove('menu-up');
        } else {
            menu.classList.remove('menu-up');
            menu.style.display = 'flex';
            const rect = menu.getBoundingClientRect();
            if (rect.bottom > window.innerHeight) {
                menu.classList.add('menu-up');
            }
        }
    }

    async function adminToggleStatus(userId, badgeId, btn) {
        const badge = document.getElementById(badgeId);
        const isCurrentlyActive = badge.classList.contains('st-active');

        if (isCurrentlyActive) {
            document.getElementById('modal-user-deactivate').style.display = 'flex';
            document.getElementById('admin-confirm-pass').value = '';
            document.getElementById('admin-confirm-pass').focus();

            document.getElementById('btn-confirm-deactivate').onclick = async function() {
                const password = document.getElementById('admin-confirm-pass').value;
                if (!password) {
                    alert('{{ __('app.admin.js_ingresar_contrasena') }}');
                    return;
                }
                const originalBtnText = this.innerText;
                this.innerText = '{{ __('app.admin.js_procesando') }}';
                this.disabled = true;
                const success = await executeStatusUpdate(userId, badgeId, btn, password);
                this.innerText = originalBtnText;
                this.disabled = false;
                if (success) cerrarModalDeactivate();
            };
        } else {
            executeStatusUpdate(userId, badgeId, btn);
        }
    }

    async function executeStatusUpdate(userId, badgeId, btn, password = null) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const formData = new FormData();
        if (password) formData.append('password', password);

        try {
            const res = await fetch(`/admin/usuarios/${userId}/toggle-status`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                const badge = document.getElementById(badgeId);
                if (data.activo) {
                    badge.className = 'status-badge st-active';
                    badge.innerText = '{{ __('app.admin.activo') }}';
                    btn.innerText = '{{ __('app.admin.js_desactivar_cuenta') }}';
                    btn.className = 'btn-action-admin btn-status-off';
                } else {
                    badge.className = 'status-badge st-inactive';
                    badge.innerText = '{{ __('app.admin.inactivo') }}';
                    btn.innerText = '{{ __('app.admin.js_activar_cuenta') }}';
                    btn.className = 'btn-action-admin btn-status-on';
                }
                const row = btn.closest('tr');
                if(row) row.setAttribute('data-estado', data.activo ? 'activo' : 'inactivo');
                return true;
            } else {
                alert(data.mensaje || '{{ __('app.admin.js_error_estado') }}');
                return false;
            }
        } catch (err) {
            console.error(err);
            alert('{{ __('app.admin.js_error_conexion') }}');
            return false;
        }
    }

    function cerrarModalDeactivate() {
        document.getElementById('modal-user-deactivate').style.display = 'none';
    }

    async function adminToggleRole(userId, roleCellId, btn) {
        const roleCell = document.getElementById(roleCellId);
        const currentRole = roleCell.innerText.trim().toLowerCase();
        const willBeAdmin = currentRole === 'usuario';

        document.getElementById('modal-role-title').innerText = willBeAdmin
            ? '{{ __('app.admin.js_hacer_admin') }}'
            : '{{ __('app.admin.js_quitar_admin') }}';
        document.getElementById('modal-role-text').innerText = willBeAdmin
            ? '{{ __('app.admin.js_texto_hacer_admin') }}'
            : '{{ __('app.admin.js_texto_quitar_admin') }}';

        document.getElementById('modal-user-role').style.display = 'flex';
        document.getElementById('admin-role-pass').value = '';
        document.getElementById('admin-role-pass').focus();

        document.getElementById('btn-confirm-role').onclick = async function() {
            const password = document.getElementById('admin-role-pass').value;
            if (!password) { alert('{{ __('app.admin.js_ingresar_contrasena') }}'); return; }
            const originalBtnText = this.innerText;
            this.innerText = '{{ __('app.admin.js_procesando') }}';
            this.disabled = true;
            const success = await executeRoleUpdate(userId, roleCellId, btn, password);
            this.innerText = originalBtnText;
            this.disabled = false;
            if (success) cerrarModalRole();
        };
    }

    async function executeRoleUpdate(userId, roleCellId, btn, password) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const formData = new FormData();
        formData.append('password', password);
        try {
            const res = await fetch(`/admin/usuarios/${userId}/toggle-role`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                const roleCell = document.getElementById(roleCellId);
                if (data.es_admin) {
                    roleCell.innerText = '{{ __('app.admin.rol_administrador') }}';
                    btn.innerText = '{{ __('app.admin.js_quitar_admin') }}';
                    btn.className = 'btn-action-admin btn-role-user';
                } else {
                    roleCell.innerText = '{{ __('app.admin.rol_usuario') }}';
                    btn.innerText = '{{ __('app.admin.js_volver_admin') }}';
                    btn.className = 'btn-action-admin btn-role-admin';
                }
                const row = btn.closest('tr');
                if(row) row.setAttribute('data-rol', data.es_admin ? 'admin' : 'usuario');
                return true;
            } else {
                alert(data.mensaje || '{{ __('app.admin.js_error_rol') }}');
                return false;
            }
        } catch (err) {
            console.error(err);
            alert('{{ __('app.admin.js_error_conexion') }}');
            return false;
        }
    }

    function cerrarModalRole() {
        document.getElementById('modal-user-role').style.display = 'none';
    }

    /* ══ Calendario ══ */
    let cur = new Date();
    let currentCalView = 'dias';
    let eventos = JSON.parse(localStorage.getItem('eventos') || '{}');

    const boliviaHolidays = {
        "01-01": "{{ __('app.admin.feriado_anio_nuevo') }}",
        "22-01": "{{ __('app.admin.feriado_estado_plurinacional') }}",
        "19-03": "{{ __('app.admin.feriado_dia_padre') }}",
        "12-04": "{{ __('app.admin.feriado_dia_nino') }}",
        "01-05": "{{ __('app.admin.feriado_dia_trabajo') }}",
        "27-05": "{{ __('app.admin.feriado_dia_madre') }}",
        "21-06": "{{ __('app.admin.feriado_anio_aymara') }}",
        "06-08": "{{ __('app.admin.feriado_independencia') }}",
        "17-08": "{{ __('app.admin.feriado_dia_bandera') }}",
        "21-09": "{{ __('app.admin.feriado_dia_primavera') }}",
        "11-10": "{{ __('app.admin.feriado_mujer_boliviana') }}",
        "02-11": "{{ __('app.admin.feriado_dia_difuntos') }}",
        "25-12": "{{ __('app.admin.feriado_navidad') }}"
    };

    function keyFecha(d,m,y){ return `${y}-${m}-${d}`; }

    function changeCalView(view) {
        currentCalView = view;
        renderCal();
    }

    function renderCal() {
        const y = cur.getFullYear(), m = cur.getMonth();
        const months = [
            "{{ __('app.admin.mes_enero') }}","{{ __('app.admin.mes_febrero') }}","{{ __('app.admin.mes_marzo') }}",
            "{{ __('app.admin.mes_abril') }}","{{ __('app.admin.mes_mayo') }}","{{ __('app.admin.mes_junio') }}",
            "{{ __('app.admin.mes_julio') }}","{{ __('app.admin.mes_agosto') }}","{{ __('app.admin.mes_septiembre') }}",
            "{{ __('app.admin.mes_octubre') }}","{{ __('app.admin.mes_noviembre') }}","{{ __('app.admin.mes_diciembre') }}"
        ];
        const gridContainer = document.getElementById("cal-grid-container");

        if (currentCalView === 'dias' || currentCalView === 'semanas') {
            document.getElementById("cal-title").textContent = months[m] + " " + y;
            let html = `<div class="cal-grid" id="cal-grid">
                <div class="cdn">{{ __('app.admin.cal_do') }}</div><div class="cdn">{{ __('app.admin.cal_lu') }}</div><div class="cdn">{{ __('app.admin.cal_ma') }}</div>
                <div class="cdn">{{ __('app.admin.cal_mi') }}</div><div class="cdn">{{ __('app.admin.cal_ju') }}</div><div class="cdn">{{ __('app.admin.cal_vi') }}</div><div class="cdn">{{ __('app.admin.cal_sa') }}</div>`;

            const first = new Date(y, m, 1).getDay();
            const days = new Date(y, m + 1, 0).getDate();
            const today = new Date();

            let dayCount = 0;
            if (currentCalView === 'semanas') html += `<div class="row-week">`;

            for(let i=0; i<first; i++) {
                const prev = new Date(y, m, 0).getDate() - first + i + 1;
                html += `<div class="cd other">${prev}</div>`;
                dayCount++;
            }

            for(let i=1; i<=days; i++) {
                if (currentCalView === 'semanas' && dayCount % 7 === 0) {
                    html += `</div><div class="row-week">`;
                }
                let cls = "cd";
                let titleAttr = "";
                if(y === today.getFullYear() && m === today.getMonth() && i === today.getDate()) cls += " today";
                const k = keyFecha(i, m, y);
                if(eventos[k] && eventos[k].length > 0) cls += " ev";
                const monthStr = (m + 1).toString().padStart(2, '0');
                const dayStr = i.toString().padStart(2, '0');
                const holidayKey = `${dayStr}-${monthStr}`;
                if(boliviaHolidays[holidayKey]) {
                    cls += " holiday";
                    titleAttr = `title="{{ __('app.admin.cal_feriado') }}: ${boliviaHolidays[holidayKey]}"`;
                }
                html += `<div class="${cls}" ${titleAttr}>${i}</div>`;
                dayCount++;
            }

            if (currentCalView === 'semanas') html += `</div>`;
            html += `</div>`;
            gridContainer.innerHTML = html;
        }
        else if (currentCalView === 'meses') {
            document.getElementById("cal-title").textContent = y;
            let html = `<div class="cal-grid-meses">`;
            months.forEach((mes, idx) => {
                let cls = "cm-btn";
                if(y === new Date().getFullYear() && idx === new Date().getMonth()) cls += " current";
                html += `<div class="${cls}" onclick="cur.setMonth(${idx}); document.getElementById('cal-view-sel').value='dias'; changeCalView('dias');">${mes.substring(0,3)}</div>`;
            });
            html += `</div>`;
            gridContainer.innerHTML = html;
        }
        else if (currentCalView === 'anios') {
            const startDecade = Math.floor(y / 10) * 10;
            document.getElementById("cal-title").textContent = `${startDecade} - ${startDecade + 9}`;
            let html = `<div class="cal-grid-anios">`;
            for(let i = startDecade - 1; i <= startDecade + 10; i++) {
                let cls = "cm-btn";
                if(i === new Date().getFullYear()) cls += " current";
                if(i < startDecade || i > startDecade + 9) cls += " other";
                html += `<div class="${cls}" onclick="cur.setFullYear(${i}); document.getElementById('cal-view-sel').value='meses'; changeCalView('meses');">${i}</div>`;
            }
            html += `</div>`;
            gridContainer.innerHTML = html;
        }
    }

    function changeMonth(dir) {
        if(currentCalView === 'dias' || currentCalView === 'semanas') {
            cur.setMonth(cur.getMonth() + dir);
        } else if(currentCalView === 'meses') {
            cur.setFullYear(cur.getFullYear() + dir);
        } else if(currentCalView === 'anios') {
            cur.setFullYear(cur.getFullYear() + (dir * 10));
        }
        renderCal();
    }
    renderCal();

    
</script>

</body>
</html>