<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - SansiFolios</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --navy:#1a2340;--navy2:#1e2d50;--blue:#2563eb;--blue2:#3b82f6;
            --teal:#0d9488;--red:#dc2626;--white:#fff;--gray:#f0f2f8;
            --gray2:#e2e8f0;--gray3:#cbd5e1;--text:#1e293b;--muted:#64748b;
            --sw:190px;--hh:72px;
        }
        html,body{height:100%;font-family:"DM Sans",sans-serif;background:var(--gray);color:var(--text);overflow:hidden}
        .app{display:flex;flex-direction:column;height:100vh}

        /* Topbar */
        .topbar{height:var(--hh);background:var(--navy);display:flex;align-items:center;justify-content:space-between;padding:0 28px;flex-shrink:0;border-bottom:3px solid #0f1729;box-shadow:0 2px 12px rgba(0,0,0,0.25)}
        .tb-left{display:flex;align-items:center;gap:14px}
        .logo-img{width:52px;height:52px;object-fit:contain;border-radius:6px;background:rgba(255,255,255,0.08);padding:2px}
        .sysname{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;color:#fff;letter-spacing:-0.5px}
        .sysname span{color:#f87171}
        .tb-nav{display:flex;align-items:center;gap:24px}
        .tb-link{font-size:14px;font-weight:500;color:rgba(255,255,255,0.75);cursor:pointer;border:none;background:none;font-family:"DM Sans",sans-serif;transition:color .2s;padding:4px 0;text-decoration:none}
        .tb-link:hover{color:#fff}

        /* Body row */
        .body-row{flex:1;display:flex;overflow:hidden}

        /* Sidebar */
        aside{width:var(--sw);background:var(--navy);flex-shrink:0;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,0.05)}
        .sb-top{padding:16px 0;flex:1}
        .sb-item{display:flex;align-items:center;gap:11px;padding:11px 20px;cursor:pointer;color:#8ba5c8;font-size:13.5px;font-weight:400;transition:all .2s;border-left:3px solid transparent;font-family:"DM Sans",sans-serif;text-decoration:none}
        .sb-item:hover{background:rgba(255,255,255,0.06);color:#c8d8ef}
        .sb-item.active{background:rgba(37,99,235,0.2);color:#fff;border-left-color:var(--blue2);font-weight:600}
        .sb-item svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;flex-shrink:0;stroke-linecap:round;stroke-linejoin:round}
        .sb-div{height:1px;background:rgba(255,255,255,0.07);margin:6px 12px}
        .sb-user{padding:12px 16px;display:flex;align-items:center;gap:10px;border-top:1px solid rgba(255,255,255,0.07)}
        .sb-av{width:38px;height:38px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff}
        .sb-uname{font-size:13px;color:#fff;font-weight:600}
        .sb-uid{font-size:11px;color:#5a7fa0}
        .btn-logout{width:calc(100% - 24px);margin:0 12px 12px;background:rgba(255,255,255,0.05);color:#8ba5c8;border:1px solid rgba(255,255,255,0.1);border-radius:7px;padding:8px 10px;font-size:12.5px;font-family:"DM Sans",sans-serif;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .2s;text-decoration:none}
        .btn-logout:hover{background:rgba(220,38,38,0.15);color:#fca5a5}
        .btn-logout svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        /* Main */
        main{flex:1;overflow-y:auto;background:var(--gray)}
        .main-inner{padding:1.4rem 1.6rem;max-width:900px}

        /* Header */
        .content-bar{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.4rem}
        .content-title h1{font-family:"Plus Jakarta Sans",sans-serif;font-size:24px;font-weight:800;color:var(--text)}
        .content-title p{font-size:12.5px;color:var(--muted);margin-top:3px}

        /* Alerts */
        .alert{padding:12px 16px;border-radius:10px;font-size:13.5px;font-weight:500;margin-bottom:1.2rem;display:flex;align-items:center;gap:10px}
        .alert-success{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
        .alert-success svg{stroke:#15803d}
        .alert svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;stroke-linecap:round;stroke-linejoin:round}
        .alert-error{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca}
        .alert-error svg{stroke:#b91c1c}
        .alert-retry{background:#fef3c7;color:#92400e;border:1px solid #fde68a}
        .alert-retry svg{stroke:#d97706}

        /* Preview toggle */
        .mode-toggle{display:flex;align-items:center;gap:8px;padding:6px 14px;border-radius:8px;border:1.5px solid var(--gray2);background:#fff;font-size:13px;font-weight:500;cursor:pointer;transition:all .2s;font-family:"DM Sans",sans-serif;color:var(--text)}
        .mode-toggle:hover{border-color:var(--blue2);color:var(--blue)}
        .mode-toggle svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .mode-toggle.active{background:var(--navy);color:#fff;border-color:var(--navy)}

        /* Grid layout */
        .profile-grid{display:grid;grid-template-columns:220px 1fr;gap:1.2rem}

        /* Photo card */
        .photo-card{background:#fff;border-radius:14px;padding:1.2rem;border:1.5px solid var(--gray2);display:flex;flex-direction:column;align-items:center;gap:14px;align-self:start}
        .photo-wrap{position:relative;width:120px;height:120px}
        .photo-avatar{width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--gray2)}
        .photo-initials{width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:36px;font-weight:700;color:#fff;border:3px solid var(--gray2)}
        .photo-overlay{position:absolute;inset:0;border-radius:50%;background:rgba(0,0,0,0.45);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;cursor:pointer}
        .photo-overlay svg{width:22px;height:22px;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .photo-wrap:hover .photo-overlay{opacity:1}
        .photo-hint{font-size:11px;color:var(--muted);text-align:center;line-height:1.5}
        .photo-error{font-size:11.5px;color:var(--red);text-align:center;font-weight:500;display:none}

        /* Form card */
        .form-card{background:#fff;border-radius:14px;padding:1.4rem;border:1.5px solid var(--gray2)}
        .card-title{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;color:var(--text);margin-bottom:1.1rem;padding-bottom:.7rem;border-bottom:1px solid var(--gray2)}

        /* Fields */
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
        .form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:1rem}
        .form-group:last-child{margin-bottom:0}
        label{font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--muted)}
        .req{color:var(--red);margin-left:2px}
        .field{border-radius:9px;border:1.5px solid var(--gray2);padding:10px 13px;font-size:13.5px;color:var(--text);font-family:"DM Sans",sans-serif;transition:border .2s;outline:none;width:100%;background:#fff}
        .field:focus{border-color:var(--blue2)}
        .field.error{border-color:var(--red);background:#fff5f5}
        .field-err{font-size:11px;color:var(--red);margin-top:3px;display:none}
        .field-err.show{display:block}

        /* Textarea */
        textarea.field{resize:vertical;min-height:110px;line-height:1.5}
        .bio-footer{display:flex;justify-content:space-between;align-items:center;margin-top:4px}
        .bio-counter{font-size:11.5px;color:var(--muted);font-weight:500}
        .bio-counter.over{color:var(--red);font-weight:700}

        /* Action buttons */
        .form-actions{display:flex;align-items:center;gap:10px;margin-top:1.2rem;padding-top:1rem;border-top:1px solid var(--gray2)}
        .btn-save{background:linear-gradient(135deg,var(--blue),var(--blue2));color:#fff;border:none;border-radius:9px;padding:10px 26px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;transition:opacity .2s;display:inline-flex;align-items:center;gap:8px}
        .btn-save:hover{opacity:.9}
        .btn-save:disabled{opacity:.5;cursor:not-allowed}
        .btn-save .spinner{width:14px;height:14px;border:2px solid rgba(255,255,255,0.4);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;display:none}
        .btn-save.loading .spinner{display:block}
        .btn-save.loading .btn-label{opacity:.5}
        .btn-cancel{background:#fff;color:var(--text);border:1.5px solid var(--gray2);border-radius:9px;padding:10px 22px;font-size:13.5px;font-weight:500;cursor:pointer;font-family:"DM Sans",sans-serif;transition:background .2s}
        .btn-cancel:hover{background:var(--gray)}

        /* Modal overlay */
        .modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,0.5);z-index:100;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(3px);opacity:0;pointer-events:none;transition:opacity .2s}
        .modal-overlay.show{opacity:1;pointer-events:all}
        .modal{background:#fff;border-radius:20px;padding:2rem;width:100%;max-width:420px;box-shadow:0 24px 60px rgba(0,0,0,0.2);transform:translateY(12px);transition:transform .2s}
        .modal-overlay.show .modal{transform:translateY(0)}
        .modal-ico{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem}
        .modal-ico.blue{background:#dbeafe}
        .modal-ico.red{background:#fee2e2}
        .modal-ico svg{width:24px;height:24px;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .modal-ico.blue svg{stroke:#2563eb}
        .modal-ico.red svg{stroke:#dc2626}
        .modal h3{font-family:"Plus Jakarta Sans",sans-serif;font-size:17px;font-weight:800;color:var(--text);text-align:center;margin-bottom:6px}
        .modal p{font-size:13px;color:var(--muted);text-align:center;line-height:1.6}
        .modal-actions{display:flex;gap:10px;margin-top:1.4rem}
        .modal-actions .btn-save{flex:1;justify-content:center}
        .modal-actions .btn-cancel{flex:1;text-align:center}
        .btn-danger{background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;border:none;border-radius:9px;padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;flex:1;transition:opacity .2s}
        .btn-danger:hover{opacity:.88}

        /* Modal Trayectoria */
        .tray-modal{background:#fff;border-radius:20px;width:100%;max-width:680px;max-height:88vh;display:flex;flex-direction:column;box-shadow:0 24px 60px rgba(0,0,0,0.25);transform:translateY(16px);transition:transform .25s}
        .modal-overlay.show .tray-modal{transform:translateY(0)}
        .tray-modal-head{display:flex;align-items:center;justify-content:space-between;padding:1.4rem 1.6rem 0}
        .tray-modal-head h2{font-family:"Plus Jakarta Sans",sans-serif;font-size:18px;font-weight:800;color:var(--text)}
        .tray-close{background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;border-radius:6px;transition:background .15s;display:flex}
        .tray-close:hover{background:var(--gray)}
        .tray-close svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round}
        /* Tabs */
        .tray-tabs{display:flex;gap:0;border-bottom:2px solid var(--gray2);padding:0 1.6rem;margin-top:1rem}
        .tray-tab{background:none;border:none;padding:10px 18px;font-size:13.5px;font-weight:600;color:var(--muted);cursor:pointer;font-family:"DM Sans",sans-serif;border-bottom:2px solid transparent;margin-bottom:-2px;transition:color .15s,border-color .15s}
        .tray-tab.active{color:var(--blue);border-bottom-color:var(--blue)}
        /* Tab content */
        .tray-body{flex:1;overflow-y:auto;padding:1.2rem 1.6rem}
        .tray-pane{display:none}
        .tray-pane.active{display:block}
        /* Formulario de entrada */
        .tray-form{background:var(--gray);border-radius:12px;padding:1rem 1.2rem;margin-bottom:1.2rem}
        .tray-form-title{font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--muted);margin-bottom:.8rem}
        .tray-fg{display:flex;flex-direction:column;gap:4px;margin-bottom:.75rem}
        .tray-fg label{font-size:11px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;color:var(--muted)}
        .tray-fg input,.tray-fg textarea,.tray-fg select{border-radius:8px;border:1.5px solid var(--gray2);padding:9px 12px;font-size:13px;color:var(--text);font-family:"DM Sans",sans-serif;outline:none;width:100%;background:#fff;transition:border .2s}
        .tray-fg input:focus,.tray-fg textarea:focus,.tray-fg select:focus{border-color:var(--blue2)}
        .tray-fg textarea{resize:vertical;min-height:72px;line-height:1.5}
        .tray-row{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
        .tray-err{font-size:11px;color:var(--red);margin-top:2px;display:none}
        .tray-err.show{display:block}
        /* Stars rating */
        .stars{display:flex;gap:4px;cursor:pointer}
        .star{font-size:22px;color:var(--gray3);transition:color .1s;line-height:1;user-select:none}
        .star.on{color:#f59e0b}
        /* Autocomplete dropdown */
        .ac-wrap{position:relative}
        .ac-drop{position:absolute;top:100%;left:0;right:0;background:#fff;border:1.5px solid var(--blue2);border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.1);z-index:200;max-height:180px;overflow-y:auto;display:none}
        .ac-item{padding:9px 12px;font-size:13px;cursor:pointer;color:var(--text)}
        .ac-item:hover{background:var(--gray)}
        /* Item list */
        .item-list{display:flex;flex-direction:column;gap:.6rem}
        .item-card{background:#fff;border:1.5px solid var(--gray2);border-radius:10px;padding:.9rem 1rem;display:flex;align-items:flex-start;gap:.8rem}
        .item-card-body{flex:1;min-width:0}
        .item-card-body strong{font-size:13.5px;font-weight:600;color:var(--text);display:block}
        .item-card-body span{font-size:12px;color:var(--muted);display:block;margin-top:2px}
        .item-card-body p{font-size:12px;color:var(--text);margin-top:5px;white-space:pre-wrap;line-height:1.5}
        .item-badge{display:inline-block;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;margin-top:4px}
        .badge-p{background:#dbeafe;color:#1d4ed8}
        .badge-i{background:#fef3c7;color:#92400e}
        .badge-a{background:#dcfce7;color:#15803d}
        .btn-del-item{background:none;border:none;cursor:pointer;color:var(--gray3);padding:4px;transition:color .15s;flex-shrink:0;display:flex}
        .btn-del-item:hover{color:var(--red)}
        .btn-del-item svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round}
        .empty-state{text-align:center;padding:2rem;color:var(--muted);font-size:13px}
        .btn-add-tray{background:none;border:1.5px dashed var(--gray3);border-radius:9px;padding:9px;width:100%;color:var(--muted);font-size:13px;font-family:"DM Sans",sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;margin-top:.75rem;transition:all .2s}
        .btn-add-tray:hover{border-color:var(--blue2);color:var(--blue)}
        .btn-add-tray svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2}
        /* Checkbox */
        .tray-check{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--text)}
        .tray-check input{width:15px;height:15px;accent-color:var(--blue);cursor:pointer}
        /* Alerta error trayectoria */
        .tray-alert{display:none;background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:9px 12px;font-size:12.5px;color:#92400e;margin-bottom:.75rem;align-items:center;gap:8px}
        .tray-alert.show{display:flex}
        .tray-alert button{margin-left:auto;background:none;border:none;font-weight:700;color:#92400e;cursor:pointer;font-family:inherit;font-size:12.5px}
        /* Modal confirmación borrar */
        .del-overlay{position:fixed;inset:0;background:rgba(15,23,42,0.5);z-index:300;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(2px);opacity:0;pointer-events:none;transition:opacity .2s}
        .del-overlay.show{opacity:1;pointer-events:all}

        /* Botones extra */
        .extra-actions{display:flex;gap:10px;margin-top:1rem}
        .btn-tray{background:#fff;color:var(--navy);border:1.5px solid var(--gray2);border-radius:9px;padding:10px 18px;font-size:13px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:7px;transition:all .2s}
        .btn-tray:hover{border-color:var(--blue2);color:var(--blue)}
        .btn-tray svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .btn-deactivate{background:#fff;color:var(--red);border:1.5px solid #fecaca;border-radius:9px;padding:10px 18px;font-size:13px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:7px;transition:all .2s}
        .btn-deactivate:hover{background:#fee2e2}
        .btn-deactivate svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        /* Preview card */
        .preview-card{background:linear-gradient(140deg,#1e2d50,#1a2340);border-radius:14px;padding:1.4rem;color:#fff;display:none}
        .preview-card.show{display:block}
        .preview-av{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:#fff;margin-bottom:12px;overflow:hidden}
        .preview-av img{width:100%;height:100%;object-fit:cover}
        .preview-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:18px;font-weight:800}
        .preview-prof{font-size:13px;color:#93c5fd;margin-top:3px;font-weight:500}
        .preview-bio{font-size:13px;color:#cbd5e1;margin-top:10px;line-height:1.6;white-space:pre-wrap}
        .preview-lbl{font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#5a7fa0;margin-bottom:10px}

        /* Footer */
        footer{height:44px;background:var(--navy);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .footer-content{display:flex;align-items:center;gap:10px}
        .footer-logo{height:22px;width:auto;object-fit:contain}
        footer p{font-size:12px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0}
        footer b{color:#7a9cc0}

        /* Responsive */
        @media(max-width:992px){
            aside{width:78px}
            .sb-item span,.sb-uname,.sb-uid,.btn-logout span{display:none}
            .sb-item{justify-content:center;padding:13px 10px}
            .sb-user{justify-content:center}
            .btn-logout{justify-content:center}
            .profile-grid{grid-template-columns:1fr}
            .form-row{grid-template-columns:1fr}
        }

        @keyframes spin{to{transform:rotate(360deg)}}
        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}
    </style>
</head>
<body>
<div class="app">

    <div class="topbar">
        <div class="tb-left">
            <img class="logo-img" src="{{ asset('images/logo.png') }}" alt="UMSS">
            <div class="sysname">Sansi<span>Folios</span></div>
        </div>
        <nav class="tb-nav">
            <a href="{{ route('inicio') }}" class="tb-link">Inicio</a>
            <a href="{{ route('caracteristicas') }}" class="tb-link">Características</a>
            <a href="{{ route('portafolios.index') }}" class="tb-link">Portafolios</a>
        </nav>
    </div>

    <div class="body-row">
        <aside>
            <div class="sb-top">
                <a href="{{ route('menu') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <span>Menú principal</span>
                </a>
                <div class="sb-div"></div>
                <a href="{{ route('portafolios.index') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>Portafolios</span>
                </a>
                <a href="{{ route('academico') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    <span>Académico</span>
                </a>
                <a href="{{ route('reportes') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>Reportes</span>
                </a>
                <a href="{{ route('perfil') }}" class="sb-item active">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Mi Perfil</span>
                </a>
            </div>

            <div class="sb-user">
                <div class="sb-av" id="sidebarAv">
                    @if($usuario->foto_perfil)
                        <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%"
                             onerror="this.parentElement.innerHTML='{{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($usuario->apellido ?? '', 0, 1)) }}'">
                    @else
                        {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($usuario->apellido ?? '', 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="sb-uname">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                    <div class="sb-uid">#{{ $usuario->id }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </aside>

        <main>
            <div class="main-inner">
                <div class="content-bar">
                    <div class="content-title">
                        <h1>Mi Perfil</h1>
                        <p>Gestiona tu información personal y biografía profesional.</p>
                    </div>
                    <button type="button" class="mode-toggle" id="btnPreview" onclick="togglePreview()">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Vista Previa
                    </button>
                </div>

                {{-- Mensaje de éxito --}}
                @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                {{-- Errores de validación --}}
                @if($errors->any())
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $errors->first() }}
                </div>
                @endif

                {{-- Alerta de reintento --}}
                <div class="alert alert-retry" id="alertRetry" style="display:none">
                    <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                    Error de conexión. Tus datos no se perdieron.
                    <button onclick="retrySubmit()" style="margin-left:auto;background:none;border:none;font-weight:700;color:#92400e;cursor:pointer;font-family:inherit">Reintentar</button>
                </div>

                {{-- Vista previa --}}
                <div class="preview-card" id="previewCard">
                    <div class="preview-lbl">
                        <svg viewBox="0 0 24 24" style="width:11px;height:11px;fill:none;stroke:currentColor;stroke-width:2;display:inline;margin-right:4px"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Así verán tu perfil terceros
                    </div>
                    <div class="preview-av" id="prevAv">
                        @if($usuario->foto_perfil)
                            <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="foto">
                        @else
                            {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($usuario->apellido ?? '', 0, 1)) }}
                        @endif
                    </div>
                    <div class="preview-name" id="prevName">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                    <div class="preview-prof" id="prevProf">{{ $usuario->profesion ?? 'Sin profesión' }}</div>
                    <div class="preview-bio" id="prevBio">{{ $usuario->biografia ?? 'Sin biografía.' }}</div>
                </div>

                {{-- Formulario principal --}}
                <form id="perfilForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST">

                    <div class="profile-grid">
                        {{-- Foto de perfil --}}
                        <div>
                            <div class="photo-card">
                                <div class="photo-wrap" onclick="document.getElementById('inputFoto').click()">
                                    <div class="photo-initials" id="photoInitials" style="{{ $usuario->foto_perfil ? 'display:none' : 'display:flex' }}">
                                        {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr($usuario->apellido ?? '', 0, 1)) }}
                                    </div>
                                    @if($usuario->foto_perfil)
                                    <img id="photoPreview" class="photo-avatar" src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt=""
                                         onerror="this.style.display='none';document.getElementById('photoInitials').style.display='flex'">
                                    @endif
                                    <div class="photo-overlay">
                                        <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                    </div>
                                </div>
                                <input type="file" id="inputFoto" name="foto_perfil" accept=".jpg,.jpeg,.png" style="display:none" onchange="handlePhoto(this)">
                                <p class="photo-hint">JPG o PNG · Máx 2 MB<br>Click en la foto para cambiar</p>
                                <p class="photo-error" id="photoError"></p>
                            </div>
                        </div>

                        {{-- Información personal + biografía --}}
                        <div>
                            <div class="form-card" style="margin-bottom:1.2rem">
                                <div class="card-title">Información Personal</div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nombre <span class="req">*</span></label>
                                        <input type="text" name="nombre" id="fNombre" class="field" value="{{ old('nombre', $usuario->nombre) }}" placeholder="Tu nombre" maxlength="100" oninput="charCheck(this,'errNombre')">
                                        <span class="field-err" id="errNombre">El nombre es obligatorio.</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido <span class="req">*</span></label>
                                        <input type="text" name="apellido" id="fApellido" class="field" value="{{ old('apellido', $usuario->apellido) }}" placeholder="Tu apellido" maxlength="100" oninput="charCheck(this,'errApellido')">
                                        <span class="field-err" id="errApellido">El apellido es obligatorio.</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Profesión <span class="req">*</span></label>
                                    <input type="text" name="profesion" id="fProfesion" class="field" value="{{ old('profesion', $usuario->profesion) }}" placeholder="Ej: Ingeniero de Software" maxlength="150" oninput="charCheck(this,'errProfesion')">
                                    <span class="field-err" id="errProfesion">La profesión es obligatoria.</span>
                                </div>
                            </div>

                            <div class="form-card">
                                <div class="card-title">Biografía Profesional</div>

                                <div class="form-group">
                                    <label>Biografía</label>
                                    <textarea name="biografia" id="fBiografia" class="field" placeholder="Cuéntanos sobre ti, tu experiencia y objetivos profesionales..." maxlength="1100" oninput="updateCounter();charCheck(this,'errBiografia')">{{ old('biografia', $usuario->biografia) }}</textarea>
                                    <div class="bio-footer">
                                        <span class="field-err" id="errBiografia" style="margin-top:0"></span>
                                        <span class="bio-counter" id="bioCounter">0 / 1000</span>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-save" id="btnSave" onclick="abrirModalGuardar()">
                                        <div class="spinner"></div>
                                        <span class="btn-label">Guardar</span>
                                    </button>
                                    <button type="button" class="btn-cancel" onclick="cancelarEdicion()">Cancelar</button>
                                </div>
                            </div>

                            {{-- Botones extra --}}
                            <div class="extra-actions">
                                <button type="button" class="btn-tray" onclick="abrirTrayectoria()">
                                    <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    Mi Trayectoria
                                </button>
                                <button type="button" class="btn-deactivate" onclick="abrirModalDesactivar()">
                                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                    Desactivar cuenta
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        {{-- Modal: Confirmar guardar --}}
        <div class="modal-overlay" id="modalGuardar">
            <div class="modal">
                <div class="modal-ico blue">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                </div>
                <h3>¿Guardar cambios?</h3>
                <p>Se actualizará tu información personal, profesión y biografía en el sistema.</p>
                <div class="modal-actions">
                    <button class="btn-cancel" onclick="cerrarModal('modalGuardar')">Cancelar</button>
                    <button class="btn-save" onclick="cerrarModal('modalGuardar');submitPerfil()">
                        <div class="spinner"></div>
                        <span class="btn-label">Sí, guardar</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal: Confirmar desactivar cuenta --}}
        <div class="modal-overlay" id="modalDesactivar">
            <div class="modal">
                <div class="modal-ico red">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                </div>
                <h3>¿Desactivar tu cuenta?</h3>
                <p>Tu cuenta quedará inactiva. No podrás iniciar sesión hasta que un administrador la reactive. Esta acción no elimina tus datos.</p>
                <div class="modal-actions">
                    <button class="btn-cancel" onclick="cerrarModal('modalDesactivar')">Cancelar</button>
                    <button class="btn-danger" onclick="desactivarCuenta()">Sí, desactivar</button>
                </div>
            </div>
        </div>

        {{-- Modal: Mi Trayectoria --}}
        <div class="modal-overlay" id="modalTrayectoria" style="align-items:flex-start;padding:3vh 1rem">
            <div class="tray-modal">
                <div class="tray-modal-head">
                    <h2>Mi Trayectoria</h2>
                    <button class="tray-close" onclick="cerrarModal('modalTrayectoria')">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <div class="tray-tabs">
                    <button class="tray-tab active" onclick="switchTab('habilidades')">Habilidades</button>
                    <button class="tray-tab" onclick="switchTab('experiencia')">Experiencia</button>
                    <button class="tray-tab" onclick="switchTab('formacion')">Formación</button>
                    <button class="tray-tab" onclick="switchTab('certificacion')">Certificaciones</button>
                </div>

                <div class="tray-body">

                    {{-- Alerta de error de red --}}
                    <div class="tray-alert" id="trayAlert">
                        <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Tuvimos un fallo momentáneo, vuelve a presionar.
                        <button onclick="retryTray()">Reintentar</button>
                    </div>

                    {{-- Tab: Habilidades --}}
                    <div class="tray-pane active" id="pane-habilidades">
                        <div class="tray-form">
                            <div class="tray-form-title">Agregar habilidad</div>
                            <div class="tray-fg ac-wrap">
                                <label>Nombre <span class="req">*</span></label>
                                <input type="text" id="habNombre" placeholder="Ej: JavaScript, Python, Diseño UX..." autocomplete="off"
                                       oninput="acFilter(this.value);charCheck(this,'errHabNombre')" onblur="setTimeout(()=>closeAc(),200)">
                                <div class="ac-drop" id="acDrop"></div>
                                <span class="tray-err" id="errHabNombre">El nombre es obligatorio.</span>
                                <span class="tray-err" id="errHabDup">Ya tienes registrada esta habilidad.</span>
                            </div>
                            <div class="tray-fg">
                                <label>Nivel de dominio <span class="req">*</span></label>
                                <div class="stars" id="starsWrap">
                                    <span class="star" data-v="1" onclick="setStar(1)">★</span>
                                    <span class="star" data-v="2" onclick="setStar(2)">★</span>
                                    <span class="star" data-v="3" onclick="setStar(3)">★</span>
                                    <span class="star" data-v="4" onclick="setStar(4)">★</span>
                                    <span class="star" data-v="5" onclick="setStar(5)">★</span>
                                </div>
                                <span style="font-size:11px;color:var(--muted);margin-top:3px" id="nivelLabel">1-2 ★ Principiante · 3 ★ Intermedio · 4-5 ★ Avanzado</span>
                                <span class="tray-err" id="errHabNivel">Selecciona un nivel.</span>
                            </div>
                            <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addHabilidad()">
                                <div class="spinner"></div>
                                <span class="btn-label">Agregar</span>
                            </button>
                        </div>
                        <div class="item-list" id="listHabilidades">
                            <div class="empty-state">Cargando...</div>
                        </div>
                    </div>

                    {{-- Tab: Experiencia --}}
                    <div class="tray-pane" id="pane-experiencia">
                        <div class="tray-form">
                            <div class="tray-form-title">Agregar experiencia laboral</div>
                            <div class="tray-row">
                                <div class="tray-fg">
                                    <label>Empresa <span class="req">*</span></label>
                                    <input type="text" id="expEmpresa" placeholder="Nombre de la empresa" maxlength="150" oninput="charCheck(this,'errExpEmpresa')">
                                    <span class="tray-err" id="errExpEmpresa">La empresa es obligatoria.</span>
                                </div>
                                <div class="tray-fg">
                                    <label>Cargo <span class="req">*</span></label>
                                    <input type="text" id="expCargo" placeholder="Tu cargo o rol" maxlength="150" oninput="charCheck(this,'errExpCargo')">
                                    <span class="tray-err" id="errExpCargo">El cargo es obligatorio.</span>
                                </div>
                            </div>
                            <div class="tray-row">
                                <div class="tray-fg">
                                    <label>Fecha inicio <span class="req">*</span></label>
                                    <input type="date" id="expInicio" onchange="checkFechaCoherencia()">
                                    <span class="tray-err" id="errExpInicio">La fecha de inicio es obligatoria.</span>
                                </div>
                                <div class="tray-fg" id="fgExpFin">
                                    <label>Fecha fin</label>
                                    <input type="date" id="expFin" onchange="checkFechaCoherencia()">
                                    <span class="tray-err" id="errExpFin">La fecha fin no puede ser anterior al inicio.</span>
                                </div>
                            </div>
                            <div class="tray-fg">
                                <label class="tray-check">
                                    <input type="checkbox" id="expActual" onchange="toggleActual()">
                                    Actualmente trabajo aquí
                                </label>
                            </div>
                            <div class="tray-fg">
                                <label>Descripción</label>
                                <textarea id="expDesc" placeholder="Describe tus actividades y logros..." maxlength="2000" oninput="charCheck(this,'errExpDesc')"></textarea>
                                <span class="tray-err" id="errExpDesc"></span>
                            </div>
                            <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addExperiencia()">
                                <div class="spinner"></div>
                                <span class="btn-label">Agregar</span>
                            </button>
                        </div>
                        <div class="item-list" id="listExperiencias">
                            <div class="empty-state">Cargando...</div>
                        </div>
                    </div>

                    {{-- Tab: Formación --}}
                    <div class="tray-pane" id="pane-formacion">
                        <div class="tray-form">
                            <div class="tray-form-title">Agregar formación académica</div>
                            <div class="tray-fg">
                                <label>Institución <span class="req">*</span></label>
                                <input type="text" id="forInstitucion" placeholder="Universidad / Instituto / Colegio..." maxlength="200" oninput="charCheck(this,'errForInstitucion')">
                                <span class="tray-err" id="errForInstitucion">La institución es obligatoria.</span>
                            </div>
                            <div class="tray-fg">
                                <label>Título / Grado</label>
                                <input type="text" id="forTitulo" placeholder="Ej: Ingeniería en Sistemas..." maxlength="200" oninput="charCheck(this,'errForTitulo')">
                                <span class="tray-err" id="errForTitulo"></span>
                            </div>
                            <div class="tray-row">
                                <div class="tray-fg">
                                    <label>Fecha inicio <span class="req">*</span></label>
                                    <input type="date" id="forInicio" onchange="checkFormFecha()">
                                    <span class="tray-err" id="errForInicio">La fecha de inicio es obligatoria.</span>
                                </div>
                                <div class="tray-fg">
                                    <label>Fecha fin</label>
                                    <input type="date" id="forFin" onchange="checkFormFecha()">
                                    <span class="tray-err" id="errForFin">La fecha fin no puede ser anterior al inicio.</span>
                                </div>
                            </div>
                            <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addFormacion()">
                                <div class="spinner"></div>
                                <span class="btn-label">Agregar</span>
                            </button>
                        </div>
                        <div class="item-list" id="listFormaciones">
                            <div class="empty-state">Cargando...</div>
                        </div>
                    </div>

                    {{-- Tab: Certificaciones --}}
                    <div class="tray-pane" id="pane-certificacion">
                        <div class="tray-form">
                            <div class="tray-form-title">Agregar certificación</div>
                            <div class="tray-fg">
                                <label>Nombre del certificado <span class="req">*</span></label>
                                <input type="text" id="certNombre" placeholder="Ej: AWS Certified Developer, Scrum Master..." maxlength="200" oninput="charCheck(this,'errCertNombre')">
                                <span class="tray-err" id="errCertNombre">El nombre es obligatorio.</span>
                            </div>
                            <div class="tray-row">
                                <div class="tray-fg">
                                    <label>Organización emisora</label>
                                    <input type="text" id="certOrg" placeholder="Ej: Amazon, Coursera, UMSS..." maxlength="200" oninput="charCheck(this,'errCertOrg')">
                                    <span class="tray-err" id="errCertOrg"></span>
                                </div>
                                <div class="tray-fg">
                                    <label>Fecha de obtención</label>
                                    <input type="date" id="certFecha">
                                </div>
                            </div>
                            <div class="tray-fg">
                                <label>Descripción</label>
                                <textarea id="certDesc" placeholder="Describe brevemente el certificado, habilidades validadas, etc." maxlength="1000" oninput="charCheck(this,'errCertDesc')"></textarea>
                                <span class="tray-err" id="errCertDesc"></span>
                            </div>
                            <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addCertificacion()">
                                <div class="spinner"></div>
                                <span class="btn-label">Agregar</span>
                            </button>
                        </div>
                        <div class="item-list" id="listCertificaciones">
                            <div class="empty-state">Cargando...</div>
                        </div>
                    </div>

                </div>{{-- end tray-body --}}
            </div>
        </div>

        {{-- Mini-modal confirmación borrar --}}
        <div class="del-overlay" id="delOverlay">
            <div class="modal" style="max-width:360px">
                <div class="modal-ico red">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                </div>
                <h3>¿Eliminar este registro?</h3>
                <p>Esta acción no se puede deshacer.</p>
                <div class="modal-actions">
                    <button class="btn-cancel" onclick="cerrarDelOverlay()">Cancelar</button>
                    <button class="btn-danger" id="btnConfirmDel" onclick="confirmarDel()">Sí, eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <img src="{{ asset('images/InfinityCode.jpeg') }}" alt="Logo Footer" class="footer-logo">
            <p><b>Infinity Code</b> © 2026 Infinity Code. Todos los derechos reservados.</p>
        </div>
    </footer>
</div>

<script>
    // Valores originales para cancelar
    const original = {
        nombre:    '{{ addslashes($usuario->nombre ?? '') }}',
        apellido:  '{{ addslashes($usuario->apellido ?? '') }}',
        profesion: '{{ addslashes($usuario->profesion ?? '') }}',
        biografia: `{{ addslashes($usuario->biografia ?? '') }}`,
    };

    let pendingFormData = null;

    // --- Contador de biografía ---
    function updateCounter() {
        const ta  = document.getElementById('fBiografia');
        const cnt = document.getElementById('bioCounter');
        const btn = document.getElementById('btnSave');
        const err = document.getElementById('errBiografia');
        const len = ta.value.length;
        const rem = 1000 - len;

        cnt.textContent = len + ' / 1000';
        if (rem < 0) {
            cnt.classList.add('over');
            cnt.textContent = rem + ' caracteres';
            btn.disabled = true;
            err.textContent = 'La biografía supera el límite de 1000 caracteres.';
            err.classList.add('show');
        } else {
            cnt.classList.remove('over');
            btn.disabled = false;
            err.textContent = '';
            err.classList.remove('show');
        }
        updatePreview();
    }

    // --- Preview en tiempo real ---
    function updatePreview() {
        document.getElementById('prevName').textContent =
            (document.getElementById('fNombre').value || '') + ' ' +
            (document.getElementById('fApellido').value || '');
        document.getElementById('prevProf').textContent =
            document.getElementById('fProfesion').value || 'Sin profesión';
        document.getElementById('prevBio').textContent =
            document.getElementById('fBiografia').value || 'Sin biografía.';
    }

    ['fNombre','fApellido','fProfesion'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
    });

    // --- Toggle vista previa ---
    function togglePreview() {
        const card = document.getElementById('previewCard');
        const btn  = document.getElementById('btnPreview');
        updatePreview();
        card.classList.toggle('show');
        btn.classList.toggle('active');
        btn.innerHTML = card.classList.contains('show')
            ? '<svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round"><line x1="1" y1="1" x2="23" y2="23"/><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/></svg> Ocultar Preview'
            : '<svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Vista Previa';
    }

    // --- Foto de perfil ---
    function handlePhoto(input) {
        const file     = input.files[0];
        const errEl    = document.getElementById('photoError');
        const preview  = document.getElementById('photoPreview');
        const initials = document.getElementById('photoInitials');

        errEl.style.display = 'none';
        errEl.textContent   = '';

        if (!file) return;

        // Formato
        const allowed = ['image/jpeg','image/jpg','image/png'];
        if (!allowed.includes(file.type)) {
            errEl.textContent   = 'Formato no soportado. Solo JPG/PNG.';
            errEl.style.display = 'block';
            input.value = '';
            return;
        }

        // Tamaño (2MB)
        if (file.size > 2 * 1024 * 1024) {
            errEl.textContent   = 'La imagen no puede pesar más de 2MB.';
            errEl.style.display = 'block';
            input.value = '';
            return;
        }

        // Previsualizar
        const reader = new FileReader();
        reader.onload = e => {
            const src  = e.target.result;
            const wrap = document.querySelector('.photo-wrap');

            // Foto en el card
            let img = document.getElementById('photoPreview');
            if (!img) {
                img = document.createElement('img');
                img.id        = 'photoPreview';
                img.className = 'photo-avatar';
                img.alt       = '';
                wrap.insertBefore(img, wrap.firstChild);
            }
            img.src           = src;
            img.style.display = 'block';
            if (initials) initials.style.display = 'none';

            // Vista previa
            document.getElementById('prevAv').innerHTML = '<img src="' + src + '" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';

            // Sidebar
            document.getElementById('sidebarAv').innerHTML = '<img src="' + src + '" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
        };
        reader.readAsDataURL(file);
    }

    // --- Validación front-end ---
    function validateForm() {
        let valid = true;

        const fields = [
            { id: 'fNombre',   err: 'errNombre',   msg: 'El nombre es obligatorio.' },
            { id: 'fApellido', err: 'errApellido',  msg: 'El apellido es obligatorio.' },
            { id: 'fProfesion',err: 'errProfesion', msg: 'La profesión es obligatoria.' },
        ];

        fields.forEach(f => {
            const el  = document.getElementById(f.id);
            const err = document.getElementById(f.err);
            if (!el.value.trim()) {
                el.classList.add('error');
                err.textContent = f.msg;
                err.classList.add('show');
                valid = false;
            } else if (!charCheck(el, f.err)) {
                valid = false;
            } else {
                el.classList.remove('error');
                err.classList.remove('show');
            }
        });

        // Biografía
        const bio    = document.getElementById('fBiografia');
        const errBio = document.getElementById('errBiografia');
        if (bio.value.trim() === '') {
            errBio.textContent = 'La biografía no puede estar vacía.';
            errBio.classList.add('show');
            bio.classList.add('error');
            valid = false;
        } else if (!charCheck(bio, 'errBiografia')) {
            valid = false;
        } else if (bio.value.length <= 1000) {
            errBio.classList.remove('show');
            bio.classList.remove('error');
        }

        return valid;
    }

    // --- Envío con fetch (permite reintento) ---
    function submitPerfil() {
        if (!validateForm()) return;

        const btn = document.getElementById('btnSave');
        btn.classList.add('loading');
        btn.disabled = true;
        document.getElementById('alertRetry').style.display = 'none';

        const form = document.getElementById('perfilForm');
        pendingFormData = new FormData(form);

        sendRequest(pendingFormData, btn);
    }

    function sendRequest(formData, btn) {
        fetch('{{ route("perfil.update") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData,
        })
        .then(res => {
            if (!res.ok) throw new Error('Server error ' + res.status);
            return res.text();
        })
        .then(() => {
            window.location.href = '{{ route("perfil") }}?updated=1';
        })
        .catch(() => {
            btn.classList.remove('loading');
            btn.disabled = false;
            document.getElementById('alertRetry').style.display = 'flex';
        });
    }

    function retrySubmit() {
        if (!pendingFormData) return;
        const btn = document.getElementById('btnSave');
        btn.classList.add('loading');
        btn.disabled = true;
        document.getElementById('alertRetry').style.display = 'none';
        sendRequest(pendingFormData, btn);
    }

    // --- Cancelar edición ---
    function cancelarEdicion() {
        document.getElementById('fNombre').value    = original.nombre;
        document.getElementById('fApellido').value  = original.apellido;
        document.getElementById('fProfesion').value = original.profesion;
        document.getElementById('fBiografia').value = original.biografia;

        // Limpiar errores
        ['fNombre','fApellido','fProfesion','fBiografia'].forEach(id => {
            document.getElementById(id).classList.remove('error');
        });
        ['errNombre','errApellido','errProfesion','errBiografia'].forEach(id => {
            document.getElementById(id).classList.remove('show');
        });

        updateCounter();
        updatePreview();
    }

    // Mostrar éxito desde URL param
    if (new URLSearchParams(location.search).get('updated') === '1') {
        const a = document.createElement('div');
        a.className = 'alert alert-success';
        a.innerHTML = '<svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:#15803d;stroke-width:2"><path d="M20 6L9 17l-5-5"/></svg> Perfil actualizado correctamente.';
        document.querySelector('.main-inner').prepend(a);
        history.replaceState({}, '', '{{ route("perfil") }}');
    }

    // Inicializar contador
    updateCounter();

    // --- Modales ---
    function abrirModalGuardar() {
        if (!validateForm()) return;
        document.getElementById('modalGuardar').classList.add('show');
    }

    function abrirModalDesactivar() {
        document.getElementById('modalDesactivar').classList.add('show');
    }

    function cerrarModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    // Cerrar modal al click fuera
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('show');
        });
    });

    // --- Desactivar cuenta ---
    function desactivarCuenta() {
        cerrarModal('modalDesactivar');
        fetch('{{ route("perfil.desactivar") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        }).then(() => window.location.href = '/home');
    }

    // ===================== RESTRICCIÓN DE CARACTERES =====================
    const CHARS_PROHIBIDOS = /[<>";\`\\{}]/;
    const MSG_CHARS = 'Carácter no permitido: < > " ; ` \\ { }';

    function charCheck(inputEl, errId) {
        const errEl = errId ? document.getElementById(errId) : null;
        if (CHARS_PROHIBIDOS.test(inputEl.value)) {
            inputEl.classList.add('error');
            if (errEl) { errEl.textContent = MSG_CHARS; errEl.classList.add('show'); }
            return false;
        }
        // Solo limpia si el mensaje actual era el de caracteres (no sobreescribir errores de requerido)
        if (errEl && errEl.textContent === MSG_CHARS) {
            errEl.textContent = '';
            errEl.classList.remove('show');
            inputEl.classList.remove('error');
        }
        return true;
    }

    function camposConCaracteresInvalidos(ids) {
        // Recibe array de {inputId, errId} y retorna true si alguno tiene chars prohibidos
        return ids.some(({ inputId, errId }) => {
            const el = document.getElementById(inputId);
            return el ? !charCheck(el, errId) : false;
        });
    }

    // ===================== TRAYECTORIA =====================

    const CSRF = () => document.querySelector('meta[name="csrf-token"]').content;
    let starValue = 0;
    let trayData  = { habilidades: [], experiencias: [], formaciones: [], certificaciones: [] };
    let pendingDel = null; // { type, id }
    let lastTrayAction = null; // para reintento

    // Sugerencias de habilidades
    const SUGERENCIAS = [
        'JavaScript','TypeScript','Python','Java','C#','C++','PHP','Go','Rust','Swift',
        'Kotlin','Ruby','Scala','R','MATLAB','Dart','Flutter','React','Vue','Angular',
        'Node.js','Laravel','Django','Spring Boot','ASP.NET','MySQL','PostgreSQL','MongoDB',
        'Redis','Docker','Kubernetes','AWS','Azure','GCP','Git','Linux','Figma',
        'Adobe XD','Photoshop','Illustrator','SQL','HTML','CSS','Tailwind CSS','Bootstrap',
        'GraphQL','REST APIs','Machine Learning','Deep Learning','Data Science','Excel','Power BI'
    ];

    function abrirTrayectoria() {
        document.getElementById('modalTrayectoria').classList.add('show');
        cargarTrayectoria();
    }

    function cargarTrayectoria() {
        fetch('/trayectoria', { headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                trayData = data;
                renderHabilidades();
                renderExperiencias();
                renderFormaciones();
                renderCertificaciones();
            })
            .catch(() => mostrarAlertaTray());
    }

    // --- TABS ---
    function switchTab(tab) {
        document.querySelectorAll('.tray-tab').forEach((t, i) => {
            const names = ['habilidades','experiencia','formacion','certificacion'];
            t.classList.toggle('active', names[i] === tab);
        });
        document.querySelectorAll('.tray-pane').forEach(p => p.classList.remove('active'));
        document.getElementById('pane-' + tab).classList.add('active');
        ocultarAlertaTray();
    }

    // --- ALERTAS ---
    function mostrarAlertaTray() {
        document.getElementById('trayAlert').classList.add('show');
    }
    function ocultarAlertaTray() {
        document.getElementById('trayAlert').classList.remove('show');
    }
    function retryTray() {
        ocultarAlertaTray();
        if (lastTrayAction) lastTrayAction();
    }

    // --- AUTOCOMPLETE ---
    function acFilter(val) {
        const drop = document.getElementById('acDrop');
        if (!val.trim()) { drop.style.display = 'none'; return; }
        const matches = SUGERENCIAS.filter(s => s.toLowerCase().startsWith(val.toLowerCase()) && s.toLowerCase() !== val.toLowerCase());
        if (!matches.length) { drop.style.display = 'none'; return; }
        drop.innerHTML = matches.slice(0, 8).map(m =>
            `<div class="ac-item" onmousedown="selectAc('${m}')">${m}</div>`
        ).join('');
        drop.style.display = 'block';
    }
    function selectAc(val) {
        document.getElementById('habNombre').value = val;
        document.getElementById('acDrop').style.display = 'none';
    }
    function closeAc() {
        document.getElementById('acDrop').style.display = 'none';
    }

    // --- STARS ---
    function setStar(n) {
        starValue = n;
        document.querySelectorAll('.star').forEach(s => {
            s.classList.toggle('on', parseInt(s.dataset.v) <= n);
        });
        const labels = {1:'Principiante',2:'Principiante',3:'Intermedio',4:'Avanzado',5:'Avanzado'};
        document.getElementById('nivelLabel').textContent = n + ' ★ — ' + labels[n];
        document.getElementById('errHabNivel').classList.remove('show');
    }

    function nivelFromStars(n) {
        if (n <= 2) return 'principiante';
        if (n === 3) return 'intermedio';
        return 'avanzado';
    }

    // --- HABILIDADES ---
    function addHabilidad() {
        const nombre = document.getElementById('habNombre').value.trim();
        let valid = true;

        document.getElementById('errHabNombre').classList.remove('show');
        document.getElementById('errHabDup').classList.remove('show');
        document.getElementById('errHabNivel').classList.remove('show');

        if (!nombre) { document.getElementById('errHabNombre').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('habNombre'), 'errHabNombre')) { valid = false; }
        if (!starValue) { document.getElementById('errHabNivel').classList.add('show'); valid = false; }
        if (!valid) return;

        const nivel = nivelFromStars(starValue);
        const btn = document.querySelector('#pane-habilidades .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const action = () => fetch('/trayectoria/habilidades', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ nombre, nivel }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status === 422 && body.error) {
                document.getElementById('errHabDup').textContent = body.error;
                document.getElementById('errHabDup').classList.add('show');
                return;
            }
            if (status !== 201) throw new Error();
            trayData.habilidades.push(body);
            trayData.habilidades.sort((a,b) => a.nombre.localeCompare(b.nombre));
            renderHabilidades();
            document.getElementById('habNombre').value = '';
            starValue = 0;
            document.querySelectorAll('.star').forEach(s => s.classList.remove('on'));
            document.getElementById('nivelLabel').textContent = '1-2 ★ Principiante · 3 ★ Intermedio · 4-5 ★ Avanzado';
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function renderHabilidades() {
        const list = document.getElementById('listHabilidades');
        if (!trayData.habilidades.length) {
            list.innerHTML = '<div class="empty-state">Aún no tienes habilidades registradas.</div>';
            return;
        }
        const badge = { principiante: 'badge-p', intermedio: 'badge-i', avanzado: 'badge-a' };
        const label = { principiante: 'Principiante', intermedio: 'Intermedio', avanzado: 'Avanzado' };
        list.innerHTML = trayData.habilidades.map(h => `
            <div class="item-card">
                <div class="item-card-body">
                    <strong>${escH(h.nombre)}</strong>
                    <span class="item-badge ${badge[h.nivel] || 'badge-p'}">${label[h.nivel] || h.nivel}</span>
                </div>
                <button class="btn-del-item" onclick="pedirDel('habilidades',${h.id})">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                </button>
            </div>`).join('');
    }

    // --- EXPERIENCIA ---
    function toggleActual() {
        const chk = document.getElementById('expActual');
        const fg  = document.getElementById('fgExpFin');
        if (chk.checked) {
            fg.innerHTML = `<label>Fecha fin</label><input type="text" value="Presente" disabled style="background:#f0f2f8;color:var(--muted)">`;
        } else {
            fg.innerHTML = `<label>Fecha fin</label><input type="date" id="expFin" onchange="checkFechaCoherencia()"><span class="tray-err" id="errExpFin">La fecha fin no puede ser anterior al inicio.</span>`;
        }
    }

    function checkFechaCoherencia() {
        const ini = document.getElementById('expInicio')?.value;
        const fin = document.getElementById('expFin')?.value;
        const err = document.getElementById('errExpFin');
        if (ini && fin && fin < ini) {
            err?.classList.add('show');
        } else {
            err?.classList.remove('show');
        }
    }

    function checkFormFecha() {
        const ini = document.getElementById('forInicio')?.value;
        const fin = document.getElementById('forFin')?.value;
        const err = document.getElementById('errForFin');
        if (ini && fin && fin < ini) {
            err?.classList.add('show');
        } else {
            err?.classList.remove('show');
        }
    }

    function addExperiencia() {
        const empresa  = document.getElementById('expEmpresa').value.trim();
        const cargo    = document.getElementById('expCargo').value.trim();
        const inicio   = document.getElementById('expInicio').value;
        const actual   = document.getElementById('expActual').checked;
        const fin      = actual ? null : document.getElementById('expFin')?.value || null;
        const desc     = document.getElementById('expDesc').value.trim();

        let valid = true;
        ['errExpEmpresa','errExpCargo','errExpInicio','errExpFin'].forEach(id => {
            document.getElementById(id)?.classList.remove('show');
        });
        if (!empresa) { document.getElementById('errExpEmpresa').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('expEmpresa'), 'errExpEmpresa')) { valid = false; }
        if (!cargo)   { document.getElementById('errExpCargo').classList.add('show');   valid = false; }
        else if (!charCheck(document.getElementById('expCargo'), 'errExpCargo')) { valid = false; }
        if (!inicio)  { document.getElementById('errExpInicio').classList.add('show');  valid = false; }
        if (fin && inicio && fin < inicio) { document.getElementById('errExpFin')?.classList.add('show'); valid = false; }
        if (desc && !charCheck(document.getElementById('expDesc'), 'errExpDesc')) { valid = false; }
        if (!valid) return;

        const btn = document.querySelector('#pane-experiencia .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const action = () => fetch('/trayectoria/experiencias', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ empresa, cargo, fecha_inicio: inicio, fecha_fin: fin, actual, descripcion: desc }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status !== 201) throw new Error(JSON.stringify(body));
            trayData.experiencias.unshift(body);
            renderExperiencias();
            ['expEmpresa','expCargo','expInicio','expDesc'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('expActual').checked = false;
            toggleActual();
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function renderExperiencias() {
        const list = document.getElementById('listExperiencias');
        if (!trayData.experiencias.length) {
            list.innerHTML = '<div class="empty-state">Aún no tienes experiencias registradas.</div>';
            return;
        }
        list.innerHTML = trayData.experiencias.map(e => {
            const finLabel = e.actual ? 'Presente' : (e.fecha_fin ? e.fecha_fin.substring(0,7) : '');
            const periodo  = e.fecha_inicio ? e.fecha_inicio.substring(0,7) + (finLabel ? ' — ' + finLabel : '') : '';
            return `
            <div class="item-card">
                <div class="item-card-body">
                    <strong>${escH(e.cargo)} · ${escH(e.empresa)}</strong>
                    <span>${escH(periodo)}</span>
                    ${e.descripcion ? `<p>${escH(e.descripcion)}</p>` : ''}
                </div>
                <button class="btn-del-item" onclick="pedirDel('experiencias',${e.id})">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                </button>
            </div>`;
        }).join('');
    }

    // --- FORMACIÓN ---
    function addFormacion() {
        const inst   = document.getElementById('forInstitucion').value.trim();
        const titulo = document.getElementById('forTitulo').value.trim();
        const inicio = document.getElementById('forInicio').value;
        const fin    = document.getElementById('forFin').value || null;

        let valid = true;
        ['errForInstitucion','errForInicio','errForFin'].forEach(id => document.getElementById(id)?.classList.remove('show'));
        if (!inst)  { document.getElementById('errForInstitucion').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('forInstitucion'), 'errForInstitucion')) { valid = false; }
        if (!inicio){ document.getElementById('errForInicio').classList.add('show');      valid = false; }
        if (fin && inicio && fin < inicio) { document.getElementById('errForFin').classList.add('show'); valid = false; }
        if (titulo && !charCheck(document.getElementById('forTitulo'), 'errForTitulo')) { valid = false; }
        if (!valid) return;

        const btn = document.querySelector('#pane-formacion .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const action = () => fetch('/trayectoria/formaciones', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ institucion: inst, titulo: titulo || null, fecha_inicio: inicio, fecha_fin: fin }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status !== 201) throw new Error();
            trayData.formaciones.unshift(body);
            renderFormaciones();
            ['forInstitucion','forTitulo','forInicio','forFin'].forEach(id => document.getElementById(id).value = '');
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function renderFormaciones() {
        const list = document.getElementById('listFormaciones');
        if (!trayData.formaciones.length) {
            list.innerHTML = '<div class="empty-state">Aún no tienes formaciones registradas.</div>';
            return;
        }
        list.innerHTML = trayData.formaciones.map(f => {
            const finLabel = f.fecha_fin ? f.fecha_fin.substring(0,7) : 'En curso';
            const periodo  = f.fecha_inicio ? f.fecha_inicio.substring(0,7) + ' — ' + finLabel : '';
            return `
            <div class="item-card">
                <div class="item-card-body">
                    <strong>${escH(f.institucion)}</strong>
                    ${f.titulo ? `<span>${escH(f.titulo)}</span>` : ''}
                    <span style="margin-top:2px">${escH(periodo)}</span>
                </div>
                <button class="btn-del-item" onclick="pedirDel('formaciones',${f.id})">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                </button>
            </div>`;
        }).join('');
    }

    // --- CERTIFICACIONES ---
    function addCertificacion() {
        const nombre = document.getElementById('certNombre').value.trim();
        const org    = document.getElementById('certOrg').value.trim();
        const fecha  = document.getElementById('certFecha').value || null;
        const desc   = document.getElementById('certDesc').value.trim();

        let valid = true;
        ['errCertNombre','errCertOrg','errCertDesc'].forEach(id => document.getElementById(id)?.classList.remove('show'));

        if (!nombre) { document.getElementById('errCertNombre').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('certNombre'), 'errCertNombre')) { valid = false; }
        if (org   && !charCheck(document.getElementById('certOrg'),  'errCertOrg'))  { valid = false; }
        if (desc  && !charCheck(document.getElementById('certDesc'), 'errCertDesc')) { valid = false; }
        if (!valid) return;

        const btn = document.querySelector('#pane-certificacion .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const action = () => fetch('/trayectoria/certificaciones', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ nombre, organizacion: org || null, fecha_obtencion: fecha, descripcion: desc || null }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status !== 201) throw new Error();
            trayData.certificaciones.unshift(body);
            renderCertificaciones();
            ['certNombre','certOrg','certFecha','certDesc'].forEach(id => document.getElementById(id).value = '');
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function renderCertificaciones() {
        const list = document.getElementById('listCertificaciones');
        if (!trayData.certificaciones.length) {
            list.innerHTML = '<div class="empty-state">Aún no tienes certificaciones registradas.</div>';
            return;
        }
        list.innerHTML = trayData.certificaciones.map(c => {
            const fecha = c.fecha_obtencion ? c.fecha_obtencion.substring(0, 7) : '';
            return `
            <div class="item-card">
                <div class="item-card-body">
                    <strong>${escH(c.nombre)}</strong>
                    ${c.organizacion ? `<span>${escH(c.organizacion)}</span>` : ''}
                    ${fecha ? `<span style="margin-top:2px">${escH(fecha)}</span>` : ''}
                    ${c.descripcion ? `<p>${escH(c.descripcion)}</p>` : ''}
                </div>
                <button class="btn-del-item" onclick="pedirDel('certificaciones',${c.id})">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                </button>
            </div>`;
        }).join('');
    }

    // --- ELIMINAR ---
    function pedirDel(type, id) {
        pendingDel = { type, id };
        document.getElementById('delOverlay').classList.add('show');
    }
    function cerrarDelOverlay() {
        pendingDel = null;
        document.getElementById('delOverlay').classList.remove('show');
    }
    function confirmarDel() {
        if (!pendingDel) return;
        const { type, id } = pendingDel;
        cerrarDelOverlay();
        ocultarAlertaTray();

        const action = () => fetch('/trayectoria/' + type + '/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        })
        .then(r => { if (!r.ok) throw new Error(); return r.json(); })
        .then(() => {
            trayData[type] = trayData[type].filter(x => x.id !== id);
            if (type === 'habilidades')     renderHabilidades();
            if (type === 'experiencias')    renderExperiencias();
            if (type === 'formaciones')     renderFormaciones();
            if (type === 'certificaciones') renderCertificaciones();
        })
        .catch(() => { lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    // Click fuera del del-overlay
    document.getElementById('delOverlay').addEventListener('click', function(e) {
        if (e.target === this) cerrarDelOverlay();
    });

    // --- Utilidad escape HTML ---
    function escH(str) {
        if (!str) return '';
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
</script>
</body>
</html>
