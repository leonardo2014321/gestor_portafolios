{{-- ============================================================
     _explorador_menu.blade.php
     Partial: contenido de la vista "Explorador" para menu.blade.php
     Uso: @include('_explorador_menu')
     ============================================================ --}}

<div class="exp-hero">
    <div class="exp-hero-bg"></div>
    <div class="exp-hero-content">
        <div class="exp-hero-title">{{ __('app.explorador.hero_titulo') }}</div>
        <div class="exp-hero-sub">{{ __('app.explorador.hero_subtitulo') }}</div>
        <div class="exp-search-wrap">
            <div class="exp-search-box">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="expSearch"
                       placeholder="{{ __('app.explorador.buscar_placeholder') }}"
                       onfocus="expShowHistory()"
                       onkeydown="if(event.key==='Enter') expSearchAction()"/>
            </div>
            <button class="btn-buscar" onclick="expSearchAction()">{{ __('app.explorador.btn_buscar') }}</button>
            <div id="expHistory" class="exp-history-dropdown" style="display:none;"></div>
        </div>
    </div>
</div>

<div class="exp-filters">
    <button class="exp-filter active" onclick="expSetFilter(this,'todos')">{{ __('app.explorador.filtro_todos') }}</button>
    <button class="exp-filter" onclick="expSetFilter(this,'proyecto')">{{ __('app.explorador.filtro_proyectos') }}</button>
    <button class="exp-filter" onclick="expSetFilter(this,'perfil')">{{ __('app.explorador.filtro_perfiles') }}</button>
    <button class="exp-filter" onclick="expSetFilter(this,'documento')">{{ __('app.explorador.filtro_documentos') }}</button>
    <button class="exp-filter" onclick="expSetFilter(this,'habilidad')">{{ __('app.explorador.filtro_habilidades') }}</button>
</div>

<div class="exp-results-bar">
    <span class="exp-count" id="expCount">0 {{ __('app.explorador.resultados') }}</span>

    @if(isset($busquedas) && count($busquedas) > 0)
        <span style="background:#dcfce7;color:#166534;padding:2px 10px;border-radius:5px;
                     font-size:11px;font-weight:bold;margin-left:10px;">
            {{ __('app.explorador.difusion_activa') }}
        </span>
    @endif

    <div id="sortContainer" style="position:relative;display:inline-block;">
        <button class="exp-filter"
                onclick="document.getElementById('sortMenu').style.display =
                         document.getElementById('sortMenu').style.display === 'block' ? 'none' : 'block'"
                style="display:inline-flex;align-items:center;gap:6px;">
            <span id="sortLabel">{{ __('app.explorador.ordenar_relevancia') }}</span>
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div id="sortMenu"
             style="display:none;position:absolute;right:0;top:110%;background:#fff;
                    border:1.5px solid var(--gray2);border-radius:8px;
                    box-shadow:0 4px 12px rgba(0,0,0,0.1);z-index:10;min-width:160px;overflow:hidden;">
            <div onclick="expSetSort('relevancia', '{{ __('app.explorador.ordenar_relevancia') }}')"
                 style="padding:8px 16px;font-size:13px;font-family:'DM Sans',sans-serif;cursor:pointer;
                        transition:background .2s;color:var(--text);"
                 onmouseover="this.style.background='var(--gray)'"
                 onmouseout="this.style.background='transparent'">{{ __('app.explorador.orden_relevancia') }}</div>
            <div onclick="expSetSort('az', '{{ __('app.explorador.ordenar_az') }}')"
                 style="padding:8px 16px;font-size:13px;font-family:'DM Sans',sans-serif;cursor:pointer;
                        transition:background .2s;color:var(--text);"
                 onmouseover="this.style.background='var(--gray)'"
                 onmouseout="this.style.background='transparent'">{{ __('app.explorador.orden_az') }}</div>
            <div onclick="expSetSort('za', '{{ __('app.explorador.ordenar_za') }}')"
                 style="padding:8px 16px;font-size:13px;font-family:'DM Sans',sans-serif;cursor:pointer;
                        transition:background .2s;color:var(--text);"
                 onmouseover="this.style.background='var(--gray)'"
                 onmouseout="this.style.background='transparent'">{{ __('app.explorador.orden_za') }}</div>
        </div>
    </div>
</div>

<div class="exp-grid" id="expGrid"></div>

