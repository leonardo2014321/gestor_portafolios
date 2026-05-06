<!-- ═══ VISTA: USUARIOS ═══ -->
<div id="view-usuarios" class="admin-view" style="display:none">
    <div class="admin-hero" style="margin-bottom:1.5rem">
        <div class="hero-content">
            <h1 class="hero-title">Gestión de Usuarios</h1>
            <p class="hero-sub">Administra los usuarios registrados en la plataforma.</p>
        </div>
    </div>

    <!-- Stats rápidas -->
    <div class="stats-grid" style="margin-bottom:1.5rem">
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Total Usuarios</div><div class="stat-val">{{ number_format($stats['total_usuarios']) }}</div><div class="stat-trend trend-up">Registrados</div></div>
            <div class="stat-icon icon-purple"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Activos</div><div class="stat-val">{{ number_format($stats['usuarios_activos']) }}</div><div class="stat-trend trend-up">En línea</div></div>
            <div class="stat-icon icon-teal"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Inactivos</div><div class="stat-val">{{ number_format($stats['usuarios_inactivos']) }}</div><div class="stat-trend trend-down">Desactivados</div></div>
            <div class="stat-icon icon-rose"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Admins</div><div class="stat-val">{{ $stats['total_admins'] }}</div><div class="stat-trend trend-up">Con privilegios</div></div>
            <div class="stat-icon icon-blue"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        </div>
    </div>

    <!-- Tabla completa -->
    <div class="panel" style="margin-bottom:0">
        <div class="panel-header" style="padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray2);">
            <h2 class="panel-title">Lista de Usuarios</h2>
            <div style="display:flex;gap:10px;align-items:center;">
                <div style="display:flex;align-items:center;gap:8px;background:var(--gray);border:1px solid var(--gray2);border-radius:10px;padding:8px 14px;">
                    <svg width="14" height="14" fill="none" stroke="var(--muted)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input id="buscar-usuario" oninput="filtrarUsuarios()" type="text" placeholder="Buscar usuario..." style="border:none;outline:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;color:var(--text);width:160px">
                </div>
                <select id="filtro-estado" onchange="filtrarUsuarios()" style="padding:8px 12px;border:1px solid var(--gray2);border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;background:#fff;cursor:pointer;outline:none;">
                    <option value="">Todos</option>
                    <option value="activo">Activos</option>
                    <option value="inactivo">Inactivos</option>
                </select>
            </div>
        </div>
        <div class="table-wrap">
            <table id="tabla-usuarios">
                <thead><tr><th>Usuario</th><th>Rol</th><th>Fecha Registro</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @foreach($todos_usuarios as $usuario)
                    <tr data-estado="{{ $usuario->activo ? 'activo' : 'inactivo' }}">
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
                        <td><span id="ur-{{ $usuario->id }}">{{ $usuario->es_admin ? 'Administrador' : 'Usuario' }}</span></td>
                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="status-badge {{ $usuario->activo ? 'st-active' : 'st-inactive' }}" id="us-{{ $usuario->id }}">
                                {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-dropdown-container">
                                <button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                                <div class="action-menu">
                                    <div style="display:flex;justify-content:space-between;align-items:center">
                                        <span style="font-size:13px;font-weight:600">Estado</span>
                                        <label class="switch">
                                            <input type="checkbox" {{ $usuario->activo ? 'checked' : '' }} onchange="toggleStatus(this,'us-{{ $usuario->id }}')">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div style="height:1px;background:var(--gray2)"></div>
                                    <div style="display:flex;justify-content:space-between;align-items:center">
                                        <span style="font-size:13px;font-weight:600">Admin</span>
                                        <label class="switch">
                                            <input type="checkbox" {{ $usuario->es_admin ? 'checked' : '' }} onchange="toggleRole(this,'ur-{{ $usuario->id }}')">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /view-usuarios -->
