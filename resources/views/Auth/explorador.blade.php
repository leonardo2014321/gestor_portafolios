<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SansiFolios - Explorador</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy: #0f172a;
      --blue: #1a56db; --blue-dark: #1340b0; --blue-light: #3b82f6;
      --bg: #f0f2f5; --white: #ffffff; --border: #e2e5ea;
      --text-main: #111827; --text-muted: #6b7280; --text-light: #9ca3af;
      --tag-bg: #e8edf5; --tag-text: #374151; --radius: 10px; --shadow: 0 2px 8px rgba(0,0,0,.08);
    }
    body { font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--text-main); min-height:100vh; }

    /* navbar styles */
    .topbar { background:var(--navy);display:flex;align-items:center;justify-content:space-between;padding:0 28px;height:64px;border-bottom:1px solid rgba(255,255,255,0.06);position:sticky;top:0;z-index:50; }
    .tb-left { display:flex;align-items:center;gap:12px; }
    .tb-nav  { display:flex;align-items:center;gap:28px; }
    .tb-right{ display:flex;align-items:center;gap:10px; }
    .logo-img{ width:44px;height:44px;object-fit:contain;border-radius:8px;background:rgba(255,255,255,0.08);padding:2px; }
    .sysname { font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px; }
    .sysname span { color:#f87171; }
    .tb-bell { width:36px;height:36px;border-radius:9px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;cursor:pointer; }
    .tb-bell svg { width:16px;height:16px;fill:none;stroke:rgba(255,255,255,0.7);stroke-width:2;stroke-linecap:round; }
    .sb-av { border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-family:'DM Sans',sans-serif; }
    footer { height:40px;background:var(--navy);display:flex;align-items:center;justify-content:center; }
    .footer-content { display:flex;align-items:center;justify-content:center;gap:10px; }
    .footer-logo { height:20px;width:auto;object-fit:contain;display:block; }
    footer p { font-size:11.5px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0;font-family:'DM Sans',sans-serif; }
    footer b { color:#7a9cc0; }
    @media(max-width:768px){
      .topbar{padding:0 16px;height:auto;padding-top:10px;padding-bottom:10px;flex-wrap:wrap;gap:10px;}
      .tb-left{width:100%;justify-content:space-between;}
      .tb-right{width:100%;justify-content:flex-end;}
      .sysname{font-size:18px;} .tb-nav{display:none;}
    }
    @media(max-width:480px){ .sysname{display:none;} }

    /* explorador styles */
    .hero { background:linear-gradient(135deg,var(--blue-dark) 0%,var(--blue) 60%,var(--blue-light) 100%);padding:2rem 2.5rem 3.5rem;position:relative;overflow:hidden; }
    .hero::after { content:'';position:absolute;right:-60px;bottom:-80px;width:320px;height:320px;border-radius:50%;background:rgba(255,255,255,.06); }
    .hero-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:700;color:#fff;line-height:1.2; }
    .hero-sub { font-size:12px;color:rgba(255,255,255,.7);margin-top:4px; }
    .search-wrap { display:flex;align-items:center;gap:10px;margin-top:1.5rem;max-width:1080px; }
    .search-box { flex:1;display:flex;align-items:center;background:#fff;border-radius:var(--radius);padding:0 14px;height:44px;box-shadow:0 2px 12px rgba(0,0,0,.15); }
    .search-box svg { color:#9ca3af;flex-shrink:0; }
    .search-box input { flex:1;border:none;outline:none;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text-main);background:transparent;padding-left:10px; }
    .search-box input::placeholder { color:var(--text-light); }
    .btn-search { height:44px;padding:0 22px;background:var(--blue);color:#fff;border:none;border-radius:var(--radius);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:14px;cursor:pointer;transition:background .2s; }
    .btn-search:hover { background:var(--blue-dark); }
    .body-wrap { max-width:1100px;margin:0 auto;padding:0 2rem 3rem; }
    .filter-row { display:flex;align-items:center;gap:8px;margin-top:1.4rem; }
    .filter-btn { padding:7px 18px;border-radius:999px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;border:1.5px solid var(--border);cursor:pointer;transition:all .18s;background:var(--white);color:var(--text-muted); }
    .filter-btn:hover { border-color:var(--blue);color:var(--blue); }
    .filter-btn.active { background:var(--blue);color:#fff;border-color:var(--blue); }
    .results-bar { display:flex;align-items:center;justify-content:space-between;margin-top:1.4rem;margin-bottom:1rem; }
    .results-count { font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.04em; }
    .sort-btn { display:flex;align-items:center;gap:6px;font-size:13px;font-family:'DM Sans',sans-serif;color:var(--text-muted);background:none;border:none;cursor:pointer; }
    .cards-grid { display:grid;grid-template-columns:1fr 1fr;gap:1rem; }
    @media(max-width:680px){ .cards-grid { grid-template-columns:1fr; } }
    .card { background:var(--white);border-radius:14px;padding:18px;box-shadow:var(--shadow);border:1px solid var(--border);display:flex;flex-direction:column;gap:10px;position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s; }
    .card:hover { box-shadow:0 6px 20px rgba(26,86,219,.12);transform:translateY(-2px); }
    .card::after { content:'';position:absolute;right:0;bottom:0;width:90px;height:60px;background:linear-gradient(135deg,transparent 50%,rgba(26,86,219,.06) 50%);border-top-left-radius:60px; }
    .card-type { font-size:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--blue); }
    .card-top { display:flex;align-items:flex-start;gap:10px; }
    .card-avatar { width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:#fff;flex-shrink:0; }
    .av-blue{background:#1a56db;} .av-green{background:#059669;} .av-orange{background:#d97706;} .av-teal{background:#0891b2;}
    .card-title { font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text-main);line-height:1.3; }
    .card-title mark { background:rgba(26,86,219,.13);color:var(--blue);border-radius:3px;padding:0 1px; }
    .card-desc { font-size:12px;color:var(--text-muted);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
    .card-actions { display:flex;align-items:center;justify-content:space-between; }
    .tags { display:flex;flex-wrap:wrap;gap:5px; }
    .tag { padding:3px 9px;border-radius:999px;font-size:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;background:var(--tag-bg);color:var(--tag-text); }
    .card-icons { display:flex;align-items:center;gap:8px; }
    .icon-btn { width:28px;height:28px;border-radius:8px;border:1px solid var(--border);background:var(--white);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-muted);transition:all .15s; }
    .icon-btn:hover { border-color:var(--blue);color:var(--blue); }
    .icon-btn svg { width:14px;height:14px; }
    .user-stack { display:flex;align-items:center; }
    .user-dot { width:20px;height:20px;border-radius:50%;border:2px solid #fff;margin-left:-6px; }
    .user-dot:first-child { margin-left:0; }
    .trend-icon { position:absolute;right:14px;bottom:12px;opacity:.15; }
    .trend-icon svg { width:38px;height:26px; }
  </style>
</head>
<body>

    @include('components.layout.navbar')

    <div class="hero">
        <div class="hero-title">Sistema de<br>Portafolios</div>
        <div class="hero-sub">Gestión Institucional de Activos Digitales · UMSS</div>
        <div class="search-wrap">
            <div class="search-box">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Buscar..." oninput="filterCards()" />
            </div>
            <button class="btn-search" onclick="filterCards()">Buscar</button>
        </div>
    </div>

    <div class="body-wrap">
        <div class="filter-row">
            <button class="filter-btn active" onclick="setFilter(this,'todos')">Todos</button>
            <button class="filter-btn" onclick="setFilter(this,'proyecto')">Proyectos</button>
            <button class="filter-btn" onclick="setFilter(this,'documento')">Documentos</button>
            <button class="filter-btn" onclick="setFilter(this,'habilidad')">Habilidades</button>
        </div>
        <div class="results-bar">
            <span class="results-count" id="results-count">0 Resultados</span>
            @if(count($busquedas) > 0)
                <span style="background:#dcfce7;color:#166534;padding:2px 10px;border-radius:5px;font-size:11px;font-weight:bold;">
                    DIFUSION: BASE DE DATOS ACTIVA
                </span>
            @endif
            <button class="sort-btn">
                Ordenar por relevancia
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>
        <div class="cards-grid" id="cards-grid"></div>
    </div>

    @include('components.layout.footer')

    @guest
        @include('Auth.login')
        @include('Auth.registro')
        @include('Auth.recuperar')
        <script>
            const modal = document.getElementById('loginModal');
            const toggleModal = () => { if(!modal) return; modal.classList.toggle('hidden'); document.body.classList.toggle('overflow-hidden'); };
            ['openLoginModal','openLoginModalMobile'].forEach(id => { const b=document.getElementById(id); if(b) b.addEventListener('click',toggleModal); });
            const closeBtn = document.getElementById('closeModal');
            if(closeBtn) closeBtn.addEventListener('click', toggleModal);
            if(modal) modal.addEventListener('click', e => { if(e.target===modal) toggleModal(); });
            const registerModal = document.getElementById('registerModal');
            const toggleRegister = () => { if(!registerModal) return; registerModal.classList.toggle('hidden'); document.body.classList.toggle('overflow-hidden'); };
            ['openRegisterModal','openRegisterModalMobile'].forEach(id => { const b=document.getElementById(id); if(b) b.addEventListener('click',toggleRegister); });
            if(registerModal) registerModal.addEventListener('click', e => { if(e.target===registerModal) toggleRegister(); });
            document.addEventListener('keydown', e => {
                if(e.key==='Escape'){
                    if(modal && !modal.classList.contains('hidden')) toggleModal();
                    if(registerModal && !registerModal.classList.contains('hidden')) toggleRegister();
                }
            });
        </script>
    @endguest

    <script>
        const dbCards = @json($busquedas);
        const exampleCards = [
            { type:"PROYECTO", avatarClass:"av-blue", avatarLetter:"P", title:"Programa de Optimización Fiscal 2024", desc:"Iniciativa estratégica para la mejora de flujos de caja institucionales.", tags:["#FINANCE","#FISCAL","#STRATEGY"], category:"proyecto" },
            { type:"PROYECTO", avatarClass:"av-green", avatarLetter:"P", title:"Programa de Desarrollo Ambiental 2020", desc:"Iniciativa estratégica para la mejora del desarrollo ambiental.", tags:["#FINANCE","#LIFE","#STRATEGY"], category:"proyecto" },
            { type:"HABILIDAD", avatarClass:"av-orange", avatarLetter:"H", title:"Programación en PHP / Symfony", desc:"Capacidad funcional en el desarrollo de frameworks para diseño y sistemas.", tags:["#PHP","#BACKEND"], category:"habilidad", hasUsers:true },
            { type:"DOCUMENTO", avatarClass:"av-teal", avatarLetter:"D", title:"Protocolos de Seguridad Interna V2", desc:"Documentación técnica sobre buenas prácticas en encriptación.", tags:["#SECURITY","#PDF"], category:"documento" },
        ];
        const allCards = dbCards.length > 0 ? dbCards.map(c => ({
            type:(c.tipo||'S/T').toUpperCase(), avatarClass:c.avatar_class||'av-blue', avatarLetter:c.avatar_letter||'?',
            title:c.titulo||'Sin título', desc:c.descripcion||'Sin descripción',
            tags:Array.isArray(c.tags)?c.tags:(typeof c.tags==='string'?JSON.parse(c.tags):[]),
            category:c.tipo||'otros', hasUsers:!!c.has_users
        })) : exampleCards;

        let activeFilter = 'todos';

        function highlight(text) {
            const q = document.getElementById('searchInput').value.trim();
            if (!q) return text;
            const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`,'gi');
            return text.replace(re,'<mark>$1</mark>');
        }

        function renderCards(cards) {
            document.getElementById('results-count').textContent = `${cards.length} Resultado${cards.length!==1?'s':''} Encontrado${cards.length!==1?'s':''}`;
            document.getElementById('cards-grid').innerHTML = cards.map(c => `
                <div class="card">
                    <div class="card-type">${c.type}</div>
                    <div class="card-top">
                        <div class="card-avatar ${c.avatarClass}">${c.avatarLetter}</div>
                        <div class="card-title">${highlight(c.title)}</div>
                    </div>
                    <div class="card-desc">${c.desc}</div>
                    <div class="card-actions">
                        <div class="tags">${c.tags.map(t=>`<span class="tag">${t}</span>`).join('')}</div>
                        <div class="card-icons">
                            ${c.hasUsers?`<div class="user-stack"><div class="user-dot" style="background:#1a56db"></div><div class="user-dot" style="background:#059669"></div></div>`:''}
                            <button class="icon-btn"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg></button>
                            <button class="icon-btn"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg></button>
                        </div>
                    </div>
                    <div class="trend-icon"><svg viewBox="0 0 38 26" fill="none" stroke="#1a56db" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,20 10,12 16,16 26,6 36,10"/></svg></div>
                </div>`).join('');
        }

        function filterCards() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            renderCards(allCards.filter(c => (c.title.toLowerCase().includes(q)||c.desc.toLowerCase().includes(q)) && (activeFilter==='todos'||c.category===activeFilter)));
        }

        function setFilter(btn, cat) {
            activeFilter = cat;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterCards();
        }

        renderCards(allCards);
    </script>
</body>
</html>