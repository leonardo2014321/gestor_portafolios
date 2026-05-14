{{-- _styles_admin.blade.php --}}
<style>
    /* ══════════════════════════════════════
       VARIABLES ADMIN (sobreescriben _styles_menu)
    ══════════════════════════════════════ */
    :root {
        --admin-purple: #6366f1;
        --admin-purple-dark: #4f46e5;
        --rose: #e11d48;
        --sw: 240px;
        --hh: 70px;
        --gray: #f8fafc;
    }

    /* ══════════════════════════════════════
       LAYOUT ADMIN
    ══════════════════════════════════════ */
    html { height: 100%; }
    html, body { height: 100%; overflow: hidden; }
    .app { height: 100vh; display: flex !important; flex-direction: column !important; overflow: hidden; }
    .body-row { flex: 1 1 0 !important; display: flex !important; overflow: hidden !important; min-height: 0 !important; max-height: calc(100vh - var(--hh)); }
    .body-row > main { flex: 1 1 0 !important; min-height: 0 !important; overflow-y: auto !important; }

    /* ══════════════════════════════════════
       SIDEBAR ADMIN (sobreescribe _styles_menu)
    ══════════════════════════════════════ */
    aside { width: var(--sw); }
    .sb-top { padding: 20px 0; flex: 1; overflow-y: auto; }
    .sb-label { font-size: 11px; font-weight: 700; color: #8ba5c8; text-transform: uppercase; letter-spacing: 1px; padding: 0 24px; margin-bottom: 12px; margin-top: 10px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .sb-item { gap: 14px; padding: 12px 24px; font-size: 13.5px; font-weight: 500; text-align: left; }
    .sb-item svg { width: 18px; height: 18px; }
    .sb-div { margin: 12px 24px; }
    .sb-user-block { padding: 16px 24px; gap: 12px; background: rgba(255,255,255,0.03); }
    .sb-av { width: 40px; height: 40px; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(59,130,246,0.3); }
    .sb-uname { font-size: 14px; font-weight: 700; }
    .sb-uid { font-size: 12px; color: #5a7fa0; }

    /* Badge admin en topbar */
    .badge-admin { background: rgba(255,255,255,0.1); color: #fff; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; border: 1px solid rgba(255,255,255,0.2); }

    /* Overlay sidebar móvil */
    .sidebar-overlay { position: fixed; top: var(--hh); left: 0; width: 100%; height: calc(100vh - var(--hh)); background: rgba(0,0,0,0.4); z-index: 999; opacity: 0; visibility: hidden; transition: all 0.3s ease; }
    .sidebar-overlay.show { opacity: 1; visibility: visible; }
    .mobile-menu-btn { display: none; background: none; border: none; color: #fff; cursor: pointer; padding: 4px; margin-right: 8px; }
    .mobile-menu-btn svg { width: 24px; height: 24px; }

    /* ══════════════════════════════════════
       MAIN ADMIN (grid con panel derecho)
    ══════════════════════════════════════ */
    main { flex: 1; display: grid; grid-template-columns: 1fr 320px; overflow: hidden; background: var(--gray); position: relative; }
    .main-inner { padding: 2rem 2.5rem; overflow-y: auto; width: 100%; max-width: 1400px; margin: 0 auto; }
    .admin-view { display: none; }
    .admin-view.active { display: block; }

    /* ══════════════════════════════════════
       HERO ADMIN
    ══════════════════════════════════════ */
    .admin-hero { background: linear-gradient(135deg, #1e1b4b 0%, var(--admin-purple-dark) 100%); padding: 2rem 2.5rem; border-radius: 20px; margin-bottom: 2rem; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(99,102,241,0.15); display: flex; justify-content: space-between; align-items: center; }
    .admin-hero::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml;utf8,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1" fill="rgba(255,255,255,0.05)"/></svg>'); }
    .admin-hero::after { content: ''; position: absolute; right: -50px; bottom: -80px; width: 300px; height: 300px; border-radius: 50%; background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); }
    .hero-content { position: relative; z-index: 1; }
    .hero-title { font-family: "Plus Jakarta Sans", sans-serif; font-size: 28px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 8px; }
    .hero-sub { font-size: 14px; color: rgba(255,255,255,.8); font-weight: 500; }
    .hero-actions { position: relative; z-index: 1; display: flex; gap: 12px; }
    .btn-primary { background: #fff; color: var(--admin-purple-dark); padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13.5px; border: none; cursor: pointer; transition: all 0.2s; font-family: "DM Sans", sans-serif; display: flex; align-items: center; gap: 8px; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,255,255,0.2); }
    .btn-outline { background: rgba(255,255,255,0.1); color: #fff; padding: 10px 20px; border-radius: 10px; font-weight: 600; font-size: 13.5px; border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: all 0.2s; font-family: "DM Sans", sans-serif; }
    .btn-outline:hover { background: rgba(255,255,255,0.2); }

    /* ══════════════════════════════════════
       STATS GRID
    ══════════════════════════════════════ */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem; margin-bottom: 2rem; }
    .stat-card { background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--gray2); box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: flex-start; justify-content: space-between; transition: all 0.2s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.05); border-color: var(--gray3); }
    .stat-info { display: flex; flex-direction: column; gap: 6px; }
    .stat-label { font-size: 12.5px; font-weight: 600; color: var(--muted); }
    .stat-val { font-family: "Plus Jakarta Sans", sans-serif; font-size: 28px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-trend { display: flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600; }
    .trend-up { color: #10b981; }
    .trend-down { color: #ef4444; }
    .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon svg { width: 22px; height: 22px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .icon-purple { background: rgba(99,102,241,0.1); color: var(--admin-purple); }
    .icon-teal { background: rgba(13,148,136,0.1); color: var(--teal); }
    .icon-blue { background: rgba(37,99,235,0.1); color: #2563eb; }
    .icon-rose { background: rgba(225,29,72,0.1); color: var(--rose); }

    /* ══════════════════════════════════════
       PANEL / TABLA
    ══════════════════════════════════════ */
    .dash-grid { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
    .panel { background: #fff; border-radius: 16px; border: 1px solid var(--gray2); box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow: hidden; }
    .panel-header { padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--gray2); display: flex; justify-content: space-between; align-items: center; }
    .panel-title { font-family: "Plus Jakarta Sans", sans-serif; font-size: 16px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
    .panel-action { font-size: 13px; font-weight: 600; color: var(--admin-purple); text-decoration: none; }
    .panel-action:hover { text-decoration: underline; }
    .table-wrap { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { padding: 12px 1.5rem; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; background: var(--gray); border-bottom: 1px solid var(--gray2); }
    td { padding: 14px 1.5rem; font-size: 13.5px; color: var(--text); border-bottom: 1px solid var(--gray2); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: var(--gray); }

    /* ══════════════════════════════════════
       USUARIOS
    ══════════════════════════════════════ */
    .user-cell { display: flex; align-items: center; gap: 12px; }
    .u-avatar { width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, var(--admin-purple), #818cf8); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .u-info { display: flex; flex-direction: column; gap: 2px; }
    .u-name { font-size: 13px; font-weight: 600; color: var(--text); }
    .u-email { font-size: 11.5px; color: var(--muted); }
    .status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .st-active { background: rgba(16,185,129,0.1); color: #059669; }
    .st-pending { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
    .st-inactive { background: rgba(239,68,68,0.1); color: #ef4444; }

    /* ══════════════════════════════════════
       BOTONES Y ACCIONES
    ══════════════════════════════════════ */
    .action-btn { width: 28px; height: 28px; border-radius: 6px; border: 1px solid var(--gray2); background: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; color: var(--muted); transition: all 0.2s; }
    .action-btn:hover { border-color: var(--admin-purple); color: var(--admin-purple); }
    .action-btn svg { width: 14px; height: 14px; stroke-width: 2; }
    .switch { position: relative; display: inline-block; width: 34px; height: 20px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--gray2); transition: .4s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    input:checked + .slider { background-color: var(--admin-purple); }
    input:checked + .slider:before { transform: translateX(14px); }
    .btn-action-admin { width: 100%; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans', sans-serif; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .btn-status-off { background: #fee2e2; color: #b91c1c; }
    .btn-status-off:hover { background: #fecaca; }
    .btn-status-on { background: #dcfce7; color: #15803d; }
    .btn-status-on:hover { background: #bbf7d0; }
    .btn-role-admin { background: #e0e7ff; color: #4338ca; }
    .btn-role-admin:hover { background: #c7d2fe; }
    .btn-role-user { background: #f1f5f9; color: #475569; }
    .btn-role-user:hover { background: #e2e8f0; }
    .action-dropdown-container { position: relative; display: inline-block; }
    .action-menu { display: none; position: absolute; right: 0; top: 100%; margin-top: 5px; background: #fff; border: 1px solid var(--gray2); border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 200px; z-index: 100; padding: 12px; flex-direction: column; gap: 12px; }
    .action-menu.menu-up { top: auto; bottom: 100%; margin-top: 0; margin-bottom: 5px; }

    /* ══════════════════════════════════════
       ACTIVIDAD
    ══════════════════════════════════════ */
    .activity-list { padding: 0; }
    .act-item { display: flex; align-items: flex-start; gap: 14px; padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--gray2); transition: background 0.2s; cursor: pointer; }
    .act-item:hover { background: var(--gray); }
    .act-item:last-child { border-bottom: none; }
    .act-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .act-icon svg { width: 16px; height: 16px; stroke-width: 2; }
    .act-content { flex: 1; }
    .act-title { font-size: 13.5px; font-weight: 600; color: var(--text); line-height: 1.4; }
    .act-title span { font-weight: 400; color: var(--muted); }
    .act-time { font-size: 11px; font-weight: 600; color: var(--muted); margin-top: 4px; }

    /* ══════════════════════════════════════
       PANEL DERECHO / CALENDARIO
    ══════════════════════════════════════ */
    .rpanel { width: 100%; background: #fff; border-left: 1px solid var(--gray2); display: flex; flex-direction: column; overflow-y: auto; }
    .rp-sec { padding: .9rem 1rem; border-bottom: 1px solid var(--gray2); }
    .cal-hd { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .cal-month { font-family: "Plus Jakarta Sans", sans-serif; font-size: 15px; font-weight: 700; color: var(--text); }
    .cal-navs { display: flex; gap: 2px; }
    .cal-nav { width: 24px; height: 24px; border-radius: 6px; background: var(--gray); border: none; cursor: pointer; color: var(--muted); font-size: 16px; display: flex; align-items: center; justify-content: center; transition: background .15s; }
    .cal-nav:hover { background: var(--gray2); }
    .cal-grid { display: grid; grid-template-columns: repeat(7,1fr); gap: 1px; }
    .cdn { font-size: 9.5px; color: var(--muted); text-align: center; padding: 3px 0; font-weight: 700; }
    .cd { font-size: 11.5px; text-align: center; padding: 4px 2px; border-radius: 6px; cursor: pointer; transition: background .15s; color: var(--text); position: relative; }
    .cd:hover { background: var(--gray); }
    .cd.today { background: var(--admin-purple); color: #fff; font-weight: 700; }
    .cd.other { color: var(--gray3); }
    .cd.ev::after { content: ""; position: absolute; bottom: 1px; left: 50%; transform: translateX(-50%); width: 4px; height: 4px; border-radius: 50%; background: var(--teal); }
    .cd.holiday { color: #ef4444; font-weight: 700; }
    .cd.holiday::before { content: ''; position: absolute; top: 2px; right: 2px; width: 4px; height: 4px; border-radius: 50%; background: #ef4444; }
    .cal-view-selector { margin-left: auto; margin-right: 10px; padding: 3px 6px; border-radius: 6px; border: 1px solid var(--gray2); background: #fff; font-size: 11px; font-family: "DM Sans", sans-serif; color: var(--text); outline: none; cursor: pointer; }
    .cal-grid-meses { display: grid; grid-template-columns: repeat(3,1fr); gap: 6px; margin-top: 10px; padding: 0 5px; }
    .cal-grid-anios { display: grid; grid-template-columns: repeat(4,1fr); gap: 4px; margin-top: 10px; }
    .cm-btn { font-size: 12px; padding: 12px 0; text-align: center; border-radius: 8px; cursor: pointer; background: var(--gray); transition: all .15s; color: var(--text); font-weight: 600; }
    .cm-btn:hover { background: var(--gray2); color: var(--admin-purple); }
    .cm-btn.current { background: var(--admin-purple); color: #fff; }
    .cm-btn.other { opacity: 0.5; }
    .row-week { display: contents; }
    .row-week:hover > .cd { background: rgba(99,102,241,0.1); color: var(--admin-purple); }

    /* ══════════════════════════════════════
       ANIMACIÓN
    ══════════════════════════════════════ */
    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95); }
        to   { opacity: 1; transform: scale(1); }
    }

    /* ══════════════════════════════════════
       RESPONSIVE ADMIN
    ══════════════════════════════════════ */
    @media(max-width: 1200px) {
        main { grid-template-columns: 1fr; overflow-y: auto; }
        .main-inner { overflow-y: visible; padding: 1.5rem; height: max-content; }
        .rpanel { border-left: none; border-top: 1px solid var(--gray2); overflow-y: visible; height: max-content; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media(max-width: 768px) {
        .mobile-menu-btn { display: block; }
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
        .admin-hero { padding: 1.5rem; }
        .hero-title { font-size: 24px; }
        .panel-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .sb-uname, .sb-uid { display: none; }
        .action-menu {
            position: fixed;
            top: auto !important;
            bottom: 0; left: 0; right: 0;
            width: 100%;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
            z-index: 9999;
            padding: 24px;
            border-bottom: none;
        }
    }
</style>