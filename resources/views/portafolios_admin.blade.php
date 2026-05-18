<!-- ═══ VISTA: PORTAFOLIOS ═══ -->
<div id="view-portafolios" class="admin-view" style="display:none">
    <div class="admin-hero" style="margin-bottom:1.5rem">
        <div class="hero-content">
            <h1 class="hero-title">{{ __('app.portafolios_admin.titulo') }}</h1>
            <p class="hero-sub">{{ __('app.portafolios_admin.subtitulo') }}</p>
        </div>
    </div>

    <!-- Stats rápidas -->
    <div class="stats-grid portafolios-stats" style="margin-bottom:1.5rem;">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('app.portafolios_admin.stat_total') }}</div>
                <div class="stat-val">{{ number_format($portafolios_stats['total']) }}</div>
                <div class="stat-trend trend-up">{{ __('app.portafolios_admin.stat_registrados') }}</div>
            </div>
            <div class="stat-icon icon-blue"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('app.portafolios_admin.stat_vinculados') }}</div>
                <div class="stat-val">{{ number_format($portafolios_stats['con_usuarios']) }}</div>
                <div class="stat-trend trend-up">{{ __('app.portafolios_admin.stat_con_usuarios') }}</div>
            </div>
            <div class="stat-icon icon-teal"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('app.portafolios_admin.stat_no_vinculados') }}</div>
                <div class="stat-val">{{ number_format($portafolios_stats['sin_usuarios']) }}</div>
                <div class="stat-trend trend-down">{{ __('app.portafolios_admin.stat_sin_usuarios') }}</div>
            </div>
            <div class="stat-icon icon-rose"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
        </div>
    </div>

    <!-- Tabla completa -->
    <div class="panel" style="margin-bottom:0">
        <div class="panel-header" style="padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray2);">
            <h2 class="panel-title">{{ __('app.portafolios_admin.lista_titulo') }}</h2>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:8px;background:var(--gray);border:1px solid var(--gray2);border-radius:10px;padding:8px 14px;">
                    <svg width="14" height="14" fill="none" stroke="var(--muted)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input id="buscar-portafolio" oninput="filtrarPortafolios()" type="text"
                        placeholder="{{ __('app.portafolios_admin.buscar_placeholder') }}"
                        style="border:none;outline:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;color:var(--text);width:180px">
                </div>
            </div>
        </div>
        <div class="table-wrap">
            <table id="tabla-portafolios">
                <thead><tr>
                    <th>{{ __('app.portafolios_admin.col_portafolio') }}</th>
                    <th>{{ __('app.portafolios_admin.col_autor') }}</th>
                    <th>{{ __('app.portafolios_admin.col_repositorio') }}</th>
                    <th>{{ __('app.portafolios_admin.col_estado') }}</th>
                    <th>{{ __('app.portafolios_admin.col_acciones') }}</th>
                </tr></thead>
                <tbody>
                    @foreach($todos_portafolios as $portafolio)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="u-avatar" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: #fff;">
                                    {{ strtoupper(substr($portafolio->nombre, 0, 1)) }}
                                </div>
                                <div class="u-info">
                                    <span class="u-name">{{ $portafolio->nombre }}</span>
                                    <span class="u-email">{{ Str::limit($portafolio->descripcion, 40) ?: __('app.portafolios_admin.empty_descripcion') }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($portafolio->usuario)
                                <span style="font-weight: 500;">{{ $portafolio->usuario->nombre }} {{ $portafolio->usuario->apellido }}</span>
                            @else
                                <span style="color: var(--muted); font-size: 12px; font-style: italic;">{{ __('app.portafolios_admin.empty_usuario') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($portafolio->repositorio_url)
                                <a href="{{ $portafolio->repositorio_url }}" target="_blank" style="color: var(--admin-purple); text-decoration: none; font-size: 12.5px; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 1 7.54.54l3 3a5 5 0 0 1-7.07 7.07l-1.72-1.71"/><path d="M14 11a5 5 0 0 1-7.54-.54l-3-3A5 5 0 0 1 10.54.39l1.71 1.71"/></svg>
                                    {{ __('app.portafolios_admin.enlace_repo') }}
                                </a>
                            @else
                                <span style="color: var(--muted); font-size: 12px;">{{ __('app.portafolios_admin.empty_repositorio') }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $portafolio->estado === 'activo' ? 'st-active' : 'st-inactive' }}">
                                {{ $portafolio->estado === 'activo' ? __('app.portafolios_admin.estado_activo') : ($portafolio->estado ?: __('app.portafolios_admin.estado_desconocido')) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-dropdown-container">
                                <button class="action-btn" onclick="toggleActionMenu(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                </button>
                                <div class="action-menu">
                                    <button class="btn-action-admin btn-role-user" onclick="alert('Funcionalidad en desarrollo')">
                                        {{ __('app.portafolios_admin.accion_ver_detalles') }}
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($todos_portafolios->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: var(--muted);">
                            {{ __('app.portafolios_admin.empty_tabla') }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /view-portafolios -->