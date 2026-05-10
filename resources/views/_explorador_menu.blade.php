{{-- ============================================================
     _explorador_menu.blade.php
     Partial: contenido de la vista "Explorador" para menu.blade.php
     Uso: @include('_explorador_menu')
     ============================================================ --}}

<div class="exp-hero">
    <div class="exp-hero-bg"></div>
    <div class="exp-hero-content">
        <div class="exp-hero-title">Sistema de Portafolios</div>
        <div class="exp-hero-sub">Gestión Institucional de Activos Digitales · UMSS</div>
        <div class="exp-search-wrap">
            <div class="exp-search-box">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="expSearch"
                       placeholder="Buscar... (Ctrl + K)"
                       onfocus="expShowHistory()"
                       onkeydown="if(event.key==='Enter') expSearchAction()"/>
            </div>
            <button class="btn-buscar" onclick="expSearchAction()">Buscar</button>
            <div id="expHistory" class="exp-history-dropdown" style="display:none;"></div>
        </div>
    </div>
</div>

<div class="exp-filters">
    <button class="exp-filter active" onclick="expSetFilter(this,'todos')">Todos</button>
    <button class="exp-filter" onclick="expSetFilter(this,'proyecto')">Proyectos</button>
    <button class="exp-filter" onclick="expSetFilter(this,'perfil')">Perfiles</button>
    <button class="exp-filter" onclick="expSetFilter(this,'documento')">Documentos</button>
    <button class="exp-filter" onclick="expSetFilter(this,'habilidad')">Habilidades</button>
</div>

<div class="exp-results-bar">
    <span class="exp-count" id="expCount">0 Resultados</span>

    @if(isset($busquedas) && count($busquedas) > 0)
        <span style="background:#dcfce7;color:#166534;padding:2px 10px;border-radius:5px;
                     font-size:11px;font-weight:bold;margin-left:10px;">
            DIFUSION: BASE DE DATOS ACTIVA
        </span>
    @endif

    <div id="sortContainer" style="position:relative;display:inline-block;">
        <button class="exp-filter"
                onclick="document.getElementById('sortMenu').style.display =
                         document.getElementById('sortMenu').style.display === 'block' ? 'none' : 'block'"
                style="display:inline-flex;align-items:center;gap:6px;">
            <span id="sortLabel">Ordenar por relevancia</span>
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div id="sortMenu"
             style="display:none;position:absolute;right:0;top:110%;background:#fff;
                    border:1.5px solid var(--gray2);border-radius:8px;
                    box-shadow:0 4px 12px rgba(0,0,0,0.1);z-index:10;min-width:160px;overflow:hidden;">
            <div onclick="expSetSort('relevancia','Ordenar por relevancia')"
                 style="padding:8px 16px;font-size:13px;font-family:'DM Sans',sans-serif;cursor:pointer;
                        transition:background .2s;color:var(--text);"
                 onmouseover="this.style.background='var(--gray)'"
                 onmouseout="this.style.background='transparent'">Relevancia</div>
            <div onclick="expSetSort('az','Ordenar: A - Z')"
                 style="padding:8px 16px;font-size:13px;font-family:'DM Sans',sans-serif;cursor:pointer;
                        transition:background .2s;color:var(--text);"
                 onmouseover="this.style.background='var(--gray)'"
                 onmouseout="this.style.background='transparent'">A - Z</div>
            <div onclick="expSetSort('za','Ordenar: Z - A')"
                 style="padding:8px 16px;font-size:13px;font-family:'DM Sans',sans-serif;cursor:pointer;
                        transition:background .2s;color:var(--text);"
                 onmouseover="this.style.background='var(--gray)'"
                 onmouseout="this.style.background='transparent'">Z - A</div>
        </div>
    </div>
</div>

<div class="exp-grid" id="expGrid"></div>

