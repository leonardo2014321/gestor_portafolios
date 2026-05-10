<!-- ═══ VISTA: PORTAFOLIOS ═══ -->
<div id="view-portafolios" class="admin-view" style="display:none">
    <div class="admin-hero" style="margin-bottom:1.5rem">
        <div class="hero-content">
            <h1 class="hero-title">Gestión de Portafolios</h1>
            <p class="hero-sub">Supervisa y administra los portafolios de los estudiantes.</p>
        </div>
    </div>

    <!-- Stats rápidas -->
    <div class="stats-grid" style="margin-bottom:1.5rem; grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Total Portafolios</div><div class="stat-val">{{ number_format($portafolios_stats['total']) }}</div><div class="stat-trend trend-up">Registrados</div></div>
            <div class="stat-icon icon-blue"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Vinculados</div><div class="stat-val">{{ number_format($portafolios_stats['con_usuarios']) }}</div><div class="stat-trend trend-up">Con usuarios</div></div>
            <div class="stat-icon icon-teal"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">No Vinculados</div><div class="stat-val">{{ number_format($portafolios_stats['sin_usuarios']) }}</div><div class="stat-trend trend-down">Sin usuarios</div></div>
            <div class="stat-icon icon-rose"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
        </div>
    </div>

    <!-- Tabla completa -->
    <div class="panel" style="margin-bottom:0">
        <div class="panel-header" style="padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray2);">
            <h2 class="panel-title">Lista de Portafolios</h2>
            <div style="display:flex;gap:10px;align-items:center;">
                <div style="display:flex;align-items:center;gap:8px;background:var(--gray);border:1px solid var(--gray2);border-radius:10px;padding:8px 14px;">
                    <svg width="14" height="14" fill="none" stroke="var(--muted)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input id="buscar-portafolio" oninput="filtrarPortafolios()" type="text" placeholder="Buscar portafolio..." style="border:none;outline:none;background:transparent;font-size:13px;font-family:'DM Sans',sans-serif;color:var(--text);width:180px">
                </div>
            </div>
        </div>
        <div class="table-wrap">
            <table id="tabla-portafolios">
                <thead><tr><th>Portafolio</th><th>Tipo</th><th>Tags</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @foreach($todos_portafolios as $portafolio)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="u-avatar {{ $portafolio->avatar_class }}">{{ $portafolio->avatar_letter }}</div>
                                <div class="u-info">
                                    <span class="u-name">{{ $portafolio->titulo }}</span>
                                    <span class="u-email">{{ Str::limit($portafolio->descripcion, 40) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ ucfirst($portafolio->tipo) }}</td>
                        <td>
                            @if(is_array($portafolio->tags))
                                @foreach(array_slice($portafolio->tags, 0, 2) as $tag)
                                    <span class="status-badge" style="background:var(--gray); color:var(--muted); text-transform:none; font-size:10px;">{{ $tag }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $portafolio->has_users ? 'st-active' : 'st-pending' }}">
                                {{ $portafolio->has_users ? 'Vinculado' : 'Pendiente' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-dropdown-container">
                                <button class="action-btn" onclick="toggleActionMenu(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /view-portafolios -->
