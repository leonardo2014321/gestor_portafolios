{{-- ============================================================
     _calendario_menu.blade.php
     Partial: calendario del panel derecho (HTML + JS)
     Uso: @include('_calendario_menu')
     ============================================================ --}}

{{-- ══ HTML del Calendario ══ --}}
<div class="rp-sec">
    <div class="cal-hd" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
        <div class="cal-month" id="cal-title" style="flex:1;">Abril 2026</div>
        <select class="cal-view-selector" id="cal-view-sel" onchange="changeCalView(this.value)" style="margin:0;">
            <option value="dias">{{ __('app.menu.dias') }}</option>
            <option value="semanas">{{ __('app.menu.semanas') }}</option>
            <option value="meses">{{ __('app.menu.meses') }}</option>
            <option value="anios">{{ __('app.menu.anios') }}</option>
        </select>
        <div class="cal-navs">
            <button class="cal-nav" onclick="changeMonth(-1)">‹</button>
            <button class="cal-nav" onclick="changeMonth(1)">›</button>
        </div>
    </div>
    <div id="cal-grid-container">
        <div class="cal-grid" id="cal-grid">
            <div class="cdn">Do</div><div class="cdn">Lu</div><div class="cdn">Ma</div>
            <div class="cdn">Mi</div><div class="cdn">Ju</div><div class="cdn">Vi</div><div class="cdn">Sá</div>
        </div>
    </div>
</div>

{{-- ══ Modal detalle del día ══ --}}
<div id="modalDia" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
    <div style="width:90%;max-width:440px;background:#fff;border-radius:28px;overflow:hidden;max-height:90vh;overflow-y:auto;box-shadow:0 24px 60px rgba(0,0,0,0.2);">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;padding:28px 28px 0;">
            <div>
                <div style="font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:#64748b;margin-bottom:4px;">Detalle del día</div>
                <div id="modalFecha" style="font-size:24px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;"></div>
            </div>
            <button onclick="cerrarModal()" style="width:36px;height:36px;border-radius:50%;border:1px solid #e2e8f0;background:transparent;cursor:pointer;font-size:16px;color:#64748b;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;padding:20px 28px 0;" id="listaEventos"></div>
        <div style="padding:16px 28px 0;">
            <div style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#64748b;margin-bottom:10px;">Nuevo evento</div>
            <input id="nuevoEventoInput" type="text" placeholder="Nombre del evento..."
                style="width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid #e2e8f0;font-family:'DM Sans',sans-serif;font-size:13px;outline:none;margin-bottom:8px;">
            <input id="nuevoEventoHora" type="text" placeholder="Hora (ej: 10:00 AM)"
                style="width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid #e2e8f0;font-family:'DM Sans',sans-serif;font-size:13px;outline:none;">
        </div>
        <div style="display:flex;gap:12px;padding:16px 28px 28px;">
            <button onclick="cerrarModal()" style="flex:1;padding:13px;border-radius:12px;border:1px solid #e2e8f0;background:transparent;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">Cerrar</button>
            <button onclick="agregarEvento()" style="flex:1.3;display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;border-radius:12px;border:none;background:#2563eb;color:#fff;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="12" x2="12" y1="14" y2="18"/><line x1="10" x2="14" y1="16" y2="16"/></svg>
                Agregar evento
            </button>
        </div>
    </div>
</div>

