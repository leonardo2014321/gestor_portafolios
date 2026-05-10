<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SansiFolios - UMSS' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ══════════════════════════════════════
           RESET & VARIABLES
        ══════════════════════════════════════ */
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
          --navy:#0f172a;
          --navy2:#1e2d50;
          --blue:#2563eb;
          --blue2:#3b82f6;
          --teal:#0d9488;
          --white:#fff;
          --gray:#f1f5f9;
          --gray2:#e2e8f0;
          --gray3:#cbd5e1;
          --text:#0f172a;
          --muted:#64748b;
          --sw:200px;
          --hh:64px;
        }
        html,body{height:100%;font-family:"DM Sans",sans-serif;background:var(--gray);color:var(--text);overflow:hidden}
        .app{display:flex;flex-direction:column;height:100vh}

        /* ══════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════ */
        .topbar{height:var(--hh);background:var(--navy);display:flex;align-items:center;justify-content:space-between;padding:0 28px;flex-shrink:0;border-bottom:1px solid rgba(255,255,255,0.06)}
        .tb-left{display:flex;align-items:center;gap:12px}
        .logo-img{width:44px;height:44px;object-fit:contain;border-radius:8px;background:rgba(255,255,255,0.08);padding:2px}
        .sysname{font-family:"Plus Jakarta Sans",sans-serif;font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px}
        .sysname span{color:#f87171}
        .tb-nav{display:flex;align-items:center;gap:28px}
        .tb-link{font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);text-decoration:none;transition:color .2s}
        .tb-link:hover{color:#fff}
        .tb-right{display:flex;align-items:center;gap:10px}
        .tb-search{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);border-radius:9px;padding:7px 14px;height:36px}
        .tb-search svg{width:14px;height:14px;fill:none;stroke:rgba(255,255,255,0.5);stroke-width:2;flex-shrink:0}
        .tb-search input{border:none;outline:none;background:transparent;font-family:"DM Sans",sans-serif;font-size:13px;color:#fff;width:130px}
        .tb-search input::placeholder{color:rgba(255,255,255,0.4)}
        .tb-bell{width:36px;height:36px;border-radius:9px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;cursor:pointer}
        .tb-bell svg{width:16px;height:16px;fill:none;stroke:rgba(255,255,255,0.7);stroke-width:2;stroke-linecap:round}
        .btn-cerrar-ses{height:36px;padding:0 16px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:9px;color:#fff;font-family:"DM Sans",sans-serif;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;display:flex;align-items:center;transition:background .2s}
        .btn-cerrar-ses:hover{background:rgba(255,255,255,0.16)}

        /* ══════════════════════════════════════
           LAYOUT PRINCIPAL
        ══════════════════════════════════════ */
        .body-row{flex:1;display:flex;overflow:hidden}
        .content-wrapper{flex:1;display:flex;flex-direction:row;overflow:hidden}

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        aside{width:var(--sw);background:#0f172a !important;flex-shrink:0;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,0.06) !important;}
        .sb-item{display:flex;align-items:center;gap:11px;padding:10px 20px;cursor:pointer;color:#8ba5c8;font-size:13px;font-weight:400;transition:all .18s;border-left:3px solid transparent;font-family:"DM Sans",sans-serif;text-decoration:none;background:none;border-top:none;border-right:none;border-bottom:none;width:100%}
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

        /* ══════════════════════════════════════
           MAIN / VISTAS
        ══════════════════════════════════════ */
        main{flex:1;overflow-y:auto;background:var(--gray)}
        .main-inner{padding:1.6rem 1.8rem}
        .view{display:none}
        .view.active{display:block}
        .content-bar{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.4rem}
        .content-title h1{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;color:var(--text)}
        .content-title p{font-size:12.5px;color:var(--muted);margin-top:3px}
        .sec-lbl{font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);display:flex;align-items:center;gap:7px;margin-bottom:1.1rem}
        .sec-lbl svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2}

        /* ══════════════════════════════════════
           STATS
        ══════════════════════════════════════ */
        .stats{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-bottom:1.6rem}
        .stat{border-radius:16px;padding:1.2rem 1.4rem;display:flex;align-items:center;gap:14px}
        .stat.s-blue{background:linear-gradient(135deg,#1d4ed8,#2563eb);color:#fff;box-shadow:0 4px 20px rgba(37,99,235,0.3)}
        .stat.s-white{background:#fff;border:1.5px solid var(--gray2);color:var(--text)}
        .stat.s-teal{background:linear-gradient(135deg,#ccfbf1,#a7f3d0);color:#0f766e}
        .stat-ico{width:46px;height:46px;border-radius:12px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .stat.s-white .stat-ico{background:rgba(37,99,235,0.08)}
        .stat.s-teal .stat-ico{background:rgba(13,148,136,0.15)}
        .stat-ico svg{width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .stat-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:34px;font-weight:800;line-height:1}
        .stat-lbl{font-size:13px;opacity:.8;margin-top:3px;font-weight:500}

        /* ══════════════════════════════════════
           PORTFOLIO CARDS
        ══════════════════════════════════════ */
        .pgrid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
        .dot{width:7px;height:7px;border-radius:50%;display:inline-block;flex-shrink:0}
        .dg{background:#4ade80}.dy{background:#fbbf24}.dr{background:#f87171}

        /* Dark card */
        .pcard-dark{border-radius:16px;padding:1.2rem 1.4rem;background:linear-gradient(140deg,#1e2d50,#0f172a);color:#fff;box-shadow:0 4px 20px rgba(15,23,42,0.25);display:flex;flex-direction:column;gap:14px;height:160px;min-height:160px;max-height:160px;overflow:hidden}
        .pcard-dark .pcard-top{display:flex;align-items:flex-start;gap:12px;flex:1;min-height:0;overflow:hidden}
        .pcard-dark .pcard-ico{width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .pcard-dark .pcard-ico svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .pcard-dark .pcard-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%}
        .pcard-dark .pcard-sub{font-size:11.5px;opacity:.55;margin-top:2px;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
        .pcard-dark .pcard-bot{display:flex;align-items:flex-end;justify-content:space-between;flex-shrink:0}
        .pcard-dark .pcard-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;line-height:1}
        .pcard-dark .pcard-num small{font-size:11px;font-weight:600;opacity:.6;margin-left:3px}
        .pcard-dark .pcard-st{font-size:11px;opacity:.65;display:flex;align-items:center;gap:5px;margin-top:4px}
        .btn-ver{background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.25);border-radius:10px;padding:8px 20px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;transition:all .2s;text-decoration:none;white-space:nowrap}
        .btn-ver:hover{background:rgba(255,255,255,0.25)}

        /* Teal card */
        .pcard-teal{border-radius:16px;padding:1.2rem 1.4rem;background:linear-gradient(140deg,#0f766e,#0d9488);color:#fff;box-shadow:0 4px 20px rgba(13,148,136,0.25);display:flex;flex-direction:column;gap:14px;height:160px;min-height:160px;max-height:160px;overflow:hidden}
        .pcard-teal .pcard-top{display:flex;align-items:flex-start;gap:12px;flex:1;min-height:0;overflow:hidden}
        .pcard-teal .pcard-ico{width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .pcard-teal .pcard-ico svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .pcard-teal .pcard-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%}
        .pcard-teal .pcard-sub{font-size:11.5px;opacity:.6;margin-top:2px;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
        .pcard-teal .pcard-bot{display:flex;align-items:flex-end;justify-content:space-between;flex-shrink:0}
        .pcard-teal .pcard-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;line-height:1}
        .pcard-teal .pcard-num small{font-size:11px;font-weight:600;opacity:.6;margin-left:3px}
        .pcard-teal .pcard-st{font-size:11px;opacity:.7;display:flex;align-items:center;gap:5px;margin-top:4px}

        /* Light card */
        .pcard-light{border-radius:16px;padding:1.2rem 1.4rem;background:#fff;border:1.5px solid var(--gray2);color:var(--text);display:flex;flex-direction:column;gap:14px;height:160px;min-height:160px;max-height:160px;overflow:hidden}
        .pcard-light .pcard-top{display:flex;align-items:flex-start;gap:12px;flex:1;min-height:0;overflow:hidden}
        .pcard-light .pcard-ico{width:40px;height:40px;border-radius:10px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .pcard-light .pcard-ico svg{width:18px;height:18px;fill:none;stroke:#2563eb;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .pcard-light .pcard-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%}
        .pcard-light .pcard-sub{font-size:11.5px;color:var(--muted);margin-top:2px;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
        .pcard-light .pcard-bot{display:flex;align-items:flex-end;justify-content:space-between;flex-shrink:0}
        .pcard-light .pcard-num{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;line-height:1;color:var(--text)}
        .pcard-light .pcard-num small{font-size:11px;font-weight:600;color:var(--muted);margin-left:3px}
        .pcard-light .pcard-st{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:5px;margin-top:4px}
        .btn-ver-dk{background:transparent;color:var(--text);border:1.5px solid var(--gray3);border-radius:10px;padding:8px 20px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;transition:all .2s;text-decoration:none;white-space:nowrap}
        .btn-ver-dk:hover{background:var(--gray2)}

        /* Row card */
        .pcard-row{border-radius:16px;padding:1rem 1.4rem;background:#fff;border:1.5px solid var(--gray2);display:flex;align-items:center;justify-content:space-between;margin-bottom:.8rem}
        .pcard-row-left{display:flex;align-items:center;gap:14px}
        .pcard-row-ico{width:38px;height:38px;border-radius:10px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .pcard-row-ico svg{width:16px;height:16px;fill:none;stroke:#2563eb;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .pcard-row-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:14px;font-weight:700;color:var(--text)}
        .pcard-row-sub{font-size:12px;color:var(--muted);margin-top:2px}
        .badge-review{font-size:11px;font-weight:600;color:#d97706;display:flex;align-items:center;gap:5px}
        .badge-review::before{content:'';width:7px;height:7px;border-radius:50%;background:#fbbf24;display:inline-block}

        /* ══════════════════════════════════════
           EXPLORADOR (estilos base + historial)
           El JS vive en _explorador_menu.blade.php
        ══════════════════════════════════════ */
        .exp-hero{position:relative;margin-bottom:1.4rem;z-index:10;}
        .exp-hero-bg{position:absolute;inset:0;background:linear-gradient(135deg,#1340b0 0%,#1a56db 60%,#3b82f6 100%);border-radius:16px;overflow:hidden;z-index:0}
        .exp-hero-bg::after{content:'';position:absolute;right:-40px;bottom:-60px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,0.06)}
        .exp-hero-content{position:relative;z-index:1;padding:1.6rem 2rem 2.2rem}
        .exp-hero-title{font-family:"Plus Jakarta Sans",sans-serif;font-size:20px;font-weight:800;color:#fff;line-height:1.2}
        .exp-hero-sub{font-size:12px;color:rgba(255,255,255,.7);margin-top:3px}
        .exp-search-wrap{display:flex;align-items:center;gap:10px;margin-top:1.2rem;max-width:600px;position:relative;z-index:1}
        .exp-search-box{flex:1;display:flex;align-items:center;background:#fff;border-radius:9px;padding:0 14px;height:42px;box-shadow:0 2px 12px rgba(0,0,0,.15)}
        .exp-search-box svg{color:#9ca3af;flex-shrink:0;width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2}
        .exp-search-box input{flex:1;border:none;outline:none;font-family:"DM Sans",sans-serif;font-size:13.5px;color:var(--text);background:transparent;padding-left:9px}
        .exp-search-box input::placeholder{color:#9ca3af}
        .btn-buscar{height:42px;padding:0 20px;background:#fff;color:#1a56db;border:none;border-radius:9px;font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;font-size:13.5px;cursor:pointer;transition:background .2s;white-space:nowrap}
        .btn-buscar:hover{background:#f0f2f8}
        .exp-filters{display:flex;align-items:center;gap:8px;margin-bottom:1rem}
        .exp-filter{padding:6px 16px;border-radius:999px;font-family:"Plus Jakarta Sans",sans-serif;font-weight:600;font-size:13px;border:1.5px solid var(--gray2);cursor:pointer;transition:all .18s;background:#fff;color:var(--muted)}
        .exp-filter:hover{border-color:var(--blue);color:var(--blue)}
        .exp-filter.active{background:var(--blue);color:#fff;border-color:var(--blue)}
        .exp-results-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
        .exp-count{font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.06em}
        .exp-sort{display:flex;align-items:center;gap:5px;font-size:13px;font-family:"DM Sans",sans-serif;color:var(--muted);background:none;border:none;cursor:pointer}
        .exp-sort svg{width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2}
        .exp-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
        .exp-card{background:#fff;border-radius:14px;padding:16px;box-shadow:0 2px 8px rgba(0,0,0,.07);border:1px solid var(--gray2);display:flex;flex-direction:column;gap:10px;position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s}
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
        /* Historial de búsquedas */
        .exp-history-dropdown{position:absolute;top:100%;left:0;width:calc(100% - 100px);background:#fff;border:1.5px solid var(--gray2);border-radius:9px;margin-top:5px;box-shadow:0 4px 15px rgba(0,0,0,0.1);z-index:100;max-height:200px;overflow-y:auto;}
        .exp-history-item{display:flex;align-items:center;gap:10px;padding:8px 14px;font-size:13px;color:var(--text);cursor:pointer;transition:background 0.2s;}
        .exp-history-item:hover{background:var(--gray);}
        .exp-history-item svg{width:12px;height:12px;color:var(--muted);}
        .exp-history-header{display:flex;justify-content:space-between;align-items:center;padding:8px 14px;border-bottom:1px solid var(--gray);font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px;}
        .btn-clear-history{color:var(--blue);cursor:pointer;text-transform:none;font-weight:600;}
        .btn-clear-history:hover{text-decoration:underline;}
        .btn-remove-history{padding:4px;border-radius:4px;color:var(--muted);opacity:0;transition:all 0.2s;display:flex;align-items:center;justify-content:center;}
        .exp-history-item:hover .btn-remove-history{opacity:1;}
        .btn-remove-history:hover{background:rgba(220,38,38,0.1);color:#ef4444;}
        .btn-remove-history svg{width:14px !important;height:14px !important;}

        /* ══════════════════════════════════════
           RIGHT PANEL (calendario, notifs, enlaces)
           El JS vive en _calendario_menu.blade.php
           y _notificaciones_menu.blade.php
        ══════════════════════════════════════ */
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
        .cd.holiday{color:#ef4444;font-weight:700;}
        .cd.holiday::before{content:'';position:absolute;top:2px;right:2px;width:4px;height:4px;border-radius:50%;background:#ef4444;}
        .cal-grid-meses{display:grid;grid-template-columns:repeat(3,1fr);gap:6px;margin-top:10px;padding:0 5px;}
        .cal-grid-anios{display:grid;grid-template-columns:repeat(4,1fr);gap:4px;margin-top:10px;}
        .cm-btn{font-size:12px;padding:12px 0;text-align:center;border-radius:8px;cursor:pointer;background:var(--gray);transition:all .15s;color:var(--text);font-weight:600;}
        .cm-btn:hover{background:#e2e8f0;color:var(--blue);}
        .cm-btn.current{background:var(--blue);color:#fff;}
        .cm-btn.other{opacity:0.5;}
        .row-week{display:contents;}
        .row-week:hover > .cd{background:#eff6ff;color:var(--blue);}
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

        /* ══════════════════════════════════════
           CV / REPORTES
           El JS vive en _reportes_menu.blade.php
        ══════════════════════════════════════ */
        .cv-wrapper{display:flex;justify-content:center;padding-bottom:40px;}
        .cv-container{width:210mm;min-height:297mm;background:#fff;box-shadow:0 10px 40px rgba(0,0,0,0.15);display:flex;overflow:hidden;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#1e293b;}
        .cv-left{width:35%;background-color:#3b82f6;color:#fff;padding:30px 25px;display:flex;flex-direction:column;position:relative;}
        .cv-right{width:65%;background-color:#fff;padding:40px 35px;}
        .cv-photo-box{background-color:#1e293b;padding:15px;margin-bottom:30px;position:relative;z-index:1;}
        .cv-photo{width:100%;height:auto;border:3px solid #93c5fd;display:block;object-fit:cover;aspect-ratio:1;}
        .cv-section-left{margin-bottom:30px;position:relative;z-index:1;}
        .cv-title-left{font-size:14px;font-weight:700;border-top:1px solid rgba(255,255,255,0.4);border-bottom:1px solid rgba(255,255,255,0.4);padding:8px 0;margin-bottom:15px;letter-spacing:1px;text-transform:uppercase;}
        .cv-contact-item{display:flex;align-items:center;gap:10px;font-size:11px;margin-bottom:12px;line-height:1.4;}
        .cv-contact-item svg{width:14px;height:14px;flex-shrink:0;}
        .cv-list-left,.cv-list-right,.cv-job-desc{list-style:none;padding:0;margin:0;}
        .cv-list-left li,.cv-list-right li,.cv-job-desc li{font-size:11.5px;margin-bottom:8px;position:relative;padding-left:12px;line-height:1.4;}
        .cv-list-left li::before{content:"";width:4px;height:4px;background:#fff;border-radius:50%;position:absolute;left:0;top:6px;}
        .cv-list-right li,.cv-job-desc li{font-size:12px;margin-bottom:6px;}
        .cv-list-right li::before,.cv-job-desc li::before{content:"";width:4px;height:4px;background:#1e293b;border-radius:50%;position:absolute;left:0;top:6px;}
        .cv-text-left{font-size:11.5px;line-height:1.6;text-align:justify;}
        .cv-name{font-size:38px;font-weight:800;color:#3b82f6;line-height:1.1;margin-bottom:35px;font-family:Arial,sans-serif;}
        .cv-section-right{margin-bottom:25px;}
        .cv-title-right{font-size:14px;font-weight:700;color:#1e293b;border-bottom:2px solid #93c5fd;padding-bottom:5px;margin-bottom:12px;text-transform:uppercase;letter-spacing:1px;}
        .cv-job-container{margin-bottom:15px;}
        .cv-job-date{font-size:11px;color:#475569;margin-bottom:3px;}
        .cv-job-title{font-size:12.5px;font-weight:700;color:#1e293b;margin-bottom:6px;}
        .cv-job-achievements{font-size:12px;font-weight:700;margin-top:6px;margin-bottom:4px;}
        .cv-bg-pattern{position:absolute;top:0;left:0;width:100%;height:100%;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIDIwaDQwTTIwIDB2NDAiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9zdmc+');pointer-events:none;}
        .btn-export{background:var(--blue);color:#fff;border:none;border-radius:9px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:8px;transition:background .2s;box-shadow:0 4px 12px rgba(37,99,235,0.2)}
        .btn-export:hover{background:var(--blue2)}
        .btn-export svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        /* Selector de plantillas CV */
        .template-selector{display:flex;gap:10px;margin-bottom:20px;}
        .ts-btn{padding:8px 16px;border-radius:8px;border:1px solid var(--gray2);background:#fff;color:var(--muted);font-size:13px;font-weight:600;cursor:pointer;transition:all 0.2s;font-family:"DM Sans",sans-serif;}
        .ts-btn:hover{border-color:var(--blue);color:var(--blue);}
        .ts-btn.active{background:var(--blue);color:#fff;border-color:var(--blue);}
        .cv-template-view:not(.active-tpl){display:none !important;}
        /* Plantilla 2 - Clásico */
        #cv-template-2{flex-direction:column;padding:50px;font-family:'Times New Roman',Times,serif;}
        #cv-template-2 .cv2-header{text-align:center;border-bottom:2px solid #1e293b;padding-bottom:20px;margin-bottom:30px;}
        #cv-template-2 .cv2-name{font-size:32px;font-weight:bold;color:#1e293b;margin-bottom:10px;text-transform:uppercase;letter-spacing:2px;}
        #cv-template-2 .cv2-contact{font-size:13px;color:#475569;display:flex;justify-content:center;gap:15px;}
        #cv-template-2 .cv2-section{margin-bottom:25px;}
        #cv-template-2 .cv2-title{font-size:16px;font-weight:bold;color:#1e293b;text-transform:uppercase;border-bottom:1px solid #cbd5e1;padding-bottom:5px;margin-bottom:15px;}
        #cv-template-2 .cv2-item{margin-bottom:15px;}
        #cv-template-2 .cv2-item-header{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:5px;}
        #cv-template-2 .cv2-item-title{font-weight:bold;font-size:14px;}
        #cv-template-2 .cv2-item-date{font-style:italic;font-size:13px;color:#64748b;}
        #cv-template-2 ul{list-style-type:disc;padding-left:20px;font-size:13px;color:#334155;line-height:1.5;}
        /* Plantilla 3 - Minimalista */
        #cv-template-3{font-family:'Helvetica Neue',Arial,sans-serif;padding:40px;display:grid;grid-template-columns:1fr 2.5fr;gap:30px;}
        #cv-template-3 .cv3-left{border-right:1px solid #e2e8f0;padding-right:20px;}
        #cv-template-3 .cv3-name{font-size:28px;font-weight:800;color:#0f172a;margin-bottom:5px;line-height:1.1;}
        #cv-template-3 .cv3-role{font-size:14px;color:#64748b;font-weight:500;margin-bottom:30px;}
        #cv-template-3 .cv3-section-title{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#94a3b8;margin-bottom:15px;margin-top:30px;}
        #cv-template-3 .cv3-contact-item{font-size:12px;color:#475569;margin-bottom:8px;word-break:break-all;}
        #cv-template-3 .cv3-skill{display:inline-block;background:#f1f5f9;padding:4px 10px;border-radius:4px;font-size:11px;font-weight:500;color:#334155;margin:0 4px 6px 0;}
        #cv-template-3 .cv3-job{margin-bottom:20px;}
        #cv-template-3 .cv3-job-date{font-size:12px;color:#64748b;margin-bottom:4px;font-weight:500;}
        #cv-template-3 .cv3-job-title{font-size:14px;font-weight:600;color:#1e293b;margin-bottom:4px;}
        #cv-template-3 .cv3-job-desc{font-size:13px;color:#475569;line-height:1.5;}
        /* Plantilla 4 - Elegante Gris/Azul */
        #cv-template-4{display:flex;font-family:'Helvetica',Arial,sans-serif;color:#333;position:relative;padding-top:180px;}
        #cv-template-4 .cv4-header{position:absolute;top:0;left:0;width:100%;height:210px;background:#374856;clip-path:polygon(0 0,100% 0,100% 75%,0 100%);display:flex;z-index:1;}
        #cv-template-4 .cv4-name-box{margin-left:35%;padding-top:35px;text-align:right;width:60%;color:#fff;}
        #cv-template-4 .cv4-name{font-size:38px;font-weight:bold;margin-bottom:5px;letter-spacing:1px;}
        #cv-template-4 .cv4-role{font-size:16px;text-transform:uppercase;letter-spacing:2px;color:#cbd5e1;}
        #cv-template-4 .cv4-photo{position:absolute;top:40px;left:5%;width:150px;height:150px;border-radius:50%;object-fit:cover;z-index:2;border:6px solid #fff;}
        #cv-template-4 .cv4-left{width:33%;background:#eef1f4;padding:40px 20px 20px;z-index:0;}
        #cv-template-4 .cv4-right{width:67%;padding:40px 30px 20px;background:#fff;z-index:0;}
        #cv-template-4 .cv4-title{font-size:15px;font-weight:bold;text-transform:uppercase;color:#1e293b;border-bottom:2px solid #1e293b;padding-bottom:5px;margin-bottom:15px;margin-top:25px;}
        #cv-template-4 .cv4-title:first-child{margin-top:0;}
        #cv-template-4 .cv4-text{font-size:13px;line-height:1.5;color:#475569;margin-bottom:15px;}
        #cv-template-4 .cv4-list{list-style:none;padding:0;margin:0;font-size:13px;color:#1e293b;}
        #cv-template-4 .cv4-list li{margin-bottom:12px;display:flex;align-items:center;gap:8px;}
        #cv-template-4 .cv4-list-bullet{list-style-type:disc;padding-left:20px;font-size:13px;color:#475569;line-height:1.5;}
        #cv-template-4 .cv4-job{margin-bottom:20px;}
        #cv-template-4 .cv4-job-title{font-weight:bold;font-size:14px;color:#1e293b;margin-bottom:2px;}
        #cv-template-4 .cv4-job-meta{font-size:13px;font-style:italic;color:#64748b;margin-bottom:8px;}
        #cv-template-4 .cv4-bar{width:100%;height:8px;background:#cbd5e1;border-radius:4px;margin-top:6px;}
        #cv-template-4 .cv4-bar-fill{height:100%;background:#475a68;border-radius:4px;}
        /* Plantilla 5 - Creativo Verde/Rosa */
        #cv-template-5{display:flex;font-family:'Georgia',serif;position:relative;}
        #cv-template-5 .cv5-left{width:35%;background:#6a9a98;color:#fff;padding:200px 30px 30px;display:flex;flex-direction:column;}
        #cv-template-5 .cv5-right{width:65%;background:#fff;padding:180px 40px 30px;position:relative;}
        #cv-template-5 .cv5-banner{position:absolute;top:40px;left:35%;width:65%;height:120px;background:#b88a8d;z-index:1;display:flex;flex-direction:column;justify-content:center;padding-left:110px;color:#fff;}
        #cv-template-5 .cv5-photo{position:absolute;top:20px;left:10%;width:160px;height:160px;border-radius:50%;object-fit:cover;z-index:2;border:4px solid #fff;}
        #cv-template-5 .cv5-name{font-size:30px;font-weight:bold;letter-spacing:3px;text-transform:uppercase;line-height:1.2;margin-bottom:5px;}
        #cv-template-5 .cv5-role{font-size:15px;font-style:italic;opacity:0.9;}
        #cv-template-5 .cv5-title-left{font-size:15px;font-weight:bold;text-transform:uppercase;letter-spacing:2px;margin-bottom:15px;margin-top:35px;}
        #cv-template-5 .cv5-title-left:first-child{margin-top:0;}
        #cv-template-5 .cv5-text-left{font-size:13px;line-height:1.6;font-family:'Helvetica',sans-serif;}
        #cv-template-5 .cv5-contact-item{font-family:'Helvetica',sans-serif;font-size:13px;margin-bottom:12px;display:flex;align-items:center;gap:10px;}
        #cv-template-5 .cv5-title-right{font-size:16px;font-weight:bold;color:#2d3748;text-transform:uppercase;letter-spacing:2px;margin-bottom:15px;margin-top:25px;display:flex;align-items:center;gap:8px;}
        #cv-template-5 .cv5-title-right:first-child{margin-top:0;}
        #cv-template-5 .cv5-title-icon{color:#6a9a98;font-size:20px;font-weight:bold;}
        #cv-template-5 .cv5-item{font-family:'Helvetica',sans-serif;margin-bottom:15px;}
        #cv-template-5 .cv5-item-title{font-weight:bold;font-size:13px;color:#1e293b;text-transform:uppercase;letter-spacing:1px;}
        #cv-template-5 .cv5-item-meta{font-size:13px;color:#64748b;font-style:italic;margin-bottom:6px;}
        #cv-template-5 .cv5-list{padding-left:20px;font-size:13px;color:#475569;line-height:1.6;}
        /* Plantilla 6 - Moderno Malva */
        #cv-template-6{display:flex;font-family:'Helvetica',sans-serif;position:relative;padding-top:160px;}
        #cv-template-6 .cv6-banner{position:absolute;top:0;right:0;width:62%;height:160px;background:#ab8589;color:#fff;padding:30px 40px;display:flex;flex-direction:column;justify-content:center;}
        #cv-template-6 .cv6-name{font-size:34px;font-weight:300;margin-bottom:5px;}
        #cv-template-6 .cv6-role{font-size:14px;text-transform:uppercase;letter-spacing:3px;font-weight:600;margin-bottom:12px;opacity:0.9;}
        #cv-template-6 .cv6-banner-text{font-size:12px;line-height:1.5;opacity:0.85;}
        #cv-template-6 .cv6-photo{position:absolute;top:30px;left:8%;width:140px;height:140px;border-radius:50%;object-fit:cover;z-index:2;border:5px solid #fff;box-shadow:0 4px 10px rgba(0,0,0,0.05);}
        #cv-template-6 .cv6-left{width:38%;background:#f8f9fa;padding:40px 30px;border-right:1px solid #e2e8f0;}
        #cv-template-6 .cv6-right{width:62%;background:#fff;padding:40px;}
        #cv-template-6 .cv6-title{font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1e293b;margin-bottom:20px;margin-top:30px;}
        #cv-template-6 .cv6-title:first-child{margin-top:0;}
        #cv-template-6 .cv6-item{margin-bottom:20px;}
        #cv-template-6 .cv6-item-title{font-weight:600;font-size:14px;color:#0f172a;}
        #cv-template-6 .cv6-item-meta{font-size:12px;color:#64748b;margin-bottom:5px;}
        #cv-template-6 .cv6-list{list-style-type:none;padding:0;margin:0;font-size:13px;color:#475569;}
        #cv-template-6 .cv6-list li{margin-bottom:8px;position:relative;padding-left:14px;line-height:1.5;}
        #cv-template-6 .cv6-list li::before{content:'•';position:absolute;left:0;top:0;color:#ab8589;font-weight:bold;font-size:16px;}
        #cv-template-6 .cv6-contact-item{font-size:13px;color:#475569;margin-bottom:12px;display:flex;align-items:center;gap:10px;}

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        footer{height:40px;background:var(--navy);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .footer-content{display:flex;align-items:center;justify-content:center;gap:10px}
        .footer-logo{height:20px;width:auto;object-fit:contain;display:block}
        footer p{font-size:11.5px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0}
        footer b{color:#7a9cc0}

        /* ══════════════════════════════════════
           SCROLLBAR
        ══════════════════════════════════════ */
        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}

        /* ══════════════════════════════════════
           GRIDS ADICIONALES
        ══════════════════════════════════════ */
        .caract-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
        .porta-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.2rem;}

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media(max-width:1200px){
          .content-wrapper{flex-direction:column;overflow-y:auto;}
          main{overflow-y:visible;flex:none;}
          .rpanel{display:flex;flex-direction:row;flex-wrap:wrap;width:100%;height:auto;border-left:none;border-top:1.5px solid var(--gray2);overflow-y:visible;}
          .rpanel > .rp-sec{flex:1;min-width:250px;}
          .porta-grid{grid-template-columns:repeat(3,1fr)}
        }
        @media(max-width:992px){
          aside{width:72px}
          .sb-item span,.sb-uname,.sb-uid,.btn-logout span{display:none}
          .sb-item{justify-content:center;padding:13px 10px}
          .sb-user-block{justify-content:center}
          .btn-logout{justify-content:center}
          .stats,.pgrid,.exp-grid{grid-template-columns:1fr}
          .caract-grid{grid-template-columns:1fr}
          .porta-grid{grid-template-columns:repeat(2,1fr)}
          .tb-nav{display:none}
        }
        @media(max-width:768px){
          .topbar{padding:0 16px;height:auto;padding-top:10px;padding-bottom:10px;flex-wrap:wrap;gap:10px;}
          .tb-nav{display:none}
          .tb-left{width:100%;justify-content:space-between;}
          .tb-right{width:100%;justify-content:flex-end;}
          .sysname{font-size:18px}
          .main-inner{padding:1.2rem 1rem}
          .porta-grid{grid-template-columns:1fr}
          .content-title h1{font-size:22px}
          .exp-hero{padding:1.2rem}
          .exp-search-wrap{flex-direction:column;align-items:stretch}
          .exp-filters{flex-wrap:wrap}
          .stats{grid-template-columns:1fr}
          .exp-history-dropdown{width:100%;}
        }
        @media(max-width:480px){
          aside{width:60px}
          .tb-search{display:none}
          .sysname{display:none}
          .tb-left{gap:0;justify-content:center;}
          .tb-right{justify-content:center;}
          .tb-right > div > div:nth-child(2){display:none;}
          .pcard-dark,.pcard-teal,.pcard-light{padding:1rem}
          .exp-card-actions{flex-direction:column;align-items:flex-start;gap:10px}
          .stat{flex-direction:row;align-items:center;padding:1rem;}
          .stat-num{font-size:28px}
          .content-bar{flex-direction:column;gap:10px;}
        }

        /* ══════════════════════════════════════
           PRINT (para exportar CV)
        ══════════════════════════════════════ */
        @media print {
            *{-webkit-print-color-adjust:exact !important;print-color-adjust:exact !important;}
            body *{visibility:hidden;}
            #view-reportes,#view-reportes *{visibility:visible;}
            #view-reportes{position:absolute;left:0;top:0;width:100%;min-height:100vh;}
            .topbar,aside,.rpanel,.content-bar,footer,.template-selector{display:none !important;}
            .cv-template-view{display:none !important;}
            .cv-template-view.active-tpl{display:flex !important;}
            main{background:#fff;padding:0;overflow:visible;width:100%;min-height:100vh;display:block;}
            .main-inner{padding:0;display:block;}
            .cv-wrapper{padding-bottom:0;justify-content:flex-start;min-height:100vh;}
            .cv-container{box-shadow:none;width:100%;min-height:100vh;}
            @page{size:auto;margin:0;}
        }
    </style>
</head>
<body>
<div class="app">

    {{-- ══ TOPBAR ══ --}}
    @include('components.layout.navbar')

    <div class="body-row">

        {{-- ══ SIDEBAR ══ --}}
        <aside>
            <div class="sb-top">
                <button class="sb-item active" id="btn-menu" onclick="showView('menu')">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <span>{{ __('app.menu.menu_principal') }}</span>
                </button>
                <div class="sb-div"></div>
                <button id="btn-portafolios" class="sb-item" onclick="showView('portafolios')">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>{{ __('app.menu.portafolios') }}</span>
                </button>
                <a href="{{ route('academico') }}" class="sb-item {{ request()->routeIs('academico') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    <span>{{ __('app.menu.academico') }}</span>
                </a>
                <button id="btn-reportes" class="sb-item" onclick="showView('reportes')" style="background:none;border-top:none;border-right:none;border-bottom:none;width:100%;text-align:left;">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>{{ __('app.menu.reportes') }}</span>
                </button>
                <button id="btn-perfil" class="sb-item" onclick="showView('perfil')" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font-family:inherit;">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>{{ __('app.menu.mi_perfil') }}</span>
                </button>
            </div>
        </aside>

        <div class="content-wrapper">

            {{-- ══ MAIN: VISTAS ══ --}}
            <main>
                <div class="main-inner">

                    {{-- Vista: Menú principal --}}
                    <div class="view active" id="view-menu">
                        @include('_view_mis_portafolios')
                    </div>

                    {{-- Vista: Explorador (HTML + JS en _explorador_menu) --}}
                    <div class="view" id="view-explorador">
                        @include('_explorador_menu')
                    </div>

                    {{-- Vista: Características --}}
                    <div class="view" id="view-caracteristicas">
                        @include('_caracteristicas_menu')
                    </div>

                    {{-- Formulario logout (oculto, usado por ejecutarLogout) --}}
                    <form method="POST" action="{{ route('logout') }}" id="formLogout" style="display:none;">
                        @csrf
                    </form>

                    {{-- Vista: Portafolios --}}
                    <div class="view" id="view-portafolios">
                        @include('_portafolios_menu')
                    </div>

                    {{-- Vista: Reportes / CV (JS en _reportes_menu) --}}
                    <div class="view" id="view-reportes">
                        @include('_reportes_menu')
                    </div>

                    {{-- Vista: Mi Perfil --}}
                    <div class="view" id="view-perfil">
                        @include('perfil.index')
                    </div>

                </div>
            </main>

            {{-- ══ RIGHT PANEL ══
                 Calendario → _calendario_menu (HTML + JS + modal)
                 Notificaciones dinámicas → _notificaciones_menu (solo JS)
            ══ --}}
            <div class="rpanel">

                @include('_calendario_menu')

                {{-- Notificaciones estáticas del sistema --}}
                <div class="rp-sec">
                    <div class="rp-ttl">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ __('app.menu.notif_actualizacion') }}
                    </div>
                    <div class="notif">
                        <div class="ni-icon green"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div>
                        <div><div class="ntxt">{{ __('app.menu.nueva_actualizacion') }}</div></div>
                    </div>
                    <div class="notif">
                        <div class="ni-icon blue"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <div><div class="ntxt">{{ __('app.menu.informe_subido') }}</div><div class="ntime">13:10</div></div>
                    </div>
                </div>

                {{-- Enlaces rápidos --}}
                <div class="rp-sec">
                    <div class="rp-ttl">
                        <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 1 7.54.54l3 3a5 5 0 0 1-7.07 7.07l-1.72-1.71"/><path d="M14 11a5 5 0 0 1-7.54-.54l-3-3A5 5 0 0 1 10.54.39l1.71 1.71"/></svg>
                        {{ __('app.menu.enlaces') }}
                    </div>
                    <a href="#" class="enlace"><div class="en-ico yellow"><svg viewBox="0 0 24 24"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div><div class="en-lbl">{{ __('app.menu.repositorio') }}</div></a>
                    <a href="#" class="enlace"><div class="en-ico gray"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div><div class="en-lbl">{{ __('app.menu.ayuda') }}</div></a>
                    <a href="#" class="enlace"><div class="en-ico blue"><svg viewBox="0 0 24 24"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg></div><div class="en-lbl">{{ __('app.menu.portal_umss') }}</div></a>
                    <a href="#" class="enlace"><div class="en-ico blue"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div><div class="en-lbl">{{ __('app.menu.aula_virtual') }}</div></a>
                </div>

            </div>{{-- /rpanel --}}

        </div>{{-- /content-wrapper --}}
    </div>{{-- /body-row --}}

    @include('components.layout.footer')

</div>{{-- /app --}}

{{-- ══ MODALES ══ --}}
@include('_modales_crear_portafolio')

{{-- ══ SCRIPTS PRINCIPALES ══ --}}
<script>
    /* ── Navegación entre vistas ── */
    function showView(name) {
        document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
        document.getElementById('view-' + name).classList.add('active');
        document.querySelectorAll('.sb-item').forEach(b => b.classList.remove('active'));
        const btn = document.getElementById('btn-' + name);
        if (btn) btn.classList.add('active');
        document.querySelector('main').scrollTop = 0;
    }

    /* ── Atajos de teclado ──
       Ctrl+K  → abre el explorador y enfoca el buscador
       Escape  → limpia el buscador si está activo
    ── */
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            showView('explorador');
            document.getElementById('expSearch').focus();
        }
        if (e.key === 'Escape') {
            const input = document.getElementById('expSearch');
            if (document.activeElement === input) {
                input.value = '';
                expFilter();
                input.blur();
                document.getElementById('expHistory').style.display = 'none';
            }
        }
    });

    /* ── Marcar menú principal como activo al cargar ── */
    document.getElementById('btn-menu').classList.add('active');

    /* ── Logout ── */
    function confirmarLogout() {
        document.getElementById('modalLogout').style.display = 'flex';
    }
    function ejecutarLogout(btn) {
        btn.disabled = true;
        document.getElementById('logoutSpinner').style.display = 'block';
        document.getElementById('logoutBtnLabel').textContent = window.trans.cerrando;
        btn.style.opacity = '0.85';
        document.getElementById('formLogoutGlobal').submit();
    }

    /* ── CV / Reportes ──
       selectTemplate → cambia la plantilla visible
       toggleEditCV   → activa/desactiva edición inline del CV
    ── */
    function selectTemplate(tplId) {
        document.querySelectorAll('.cv-template-view').forEach(el => el.classList.remove('active-tpl'));
        document.getElementById(tplId).classList.add('active-tpl');
    }
    let isEditingCV = false;
    function toggleEditCV() {
        isEditingCV = !isEditingCV;
        const btn = document.getElementById('btn-edit-cv');
        document.querySelectorAll('.cv-template-view').forEach(tpl => {
            tpl.setAttribute('contenteditable', isEditingCV ? 'true' : 'false');
            tpl.style.outline = isEditingCV ? '2px dashed #3b82f6' : 'none';
            tpl.style.outlineOffset = isEditingCV ? '4px' : '';
        });
        btn.innerHTML = isEditingCV
            ? '<svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> Finalizar Edición'
            : '<svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Editar en pantalla';
        btn.style.background = isEditingCV ? '#3b82f6' : '#e2e8f0';
        btn.style.color      = isEditingCV ? '#fff'    : '#1e293b';
    }

    /* ── Menú de usuario (navbar) ── */
    function toggleNavMenu() {
        const menu = document.getElementById('navUserMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    function cerrarNavMenu() {
        document.getElementById('navUserMenu').style.display = 'none';
    }
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('navUserMenu');
        const btn  = menu?.previousElementSibling;
        if (menu && !menu.contains(e.target) && btn && !btn.contains(e.target)) {
            cerrarNavMenu();
        }
    });
</script>

{{-- ══ TRADUCCIONES PARA JS ══ --}}
<script>
    window.trans = {
        cerrando: "{{ __('app.menu.cerrando') }}"
    };
</script>

{{-- ══ NOTIFICACIONES DINÁMICAS (campanita) ══ --}}
@include('_notificaciones_menu')

</body>
</html>