{{-- ══ JS del Explorador ══ --}}
<script>
    const dbCards = @json($busquedas ?? []);

    const fallbackCards = [
        {type:"PROYECTO",avClass:"av-blue",avLetter:"P",title:"Programa de Optimización Fiscal 2024",desc:"Iniciativa estratégica para la mejora de flujos de caja institucionales.",tags:["#FINANCE","#FISCAL","#STRATEGY"],cat:"proyecto"},
        {type:"PROYECTO",avClass:"av-green",avLetter:"P",title:"Programa de Desarrollo Ambiental 2020",desc:"Iniciativa estratégica para la mejora del desarrollo ambiental.",tags:["#FINANCE","#LIFE","#STRATEGY"],cat:"proyecto"},
        {type:"HABILIDAD",avClass:"av-orange",avLetter:"H",title:"Programación en PHP / Symfony",desc:"Capacidad funcional en el desarrollo de frameworks para diseño y sistemas.",tags:["#PHP","#BACKEND"],cat:"habilidad",hasUsers:true},
        {type:"DOCUMENTO",avClass:"av-teal",avLetter:"D",title:"Protocolos de Seguridad Interna V2",desc:"Documentación técnica sobre buenas prácticas en encriptación.",tags:["#SECURITY","#PDF"],cat:"documento"},
    ];

    const expCards = dbCards.length > 0 ? dbCards.map(c => ({
        type: (c.tipo || 'S/T').toUpperCase(),
        avClass: c.avatar_class || 'av-blue',
        avLetter: c.avatar_letter || '?',
        title: c.titulo || 'Sin título',
        desc: c.descripcion || 'Sin descripción',
        tags: Array.isArray(c.tags) ? c.tags : (typeof c.tags === 'string' ? JSON.parse(c.tags || '[]') : []),
        cat: c.tipo || 'otros',
        hasUsers: !!c.has_users
    })) : fallbackCards;

    const originalExpCards = [...expCards];
    let expActiveFilter = 'todos';

    function escapeHTML(str) {
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    }

    function expHL(text){
        const q = document.getElementById('expSearch').value.trim();
        if(!q) return escapeHTML(text);
        const escapedText = escapeHTML(text);
        const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`,'gi');
        return escapedText.replace(re,'<mark>$1</mark>');
    }

    function expRender(cards){
        const countEl = document.getElementById('expCount');
        if (cards.length === 0) {
            countEl.textContent = "0 Resultados";
            document.getElementById('expGrid').innerHTML = `
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--muted);">
                    <svg viewBox="0 0 24 24" style="width:48px;height:48px;margin-bottom:1rem;stroke:var(--gray3);fill:none;stroke-width:1.5;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <p style="font-weight:600;color:var(--text);">No se encontraron resultados</p>
                    <p style="font-size:13px;">Intenta con otros términos o filtros.</p>
                </div>`;
            return;
        }
        countEl.textContent = `${cards.length} Resultado${cards.length!==1?'s':''} Encontrado${cards.length!==1?'s':''}`;
        document.getElementById('expGrid').innerHTML = cards.map(c=>`
            <div class="exp-card">
                <div class="exp-card-type">${escapeHTML(c.type)}</div>
                <div class="exp-card-top"><div class="exp-avatar ${escapeHTML(c.avClass)}">${escapeHTML(c.avLetter)}</div><div class="exp-card-title">${expHL(c.title)}</div></div>
                <div class="exp-card-desc">${escapeHTML(c.desc)}</div>
                <div class="exp-card-actions">
                    <div class="exp-tags">${c.tags.map(t=>`<span class="exp-tag">${escapeHTML(t)}</span>`).join('')}</div>
                    <div class="exp-icons">
                        ${c.hasUsers?`<div style="display:flex;align-items:center"><div style="width:18px;height:18px;border-radius:50%;background:#1a56db;border:2px solid #fff"></div><div style="width:18px;height:18px;border-radius:50%;background:#059669;border:2px solid #fff;margin-left:-5px"></div></div>`:''}
                        <button class="exp-icon-btn" title="Guardar"><svg viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg></button>
                        <button class="exp-icon-btn" title="Descargar"><svg viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg></button>
                    </div>
                </div>
                <div class="trend-icon"><svg viewBox="0 0 38 26" fill="none" stroke="#1a56db" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,20 10,12 16,16 26,6 36,10"/></svg></div>
            </div>`).join('');
    }

    function expSaveSearch(q) {
        if(!q || q.length < 2) return;
        let history = JSON.parse(localStorage.getItem('exp_history') || '[]');
        history = history.filter(h => h.toLowerCase() !== q.toLowerCase());
        history.unshift(q);
        history = history.slice(0, 5);
        localStorage.setItem('exp_history', JSON.stringify(history));
    }

    function expShowHistory() {
        const history = JSON.parse(localStorage.getItem('exp_history') || '[]');
        const div = document.getElementById('expHistory');
        if (history.length === 0) { div.style.display = 'none'; return; }
        div.innerHTML = `
            <div class="exp-history-header">
                <span>Búsquedas recientes</span>
                <span class="btn-clear-history" onclick="expClearHistory()">Limpiar</span>
            </div>
            ${history.map((h, i) => `
                <div class="exp-history-item">
                    <div style="flex:1;display:flex;align-items:center;gap:10px;" onclick="expSelectHistory('${h.replace(/'/g, "\\'")}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>${escapeHTML(h)}</span>
                    </div>
                    <button class="btn-remove-history" onclick="event.stopPropagation();expRemoveHistoryItem(${i})" title="Eliminar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>`).join('')}`;
        div.style.display = 'block';
    }

    function expSelectHistory(val) {
        document.getElementById('expSearch').value = val;
        document.getElementById('expHistory').style.display = 'none';
        expFilter();
    }

    function expClearHistory() {
        localStorage.removeItem('exp_history');
        document.getElementById('expHistory').style.display = 'none';
    }

    function expRemoveHistoryItem(idx) {
        let history = JSON.parse(localStorage.getItem('exp_history') || '[]');
        history.splice(idx, 1);
        if (history.length === 0) {
            localStorage.removeItem('exp_history');
            document.getElementById('expHistory').style.display = 'none';
        } else {
            localStorage.setItem('exp_history', JSON.stringify(history));
            expShowHistory();
        }
    }

    function expSearchAction() {
        const q = document.getElementById('expSearch').value.trim();
        expSaveSearch(q);
        document.getElementById('expHistory').style.display = 'none';
        expFilter();
    }

    function expFilter(){
        const q = document.getElementById('expSearch').value.toLowerCase();
        expRender(expCards.filter(c => {
            const matchText = c.title.toLowerCase().includes(q) ||
                              c.desc.toLowerCase().includes(q) ||
                              (c.tags && c.tags.some(t => t.toLowerCase().includes(q)));
            const matchCat = expActiveFilter === 'todos' || c.cat === expActiveFilter;
            return matchText && matchCat;
        }));
    }

    function expSetFilter(btn, cat){
        expActiveFilter = cat;
        document.querySelectorAll('.exp-filter').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        expFilter();
    }

    function expSetSort(mode, label) {
        document.getElementById('sortLabel').innerText = label;
        document.getElementById('sortMenu').style.display = 'none';
        if (mode === 'az') expCards.sort((a,b) => a.title.localeCompare(b.title));
        else if (mode === 'za') expCards.sort((a,b) => b.title.localeCompare(a.title));
        else if (mode === 'relevancia') { expCards.length = 0; expCards.push(...originalExpCards); }
        expFilter();
    }

    document.addEventListener('click', function(e) {
        const wrap = document.querySelector('.exp-search-wrap');
        if (wrap && !wrap.contains(e.target))
            document.getElementById('expHistory').style.display = 'none';
    });

    document.addEventListener('click', function(e) {
        const sortContainer = document.getElementById('sortContainer');
        if (sortContainer && !sortContainer.contains(e.target)) {
            const menu = document.getElementById('sortMenu');
            if(menu) menu.style.display = 'none';
        }
    });

    expRender(expCards);
</script>