{{-- ══ JS del Explorador ══ --}}
<script>
    const dbCards = @json($busquedas ?? []);

    const fallbackCards = [
        {type:"{{ __('app.explorador.tipo_proyecto') }}",avClass:"av-blue",avLetter:"P",title:"{{ __('app.explorador.empty_proyecto1_titulo') }}",desc:"{{ __('app.explorador.empty_proyecto1_desc') }}",tags:["#FINANCE","#FISCAL","#STRATEGY"],cat:"proyecto"},
        {type:"{{ __('app.explorador.tipo_proyecto') }}",avClass:"av-green",avLetter:"P",title:"{{ __('app.explorador.empty_proyecto2_titulo') }}",desc:"{{ __('app.explorador.empty_proyecto2_desc') }}",tags:["#FINANCE","#LIFE","#STRATEGY"],cat:"proyecto"},
        {type:"{{ __('app.explorador.tipo_habilidad') }}",avClass:"av-orange",avLetter:"H",title:"{{ __('app.explorador.empty_habilidad_titulo') }}",desc:"{{ __('app.explorador.empty_habilidad_desc') }}",tags:["#PHP","#BACKEND"],cat:"habilidad",hasUsers:true},
        {type:"{{ __('app.explorador.tipo_documento') }}",avClass:"av-teal",avLetter:"D",title:"{{ __('app.explorador.empty_documento_titulo') }}",desc:"{{ __('app.explorador.empty_documento_desc') }}",tags:["#SECURITY","#PDF"],cat:"documento"},
    ];

    const expCards = dbCards.length > 0 ? dbCards.map(c => ({
        type: (c.tipo || '{{ __('app.explorador.tipo_sin_tipo') }}').toUpperCase(),
        avClass: c.avatar_class || 'av-blue',
        avLetter: c.avatar_letter || '?',
        title: c.titulo || '{{ __('app.explorador.sin_titulo') }}',
        desc: c.descripcion || '{{ __('app.explorador.sin_descripcion') }}',
        tags: Array.isArray(c.tags) ? c.tags : (typeof c.tags === 'string' ? JSON.parse(c.tags || '[]') : []),
        cat: c.tipo || 'otros',
        hasUsers: !!c.has_users
    })) : fallbackCards;

    const originalExpCards = [...expCards];
    let expActiveFilter = 'todos';

    const i18n = {
        sinResultados:     "{{ __('app.explorador.sin_resultados_titulo') }}",
        sinResultadosDesc: "{{ __('app.explorador.sin_resultados_desc') }}",
        resultado:         "{{ __('app.explorador.resultado') }}",
        resultados:        "{{ __('app.explorador.resultados') }}",
        encontrado:        "{{ __('app.explorador.encontrado') }}",
        encontrados:       "{{ __('app.explorador.encontrados') }}",
        busquedasRecientes:"{{ __('app.explorador.busquedas_recientes') }}",
        limpiar:           "{{ __('app.explorador.limpiar') }}",
        guardar:           "{{ __('app.explorador.tooltip_guardar') }}",
        descargar:         "{{ __('app.explorador.tooltip_descargar') }}",
    };

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
            countEl.textContent = "0 " + i18n.resultados;
            document.getElementById('expGrid').innerHTML = `
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--muted);">
                    <svg viewBox="0 0 24 24" style="width:48px;height:48px;margin-bottom:1rem;stroke:var(--gray3);fill:none;stroke-width:1.5;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <p style="font-weight:600;color:var(--text);">${i18n.sinResultados}</p>
                    <p style="font-size:13px;">${i18n.sinResultadosDesc}</p>
                </div>`;
            return;
        }
        const s = cards.length !== 1;
        countEl.textContent = `${cards.length} ${s ? i18n.resultados : i18n.resultado} ${s ? i18n.encontrados : i18n.encontrado}`;
        document.getElementById('expGrid').innerHTML = cards.map(c=>`
            <div class="exp-card">
                <div class="exp-card-type">${escapeHTML(c.type)}</div>
                <div class="exp-card-top"><div class="exp-avatar ${escapeHTML(c.avClass)}">${escapeHTML(c.avLetter)}</div><div class="exp-card-title">${expHL(c.title)}</div></div>
                <div class="exp-card-desc">${escapeHTML(c.desc)}</div>
                <div class="exp-card-actions">
                    <div class="exp-tags">${c.tags.map(t=>`<span class="exp-tag">${escapeHTML(t)}</span>`).join('')}</div>
                    <div class="exp-icons">
                        ${c.hasUsers?`<div style="display:flex;align-items:center"><div style="width:18px;height:18px;border-radius:50%;background:#1a56db;border:2px solid #fff"></div><div style="width:18px;height:18px;border-radius:50%;background:#059669;border:2px solid #fff;margin-left:-5px"></div></div>`:''}
                        <button class="exp-icon-btn" title="${i18n.guardar}"><svg viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg></button>
                        <button class="exp-icon-btn" title="${i18n.descargar}"><svg viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg></button>
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
                <span>${i18n.busquedasRecientes}</span>
                <span class="btn-clear-history" onclick="expClearHistory()">${i18n.limpiar}</span>
            </div>
            ${history.map((h, i) => `
                <div class="exp-history-item">
                    <div style="flex:1;display:flex;align-items:center;gap:10px;" onclick="expSelectHistory('${h.replace(/'/g, "\\'")}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>${escapeHTML(h)}</span>
                    </div>
                    <button class="btn-remove-history" onclick="event.stopPropagation();expRemoveHistoryItem(${i})" title="${i18n.limpiar}">
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