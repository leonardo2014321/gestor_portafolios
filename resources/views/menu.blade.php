<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SansiFolios - UMSS' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

        :root{
          --navy:#1a2340;
          --navy2:#1e2d50;
          --blue:#2563eb;
          --blue2:#3b82f6;
          --teal:#0d9488;
          --teal2:#0f766e;
          --red:#dc2626;
          --white:#fff;
          --gray:#f0f2f8;
          --gray2:#e2e5ea;
          --gray3:#cbd5e1;
          --text:#1e293b;
          --muted:#64748b;
          --sw:190px;
          --hh:72px;
        }

        html,body{
            height:100%;
            font-family:"DM Sans",sans-serif;
            background:var(--gray);
            color:var(--text);
            overflow:hidden
        }

        .app{display:flex;flex-direction:column;height:100vh}

        /* Topbar */
        .topbar{
          height:var(--hh);
          background:var(--navy);
          display:flex;align-items:center;justify-content:space-between;
          padding:0 28px;flex-shrink:0;
          border-bottom:3px solid #0f1729;
          box-shadow:0 2px 12px rgba(0,0,0,0.25);
        }
        .tb-left{display:flex;align-items:center;gap:14px}
        .logo-img{width:52px;height:52px;object-fit:contain;border-radius:6px;background:rgba(255,255,255,0.08);padding:2px}
        .sysname{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;color:#fff;letter-spacing:-0.5px}
        .sysname span{color:#f87171}
        .bar-right{display:flex;align-items:center;gap:15px;color:white}
        .icon-bell{background:transparent;border:none;display:flex;align-items:center;justify-content:center}
        .icon-bell svg{width:20px;height:20px;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round}
        .sb-user{border:none;padding:0;display:flex;align-items:center;gap:10px}
        .sb-av{width:38px;height:38px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff}
        .sb-uname{font-size:14px;color:#fff;font-weight:600;text-align:right}
        .sb-uid{font-size:11px;color:#8ba5c8;text-align:right}

        /* Body row */
        .body-row{flex:1;display:flex;overflow:hidden}

        /* Sidebar */
        aside{
          width:var(--sw);background:var(--navy);flex-shrink:0;
          display:flex;flex-direction:column;
          border-right:1px solid rgba(255,255,255,0.05);
        }
        .sb-top{padding:16px 0;flex:1}
        .sb-item{
          display:flex;align-items:center;gap:11px;padding:11px 20px;cursor:pointer;
          color:#8ba5c8;font-size:13.5px;font-weight:400;transition:all .2s;
          border-left:3px solid transparent;font-family:"DM Sans",sans-serif;
          text-decoration:none;background:none;border-top:none;border-right:none;border-bottom:none;
          width:100%;
        }
        .sb-item:hover{background:rgba(255,255,255,0.06);color:#c8d8ef}
        .sb-item.active{background:rgba(37,99,235,0.2);color:#fff;border-left-color:var(--blue2);font-weight:600}
        .sb-item svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;flex-shrink:0;stroke-linecap:round;stroke-linejoin:round}
        .sb-div{height:1px;background:rgba(255,255,255,0.07);margin:6px 12px}
        .sb-user-block{padding:12px 16px;display:flex;align-items:center;gap:10px;border-top:1px solid rgba(255,255,255,0.07)}
        .btn-logout{
          width:calc(100% - 24px);margin:0 12px 12px;background:rgba(255,255,255,0.05);
          color:#8ba5c8;border:1px solid rgba(255,255,255,0.1);border-radius:7px;
          padding:8px 10px;font-size:12.5px;font-family:"DM Sans",sans-serif;
          cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .2s;text-decoration:none
        }
        .btn-logout:hover{background:rgba(220,38,38,0.15);color:#fca5a5}
        .btn-logout svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        /* Main */
        main{flex:1;overflow-y:auto;background:var(--gray);position:relative}
        .main-inner{padding:1.4rem 1.6rem}

        /* Vista: oculta/visible */
        .view{display:none}
        .view.active{display:block}

        .content-bar{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.4rem}
        .content-title h1{font-family:"Plus Jakarta Sans",sans-serif;font-size:24px;font-weight:800;color:var(--text)}
        .content-title p{font-size:12.5px;color:var(--muted);margin-top:3px}

        /* Stats */
        .stats{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1.4rem}
        .stat{border-radius:14px;padding:1.1rem 1.3rem;display:flex;align-items:center;gap:14px}
        .stat.s-blue{background:linear-gradient(135deg,#1d4ed8,#2563eb);color:#fff;box-shadow:0 4px 16px rgba(37,99,235,0.3)}
        .stat.s-white{background:#fff;border:1.5px solid var(--gray2);color:var(--text)}
        .stat.s-teal{background:linear-gradient(135deg,#ccfbf1,#a7f3d0);color:#0f766e}
        .stat-ico{width:44px;height:44px;border-radius:10px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .stat.s-white .stat-ico{background:rgba(37,99,235,0.08)}
        .stat.s-teal .stat-ico{background:rgba(13,148,136,0.15)}
        .stat-ico svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .stat-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:30px;font-weight:800;line-height:1}
        .stat-lbl{font-size:13px;opacity:.85;margin-top:2px;font-weight:500}

        .sec-lbl{font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);display:flex;align-items:center;gap:7px;margin-bottom:1rem}
        .sec-lbl svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2}

        .pgrid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
        .pcard{border-radius:14px;padding:1rem 1.2rem;display:flex;flex-direction:column;gap:12px}
        .pcard.cn{background:linear-gradient(140deg,#1e2d50,#1a2340);color:#fff;box-shadow:0 4px 16px rgba(26,35,64,0.25)}
        .pcard-top{display:flex;align-items:flex-start;gap:11px}
        .pcard-ico{width:38px;height:38px;border-radius:9px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .pcard-ico svg{width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .pcard-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:14.5px;font-weight:700}
        .pcard-sub{font-size:11px;opacity:.6;margin-top:2px}
        .pcard-bot{display:flex;align-items:center;justify-content:space-between}
        .pcard-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:23px;font-weight:800;line-height:1}
        .pcard-num small{font-size:11px;font-weight:600;opacity:.6;margin-left:2px}
        .pcard-st{font-size:10.5px;opacity:.7;display:flex;align-items:center;gap:4px;margin-top:3px}
        .dot{width:7px;height:7px;border-radius:50%;display:inline-block;flex-shrink:0}
        .dg{background:#4ade80}
        .btn-ver{background:rgba(255,255,255,0.18);color:#fff;border:1.5px solid rgba(255,255,255,0.3);border-radius:8px;padding:7px 18px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;transition:all .2s;text-decoration:none}
        .btn-ver:hover{background:rgba(255,255,255,0.3)}

        /* ═══════════════════════════════
           EXPLORADOR STYLES
        ═══════════════════════════════ */
        .exp-hero{
          background:linear-gradient(135deg,#1340b0 0%,#1a56db 60%,#3b82f6 100%);
          padding:1.6rem 2rem 2.2rem;
          border-radius:16px;
          margin-bottom:1.4rem;
          position:relative;
          overflow:hidden;
        }
        .exp-hero::after{
          content:'';position:absolute;right:-40px;bottom:-60px;
          width:220px;height:220px;border-radius:50%;
          background:rgba(255,255,255,0.06);
        }
        .exp-hero-title{font-family:"Plus Jakarta Sans",sans-serif;font-size:20px;font-weight:800;color:#fff;line-height:1.2}
        .exp-hero-sub{font-size:12px;color:rgba(255,255,255,.7);margin-top:3px}
        .exp-search-wrap{display:flex;align-items:center;gap:10px;margin-top:1.2rem;max-width:600px;position:relative;z-index:1}
        .exp-search-box{flex:1;display:flex;align-items:center;background:#fff;border-radius:9px;padding:0 14px;height:42px;box-shadow:0 2px 12px rgba(0,0,0,.15)}
        .exp-search-box svg{color:#9ca3af;flex-shrink:0;width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2}
        .exp-search-box input{flex:1;border:none;outline:none;font-family:"DM Sans",sans-serif;font-size:13.5px;color:var(--text);background:transparent;padding-left:9px}
        .exp-search-box input::placeholder{color:#9ca3af}
        .btn-buscar{height:42px;padding:0 20px;background:#fff;color:#1a56db;border:none;border-radius:9px;font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;font-size:13.5px;cursor:pointer;transition:background .2s;white-space:nowrap}
        .btn-buscar:hover{background:#f0f2f8}

        /* Filter tabs */
        .exp-filters{display:flex;align-items:center;gap:8px;margin-bottom:1rem}
        .exp-filter{padding:6px 16px;border-radius:999px;font-family:"Plus Jakarta Sans",sans-serif;font-weight:600;font-size:13px;border:1.5px solid var(--gray2);cursor:pointer;transition:all .18s;background:#fff;color:var(--muted)}
        .exp-filter:hover{border-color:var(--blue);color:var(--blue)}
        .exp-filter.active{background:var(--blue);color:#fff;border-color:var(--blue)}

        /* Results bar */
        .exp-results-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
        .exp-count{font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.06em}
        .exp-sort{display:flex;align-items:center;gap:5px;font-size:13px;font-family:"DM Sans",sans-serif;color:var(--muted);background:none;border:none;cursor:pointer}
        .exp-sort svg{width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2}

        /* Cards grid */
        .exp-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}

        .exp-card{
          background:#fff;border-radius:14px;padding:16px;
          box-shadow:0 2px 8px rgba(0,0,0,.07);
          border:1px solid var(--gray2);
          display:flex;flex-direction:column;gap:10px;
          position:relative;overflow:hidden;
          transition:box-shadow .2s,transform .2s;
        }
        .exp-card:hover{box-shadow:0 6px 20px rgba(26,86,219,.12);transform:translateY(-2px)}
        .exp-card::after{content:'';position:absolute;right:0;bottom:0;width:80px;height:55px;background:linear-gradient(135deg,transparent 50%,rgba(26,86,219,.06) 50%);border-top-left-radius:55px}

        .exp-card-type{font-size:10px;font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--blue)}
        .exp-card-top{display:flex;align-items:flex-start;gap:10px}
        .exp-avatar{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;font-size:14px;color:#fff;flex-shrink:0}
        .av-blue{background:#1a56db}.av-green{background:#059669}.av-orange{background:#d97706}.av-teal{background:#0891b2}

        .exp-card-title{font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;font-size:13.5px;color:var(--text);line-height:1.3}
        .exp-card-title mark{background:rgba(26,86,219,.12);color:var(--blue);border-radius:3px;padding:0 1px}
        .exp-card-desc{font-size:12px;color:var(--muted);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .exp-card-actions{display:flex;align-items:center;justify-content:space-between}

        .exp-tags{display:flex;flex-wrap:wrap;gap:5px}
        .exp-tag{padding:3px 9px;border-radius:999px;font-size:10px;font-family:"Plus Jakarta Sans",sans-serif;font-weight:600;background:#e8edf5;color:#374151}

        .exp-icons{display:flex;align-items:center;gap:7px}
        .exp-icon-btn{width:27px;height:27px;border-radius:7px;border:1px solid var(--gray2);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);transition:all .15s}
        .exp-icon-btn:hover{border-color:var(--blue);color:var(--blue)}
        .exp-icon-btn svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        .trend-icon{position:absolute;right:12px;bottom:10px;opacity:.13}
        .trend-icon svg{width:34px;height:22px}

        /* Panel derecho */
        .rpanel{width:250px;flex-shrink:0;background:#fff;border-left:1.5px solid var(--gray2);display:flex;flex-direction:column;overflow-y:auto}
        .rp-sec{padding:.9rem 1rem;border-bottom:1px solid #f1f5f9}
        .cal-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
        .cal-month{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;color:var(--text)}
        .cal-navs{display:flex;gap:2px}
        .cal-nav{width:24px;height:24px;border-radius:6px;background:var(--gray);border:none;cursor:pointer;color:var(--muted);font-size:16px;display:flex;align-items:center;justify-content:center;transition:background .15s}
        .cal-nav:hover{background:var(--gray2)}
        .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:1px}
        .cdn{font-size:9.5px;color:var(--muted);text-align:center;padding:3px 0;font-weight:700}
        .cd{font-size:11.5px;text-align:center;padding:4px 2px;border-radius:6px;cursor:pointer;transition:background .15s;color:var(--text)}
        .cd:hover{background:var(--gray)}
        .cd.today{background:var(--blue);color:#fff;font-weight:700}
        .cd.other{color:var(--gray3)}
        .cd.ev{position:relative}
        .cd.ev::after{content:"";position:absolute;bottom:1px;left:50%;transform:translateX(-50%);width:3px;height:3px;border-radius:50%;background:var(--teal)}
        .rp-ttl{font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--muted);margin-bottom:9px;display:flex;align-items:center;gap:6px}
        .rp-ttl svg{width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round}
        .notif{display:flex;align-items:flex-start;gap:9px;padding:7px 0;border-bottom:1px solid #f8fafc}
        .notif:last-child{border:none}
        .ni-icon{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .ni-icon.green{background:#dcfce7}.ni-icon.blue{background:#dbeafe}
        .ni-icon svg{width:13px;height:13px;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
        .ni-icon.green svg{stroke:#16a34a}.ni-icon.blue svg{stroke:#2563eb}
        .ntxt{font-size:12px;color:var(--text);line-height:1.35;font-weight:500}
        .ntime{font-size:10px;color:var(--muted);margin-top:1px}
        .enlace{display:flex;align-items:center;gap:10px;padding:7px 0;border-bottom:1px solid #f8fafc;cursor:pointer;transition:opacity .15s;text-decoration:none}
        .enlace:hover{opacity:.75}.enlace:last-child{border:none}
        .en-ico{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .en-ico.yellow{background:#fef3c7}.en-ico.blue{background:#dbeafe}.en-ico.gray{background:var(--gray)}
        .en-ico svg{width:14px;height:14px;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .en-ico.yellow svg{stroke:#d97706}.en-ico.blue svg{stroke:#2563eb}.en-ico.gray svg{stroke:var(--muted)}
        .en-lbl{font-size:13px;font-weight:500;color:var(--text)}

        /* Footer */
        footer{height:44px;background:var(--navy);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .footer-content{display:flex;align-items:center;justify-content:center;gap:10px}
        .footer-logo{height:22px;width:auto;object-fit:contain;display:block}
        footer p{font-size:12px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0}
        footer b{color:#7a9cc0}

        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}

        @media(max-width:1200px){.rpanel{display:none}}
        @media(max-width:992px){
          aside{width:78px}
          .sb-item span,.sb-uname,.sb-uid,.btn-logout span{display:none}
          .sb-item{justify-content:center;padding:13px 10px}
          .sb-user-block{justify-content:center}
          .btn-logout{justify-content:center}
          .stats,.pgrid,.exp-grid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
<div class="app">

    <!-- Topbar -->
    <div class="topbar">
        <div class="tb-left">
            <img class="logo-img" src="{{ asset('images/logo.png') }}" alt="UMSS">
            <div class="sysname">Sansi<span>Folios</span></div>
        </div>
        <div class="bar-right">
            <div class="icon-bell">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div class="sb-user">
                <div class="sb-av">
                    @if(auth()->user()->foto_perfil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                    @else
                        {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="sb-uname">{{ auth()->user()->nombre }}</div>
                    <div class="sb-uid">Conectado</div>
                </div>
            </div>
        </div>
    </div>

    <div class="body-row">

        <!-- Sidebar -->
        <aside>
            <div class="sb-top">

                <button class="sb-item" id="btn-menu" onclick="showView('menu')">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <span>Menú principal</span>
                </button>

                <div class="sb-div"></div>
<<<<<<< Updated upstream

                <a href="{{ route('portafolios.index') }}" class="sb-item {{ request()->routeIs('portafolios.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>Portafolios</span>
                </a>

                <!-- Explorador: abre panel inline -->
=======
                
>>>>>>> Stashed changes
                <button class="sb-item" id="btn-explorador" onclick="showView('explorador')">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <span>Explorador</span>
                </button>

                <a href="{{ route('academico') }}" class="sb-item {{ request()->routeIs('academico') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    <span>Académico</span>
                </a>

                <a href="{{ route('reportes') }}" class="sb-item {{ request()->routeIs('reportes') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>Reportes</span>
                </a>

                <a href="{{ route('perfil') }}" class="sb-item {{ request()->routeIs('perfil') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Mi Perfil</span>
                </a>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </aside>

        <!-- Área central -->
        <main>
            <div class="main-inner">

                <!-- ══════════════════════════════
                     VISTA: MENÚ PRINCIPAL
                ══════════════════════════════ -->
                <div class="view active" id="view-menu">
                    <div class="content-bar">
                        <div class="content-title">
                            <h1>Sistema de Portafolios</h1>
                            <p>Gestión institucional de activos digitales - UMSS</p>
                        </div>
                    </div>

                    <div class="stats">
                        <div class="stat s-blue">
                            <div class="stat-ico">
                                <svg viewBox="0 0 24 24" stroke="#fff"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                            </div>
                            <div>
                                <div class="stat-num">{{ $totalPortafolios ?? 0 }}</div>
                                <div class="stat-lbl">Portafolios</div>
                            </div>
                        </div>
                        <div class="stat s-white">
                            <div class="stat-ico">
                                <svg viewBox="0 0 24 24" stroke="#2563eb"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div>
                                <div class="stat-num">{{ $totalDocumentos ?? 0 }}</div>
                                <div class="stat-lbl">Documentos</div>
                            </div>
                        </div>
                        <div class="stat s-teal">
                            <div class="stat-ico">
                                <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                            </div>
                            <div>
                                <div class="stat-num">{{ $totalAprobados ?? 0 }}</div>
                                <div class="stat-lbl">Aprobados</div>
                            </div>
                        </div>
                    </div>

                    <div class="sec-lbl">
                        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        Documentos recientes
                    </div>

                    @if(isset($portafolios) && $portafolios->count() > 0)
                    <div class="pgrid">
                        @foreach($portafolios as $portafolio)
                        <div class="pcard cn">
                            <div class="pcard-top">
                                <div class="pcard-ico">
                                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                </div>
                                <div>
                                    <div class="pcard-name">{{ $portafolio->nombre }}</div>
                                    <div class="pcard-sub">{{ $portafolio->descripcion ?? '' }}</div>
                                </div>
                            </div>
                            <div class="pcard-bot">
                                <div>
                                    <div class="pcard-num">0 <small>ITEMS</small></div>
                                    <div class="pcard-st"><span class="dot dg"></span> Activo</div>
                                </div>
                                <a href="#" class="btn-ver">Ver Panel</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div style="text-align:center;padding:3rem 1rem;color:var(--muted)">
                        <svg viewBox="0 0 24 24" style="width:48px;height:48px;fill:none;stroke:var(--gray3);stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;margin:0 auto 1rem;display:block"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                        <p style="font-size:15px;font-weight:600;color:var(--text);margin-bottom:6px">Sin portafolios aún</p>
                        <p style="font-size:13px">Crea tu primer portafolio para comenzar.</p>
                        <a href="{{ route('portafolios.index') }}" style="display:inline-block;margin-top:1rem;padding:9px 22px;background:var(--blue);color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none">Crear portafolio</a>
                    </div>
                    @endif
                </div>

                <!-- ══════════════════════════════
                     VISTA: EXPLORADOR
                ══════════════════════════════ -->
                <div class="view" id="view-explorador">

                    <!-- Hero con buscador -->
                    <div class="exp-hero">
                        <div class="exp-hero-title">Sistema de Portafolios</div>
                        <div class="exp-hero-sub">Gestión Institucional de Activos Digitales · UMSS</div>
                        <div class="exp-search-wrap">
                            <div class="exp-search-box">
                                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input type="text" id="expSearch" placeholder="Buscar..." oninput="expFilter()"/>
                            </div>
                            <button class="btn-buscar" onclick="expFilter()">Buscar</button>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="exp-filters">
                        <button class="exp-filter active" onclick="expSetFilter(this,'todos')">Todos</button>
                        <button class="exp-filter" onclick="expSetFilter(this,'proyecto')">Proyectos</button>
                        <button class="exp-filter" onclick="expSetFilter(this,'documento')">Documentos</button>
                        <button class="exp-filter" onclick="expSetFilter(this,'habilidad')">Habilidades</button>
                    </div>

                    <!-- Barra de resultados -->
                    <div class="exp-results-bar">
                        <span class="exp-count" id="expCount">4 Resultados Encontrados</span>
                        <button class="exp-sort">
                            Ordenar por relevancia
                            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>

                    <!-- Grid de tarjetas -->
                    <div class="exp-grid" id="expGrid"></div>
                </div>

            </div>
        </main>

         <!-- Panel derecho -->
        <div class="rpanel">
            <div class="rp-sec">
                <div class="cal-hd">
                    <div class="cal-month" id="cal-title">Abril 2026</div>
                    <div class="cal-navs">
                        <button class="cal-nav" onclick="changeMonth(-1)">‹</button>
                        <button class="cal-nav" onclick="changeMonth(1)">›</button>
                    </div>
                </div>
                <div class="cal-grid" id="cal-grid">
                    <div class="cdn">Do</div><div class="cdn">Lu</div><div class="cdn">Ma</div>
                 <div class="cdn">Mi</div><div class="cdn">Ju</div><div class="cdn">Vi</div><div class="cdn">Sá</div>
                </div>
            </div>

            <div class="rp-sec">
                <div class="rp-ttl">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Notific. actualización
                </div>
                <div class="notif">
                    <div class="ni-icon green"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div>
                    <div><div class="ntxt">Nueva actualización disponible</div></div>
                </div>
                <div class="notif">
                    <div class="ni-icon blue"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                    <div><div class="ntxt">Informe mensual subido</div><div class="ntime">13:10</div></div>
                </div>
            </div>

            <div class="rp-sec">
                <div class="rp-ttl">
                    <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 1 7.54.54l3 3a5 5 0 0 1-7.07 7.07l-1.72-1.71"/><path d="M14 11a5 5 0 0 1-7.54-.54l-3-3A5 5 0 0 1 10.54.39l1.71 1.71"/></svg>
                    Enlaces
                </div>
                <a href="#" class="enlace"><div class="en-ico yellow"><svg viewBox="0 0 24 24"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div><div class="en-lbl">Repositorio</div></a>
                <a href="#" class="enlace"><div class="en-ico gray"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div><div class="en-lbl">Ayuda</div></a>
                <a href="#" class="enlace"><div class="en-ico blue"><svg viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg></div><div class="en-lbl">Portal UMSS</div></a>
                <a href="#" class="enlace"><div class="en-ico blue"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div><div class="en-lbl">Aula Virtual</div></a>
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

<!-- Modal detalle del día -->
<div id="modalDia" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:999;align-items:center;justify-content:center;">
  <div style="width:440px;background:#fff;border-radius:32px;overflow:hidden;max-height:90vh;overflow-y:auto;">

    <div style="display:flex;align-items:flex-start;justify-content:space-between;padding:28px 28px 0;">
      <div>
        <div style="font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:#64748b;margin-bottom:4px;">Detalle del día</div>
        <div id="modalFecha" style="font-size:24px;font-weight:700;color:#171c1f;"></div>
      </div>
      <button onclick="cerrarModal()" style="width:36px;height:36px;border-radius:50%;border:1px solid #e2e8f0;background:transparent;cursor:pointer;font-size:16px;color:#64748b;">✕</button>
    </div>

    <!-- Lista de eventos -->
    <div style="display:flex;flex-direction:column;gap:10px;padding:20px 28px 0;" id="listaEventos"></div>

    <!-- Formulario nuevo evento -->
    <div style="padding:16px 28px 0;">
      <div style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#64748b;margin-bottom:10px;">Nuevo evento</div>
      <input id="nuevoEventoInput" type="text" placeholder="Nombre del evento..."
        style="width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid #e2e8f0;font-family:'DM Sans',sans-serif;font-size:13px;outline:none;margin-bottom:8px;">
      <input id="nuevoEventoHora" type="text" placeholder="Hora (ej: 10:00 AM)"
        style="width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid #e2e8f0;font-family:'DM Sans',sans-serif;font-size:13px;outline:none;">
    </div>

    <div style="display:flex;gap:12px;padding:16px 28px 28px;">
      <button onclick="cerrarModal()" style="flex:1;padding:14px;border-radius:14px;border:1px solid #e2e8f0;background:transparent;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">Cerrar</button>
      <button onclick="agregarEvento()" style="flex:1.3;display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:14px;border:none;background:#0049db;color:#fff;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="12" x2="12" y1="14" y2="18"/><line x1="10" x2="14" y1="16" y2="16"/></svg>
        Agregar evento
      </button>
    </div>
  </div>
</div>

<script>
    /* ══ Vista switcher ══ */


    const months_es = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
let eventos = JSON.parse(localStorage.getItem('eventos') || '{}');
let modalDia = null, modalMes = null, modalAnio = null;

function guardarEventos() {
    localStorage.setItem('eventos', JSON.stringify(eventos));
}

function keyFecha(d, m, y) { return `${y}-${m}-${d}`; }

function abrirModal(dia, mes, anio) {
    modalDia = dia; modalMes = mes; modalAnio = anio;
    document.getElementById('modalFecha').textContent = dia + ' de ' + months_es[mes] + ', ' + anio;
    document.getElementById('nuevoEventoInput').value = '';
    document.getElementById('nuevoEventoHora').value = '';
    renderEventosModal();
    const modal = document.getElementById('modalDia');
    modal.style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modalDia').style.display = 'none';
}

function renderEventosModal() {
    const key = keyFecha(modalDia, modalMes, modalAnio);
    const lista = eventos[key] || [];
    const container = document.getElementById('listaEventos');
    if (lista.length === 0) {
        container.innerHTML = `
            <div style="display:flex;flex-direction:column;align-items:center;padding:18px;border-radius:20px;border:2px dashed #e2e8f0;gap:4px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="16"/><line x1="8" x2="16" y1="12" y2="12"/></svg>
                <span style="font-size:10px;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;color:#94a3b8;">Sin eventos</span>
            </div>`;
        return;
    }
    container.innerHTML = lista.map((ev, i) => `
        <div style="display:flex;align-items:flex-start;gap:14px;padding:14px;background:#f0f4f8;border-radius:4px 20px 20px 4px;border-left:4px solid #0049db;">
            <div style="width:34px;height:34px;border-radius:10px;background:#e8eefb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0049db" stroke-width="2" stroke-linecap="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:600;color:#171c1f;">${ev.nombre}</div>
                ${ev.hora ? `<div style="display:flex;align-items:center;gap:5px;color:#64748b;margin-top:4px;"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><span style="font-size:12px;">${ev.hora}</span></div>` : ''}
            </div>
            <button onclick="eliminarEvento(${i})" style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;border-radius:6px;display:flex;align-items:center;" title="Eliminar">
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
    guardarEventos();
    renderEventosModal();
    renderCal();
    document.getElementById('nuevoEventoInput').value = '';
    document.getElementById('nuevoEventoHora').value = '';
}

function eliminarEvento(idx) {
    const key = keyFecha(modalDia, modalMes, modalAnio);
    eventos[key].splice(idx, 1);
    if (eventos[key].length === 0) delete eventos[key];
    guardarEventos();
    renderEventosModal();
    renderCal();
}

    function showView(name) {
        document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
        document.getElementById('view-' + name).classList.add('active');

        document.querySelectorAll('.sb-item').forEach(b => b.classList.remove('active'));
        document.getElementById('btn-' + name).classList.add('active');

        // scroll al tope
        document.querySelector('main').scrollTop = 0;
    }

    /* ══ Explorador data ══ */
    const expCards = [
        { type:"PROYECTO", avClass:"av-blue",   avLetter:"P", title:"Programa de Optimización Fiscal 2024",    desc:"Iniciativa estratégica para la mejora de flujos de caja institucionales haciendo el aprovechamiento avanzado de herramientas.", tags:["#FINANCE","#FISCAL","#STRATEGY"], cat:"proyecto" },
        { type:"PROYECTO", avClass:"av-green",  avLetter:"P", title:"Programa de Desarrollo Ambiental 2020",   desc:"Iniciativa estratégica para la mejora del desarrollo ambiental en la gestión de políticas de sostenibilidad.",                tags:["#FINANCE","#LIFE","#STRATEGY"],   cat:"proyecto" },
        { type:"HABILIDAD",avClass:"av-orange", avLetter:"H", title:"Programación en PHP / Symfony",           desc:"Capacidad funcional en el desarrollo de frameworks para diseño y sistemas de gestión lógica.",                              tags:["#PHP","#BACKEND"],                cat:"habilidad", hasUsers:true },
        { type:"DOCUMENTO",avClass:"av-teal",   avLetter:"D", title:"Protocolos de Seguridad Interna V2",      desc:"Documentación técnica sobre buenas prácticas en encriptación y manejo de datos digitales.",                                 tags:["#SECURITY","#PDF"],               cat:"documento" },
    ];

    let expActiveFilter = 'todos';

    function expHL(text) {
        const q = document.getElementById('expSearch').value.trim();
        if (!q) return text;
        const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi');
        return text.replace(re, '<mark>$1</mark>');
    }

    function expRender(cards) {
        const cnt = document.getElementById('expCount');
        cnt.textContent = `${cards.length} Resultado${cards.length!==1?'s':''} Encontrado${cards.length!==1?'s':''}`;

        document.getElementById('expGrid').innerHTML = cards.map(c => `
            <div class="exp-card">
                <div class="exp-card-type">${c.type}</div>
                <div class="exp-card-top">
                    <div class="exp-avatar ${c.avClass}">${c.avLetter}</div>
                    <div class="exp-card-title">${expHL(c.title)}</div>
                </div>
                <div class="exp-card-desc">${c.desc}</div>
                <div class="exp-card-actions">
                    <div class="exp-tags">${c.tags.map(t=>`<span class="exp-tag">${t}</span>`).join('')}</div>
                    <div class="exp-icons">
                        ${c.hasUsers ? `<div style="display:flex;align-items:center"><div style="width:18px;height:18px;border-radius:50%;background:#1a56db;border:2px solid #fff"></div><div style="width:18px;height:18px;border-radius:50%;background:#059669;border:2px solid #fff;margin-left:-5px"></div></div>` : ''}
                        <button class="exp-icon-btn" title="Guardar"><svg viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg></button>
                        <button class="exp-icon-btn" title="Descargar"><svg viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg></button>
                    </div>
                </div>
                <div class="trend-icon"><svg viewBox="0 0 38 26" fill="none" stroke="#1a56db" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,20 10,12 16,16 26,6 36,10"/></svg></div>
            </div>`).join('');
    }

    function expFilter() {
        const q = document.getElementById('expSearch').value.toLowerCase();
        const filtered = expCards.filter(c => {
            const matchText = c.title.toLowerCase().includes(q) || c.desc.toLowerCase().includes(q);
            const matchCat  = expActiveFilter === 'todos' || c.cat === expActiveFilter;
            return matchText && matchCat;
        });
        expRender(filtered);
    }

    function expSetFilter(btn, cat) {
        expActiveFilter = cat;
        document.querySelectorAll('.exp-filter').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        expFilter();
    }

    expRender(expCards);

    /* ══ Calendario ══ */
    let cur = new Date();
    function renderCal() {
        const y = cur.getFullYear(), m = cur.getMonth();
        const months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        document.getElementById("cal-title").textContent = months[m] + " " + y;
        const grid = document.getElementById("cal-grid");
        while (grid.children.length > 7) grid.removeChild(grid.lastChild);
        const first = new Date(y,m,1).getDay();
        const days  = new Date(y,m+1,0).getDate();
        const today = new Date();
        const events = [5,12,18,24];
        for (let i=0;i<first;i++){
            const prev = new Date(y,m,0).getDate()-first+i+1;
            const d=document.createElement("div");d.className="cd other";d.textContent=prev;grid.appendChild(d);
        }
        for (let i=1;i<=days;i++){
            const d=document.createElement("div");
            let cls="cd";
            if(y===today.getFullYear()&&m===today.getMonth()&&i===today.getDate()) cls+=" today";
            else if(events.includes(i)) cls+=" ev";
            const k = keyFecha(i, m, y);
if (eventos[k] && eventos[k].length > 0 && !cls.includes('ev')) cls += ' ev';
d.className=cls;d.textContent=i;d.style.cursor='pointer';d.onclick=()=>abrirModal(i,m,y);grid.appendChild(d);
        }
    }
    function changeMonth(dir){cur.setMonth(cur.getMonth()+dir);renderCal();}
    renderCal();

    /* Activar menú principal por defecto */
    document.getElementById('btn-menu').classList.add('active');
</script>
</body>
</html>