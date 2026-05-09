<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - SansiFolios</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
          --navy:#0f172a;
          --navy2:#1e2d50;
          --admin-purple:#6366f1;
          --admin-purple-dark:#4f46e5;
          --teal:#0d9488;
          --rose:#e11d48;
          --white:#fff;
          --gray:#f8fafc;
          --gray2:#e2e8f0;
          --gray3:#cbd5e1;
          --text:#0f172a;
          --muted:#64748b;
          --sw:240px;
          --hh:70px;
        }
        html,body{height:100%;font-family:"DM Sans",sans-serif;background:var(--gray);color:var(--text);overflow:hidden}
        .app{display:flex;flex-direction:column;height:100vh}

        /* ── Topbar ── */
        .topbar{height:var(--hh);background:var(--navy);display:flex;align-items:center;justify-content:space-between;padding:0 28px;flex-shrink:0;border-bottom:1px solid rgba(255,255,255,0.06);}
        .tb-left{display:flex;align-items:center;gap:16px}
        .logo-img{width:40px;height:40px;object-fit:contain;border-radius:10px;background:var(--admin-purple);padding:4px}
        .sysname{font-family:"Plus Jakarta Sans",sans-serif;font-size:20px;font-weight:800;color:#fff;letter-spacing:-0.5px}
        .sysname span{color:#f87171}
        .tb-nav{display:flex;align-items:center;gap:28px}
        .badge-admin{background: rgba(255,255,255,0.1); color: #fff; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; border: 1px solid rgba(255,255,255,0.2);}
        
        .tb-right{display:flex;align-items:center;gap:16px}
        .tb-search{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:8px 16px;height:40px;transition: all 0.2s;}
        .tb-search:focus-within {border-color: rgba(255,255,255,0.3); box-shadow: 0 0 0 3px rgba(255,255,255,0.05);}
        .tb-search svg{width:16px;height:16px;fill:none;stroke:rgba(255,255,255,0.5);stroke-width:2;flex-shrink:0}
        .tb-search input{border:none;outline:none;background:transparent;font-family:"DM Sans",sans-serif;font-size:13.5px;color:#fff;width:180px}
        .tb-search input::placeholder{color:rgba(255,255,255,0.4)}
        .tb-bell{width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative; transition: all 0.2s;}
        .tb-bell:hover {background: rgba(255,255,255,0.16); transform: translateY(-1px);}
        .tb-bell::after{content:'';position:absolute;top:10px;right:10px;width:8px;height:8px;background:var(--rose);border-radius:50%; border: 2px solid var(--navy);}
        .tb-bell svg{width:18px;height:18px;fill:none;stroke:rgba(255,255,255,0.7);stroke-width:2;stroke-linecap:round}

        /* ── Body ── */
        .body-row{flex:1;display:flex;overflow:hidden}

        /* ── Sidebar ── */
        aside{width:var(--sw);background:var(--navy);flex-shrink:0;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,0.06)}
        .sb-top{padding:20px 0;flex:1; overflow-y: auto;}
        .sb-label {font-size: 11px; font-weight: 700; color: #8ba5c8; text-transform: uppercase; letter-spacing: 1px; padding: 0 24px; margin-bottom: 12px; margin-top: 10px;}
        .sb-item{display:flex;align-items:center;gap:14px;padding:12px 24px;cursor:pointer;color:#8ba5c8;font-size:13.5px;font-weight:500;transition:all .2s;border-left:3px solid transparent;font-family:"DM Sans",sans-serif;text-decoration:none;background:none;border-top:none;border-right:none;border-bottom:none;width:100%; text-align: left;}
        .sb-item:hover{background:rgba(255,255,255,0.05);color:#c8d8ef;}
        .sb-item.active{background:rgba(37,99,235,0.18);color:#fff;border-left-color:#3b82f6;font-weight:600;}
        .sb-item svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:1.8;flex-shrink:0;stroke-linecap:round;stroke-linejoin:round}
        .sb-div{height:1px;background:rgba(255,255,255,0.06);margin:12px 24px}
        
        .sb-user-block{padding:16px 24px;display:flex;align-items:center;gap:12px;border-top:1px solid rgba(255,255,255,0.07);background:rgba(255,255,255,0.03)}
        .sb-av{width:40px;height:40px;border-radius:12px;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff; box-shadow: 0 4px 10px rgba(59,130,246,0.3);}
        .sb-uname{font-size:14px;color:#fff;font-weight:700}
        .sb-uid{font-size:12px;color:#5a7fa0}

        /* ── Main ── */
        main{flex:1;display:grid;grid-template-columns:1fr 320px;overflow:hidden;background:var(--gray);position:relative;}
        .main-inner{padding:2rem 2.5rem; overflow-y:auto; width: 100%; max-width: 1400px; margin: 0 auto;}

        /* ── Hero Admin ── */
        .admin-hero{background:linear-gradient(135deg, #1e1b4b 0%, var(--admin-purple-dark) 100%);padding:2rem 2.5rem;border-radius:20px;margin-bottom:2rem;position:relative;overflow:hidden; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15); display: flex; justify-content: space-between; align-items: center;}
        .admin-hero::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1" fill="rgba(255,255,255,0.05)"/></svg>');}
        .admin-hero::after{content:'';position:absolute;right:-50px;bottom:-80px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1);}
        
        .hero-content {position: relative; z-index: 1;}
        .hero-title{font-family:"Plus Jakarta Sans",sans-serif;font-size:28px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:8px;}
        .hero-sub{font-size:14px;color:rgba(255,255,255,.8); font-weight: 500;}
        
        .hero-actions {position: relative; z-index: 1; display: flex; gap: 12px;}
        .btn-primary {background: #fff; color: var(--admin-purple-dark); padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13.5px; border: none; cursor: pointer; transition: all 0.2s; font-family:"DM Sans",sans-serif; display: flex; align-items: center; gap: 8px;}
        .btn-primary:hover {transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,255,255,0.2);}
        .btn-outline {background: rgba(255,255,255,0.1); color: #fff; padding: 10px 20px; border-radius: 10px; font-weight: 600; font-size: 13.5px; border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: all 0.2s; font-family:"DM Sans",sans-serif;}
        .btn-outline:hover {background: rgba(255,255,255,0.2);}

        /* ── Stats ── */
        .stats-grid{display:grid;grid-template-columns:repeat(4, 1fr);gap:1.2rem;margin-bottom:2rem}
        .stat-card{background:#fff;border-radius:16px;padding:1.5rem; border:1px solid var(--gray2); box-shadow:0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: flex-start; justify-content: space-between; transition: all 0.2s;}
        .stat-card:hover {transform: translateY(-3px); box-shadow:0 8px 20px rgba(0,0,0,0.05); border-color: var(--gray3);}
        .stat-info {display: flex; flex-direction: column; gap: 6px;}
        .stat-label {font-size: 12.5px; font-weight: 600; color: var(--muted);}
        .stat-val {font-family: "Plus Jakarta Sans", sans-serif; font-size: 28px; font-weight: 800; color: var(--text); line-height: 1;}
        .stat-trend {display: flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600;}
        .trend-up {color: #10b981;}
        .trend-down {color: #ef4444;}
        
        .stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .icon-purple {background: rgba(99, 102, 241, 0.1); color: var(--admin-purple);}
        .icon-teal {background: rgba(13, 148, 136, 0.1); color: var(--teal);}
        .icon-blue {background: rgba(37, 99, 235, 0.1); color: #2563eb;}
        .icon-rose {background: rgba(225, 29, 72, 0.1); color: var(--rose);}
        .stat-icon svg{width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        /* ── Content Grid ── */
        .dash-grid{display:grid;grid-template-columns: 1fr;gap:1.5rem;}

        /* Panel/Table */
        .panel {background: #fff; border-radius: 16px; border: 1px solid var(--gray2); box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow: hidden;}
        .panel-header {padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--gray2); display: flex; justify-content: space-between; align-items: center;}
        .panel-title {font-family: "Plus Jakarta Sans", sans-serif; font-size: 16px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px;}
        .panel-action {font-size: 13px; font-weight: 600; color: var(--admin-purple); text-decoration: none;}
        .panel-action:hover {text-decoration: underline;}

        .table-wrap {width: 100%; overflow-x: auto;}
        table {width: 100%; border-collapse: collapse; text-align: left;}
        th {padding: 12px 1.5rem; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; background: var(--gray); border-bottom: 1px solid var(--gray2);}
        td {padding: 14px 1.5rem; font-size: 13.5px; color: var(--text); border-bottom: 1px solid var(--gray2); vertical-align: middle;}
        tr:last-child td {border-bottom: none;}
        tr:hover td {background: var(--gray);}
        
        .user-cell {display: flex; align-items: center; gap: 12px;}
        .u-avatar {width: 32px; height: 32px; border-radius: 8px; background: var(--gray2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; color: var(--navy);}
        .u-info {display: flex; flex-direction: column;}
        .u-name {font-weight: 600; color: var(--text);}
        .u-email {font-size: 11.5px; color: var(--muted);}

        .status-badge {display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase;}
        .st-active {background: rgba(16, 185, 129, 0.1); color: #059669;}
        .st-pending {background: rgba(245, 158, 11, 0.1); color: #d97706;}
        .st-inactive {background: rgba(239, 68, 68, 0.1); color: #ef4444;}
        
        .action-btn {width: 28px; height: 28px; border-radius: 6px; border: 1px solid var(--gray2); background: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; color: var(--muted); transition: all 0.2s;}
        .action-btn:hover {border-color: var(--admin-purple); color: var(--admin-purple);}
        .action-btn svg {width: 14px; height: 14px; stroke-width: 2;}

        /* Action Menu & Switches */
        .switch {position: relative; display: inline-block; width: 34px; height: 20px;}
        .switch input {opacity: 0; width: 0; height: 0;}
        .slider {position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--gray2); transition: .4s; border-radius: 34px;}
        .slider:before {position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);}
        input:checked + .slider {background-color: var(--admin-purple);}
        input:checked + .slider:before {transform: translateX(14px);}
        
        .action-dropdown-container {position: relative; display: inline-block;}
        .action-menu {display: none; position: absolute; right: 0; top: 100%; margin-top: 5px; background: #fff; border: 1px solid var(--gray2); border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 200px; z-index: 100; padding: 12px; flex-direction: column; gap: 12px;}
        .action-menu.menu-up {top: auto; bottom: 100%; margin-top: 0; margin-bottom: 5px;}

        @media(max-width: 768px) {
            .action-menu {
                position: fixed;
                top: auto !important;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                border-radius: 20px 20px 0 0;
                box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
                z-index: 9999;
                padding: 24px;
                border-bottom: none;
            }
        }

        .mobile-menu-btn { display: none; background: none; border: none; color: #fff; cursor: pointer; padding: 4px; margin-right: 8px; }
        .mobile-menu-btn svg { width: 24px; height: 24px; }
        .sidebar-overlay { position: fixed; top: var(--hh); left: 0; width: 100%; height: calc(100vh - var(--hh)); background: rgba(0,0,0,0.4); z-index: 999; opacity: 0; visibility: hidden; transition: all 0.3s ease; }
        .sidebar-overlay.show { opacity: 1; visibility: visible; }
        
        @media(max-width: 1200px) {
            main { grid-template-columns: 1fr; overflow-y: auto; }
            .main-inner { overflow-y: visible; padding: 1.5rem; height: max-content; }
            .rpanel { border-left: none; border-top: 1px solid var(--gray2); overflow-y: visible; height: max-content; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media(max-width: 768px) {
            .mobile-menu-btn { display: block; }
            .tb-left { gap: 8px; }
            .sysname { display: none; }
            .tb-search input { width: 120px; }
            aside {
                position: fixed;
                top: var(--hh);
                left: -260px;
                width: 260px;
                height: calc(100vh - var(--hh));
                z-index: 1000;
                transition: left 0.3s ease;
                box-shadow: 4px 0 15px rgba(0,0,0,0.3);
            }
            aside.open { left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
            .main-inner { padding: 1rem; }
            .topbar { padding: 0 16px; }
            .admin-hero { padding: 1.5rem; }
            .hero-title { font-size: 24px; }
            .panel-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .sb-uname, .sb-uid { display: none; }
        }

        /* Activity List */
        .activity-list {padding: 0;}
        .act-item {display: flex; align-items: flex-start; gap: 14px; padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--gray2); transition: background 0.2s; cursor: pointer;}
        .act-item:hover {background: var(--gray);}
        .act-item:last-child {border-bottom: none;}
        .act-icon {width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;}
        .act-icon svg {width: 16px; height: 16px; stroke-width: 2;}
        .act-content {flex: 1;}
        .act-title {font-size: 13.5px; font-weight: 600; color: var(--text); line-height: 1.4;}
        .act-title span {font-weight: 400; color: var(--muted);}
        .act-time {font-size: 11px; font-weight: 600; color: var(--muted); margin-top: 4px;}

        /* ── Right panel ── */
        .rpanel{width:100%;background:#fff;border-left:1px solid var(--gray2);display:flex;flex-direction:column;overflow-y:auto}
        .rp-sec{padding:.9rem 1rem;border-bottom:1px solid var(--gray2)}
        .cal-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
        .cal-month{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;color:var(--text)}
        .cal-navs{display:flex;gap:2px}
        .cal-nav{width:24px;height:24px;border-radius:6px;background:var(--gray);border:none;cursor:pointer;color:var(--muted);font-size:16px;display:flex;align-items:center;justify-content:center;transition:background .15s}
        .cal-nav:hover{background:var(--gray2)}
        .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:1px}
        .cdn{font-size:9.5px;color:var(--muted);text-align:center;padding:3px 0;font-weight:700}
        .cd{font-size:11.5px;text-align:center;padding:4px 2px;border-radius:6px;cursor:pointer;transition:background .15s;color:var(--text);position:relative;}
        .cd:hover{background:var(--gray)}
        .cd.today{background:var(--admin-purple);color:#fff;font-weight:700}
        .cd.other{color:var(--gray3)}
        .cd.ev::after{content:"";position:absolute;bottom:1px;left:50%;transform:translateX(-50%);width:4px;height:4px;border-radius:50%;background:var(--teal)}
        .cal-view-selector{margin-left:auto;margin-right:10px;padding:3px 6px;border-radius:6px;border:1px solid var(--gray2);background:#fff;font-size:11px;font-family:"DM Sans",sans-serif;color:var(--text);outline:none;cursor:pointer;}
        .cd.holiday{color:#ef4444;font-weight:700;}
        .cd.holiday::before{content:'';position:absolute;top:2px;right:2px;width:4px;height:4px;border-radius:50%;background:#ef4444;}
        .cal-grid-meses{display:grid;grid-template-columns:repeat(3,1fr);gap:6px;margin-top:10px;padding:0 5px;}
        .cal-grid-anios{display:grid;grid-template-columns:repeat(4,1fr);gap:4px;margin-top:10px;}
        .cm-btn{font-size:12px;padding:12px 0;text-align:center;border-radius:8px;cursor:pointer;background:var(--gray);transition:all .15s;color:var(--text);font-weight:600;}
        .cm-btn:hover{background:var(--gray2);color:var(--admin-purple);}
        .cm-btn.current{background:var(--admin-purple);color:#fff;}
        .cm-btn.other{opacity:0.5;}
        .row-week{display:contents;}
        .row-week:hover > .cd{background:rgba(99, 102, 241, 0.1);color:var(--admin-purple);}

        /* ══ Vista Usuarios ══ */
        .user-cell{display:flex;align-items:center;gap:10px}
        .u-avatar{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,var(--admin-purple),#818cf8);color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .u-info{display:flex;flex-direction:column;gap:2px}
        .u-name{font-size:13px;font-weight:600;color:var(--text)}
        .u-email{font-size:11.5px;color:var(--muted)}
        .icon-rose{background:linear-gradient(135deg,#fce7f3,#fbcfe8);color:#be185d}
        .st-pending{background:#fef9c3;color:#854d0e;border:1px solid #fde68a}
    </style>
</head>
<body>
<div class="app">

    <!-- Topbar -->
    <div class="topbar">
        <div class="tb-left">
            <button id="mobile-menu-btn" class="mobile-menu-btn" onclick="toggleSidebar()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
            <img class="logo-img" src="{{ asset('images/logo.png') }}" alt="UMSS" style="height: 32px; width: auto; object-fit: contain;">
            <div class="sysname">Sansi<span>Folios</span></div>
        </div>
        <div class="tb-right">

            <div class="tb-bell">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            
            <div style="position:relative;">
                <div style="display:flex;align-items:center;gap:12px;border-left:1px solid rgba(255,255,255,0.1);padding-left:16px;cursor:pointer;" onclick="document.getElementById('admin-dropdown').style.display = document.getElementById('admin-dropdown').style.display === 'block' ? 'none' : 'block'">
                    <div class="sb-av" style="width:36px;height:36px;border-radius:10px;">A</div>
                    <div style="display:flex;flex-direction:column;">
                        <div style="font-size:13px;color:#fff;font-weight:600;">Administrador</div>
                        <div style="font-size:11px;color:#8ba5c8;">admin@umss.edu.bo</div>
                    </div>
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
                
                <div id="admin-dropdown" style="display:none;position:absolute;top:100%;right:0;margin-top:10px;background:#fff;border:1px solid var(--gray2);border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.1);width:180px;overflow:hidden;z-index:100;">
                    <form method="POST" action="{{ route('logout') }}" id="formLogoutAdmin">
                        @csrf
                        <button type="button" onclick="abrirLogoutAdmin()" style="width:100%;padding:12px 16px;font-size:13px;font-weight:600;color:var(--rose);background:transparent;border:none;text-align:left;display:flex;align-items:center;gap:8px;cursor:pointer;transition:background 0.2s;font-family:'DM Sans',sans-serif;" onmouseover="this.style.background='var(--gray)'" onmouseout="this.style.background='transparent'">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>

                <!-- Modal confirmación logout -->
                <div id="modal-logout-confirm" onclick="if(event.target===this)cerrarLogoutAdmin()" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
                    <div style="background:#fff;border-radius:24px;padding:2.2rem 2rem 1.8rem;width:370px;max-width:92vw;box-shadow:0 24px 64px rgba(0,0,0,0.22);text-align:center;animation:fadeInScale .2s ease;">
                        <style>@keyframes fadeInScale{from{opacity:0;transform:scale(.92)}to{opacity:1;transform:scale(1)}}</style>
                        <div style="width:60px;height:60px;border-radius:18px;background:#eff2ff;display:flex;align-items:center;justify-content:center;margin:0 auto 1.3rem;">
                            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="#1428c6ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        </div>
                        <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:#0f172a;margin-bottom:8px;">¿Cerrar sesión?</h3>
                        <p style="font-size:13.5px;color:#64748b;line-height:1.65;margin-bottom:1.8rem;">Serás redirigido a la página de inicio.<br>Podrás volver a ingresar cuando quieras.</p>
                        <div style="display:flex;gap:10px;">
                            <button onclick="cerrarLogoutAdmin()" style="flex:1;padding:12px;border-radius:14px;border:2px solid #e2e8f0;background:#fff;font-size:13.5px;font-weight:600;color:#64748b;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">Cancelar</button>
                            <button onclick="document.getElementById('formLogoutAdmin').submit()" style="flex:1;padding:12px;border-radius:14px;border:none;background:linear-gradient(135deg,#1428c6,#1e3adb);color:#fff;font-size:13.5px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;box-shadow:0 4px 14px rgba(20,40,198,0.4);transition:all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Sí, salir</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="body-row">
        <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
        <!-- Sidebar -->
        <aside>
            <div class="sb-top">
                <div class="sb-label">General</div>
                <button id="btn-dashboard" class="sb-item active" onclick="mostrarVista('dashboard')">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Menu Principal</span>
                </button>
                <button id="btn-usuarios" class="sb-item" onclick="mostrarVista('usuarios')">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Usuarios</span>
                </button>
                <button id="btn-portafolios" class="sb-item" onclick="mostrarVista('portafolios')">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span>Portafolios</span>
                </button>
                <button class="nav-item" onclick="showAdminView('notificaciones')">
                 <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                  <span>Notificaciones</span>
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
                        <h1 class="hero-title">Panel de Control</h1>
                        <p class="hero-sub">Visión general del rendimiento y actividad de la plataforma.</p>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Usuarios Totales</div>
                            <div class="stat-val">{{ number_format($stats['total_usuarios']) }}</div>
                            <div class="stat-trend trend-up">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                {{ $stats['usuarios_activos'] }} activos
                            </div>
                        </div>
                        <div class="stat-icon icon-purple">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Portafolios Registrados</div>
                            <div class="stat-val">{{ number_format($portafolios_stats['total']) }}</div>
                            <div class="stat-trend trend-up">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                {{ $portafolios_stats['con_usuarios'] }} con vinculación
                            </div>
                        </div>
                        <div class="stat-icon icon-blue">
                            <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Documentos Subidos</div>
                            <div class="stat-val">4,302</div>
                            <div class="stat-trend trend-up">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                +18% vs mes anterior
                            </div>
                        </div>
                        <div class="stat-icon icon-teal">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Administradores</div>
                            <div class="stat-val">{{ $stats['total_admins'] }}</div>
                            <div class="stat-trend trend-down">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                                Personal de gestión
                            </div>
                        </div>
                        <div class="stat-icon icon-rose">
                            <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Main Grid -->
                <div class="dash-grid">
                    
                    <!-- Últimos Usuarios -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title">Usuarios Recientes</h2>
                            <a href="#" class="panel-action">Ver todos</a>
                        </div>
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Rol</th>
                                        <th>Fecha Registro</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
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
                                        <td id="role-{{ $usuario->id }}">{{ $usuario->es_admin ? 'Administrador' : 'Usuario' }}</td>
                                        <td>{{ $usuario->created_at->diffForHumans() }}</td>
                                        <td>
                                            <span class="status-badge {{ $usuario->activo ? 'st-active' : 'st-inactive' }}" id="status-{{ $usuario->id }}">
                                                {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-dropdown-container">
                                                <button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                                                <div class="action-menu">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Estado</span>
                                                        <label class="switch">
                                                            <input type="checkbox" {{ $usuario->activo ? 'checked' : '' }} onchange="toggleStatus(this, 'status-{{ $usuario->id }}')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                    <div style="height: 1px; background: var(--gray2);"></div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Rol Admin</span>
                                                        <label class="switch">
                                                            <input type="checkbox" {{ $usuario->es_admin ? 'checked' : '' }} onchange="toggleRole(this, 'role-{{ $usuario->id }}')">
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

                </div>
                </div><!-- /view-dashboard -->

                @include('usuarios_admin')

                @include('portafolios_admin')

            </div>

        <!-- Right panel (Calendario) -->
        <div class="rpanel">
            <div class="rp-sec">
                <div class="cal-hd" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                    <div class="cal-month" id="cal-title" style="flex:1;">Mes</div>
                    <select class="cal-view-selector" id="cal-view-sel" onchange="changeCalView(this.value)" style="margin:0;">
                        <option value="dias">Días</option>
                        <option value="semanas">Semanas</option>
                        <option value="meses">Meses</option>
                        <option value="anios">Años</option>
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
                    <div class="panel-header" style="padding: 1rem;">
                        <h2 class="panel-title">Actividad Reciente</h2>
                    </div>
                    <div class="activity-list">
                        @forelse($actividades_recientes as $act)
                            @php
                                $titulo = "Acción: " . $act->accion;
                                $iconClass = "icon-purple";
                                $svg = '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'; // User icon default

                                switch($act->accion) {
                                    case 'login':
                                        $titulo = "Sesión iniciada";
                                        $iconClass = "icon-teal";
                                        $svg = '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>';
                                        break;
                                    case 'logout':
                                        $titulo = "Sesión cerrada";
                                        $iconClass = "icon-rose";
                                        $svg = '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>';
                                        break;
                                    case 'registro_usuario':
                                        $titulo = "Nuevo registro";
                                        $iconClass = "icon-purple";
                                        $svg = '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>';
                                        break;
                                    case 'PASSWORD_ACTUALIZADO':
                                        $titulo = "Contraseña cambiada";
                                        $iconClass = "icon-teal";
                                        $svg = '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>';
                                        break;
                                    case 'SOLICITAR_RECUPERACION':
                                        $titulo = "Recuperación solicitada";
                                        $iconClass = "icon-blue";
                                        $svg = '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>';
                                        break;
                                    case 'reactivacion_cuenta':
                                        $titulo = "Cuenta reactivada";
                                        $iconClass = "icon-teal";
                                        $svg = '<path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>';
                                        break;
                                    case 'SOLICITUD_REGISTRO':
                                        $titulo = "Nueva solicitud registro";
                                        $iconClass = "icon-purple";
                                        $svg = '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>';
                                        break;
                                    case 'RECUPERACION_EMAIL_NO_EXISTE':
                                        $titulo = "Error: Email no existe";
                                        $iconClass = "icon-rose";
                                        $svg = '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>';
                                        break;
                                    case 'TOKEN_INVALIDO':
                                        $titulo = "Error: Token inválido";
                                        $iconClass = "icon-rose";
                                        $svg = '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
                                        break;
                                    case 'ERROR_RECUPERACION':
                                        $titulo = "Falla en recuperación";
                                        $iconClass = "icon-rose";
                                        $svg = '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>';
                                        break;
                                    case 'PERFIL_ACTUALIZADO':
                                        $titulo = "Perfil actualizado";
                                        $iconClass = "icon-blue";
                                        $svg = '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>';
                                        break;
                                    case 'CUENTA_DESACTIVADA':
                                        $titulo = "Cuenta desactivada";
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
                                        <span>{{ $act->usuario ? $act->usuario->nombre . ' ' . $act->usuario->apellido : 'Sistema/Invitado' }}</span>
                                    </div>
                                    <div class="act-time" style="font-size: 10px;">{{ $act->created_at ? $act->created_at->diffForHumans() : 'Recientemente' }}</div>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 2rem; text-align: center; color: var(--muted); font-size: 13px;">
                                No hay actividad reciente registrada.
                            </div>
                        @endforelse
                        
                        <a href="#" style="display: block; text-align: center; padding: 1rem; font-size: 12px; font-weight: 600; color: var(--admin-purple); text-decoration: none; border-top: 1px solid var(--gray2);">Ver todo el registro</a>
                    </div>
                </div>
            </div>

        </div>
        </main>

    </div>
</div>

<script>
    function abrirLogoutAdmin() {
        document.getElementById('modal-logout-confirm').style.display = 'flex';
        document.getElementById('admin-dropdown').style.display = 'none';
    }
    function cerrarLogoutAdmin() {
        document.getElementById('modal-logout-confirm').style.display = 'none';
    }

    /* ══ Navegación entre vistas ══ */
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

    // Cerrar dropdown de administrador al hacer clic fuera
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

    function toggleStatus(checkbox, statusId) {
        const badge = document.getElementById(statusId);
        if (checkbox.checked) {
            badge.className = 'status-badge st-active';
            badge.innerText = 'Activo';
        } else {
            badge.className = 'status-badge st-inactive';
            badge.innerText = 'Inactivo';
        }
    }

    function toggleRole(checkbox, roleId, originalRole = 'Usuario') {
        const roleCell = document.getElementById(roleId);
        if (checkbox.checked) {
            roleCell.innerText = 'Administrador';
        } else {
            roleCell.innerText = originalRole;
        }
    }

    /* ══ Calendario ══ */
    let cur = new Date();
    let currentCalView = 'dias';
    let eventos = JSON.parse(localStorage.getItem('eventos') || '{}');
    
    // Feriados y Fechas Cívicas de Bolivia (Formato: DD-MM)
    const boliviaHolidays = {
        "01-01": "Año Nuevo", "22-01": "Día del Estado Plurinacional", "19-03": "Día del Padre",
        "12-04": "Día del Niño", "01-05": "Día del Trabajo", "27-05": "Día de la Madre",
        "21-06": "Año Nuevo Aymara", "06-08": "Día de la Independencia", "17-08": "Día de la Bandera",
        "21-09": "Día de la Primavera", "11-10": "Día de la Mujer Boliviana", "02-11": "Día de los Difuntos",
        "25-12": "Navidad"
    };

    function keyFecha(d,m,y){ return `${y}-${m}-${d}`; }

    function changeCalView(view) {
        currentCalView = view;
        renderCal();
    }

    function renderCal() {
        const y = cur.getFullYear(), m = cur.getMonth();
        const months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        const gridContainer = document.getElementById("cal-grid-container");
        
        if (currentCalView === 'dias' || currentCalView === 'semanas') {
            document.getElementById("cal-title").textContent = months[m] + " " + y;
            let html = `<div class="cal-grid" id="cal-grid">
                <div class="cdn">Do</div><div class="cdn">Lu</div><div class="cdn">Ma</div>
                <div class="cdn">Mi</div><div class="cdn">Ju</div><div class="cdn">Vi</div><div class="cdn">Sá</div>`;
            
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
                
                // Verificar feriados
                const monthStr = (m + 1).toString().padStart(2, '0');
                const dayStr = i.toString().padStart(2, '0');
                const holidayKey = `${dayStr}-${monthStr}`;
                if(boliviaHolidays[holidayKey]) {
                    cls += " holiday";
                    titleAttr = `title="Feriado: ${boliviaHolidays[holidayKey]}"`;
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
