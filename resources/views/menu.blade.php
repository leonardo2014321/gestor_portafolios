<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SansiFolios - UMSS' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Reset */
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

        /* Variables por designar*/ 
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
          --gray2:#e2e8f0;
          --gray3:#cbd5e1;
          --text:#1e293b;
          --muted:#64748b;
          --sw:190px;
          --hh:72px;
        }

        /* Base */
        html,body{
            height:100%;
            font-family:"DM Sans",sans-serif;
            background:var(--gray);
            color:var(--text);
            overflow:hidden
        }

        .app{display:flex;flex-direction:column;height:100vh}

        /* Barra superior */
        .topbar{
          height:var(--hh);
          background:var(--navy);
          display:flex;align-items:center;justify-content:space-between;
          padding:0 28px;flex-shrink:0;
          border-bottom:3px solid #0f1729;
          box-shadow:0 2px 12px rgba(0,0,0,0.25);
        }

        .tb-left{display:flex;align-items:center;gap:14px}

        .logo-img{
            width:52px;height:52px;object-fit:contain;border-radius:6px;
            background:rgba(255,255,255,0.08);padding:2px
        }

        .sysname{
            font-family:"Plus Jakarta Sans",sans-serif;
            font-size:26px;font-weight:800;color:#fff;letter-spacing:-0.5px
        }

        .sysname span{color:#f87171}
        .tb-nav{display:flex;align-items:center;gap:24px}

        .tb-link{
          font-size:14px;font-weight:500;color:rgba(255,255,255,0.75);
          cursor:pointer;border:none;background:none;font-family:"DM Sans",sans-serif;
          transition:color .2s;padding:4px 0;text-decoration:none
        }

        .tb-link:hover{color:#fff}

        .btn-session{
          background:var(--blue);color:#fff;border:none;border-radius:8px;
          padding:9px 24px;font-size:14px;font-weight:600;cursor:pointer;
          font-family:"DM Sans",sans-serif;letter-spacing:0.2px;transition:background .2s;
          box-shadow:0 2px 8px rgba(37,99,235,0.4);text-decoration:none;
          display:inline-flex;align-items:center
        }

        .btn-session:hover{background:var(--blue2)}

        /* Contenido principal */
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
          text-decoration:none
        }

        .sb-item:hover{background:rgba(255,255,255,0.06);color:#c8d8ef}

        .sb-item.active{
          background:rgba(37,99,235,0.2);color:#fff;border-left-color:var(--blue2);font-weight:600
        }

        .sb-item svg{
          width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;
          flex-shrink:0;stroke-linecap:round;stroke-linejoin:round
        }

        .sb-div{height:1px;background:rgba(255,255,255,0.07);margin:6px 12px}

        .sb-user{
          padding:12px 16px;display:flex;align-items:center;gap:10px;
          border-top:1px solid rgba(255,255,255,0.07)
        }

        .sb-av{
          width:38px;height:38px;border-radius:50%;overflow:hidden;flex-shrink:0;
          background:linear-gradient(135deg,#3b82f6,#0d9488);
          display:flex;align-items:center;justify-content:center;
          font-size:14px;font-weight:700;color:#fff
        }

        .sb-uname{font-size:13px;color:#fff;font-weight:600}
        .sb-uid{font-size:11px;color:#5a7fa0}

        .btn-logout{
          width:calc(100% - 24px);margin:0 12px 12px;background:rgba(255,255,255,0.05);
          color:#8ba5c8;border:1px solid rgba(255,255,255,0.1);border-radius:7px;
          padding:8px 10px;font-size:12.5px;font-family:"DM Sans",sans-serif;
          cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .2s;
          text-decoration:none
        }

        .btn-logout:hover{background:rgba(220,38,38,0.15);color:#fca5a5}

        .btn-logout svg{
          width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;
          stroke-linecap:round;stroke-linejoin:round
        }

        /* Main */
        main{flex:1;overflow-y:auto;background:var(--gray)}
        .main-inner{padding:1.4rem 1.6rem}
        .content-bar{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.4rem}

        .content-title h1{
            font-family:"Plus Jakarta Sans",sans-serif;
            font-size:24px;font-weight:800;color:var(--text)
        }

        .content-title p{font-size:12.5px;color:var(--muted);margin-top:3px}
        .bar-right{display:flex;align-items:center;gap:8px}

        .search-box{
          display:flex;align-items:center;gap:7px;background:#fff;border:1.5px solid var(--gray2);
          border-radius:9px;padding:8px 14px;box-shadow:0 1px 4px rgba(0,0,0,0.04)
        }

        .search-box svg{width:14px;height:14px;fill:none;stroke:var(--muted);stroke-width:2;flex-shrink:0}
        .search-box input{border:none;outline:none;font-size:13px;color:var(--text);font-family:"DM Sans",sans-serif;width:110px;background:transparent}

        .icon-bell{
          width:38px;height:38px;border-radius:9px;background:#fff;border:1.5px solid var(--gray2);
          display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.04)
        }

        .icon-bell svg{width:15px;height:15px;fill:none;stroke:var(--muted);stroke-width:2;stroke-linecap:round}

        .btn-cerrar{
          background:#fff;color:var(--text);border:1.5px solid var(--gray2);border-radius:8px;
          padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;font-family:"DM Sans",sans-serif;
          box-shadow:0 1px 4px rgba(0,0,0,0.04);text-decoration:none;display:inline-flex;align-items:center
        }

        /* Tarjetas resumen */
        .stats{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1.4rem}

        .stat{border-radius:14px;padding:1.1rem 1.3rem;display:flex;align-items:center;gap:14px}
        .stat.s-blue{background:linear-gradient(135deg,#1d4ed8,#2563eb);color:#fff;box-shadow:0 4px 16px rgba(37,99,235,0.3)}
        .stat.s-white{background:#fff;border:1.5px solid var(--gray2);color:var(--text)}
        .stat.s-teal{background:linear-gradient(135deg,#ccfbf1,#a7f3d0);color:#0f766e}

        .stat-ico{
          width:44px;height:44px;border-radius:10px;background:rgba(255,255,255,0.2);
          display:flex;align-items:center;justify-content:center;flex-shrink:0
        }

        .stat.s-white .stat-ico{background:rgba(37,99,235,0.08)}
        .stat.s-teal .stat-ico{background:rgba(13,148,136,0.15)}

        .stat-ico svg{
          width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.8;
          stroke-linecap:round;stroke-linejoin:round
        }

        .stat-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:30px;font-weight:800;line-height:1}
        .stat-lbl{font-size:13px;opacity:.85;margin-top:2px;font-weight:500}

        /* Título de sección */
        .sec-lbl{
          font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;
          color:var(--muted);display:flex;align-items:center;gap:7px;margin-bottom:1rem
        }

        .sec-lbl svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2}

        /* Grid de tarjetas */
        .pgrid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}

        .pcard{border-radius:14px;padding:1rem 1.2rem;display:flex;flex-direction:column;gap:12px}
        .pcard.cn{background:linear-gradient(140deg,#1e2d50,#1a2340);color:#fff;box-shadow:0 4px 16px rgba(26,35,64,0.25)}
        .pcard.ct{background:linear-gradient(140deg,#0f766e,#0d9488);color:#fff;box-shadow:0 4px 16px rgba(13,148,136,0.25)}
        .pcard.cg{background:#fff;border:1.5px solid var(--gray2);color:var(--text)}
        .pcard.cs{background:linear-gradient(140deg,#eff6ff,#dbeafe);color:var(--navy)}

        .pcard-top{display:flex;align-items:flex-start;gap:11px}

        .pcard-ico{
          width:38px;height:38px;border-radius:9px;background:rgba(255,255,255,0.15);
          display:flex;align-items:center;justify-content:center;flex-shrink:0
        }

        .pcard.cg .pcard-ico{background:rgba(37,99,235,0.08)}
        .pcard.cs .pcard-ico{background:rgba(37,99,235,0.1)}

        .pcard-ico svg{
          width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.8;
          stroke-linecap:round;stroke-linejoin:round
        }

        .pcard-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:14.5px;font-weight:700}
        .pcard-sub{font-size:11px;opacity:.6;margin-top:2px}

        .pcard-bot{display:flex;align-items:center;justify-content:space-between}
        .pcard-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:23px;font-weight:800;line-height:1}
        .pcard-num small{font-size:11px;font-weight:600;opacity:.6;margin-left:2px}

        .pcard-st{font-size:10.5px;opacity:.7;display:flex;align-items:center;gap:4px;margin-top:3px}
        .dot{width:7px;height:7px;border-radius:50%;display:inline-block;flex-shrink:0}
        .dg{background:#4ade80}.db{background:#60a5fa}.dy{background:#fbbf24}.dr{background:#f87171}

        .btn-ver{
          background:rgba(255,255,255,0.18);color:#fff;border:1.5px solid rgba(255,255,255,0.3);
          border-radius:8px;padding:7px 18px;font-size:12.5px;font-weight:600;cursor:pointer;
          font-family:"DM Sans",sans-serif;transition:all .2s;text-decoration:none
        }

        .btn-ver:hover{background:rgba(255,255,255,0.3)}
        .btn-ver.dk{background:transparent;color:var(--navy);border-color:var(--gray3)}
        .btn-ver.dk:hover{background:var(--gray2)}

        .pcard-full{
          border-radius:14px;padding:1rem 1.2rem;background:#fff;border:1.5px solid var(--gray2);
          display:flex;align-items:center;gap:14px
        }

        .pcard-full .fi{
          width:38px;height:38px;border-radius:9px;background:rgba(37,99,235,0.08);
          display:flex;align-items:center;justify-content:center;flex-shrink:0
        }

        .pcard-full .fi svg{
          width:17px;height:17px;fill:none;stroke:#2563eb;stroke-width:1.8;
          stroke-linecap:round;stroke-linejoin:round
        }

        /* Panel derecho */
        .rpanel{
          width:250px;flex-shrink:0;background:#fff;border-left:1.5px solid var(--gray2);
          display:flex;flex-direction:column;overflow-y:auto
        }

        .rp-sec{padding:.9rem 1rem;border-bottom:1px solid #f1f5f9}
        .cal-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
        .cal-month{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;color:var(--text)}
        .cal-navs{display:flex;gap:2px}

        .cal-nav{
          width:24px;height:24px;border-radius:6px;background:var(--gray);border:none;cursor:pointer;
          color:var(--muted);font-size:16px;display:flex;align-items:center;justify-content:center;transition:background .15s
        }

        .cal-nav:hover{background:var(--gray2)}
        .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:1px}
        .cdn{font-size:9.5px;color:var(--muted);text-align:center;padding:3px 0;font-weight:700}
        .cd{font-size:11.5px;text-align:center;padding:4px 2px;border-radius:6px;cursor:pointer;transition:background .15s;color:var(--text)}
        .cd:hover{background:var(--gray)}
        .cd.today{background:var(--blue);color:#fff;font-weight:700}
        .cd.other{color:var(--gray3)}
        .cd.ev{position:relative}

        .cd.ev::after{
          content:"";position:absolute;bottom:1px;left:50%;transform:translateX(-50%);
          width:3px;height:3px;border-radius:50%;background:var(--teal)
        }

        .rp-ttl{
          font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;
          color:var(--muted);margin-bottom:9px;display:flex;align-items:center;gap:6px
        }

        .rp-ttl svg{
          width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round
        }

        .notif{display:flex;align-items:flex-start;gap:9px;padding:7px 0;border-bottom:1px solid #f8fafc}
        .notif:last-child{border:none}

        .ni-icon{
          width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0
        }

        .ni-icon.green{background:#dcfce7}
        .ni-icon.blue{background:#dbeafe}

        .ni-icon svg{
          width:13px;height:13px;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round
        }

        .ni-icon.green svg{stroke:#16a34a}
        .ni-icon.blue svg{stroke:#2563eb}

        .ntxt{font-size:12px;color:var(--text);line-height:1.35;font-weight:500}
        .ntime{font-size:10px;color:var(--muted);margin-top:1px}

        .enlace{
          display:flex;align-items:center;gap:10px;padding:7px 0;border-bottom:1px solid #f8fafc;
          cursor:pointer;transition:opacity .15s;text-decoration:none
        }

        .enlace:hover{opacity:.75}
        .enlace:last-child{border:none}

        .en-ico{
          width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0
        }

        .en-ico.yellow{background:#fef3c7}
        .en-ico.blue{background:#dbeafe}
        .en-ico.gray{background:var(--gray)}

        .en-ico svg{
          width:14px;height:14px;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round
        }

        .en-ico.yellow svg{stroke:#d97706}
        .en-ico.blue svg{stroke:#2563eb}
        .en-ico.gray svg{stroke:var(--muted)}

        .en-lbl{font-size:13px;font-weight:500;color:var(--text)}

        /* Footer */
        footer{
          height:44px;
          background:var(--navy);
          display:flex;
          align-items:center;
          justify-content:center;
          flex-shrink:0
        }

        .footer-content{
          display:flex;
          align-items:center;
          justify-content:center;
          gap:10px
        }

        .footer-logo{
          height:22px;
          width:auto;
          object-fit:contain;
          display:block
        }

        footer p{
          font-size:12px;
          color:#5a7fa0;
          display:flex;
          align-items:center;
          gap:6px;
          margin:0
        }

        footer b{color:#7a9cc0}

        /* Scroll */
        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}

        /* Responsive */
        @media (max-width: 1200px){
            .rpanel{display:none}
        }

        @media (max-width: 992px){
            aside{width:78px}
            .sb-item span,.sb-uname,.sb-uid,.btn-logout span{display:none}
            .sb-item{justify-content:center;padding:13px 10px}
            .sb-user{justify-content:center}
            .btn-logout{justify-content:center}
            .stats,.pgrid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
<div class="app">

    <!-- Barra superior -->
   <div class="topbar">
    <div class="tb-left">
        <img class="logo-img" src="{{ asset('images/logo.png') }}" alt="UMSS">
        <div class="sysname">Sansi<span>Folios</span></div>
    </div>

    <div class="bar-right" style="display: flex; align-items: center; gap: 15px; color: white;">
        
        <div class="icon-bell" style="background: transparent; border: none;">
            <svg viewBox="0 0 24 24" style="stroke: #fff;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </div>

        <div class="sb-user" style="border: none; padding: 0;">
            <div class="sb-av">
                @if(auth()->user()->foto_perfil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                @else
                    {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}
                @endif
            </div>
            <div style="text-align: right;">
                <div class="sb-uname" style="font-size: 14px;">{{ auth()->user()->nombre }}</div>
                <div class="sb-uid" style="font-size: 11px; color: #8ba5c8;">Conectado</div>
            </div>
        </div>
    </div>
</div>

    <div class="body-row">

        <!-- Menú lateral -->
        <aside>
            <div class="sb-top">
                <a href="{{ route('menu') }}" class="sb-item {{ request()->routeIs('menu') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <span>Menú principal</span>
                </a>


                
                <div class="sb-div"></div>

                <a href="{{ route('portafolios.index') }}" class="sb-item {{ request()->routeIs('portafolios.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>Portafolios</span>
                </a>
                
                                {{-- EXPLORADOR AGREGADO --}}
<a href="{{ route('explorador') }}" class="sb-item {{ request()->routeIs('explorador') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <span>Explorador</span>
</a>

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
                <div class="content-bar">
                    <div class="content-title">
                        <h1>Sistema de Portafolios</h1>
                        <p>Gestión institucional de activos digitales - UMSS</p>
                    </div>

                    <div class="bar-right">
                        
                    </div>
                </div>

                <!-- Tarjetas -->
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
                    <div class="cdn">Su</div>
                    <div class="cdn">Mo</div>
                    <div class="cdn">Tu</div>
                    <div class="cdn">We</div>
                    <div class="cdn">Th</div>
                    <div class="cdn">Fr</div>
                    <div class="cdn">Sa</div>
                </div>
            </div>

            <div class="rp-sec">
                <div class="rp-ttl">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Notific. actualización
                </div>

                <div class="notif">
                    <div class="ni-icon green">
                        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div>
                        <div class="ntxt">Nueva actualización disponible</div>
                    </div>
                </div>

                <div class="notif">
                    <div class="ni-icon blue">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div>
                        <div class="ntxt">Informe mensual subido</div>
                        <div class="ntime">13:10</div>
                    </div>
                </div>
            </div>

            <div class="rp-sec">
                <div class="rp-ttl">
                    <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 1 7.54.54l3 3a5 5 0 0 1-7.07 7.07l-1.72-1.71"/><path d="M14 11a5 5 0 0 1-7.54-.54l-3-3A5 5 0 0 1 10.54.39l1.71 1.71"/></svg>
                    Enlaces
                </div>

                <a href="#" class="enlace">
                    <div class="en-ico yellow">
                        <svg viewBox="0 0 24 24"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    </div>
                    <div class="en-lbl">Repositorio</div>
                </a>

                <a href="#" class="enlace">
                    <div class="en-ico gray">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <div class="en-lbl">Ayuda</div>
                </a>

                <a href="#" class="enlace">
                    <div class="en-ico blue">
                        <svg viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg>
                    </div>
                    <div class="en-lbl">Portal UMSS</div>
                </a>

                <a href="#" class="enlace">
                    <div class="en-ico blue">
                        <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <div class="en-lbl">Aula Virtual</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <img src="{{ asset('images/InfinityCode.jpeg') }}" alt="Logo Footer" class="footer-logo">
            <p><b>Infinity Code</b> © 2026 Infinity Code. Todos los derechos reservados.</p>
        </div>
    </footer>
</div>

<script>
    let cur = new Date();

    function renderCal() {
        const y = cur.getFullYear();
        const m = cur.getMonth();
        const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

        document.getElementById("cal-title").textContent = months[m] + " " + y;

        const grid = document.getElementById("cal-grid");
        while (grid.children.length > 7) grid.removeChild(grid.lastChild);

        const first = new Date(y, m, 1).getDay();
        const days = new Date(y, m + 1, 0).getDate();
        const today = new Date();
        const events = [5, 12, 18, 24];

        for (let i = 0; i < first; i++) {
            const prev = new Date(y, m, 0).getDate() - first + i + 1;
            const d = document.createElement("div");
            d.className = "cd other";
            d.textContent = prev;
            grid.appendChild(d);
        }

        for (let i = 1; i <= days; i++) {
            const d = document.createElement("div");
            let cls = "cd";

            if (y === today.getFullYear() && m === today.getMonth() && i === today.getDate()) {
                cls += " today";
            } else if (events.includes(i)) {
                cls += " ev";
            }

            d.className = cls;
            d.textContent = i;
            grid.appendChild(d);
        }
    }

    function changeMonth(dir){
        cur.setMonth(cur.getMonth() + dir);
        renderCal();
    }

    renderCal();
</script>
</body>
</html>