{{-- ══ JS del Calendario ══ --}}
<script>
    const months_es = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    let eventos = JSON.parse(localStorage.getItem('eventos') || '{}');
    let modalDia = null, modalMes = null, modalAnio = null;

    function guardarEventos() { localStorage.setItem('eventos', JSON.stringify(eventos)); }
    function keyFecha(d, m, y) { return `${y}-${m}-${d}`; }

    function abrirModal(dia, mes, anio) {
        modalDia = dia; modalMes = mes; modalAnio = anio;
        document.getElementById('modalFecha').textContent = dia + ' de ' + months_es[mes] + ', ' + anio;
        document.getElementById('nuevoEventoInput').value = '';
        document.getElementById('nuevoEventoHora').value = '';
        renderEventosModal();
        document.getElementById('modalDia').style.display = 'flex';
    }

    function cerrarModal() { document.getElementById('modalDia').style.display = 'none'; }

    function renderEventosModal() {
        const key = keyFecha(modalDia, modalMes, modalAnio);
        const lista = eventos[key] || [];
        const container = document.getElementById('listaEventos');
        if (lista.length === 0) {
            container.innerHTML = `<div style="display:flex;flex-direction:column;align-items:center;padding:18px;border-radius:16px;border:2px dashed #e2e8f0;gap:4px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="16"/><line x1="8" x2="16" y1="12" y2="12"/></svg>
                <span style="font-size:10px;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;color:#94a3b8;">Sin eventos</span>
            </div>`;
            return;
        }
        container.innerHTML = lista.map((ev, i) => `
            <div style="display:flex;align-items:flex-start;gap:14px;padding:14px;background:#f0f4f8;border-radius:4px 16px 16px 4px;border-left:4px solid #2563eb;">
                <div style="width:34px;height:34px;border-radius:10px;background:#e8eefb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:600;color:#0f172a;">${ev.nombre}</div>
                    ${ev.hora ? `<div style="display:flex;align-items:center;gap:5px;color:#64748b;margin-top:4px;"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><span style="font-size:12px;">${ev.hora}</span></div>` : ''}
                </div>
                <button onclick="eliminarEvento(${i})" style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;display:flex;align-items:center;" title="Eliminar">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </button>
            </div>`).join('');
    }

    function agregarEvento() {
        const nombre = document.getElementById('nuevoEventoInput').value.trim();
        const hora   = document.getElementById('nuevoEventoHora').value.trim();
        if (!nombre) return;
        const key = keyFecha(modalDia, modalMes, modalAnio);
        if (!eventos[key]) eventos[key] = [];
        eventos[key].push({ nombre, hora });
        guardarEventos(); renderEventosModal(); renderCal();
        document.getElementById('nuevoEventoInput').value = '';
        document.getElementById('nuevoEventoHora').value  = '';
    }

    function eliminarEvento(idx) {
        const key = keyFecha(modalDia, modalMes, modalAnio);
        eventos[key].splice(idx, 1);
        if (eventos[key].length === 0) delete eventos[key];
        guardarEventos(); renderEventosModal(); renderCal();
    }

    /* ══ Render del calendario ══ */
    let cur = new Date();
    let currentCalView = 'dias';

    const boliviaHolidays = {
        "01-01": "Año Nuevo",
        "22-01": "Día del Estado Plurinacional",
        "19-03": "Día del Padre",
        "12-04": "Día del Niño",
        "01-05": "Día del Trabajo",
        "27-05": "Día de la Madre",
        "21-06": "Año Nuevo Aymara",
        "06-08": "Día de la Independencia",
        "17-08": "Día de la Bandera",
        "21-09": "Día de la Primavera y del Estudiante",
        "11-10": "Día de la Mujer Boliviana",
        "02-11": "Día de los Difuntos",
        "25-12": "Navidad"
    };

    function changeCalView(view) {
        currentCalView = view;
        renderCal();
    }

    function renderCal() {
        const y = cur.getFullYear(), m = cur.getMonth();
        const months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        const gridContainer = document.getElementById('cal-grid-container');

        if (currentCalView === 'dias' || currentCalView === 'semanas') {
            document.getElementById('cal-title').textContent = months[m] + ' ' + y;
            let html = `<div class="cal-grid" id="cal-grid">
                <div class="cdn">Do</div><div class="cdn">Lu</div><div class="cdn">Ma</div>
                <div class="cdn">Mi</div><div class="cdn">Ju</div><div class="cdn">Vi</div><div class="cdn">Sá</div>`;
            const first = new Date(y, m, 1).getDay();
            const days  = new Date(y, m + 1, 0).getDate();
            const today = new Date();
            let dayCount = 0;
            if (currentCalView === 'semanas') html += `<div class="row-week">`;
            for (let i = 0; i < first; i++) {
                const prev = new Date(y, m, 0).getDate() - first + i + 1;
                html += `<div class="cd other">${prev}</div>`;
                dayCount++;
            }
            for (let i = 1; i <= days; i++) {
                if (currentCalView === 'semanas' && dayCount % 7 === 0) html += `</div><div class="row-week">`;
                let cls = 'cd';
                let titleAttr = '';
                if (y === today.getFullYear() && m === today.getMonth() && i === today.getDate()) cls += ' today';
                const k = keyFecha(i, m, y);
                if (eventos[k] && eventos[k].length > 0) cls += ' ev';
                const monthStr   = (m + 1).toString().padStart(2, '0');
                const dayStr     = i.toString().padStart(2, '0');
                const holidayKey = `${dayStr}-${monthStr}`;
                if (boliviaHolidays[holidayKey]) {
                    cls += ' holiday';
                    titleAttr = `title="Feriado: ${boliviaHolidays[holidayKey]}"`;
                }
                html += `<div class="${cls}" ${titleAttr} style="cursor:pointer;" onclick="abrirModal(${i},${m},${y})">${i}</div>`;
                dayCount++;
            }
            if (currentCalView === 'semanas') html += `</div>`;
            html += `</div>`;
            gridContainer.innerHTML = html;
        }
        else if (currentCalView === 'meses') {
            document.getElementById('cal-title').textContent = y;
            let html = `<div class="cal-grid-meses">`;
            months.forEach((mes, idx) => {
                let cls = 'cm-btn';
                if (y === new Date().getFullYear() && idx === new Date().getMonth()) cls += ' current';
                html += `<div class="${cls}" onclick="cur.setMonth(${idx}); document.getElementById('cal-view-sel').value='dias'; changeCalView('dias');">${mes.substring(0, 3)}</div>`;
            });
            html += `</div>`;
            gridContainer.innerHTML = html;
        }
        else if (currentCalView === 'anios') {
            const startDecade = Math.floor(y / 10) * 10;
            document.getElementById('cal-title').textContent = `${startDecade} - ${startDecade + 9}`;
            let html = `<div class="cal-grid-anios">`;
            for (let i = startDecade - 1; i <= startDecade + 10; i++) {
                let cls = 'cm-btn';
                if (i === new Date().getFullYear()) cls += ' current';
                if (i < startDecade || i > startDecade + 9) cls += ' other';
                html += `<div class="${cls}" onclick="cur.setFullYear(${i}); document.getElementById('cal-view-sel').value='meses'; changeCalView('meses');">${i}</div>`;
            }
            html += `</div>`;
            gridContainer.innerHTML = html;
        }
    }

    function changeMonth(dir) {
        if (currentCalView === 'dias' || currentCalView === 'semanas') {
            cur.setMonth(cur.getMonth() + dir);
        } else if (currentCalView === 'meses') {
            cur.setFullYear(cur.getFullYear() + dir);
        } else if (currentCalView === 'anios') {
            cur.setFullYear(cur.getFullYear() + (dir * 10));
        }
        renderCal();
    }

    renderCal();
</script>