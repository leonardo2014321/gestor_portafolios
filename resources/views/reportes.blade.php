<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - SansiFolios</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --navy:#0f172a;--navy2:#1e2d50;--blue:#2563eb;--blue2:#3b82f6;
            --teal:#0d9488;--red:#dc2626;--white:#fff;--gray:#f0f2f8;
            --gray2:#e2e8f0;--gray3:#cbd5e1;--text:#1e293b;--muted:#64748b;
            --sw:200px;--hh:64px;
        }
        html,body{height:100%;font-family:"DM Sans",sans-serif;background:var(--gray);color:var(--text);overflow:hidden}
        .app{display:flex;flex-direction:column;height:100vh}

        /* Topbar */
        .topbar{height:var(--hh);background:var(--navy);display:flex;align-items:center;justify-content:space-between;padding:0 28px;flex-shrink:0;border-bottom:1px solid rgba(255,255,255,0.06)}
        .tb-left{display:flex;align-items:center;gap:12px}
        .logo-img{width:44px;height:44px;object-fit:contain;border-radius:8px;background:rgba(255,255,255,0.08);padding:2px}
        .sysname{font-family:"Plus Jakarta Sans",sans-serif;font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px}
        .sysname span{color:#f87171}
        .tb-nav{display:flex;align-items:center;gap:28px}
        .tb-link{font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);text-decoration:none;transition:color .2s;font-family:"DM Sans",sans-serif}
        .tb-link:hover{color:#fff}
        .tb-right{display:flex;align-items:center;gap:10px}

        /* Body row */
        .body-row{flex:1;display:flex;overflow:hidden}

        /* Sidebar */
        aside{width:var(--sw);background:var(--navy);flex-shrink:0;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,0.06)}
        .sb-top{padding:14px 0;flex:1}
        .sb-item{display:flex;align-items:center;gap:11px;padding:10px 20px;cursor:pointer;color:#8ba5c8;font-size:13px;font-weight:400;transition:all .18s;border-left:3px solid transparent;font-family:"DM Sans",sans-serif;text-decoration:none;background:none;border-top:none;border-right:none;border-bottom:none;width:100%;text-align:left;}
        .sb-item:hover{background:rgba(255,255,255,0.05);color:#c8d8ef;transform:translateX(4px)}
        .sb-item.active{background:rgba(37,99,235,0.18);color:#fff;border-left-color:#3b82f6;font-weight:600}
        .sb-item svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:1.8;flex-shrink:0;stroke-linecap:round;stroke-linejoin:round}
        .sb-div{height:1px;background:rgba(255,255,255,0.06);margin:6px 14px}
        .sb-user-block{padding:12px 16px;display:flex;align-items:center;gap:10px;border-top:1px solid rgba(255,255,255,0.07);margin-top:auto}
        .sb-av{width:36px;height:36px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff}
        .sb-uname{font-size:13px;color:#fff;font-weight:600}
        .sb-uid{font-size:11px;color:#5a7fa0}
        .btn-logout{width:calc(100% - 24px);margin:0 12px 14px;background:rgba(255,255,255,0.05);color:#8ba5c8;border:1px solid rgba(255,255,255,0.1);border-radius:8px;padding:8px 10px;font-size:12.5px;font-family:"DM Sans",sans-serif;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .2s;text-decoration:none}
        .btn-logout:hover{background:rgba(220,38,38,0.15);color:#fca5a5}
        .btn-logout svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        /* Main */
        main{flex:1;overflow-y:auto;background:var(--gray);position:relative;display:flex;flex-direction:column;}
        .main-inner{padding:1.6rem 1.8rem;flex:1;}
        .content-bar{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.4rem}
        .content-title h1{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;color:var(--text)}
        .content-title p{font-size:12.5px;color:var(--muted);margin-top:3px}

        /* Export Button */
        .btn-export{background:var(--blue);color:#fff;border:none;border-radius:9px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:8px;transition:background .2s;box-shadow:0 4px 12px rgba(37,99,235,0.2)}
        .btn-export:hover{background:var(--blue2)}
        .btn-export svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        /* ── CV TEMPLATE ── */
        .cv-wrapper {
            display: flex;
            justify-content: center;
            padding-bottom: 40px;
        }
        .cv-container {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            overflow: hidden;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
        }
        .cv-left {
            width: 35%;
            background-color: #3b82f6;
            color: #fff;
            padding: 30px 25px;
            display: flex;
            flex-direction: column;
        }
        .cv-right {
            width: 65%;
            background-color: #fff;
            padding: 40px 35px;
        }

        /* Left Side */
        .cv-photo-box {
            background-color: #1e293b;
            padding: 15px;
            margin-bottom: 30px;
        }
        .cv-photo {
            width: 100%;
            height: auto;
            border: 3px solid #93c5fd;
            display: block;
            object-fit: cover;
            aspect-ratio: 1;
        }
        .cv-section-left {
            margin-bottom: 30px;
        }
        .cv-title-left {
            font-size: 14px;
            font-weight: 700;
            border-top: 1px solid rgba(255,255,255,0.4);
            border-bottom: 1px solid rgba(255,255,255,0.4);
            padding: 8px 0;
            margin-bottom: 15px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .cv-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        .cv-contact-item svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }
        .cv-list-left {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .cv-list-left li {
            font-size: 11.5px;
            margin-bottom: 8px;
            position: relative;
            padding-left: 12px;
            line-height: 1.4;
        }
        .cv-list-left li::before {
            content: "";
            width: 4px;
            height: 4px;
            background: #fff;
            border-radius: 50%;
            position: absolute;
            left: 0;
            top: 6px;
        }
        .cv-text-left {
            font-size: 11.5px;
            line-height: 1.6;
            text-align: justify;
        }

        /* Right Side */
        .cv-name {
            font-size: 38px;
            font-weight: 800;
            color: #3b82f6;
            line-height: 1.1;
            margin-bottom: 35px;
            font-family: Arial, sans-serif;
        }
        .cv-section-right {
            margin-bottom: 25px;
        }
        .cv-title-right {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            border-bottom: 2px solid #93c5fd;
            padding-bottom: 5px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .cv-list-right {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .cv-list-right li {
            font-size: 12px;
            margin-bottom: 6px;
            position: relative;
            padding-left: 12px;
            line-height: 1.4;
        }
        .cv-list-right li::before {
            content: "";
            width: 4px;
            height: 4px;
            background: #1e293b;
            border-radius: 50%;
            position: absolute;
            left: 0;
            top: 6px;
        }
        .cv-job-container {
            margin-bottom: 15px;
        }
        .cv-job-date {
            font-size: 11px;
            color: #475569;
            margin-bottom: 3px;
        }
        .cv-job-title {
            font-size: 12.5px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }
        .cv-job-desc {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .cv-job-desc li {
            font-size: 12px;
            margin-bottom: 4px;
            position: relative;
            padding-left: 12px;
            line-height: 1.4;
        }
        .cv-job-desc li::before {
            content: "";
            width: 4px;
            height: 4px;
            background: #1e293b;
            border-radius: 50%;
            position: absolute;
            left: 0;
            top: 6px;
        }
        .cv-job-achievements {
            font-size: 12px;
            font-weight: 700;
            margin-top: 6px;
            margin-bottom: 4px;
        }
        
        .cv-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIDIwaDQwTTIwIDB2NDAiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9zdmc+');
            pointer-events: none;
        }

        /* ── Right panel ── */
        .rpanel{width:260px;flex-shrink:0;background:#fff;border-left:1.5px solid var(--gray2);display:flex;flex-direction:column;overflow-y:auto}
        .rp-sec{padding:.9rem 1rem;border-bottom:1px solid #f1f5f9}
        .cal-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
        .cal-month{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;color:var(--text)}
        .cal-navs{display:flex;gap:2px}
        .cal-nav{width:24px;height:24px;border-radius:6px;background:var(--gray);border:none;cursor:pointer;color:var(--muted);font-size:16px;display:flex;align-items:center;justify-content:center;transition:background .15s}
        .cal-nav:hover{background:var(--gray2)}
        .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:1px}
        .cdn{font-size:9.5px;color:var(--muted);text-align:center;padding:3px 0;font-weight:700}
        .cd{font-size:11.5px;text-align:center;padding:4px 2px;border-radius:6px;cursor:pointer;transition:background .15s;color:var(--text);position:relative;}
        .cd:hover{background:var(--gray)}
        .cd.today{background:var(--blue);color:#fff;font-weight:700}
        .cd.other{color:var(--gray3)}
        .cd.ev::after{content:"";position:absolute;bottom:1px;left:50%;transform:translateX(-50%);width:4px;height:4px;border-radius:50%;background:var(--teal)}
        
        .cal-view-selector{margin-left:auto;margin-right:10px;padding:3px 6px;border-radius:6px;border:1px solid var(--gray2);background:#fff;font-size:11px;font-family:"DM Sans",sans-serif;color:var(--text);outline:none;cursor:pointer;}
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

        /* ── Footer ── */
        footer{height:40px;background:var(--navy);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .footer-content{display:flex;align-items:center;justify-content:center;gap:10px}
        .footer-logo{height:20px;width:auto;object-fit:contain;display:block}
        footer p{font-size:11.5px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0}
        footer b{color:#7a9cc0}

        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}

        @media(max-width:1200px){.rpanel{display:none}}
        @media(max-width:992px){
            aside{width:72px}
        }

        /* ── PRINT STYLES ── */
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body {
                background: #fff;
                margin: 0;
                padding: 0;
            }
            .topbar, aside, .rpanel, .content-bar {
                display: none !important;
            }
            main {
                background: #fff;
                padding: 0;
                overflow: visible;
                width: 100%;
            }
            .main-inner {
                padding: 0;
            }
            .cv-wrapper {
                padding-bottom: 0;
                justify-content: flex-start;
            }
            .cv-container {
                box-shadow: none;
                width: 100%;
                min-height: auto;
            }
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
        <nav class="tb-nav">
            <a href="{{ route('inicio') }}" class="tb-link">Inicio</a>
            <a href="{{ route('caracteristicas') }}" class="tb-link">Caracter&iacute;sticas</a>
            <a href="{{ route('portafolios.index') }}" class="tb-link">Portafolios</a>
        </nav>
        <div class="tb-right">
            <div style="display:flex;align-items:center;gap:8px;">
                <div class="sb-av">
                    @if(auth()->check() && auth()->user()->foto_perfil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                    @else
                        {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellido ?? '', 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div style="font-size:13px;color:#fff;font-weight:600;">{{ auth()->check() ? auth()->user()->nombre : 'Usuario' }}</div>
                    <div style="font-size:11px;color:#8ba5c8;">Conectado</div>
                </div>
            </div>
        </div>
    </div>

    <div class="body-row">

        <!-- Sidebar -->
        <aside>
            <div class="sb-top">
                <a href="{{ route('menu') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <span>Men&uacute; principal</span>
                </a>
                <div class="sb-div"></div>
                <a href="{{ route('portafolios.index') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>Portafolios</span>
                </a>
                <a href="{{ route('academico') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    <span>Acad&eacute;mico</span>
                </a>
                <a href="{{ route('reportes') }}" class="sb-item active">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>Reportes</span>
                </a>
                <a href="{{ route('perfil') }}" class="sb-item">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Mi Perfil</span>
                </a>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" id="formLogout">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Cerrar Sesi&oacute;n</span>
                </button>
            </form>
        </aside>

        <!-- Main content -->
        <main>
            <div class="main-inner">
                <div class="content-bar">
                    <div class="content-title">
                        <h1>Reportes y Documentos</h1>
                        <p>Genera y exporta planillas, hojas de vida y curriculum vitae en formato PDF.</p>
                    </div>
                    <div>
                        <button class="btn-export" onclick="window.print()">
                            <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Exportar PDF
                        </button>
                    </div>
                </div>

                <!-- CV TEMPLATE -->
                <div class="cv-wrapper">
                    <div class="cv-container" id="cv-template">
                        <!-- Left Column -->
                        <div class="cv-left" style="position: relative;">
                            <div class="cv-bg-pattern"></div>
                            <div style="position: relative; z-index: 1;">
                                <div class="cv-photo-box">
                                    @if(auth()->check() && auth()->user()->foto_perfil)
                                        <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="Foto" class="cv-photo">
                                    @else
                                        <!-- Placeholder photo simulating the image -->
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop" alt="Foto" class="cv-photo">
                                    @endif
                                </div>

                                <div class="cv-section-left">
                                    <div class="cv-contact-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <span>Avda. de Andaluc&iacute;a, 41,<br>Archidona 29300</span>
                                    </div>
                                    <div class="cv-contact-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                        <span>692 454 731</span>
                                    </div>
                                    <div class="cv-contact-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                        <span>{{ auth()->check() ? auth()->user()->email : 'evasanchezlinares@gmail.com' }}</span>
                                    </div>
                                </div>

                                <div class="cv-section-left">
                                    <div class="cv-title-left">APTITUDES</div>
                                    <ul class="cv-list-left">
                                        <li>Trabajo en equipo.</li>
                                        <li>Iniciativa.</li>
                                        <li>Resoluci&oacute;n de problemas.</li>
                                        <li>Aprendizaje fluido.</li>
                                        <li>Comunicaci&oacute;n efectiva.</li>
                                    </ul>
                                </div>

                                <div class="cv-section-left">
                                    <div class="cv-title-left">RESUMEN PROFESIONAL</div>
                                    <div class="cv-text-left">
                                        @if(auth()->check() && auth()->user()->biografia)
                                            {{ auth()->user()->biografia }}
                                        @else
                                            Programadora web con m&aacute;s de 5 a&ntilde;os de trayectoria desarrolladas en el eCommerce. A lo largo de estos a&ntilde;os, he tenido el privilegio de formar parte en la creaci&oacute;n de webs como geekletics.es y peternappi.es, las cuales han cultivado un gran &eacute;xito, tanto en tr&aacute;fico como en conversiones. Busco formar parte de Gesico Sistemas para mi capacidad creativa al siguiente nivel, aportando mis amplio conocimientos en CSS y Prestashop.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="cv-right">
                            <h1 class="cv-name">
                                @if(auth()->check())
                                    {{ auth()->user()->nombre }}<br>{{ auth()->user()->apellido }}
                                @else
                                    Eva S&aacute;nchez<br>Linares
                                @endif
                            </h1>

                            <div class="cv-section-right">
                                <div class="cv-title-right">IDIOMAS</div>
                                <ul class="cv-list-right">
                                    <li>Ingl&eacute;s C1</li>
                                    <li>Franc&eacute;s B2</li>
                                </ul>
                            </div>

                            <div class="cv-section-right">
                                <div class="cv-title-right">HABILIDADES INFORM&Aacute;TICAS</div>
                                <ul class="cv-list-right">
                                    <li>Programaci&oacute;n con JavaScript, CSS, HTML, C#, SQL.</li>
                                    <li>Conocimientos avanzados de Prestashop.</li>
                                    <li>Manejo de MySQL, MariaDB, Mongodb.</li>
                                    <li>Desarrollo de aplicaciones m&oacute;viles.</li>
                                    <li>Maquetaci&oacute;n CSS.</li>
                                </ul>
                            </div>

                            <div class="cv-section-right">
                                <div class="cv-title-right">CURSOS Y CERTIFICADOS</div>
                                <ul class="cv-list-right">
                                    <li>Programaci&oacute;n avanzada en JavaScript (200 horas) - Edx</li>
                                    <li>Adobe Illustrator para dise&ntilde;o gr&aacute;fico (140 horas) - Domestika</li>
                                </ul>
                            </div>

                            <div class="cv-section-right">
                                <div class="cv-title-right">HISTORIAL LABORAL</div>
                                
                                <div class="cv-job-container">
                                    <div class="cv-job-date">Junio 2017 - Marzo 2020</div>
                                    <div class="cv-job-title">Desarrolladora web eCommerce Hays Response, Zaragoza</div>
                                    <ul class="cv-job-desc">
                                        <li>Maquetaci&oacute;n mediante CSS.</li>
                                        <li>Optimizaci&oacute;n de SEO on page.</li>
                                        <li>Programaci&oacute;n con JavaScript.</li>
                                        <li>Dise&ntilde;o, desarrollo e implementaci&oacute;n de interfaces de BBDD.</li>
                                    </ul>
                                    <div class="cv-job-achievements">Logros clave</div>
                                    <ul class="cv-job-desc">
                                        <li>Incremento en un 30% de media en el tr&aacute;fico de nuestros clientes.</li>
                                        <li>Nominaci&oacute;n en los premios Sodeint por mejor dise&ntilde;o web.</li>
                                    </ul>
                                </div>

                                <div class="cv-job-container">
                                    <div class="cv-job-date">Enero 2015 - Mayo 2016</div>
                                    <div class="cv-job-title">Desarrolladora SharePoint X25 Inform&aacute;tica, Madrid</div>
                                    <ul class="cv-job-desc">
                                        <li>Elaboraci&oacute;n de requisitos funcionales y documentos de especificaciones t&eacute;cnicas.</li>
                                        <li>Desarrollo de aplicaciones web basadas en tecnolog&iacute;as de Sharepoint Framework.</li>
                                        <li>Creaci&oacute;n de componentes para transferir datos seguros entre webs y sistemas internos.</li>
                                        <li>Elaboraci&oacute;n de dise&ntilde;os gr&aacute;ficos con Adobe Photoshop e Illustrator.</li>
                                    </ul>
                                    <div class="cv-job-achievements">Logro Clave</div>
                                    <ul class="cv-job-desc">
                                        <li>Dise&ntilde;o de soluciones SharePoint e Intranets corporativas para m&aacute;s de 10 empresas en expansi&oacute;n.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="cv-section-right" style="margin-bottom: 0;">
                                <div class="cv-title-right">FORMACI&Oacute;N</div>
                                <div class="cv-job-container" style="margin-bottom: 0;">
                                    <div class="cv-job-date" style="color: #1e293b; font-weight: 700; margin-bottom: 2px;">2015</div>
                                    <div style="font-size: 12px;">Grado Superior en Desarrollo de Aplicaciones Web</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            
            <footer>
                <div class="footer-content">
                    <img src="{{ asset('images/InfinityCode.jpeg') }}" alt="Logo Footer" class="footer-logo">
                    <p><b>Infinity Code</b> &copy; 2026 Infinity Code. Todos los derechos reservados.</p>
                </div>
            </footer>
        </main>

        <!-- Right panel -->
        <div class="rpanel">
            <div class="rp-sec">
                <div class="cal-hd" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                    <div class="cal-month" id="cal-title" style="flex:1;">Abril 2026</div>
                    <select class="cal-view-selector" id="cal-view-sel" style="margin:0;">
                        <option value="dias">D&iacute;as</option>
                        <option value="semanas">Semanas</option>
                        <option value="meses">Meses</option>
                        <option value="anios">A&ntilde;os</option>
                    </select>
                    <div class="cal-navs">
                        <button class="cal-nav">‹</button>
                        <button class="cal-nav">›</button>
                    </div>
                </div>
                <div id="cal-grid-container">
                    <div class="cal-grid" id="cal-grid">
                        <div class="cdn">Do</div><div class="cdn">Lu</div><div class="cdn">Ma</div>
                        <div class="cdn">Mi</div><div class="cdn">Ju</div><div class="cdn">Vi</div><div class="cdn">S&aacute;</div>
                        <!-- Dummy days -->
                        <div class="cd other">26</div><div class="cd other">27</div><div class="cd other">28</div><div class="cd other">29</div><div class="cd other">30</div><div class="cd holiday">1</div><div class="cd">2</div>
                        <div class="cd">3</div><div class="cd">4</div><div class="cd today">5</div><div class="cd">6</div><div class="cd">7</div><div class="cd">8</div><div class="cd">9</div>
                        <div class="cd">10</div><div class="cd">11</div><div class="cd">12</div><div class="cd">13</div><div class="cd">14</div><div class="cd">15</div><div class="cd">16</div>
                        <div class="cd">17</div><div class="cd">18</div><div class="cd">19</div><div class="cd">20</div><div class="cd">21</div><div class="cd">22</div><div class="cd">23</div>
                        <div class="cd">24</div><div class="cd">25</div><div class="cd">26</div><div class="cd holiday">27</div><div class="cd">28</div><div class="cd">29</div><div class="cd">30</div>
                        <div class="cd">31</div>
                    </div>
                </div>
            </div>
            <div class="rp-sec">
                <div class="rp-ttl">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Notific. actualizaci&oacute;n
                </div>
                <div class="notif">
                    <div class="ni-icon green"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div>
                    <div><div class="ntxt">Nueva actualizaci&oacute;n disponible</div></div>
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
</div>
</body>
</html>
