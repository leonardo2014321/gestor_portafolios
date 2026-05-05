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
        .topbar{height:var(--hh);background:#ffffff;display:flex;align-items:center;justify-content:space-between;padding:0 28px;flex-shrink:0;border-bottom:1px solid var(--gray2); box-shadow: 0 2px 10px rgba(0,0,0,0.02);}
        .tb-left{display:flex;align-items:center;gap:16px}
        .logo-img{width:40px;height:40px;object-fit:contain;border-radius:10px;background:var(--admin-purple);padding:4px}
        .sysname{font-family:"Plus Jakarta Sans",sans-serif;font-size:20px;font-weight:800;color:var(--navy);letter-spacing:-0.5px}
        .sysname span{color:var(--admin-purple)}
        .tb-nav{display:flex;align-items:center;gap:28px}
        .badge-admin{background: rgba(99, 102, 241, 0.1); color: var(--admin-purple); padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; border: 1px solid rgba(99, 102, 241, 0.2);}
        
        .tb-right{display:flex;align-items:center;gap:16px}
        .tb-search{display:flex;align-items:center;gap:8px;background:var(--gray);border:1px solid var(--gray2);border-radius:10px;padding:8px 16px;height:40px;transition: all 0.2s;}
        .tb-search:focus-within {border-color: var(--admin-purple); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);}
        .tb-search svg{width:16px;height:16px;fill:none;stroke:var(--muted);stroke-width:2;flex-shrink:0}
        .tb-search input{border:none;outline:none;background:transparent;font-family:"DM Sans",sans-serif;font-size:13.5px;color:var(--text);width:180px}
        .tb-search input::placeholder{color:var(--muted)}
        .tb-bell{width:40px;height:40px;border-radius:10px;background:var(--gray);border:1px solid var(--gray2);display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative; transition: all 0.2s;}
        .tb-bell:hover {background: #093d70ff; transform: translateY(-1px);}
        .tb-bell::after{content:'';position:absolute;top:10px;right:10px;width:8px;height:8px;background:var(--rose);border-radius:50%; border: 2px solid #fff;}
        .tb-bell svg{width:18px;height:18px;fill:none;stroke:var(--text);stroke-width:2;stroke-linecap:round}

        /* ── Body ── */
        .body-row{flex:1;display:flex;overflow:hidden}

        /* ── Sidebar ── */
        aside{width:var(--sw);background:#ffffff;flex-shrink:0;display:flex;flex-direction:column;border-right:1px solid var(--gray2)}
        .sb-top{padding:20px 0;flex:1; overflow-y: auto;}
        .sb-label {font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; padding: 0 24px; margin-bottom: 12px; margin-top: 10px;}
        .sb-item{display:flex;align-items:center;gap:14px;padding:12px 24px;cursor:pointer;color:var(--muted);font-size:13.5px;font-weight:600;transition:all .2s;border-right:3px solid transparent;font-family:"DM Sans",sans-serif;text-decoration:none;background:none;border-top:none;border-left:none;border-bottom:none;width:100%; text-align: left;}
        .sb-item:hover{background:var(--gray);color:var(--admin-purple);}
        .sb-item.active{background:rgba(99, 102, 241, 0.05);color:var(--admin-purple-dark);border-right-color:var(--admin-purple);}
        .sb-item svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;stroke-linecap:round;stroke-linejoin:round}
        .sb-div{height:1px;background:var(--gray2);margin:12px 24px}
        
        .sb-user-block{padding:16px 24px;display:flex;align-items:center;gap:12px;border-top:1px solid var(--gray2);background:var(--gray)}
        .sb-av{width:40px;height:40px;border-radius:12px;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,var(--admin-purple),var(--teal));display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);}
        .sb-uname{font-size:14px;color:var(--text);font-weight:700}
        .sb-uid{font-size:12px;color:var(--muted)}

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

        .mobile-menu-btn { display: none; background: none; border: none; color: var(--navy); cursor: pointer; padding: 4px; margin-right: 8px; }
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
                box-shadow: 4px 0 15px rgba(0,0,0,0.1);
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
            <div class="logo-img">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="sysname">Sansi<span>Folios</span></div>
        </div>
        <div class="tb-right">
            <div class="tb-search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Buscar usuarios, IDs...">
            </div>
            <div class="tb-bell">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            
            <div style="position:relative;">
                <div style="display:flex;align-items:center;gap:12px;border-left:1px solid var(--gray2);padding-left:16px;cursor:pointer;" onclick="document.getElementById('admin-dropdown').style.display = document.getElementById('admin-dropdown').style.display === 'block' ? 'none' : 'block'">
                    <div class="sb-av" style="width:36px;height:36px;border-radius:10px;">A</div>
                    <div style="display:flex;flex-direction:column;">
                        <div class="sb-uname" style="font-size:13px;">Administrador</div>
                        <div class="sb-uid" style="font-size:11px;">admin@umss.edu.bo</div>
                    </div>
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
                
                <div id="admin-dropdown" style="display:none;position:absolute;top:100%;right:0;margin-top:10px;background:#fff;border:1px solid var(--gray2);border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.1);width:160px;overflow:hidden;z-index:100;">
                    <a href="{{ url('/') }}" style="padding:12px 16px;font-size:13px;font-weight:600;color:var(--rose);text-decoration:none;display:flex;align-items:center;gap:8px;transition:background 0.2s;" onmouseover="this.style.background='var(--gray)'" onmouseout="this.style.background='transparent'">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Salir
                    </a>
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
                <button class="sb-item active">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Menu Principal</span>
                </button>
                <button class="sb-item">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Usuarios</span>
                </button>
                <button class="sb-item">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span>Portafolios</span>
                </button>
            </div>
        </aside>

        <!-- Main content -->
        <main>
            <div class="main-inner">
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
                            <div class="stat-val">1,248</div>
                            <div class="stat-trend trend-up">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                +12% vs mes anterior
                            </div>
                        </div>
                        <div class="stat-icon icon-purple">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Portafolios Activos</div>
                            <div class="stat-val">856</div>
                            <div class="stat-trend trend-up">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                                +5% vs mes anterior
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
                            <div class="stat-label">Alertas de Sistema</div>
                            <div class="stat-val">3</div>
                            <div class="stat-trend trend-down">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                                Requieren atención
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
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="u-avatar">MV</div>
                                                <div class="u-info">
                                                    <span class="u-name">María Vargas</span>
                                                    <span class="u-email">m.vargas@est.umss.edu</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="role-1">Usuario</td>
                                        <td>Hoy, 10:24 AM</td>
                                        <td><span class="status-badge st-active" id="status-1">Activo</span></td>
                                        <td>
                                            <div class="action-dropdown-container">
                                                <button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                                                <div class="action-menu">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Estado</span>
                                                        <label class="switch">
                                                            <input type="checkbox" checked onchange="toggleStatus(this, 'status-1')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                    <div style="height: 1px; background: var(--gray2);"></div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Rol Admin</span>
                                                        <label class="switch">
                                                            <input type="checkbox" onchange="toggleRole(this, 'role-1')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="u-avatar" style="background: #dbeafe; color: #1e3a8a;">JR</div>
                                                <div class="u-info">
                                                    <span class="u-name">Juan Robles</span>
                                                    <span class="u-email">j.robles@est.umss.edu</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="role-2">Usuario</td>
                                        <td>Ayer, 16:40 PM</td>
                                        <td><span class="status-badge st-pending" id="status-2">Pendiente</span></td>
                                        <td>
                                            <div class="action-dropdown-container">
                                                <button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                                                <div class="action-menu">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Estado</span>
                                                        <label class="switch">
                                                            <input type="checkbox" onchange="toggleStatus(this, 'status-2')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                    <div style="height: 1px; background: var(--gray2);"></div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Rol Admin</span>
                                                        <label class="switch">
                                                            <input type="checkbox" onchange="toggleRole(this, 'role-2')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="u-avatar" style="background: #fce7f3; color: #be185d;">LC</div>
                                                <div class="u-info">
                                                    <span class="u-name">Lucía Castro</span>
                                                    <span class="u-email">l.castro@doc.umss.edu</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="role-3">Usuario</td>
                                        <td>Ayer, 09:15 AM</td>
                                        <td><span class="status-badge st-active" id="status-3">Activo</span></td>
                                        <td>
                                            <div class="action-dropdown-container">
                                                <button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                                                <div class="action-menu">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Estado</span>
                                                        <label class="switch">
                                                            <input type="checkbox" checked onchange="toggleStatus(this, 'status-3')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                    <div style="height: 1px; background: var(--gray2);"></div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Rol Admin</span>
                                                        <label class="switch">
                                                            <input type="checkbox" onchange="toggleRole(this, 'role-3')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="u-avatar" style="background: #dcfce7; color: #166534;">CM</div>
                                                <div class="u-info">
                                                    <span class="u-name">Carlos Mendoza</span>
                                                    <span class="u-email">c.mendoza@est.umss.edu</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="role-4">Usuario</td>
                                        <td>Hace 2 días</td>
                                        <td><span class="status-badge st-active" id="status-4">Activo</span></td>
                                        <td>
                                            <div class="action-dropdown-container">
                                                <button class="action-btn" onclick="toggleActionMenu(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                                                <div class="action-menu">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Estado</span>
                                                        <label class="switch">
                                                            <input type="checkbox" checked onchange="toggleStatus(this, 'status-4')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                    <div style="height: 1px; background: var(--gray2);"></div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Rol Admin</span>
                                                        <label class="switch">
                                                            <input type="checkbox" onchange="toggleRole(this, 'role-4')">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

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
                        <div class="act-item" style="padding: 1rem; gap: 10px;">
                            <div class="act-icon icon-teal" style="width: 32px; height: 32px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </div>
                            <div class="act-content">
                                <div class="act-title" style="font-size: 12px;">Nuevo portafolio aprobado <br><span>"Arquitectura Moderna"</span></div>
                                <div class="act-time" style="font-size: 10px;">Hace 15 minutos</div>
                            </div>
                        </div>
                        <div class="act-item" style="padding: 1rem; gap: 10px;">
                            <div class="act-icon icon-purple" style="width: 32px; height: 32px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div class="act-content">
                                <div class="act-title" style="font-size: 12px;">Usuario <span>Juan Robles</span> completó su registro.</div>
                                <div class="act-time" style="font-size: 10px;">Hace 2 horas</div>
                            </div>
                        </div>
                        <div class="act-item" style="padding: 1rem; gap: 10px;">
                            <div class="act-icon icon-rose" style="width: 32px; height: 32px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            </div>
                            <div class="act-content">
                                <div class="act-title" style="font-size: 12px;">Alerta de seguridad <span>Intentos fallidos de acceso (IP: 192.168.x.x)</span></div>
                                <div class="act-time" style="font-size: 10px;">Hace 5 horas</div>
                            </div>
                        </div>
                        <div class="act-item" style="padding: 1rem; gap: 10px;">
                            <div class="act-icon icon-blue" style="width: 32px; height: 32px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div class="act-content">
                                <div class="act-title" style="font-size: 12px;">Reporte generado <span>Estadísticas mensuales descargadas</span></div>
                                <div class="act-time" style="font-size: 10px;">Ayer</div>
                            </div>
                        </div>
                        
                        <a href="#" style="display: block; text-align: center; padding: 1rem; font-size: 12px; font-weight: 600; color: var(--admin-purple); text-decoration: none; border-top: 1px solid var(--gray2);">Ver todo el registro</a>
                    </div>
                </div>
            </div>

        </div>
        </main>

    </div>
</div>

<script>
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
