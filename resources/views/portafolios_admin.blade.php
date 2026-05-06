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
            <div class="stat-info"><div class="stat-label">Total Portafolios</div><div class="stat-val">856</div><div class="stat-trend trend-up">Activos</div></div>
            <div class="stat-icon icon-blue"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Públicos</div><div class="stat-val">642</div><div class="stat-trend trend-up">Visibles</div></div>
            <div class="stat-icon icon-teal"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
        </div>
        <div class="stat-card">
            <div class="stat-info"><div class="stat-label">Privados</div><div class="stat-val">214</div><div class="stat-trend trend-down">Restringidos</div></div>
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
                <select id="filtro-categoria" onchange="filtrarPortafolios()" style="padding:8px 12px;border:1px solid var(--gray2);border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;background:#fff;cursor:pointer;outline:none;">
                    <option value="">Todas las categorías</option>
                    <option value="ingenieria">Ingeniería</option>
                    <option value="diseno">Diseño</option>
                    <option value="medicina">Medicina</option>
                </select>
            </div>
        </div>
        <div class="table-wrap">
            <table id="tabla-portafolios">
                <thead><tr><th>Portafolio</th><th>Autor</th><th>Categoría</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    <tr data-categoria="ingenieria">
                        <td><div class="user-cell"><div class="u-avatar" style="background:var(--admin-purple)">IP</div><div class="u-info"><span class="u-name">Proyecto Domótica</span><span class="u-email">Ingeniería de Sistemas</span></div></div></td>
                        <td>María Vargas</td><td>Sistemas</td>
                        <td><span class="status-badge st-active">Público</span></td>
                        <td><div class="action-dropdown-container"><button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button></div></td>
                    </tr>
                    <tr data-categoria="diseno">
                        <td><div class="user-cell"><div class="u-avatar" style="background:#1428c6">UI</div><div class="u-info"><span class="u-name">Rediseño Web UMSS</span><span class="u-email">Diseño Gráfico</span></div></div></td>
                        <td>Juan Robles</td><td>Gráfico</td>
                        <td><span class="status-badge st-pending">Revisión</span></td>
                        <td><div class="action-dropdown-container"><button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /view-portafolios -->
