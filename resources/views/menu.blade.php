<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SansiFolios - UMSS' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
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

        /* ── Topbar ── */
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

        /* ── Body ── */
        .body-row{flex:1;display:flex;overflow:hidden}

        /* ── Sidebar ── */
        aside{width:var(--sw);background:var(--navy);flex-shrink:0;display:flex;flex-direction:column;border-right:1px solid rgba(255,255,255,0.06)}
        .sb-top{padding:14px 0;flex:1}
        .sb-item{display:flex;align-items:center;gap:11px;padding:10px 20px;cursor:pointer;color:#8ba5c8;font-size:13px;font-weight:400;transition:all .18s;border-left:3px solid transparent;font-family:"DM Sans",sans-serif;text-decoration:none;background:none;border-top:none;border-right:none;border-bottom:none;width:100%}
        .sb-item:hover{background:rgba(255,255,255,0.05);color:#c8d8ef;transform:translateX(4px)}
        .sb-item{transition:all .18s;}
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

        /* ── Main ── */
        main{flex:1;overflow-y:auto;background:var(--gray)}
        .main-inner{padding:1.6rem 1.8rem}
        .view{display:none}
        .view.active{display:block}

        /* ── Content bar ── */
        .content-bar{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.4rem}
        .content-title h1{font-family:"Plus Jakarta Sans",sans-serif;font-size:26px;font-weight:800;color:var(--text)}
        .content-title p{font-size:12.5px;color:var(--muted);margin-top:3px}

        /* ── Stats ── */
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

        /* ── Section label ── */
        .sec-lbl{font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);display:flex;align-items:center;gap:7px;margin-bottom:1.1rem}
        .sec-lbl svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2}

        /* ── Portfolio grid ── */
        .pgrid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}

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
        .dot{width:7px;height:7px;border-radius:50%;display:inline-block;flex-shrink:0}
        .dg{background:#4ade80}.dy{background:#fbbf24}.dr{background:#f87171}
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

        /* Full row card */
        .pcard-row{border-radius:16px;padding:1rem 1.4rem;background:#fff;border:1.5px solid var(--gray2);display:flex;align-items:center;justify-content:space-between;margin-bottom:.8rem}
        .pcard-row-left{display:flex;align-items:center;gap:14px}
        .pcard-row-ico{width:38px;height:38px;border-radius:10px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .pcard-row-ico svg{width:16px;height:16px;fill:none;stroke:#2563eb;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .pcard-row-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:14px;font-weight:700;color:var(--text)}
        .pcard-row-sub{font-size:12px;color:var(--muted);margin-top:2px}
        .badge-review{font-size:11px;font-weight:600;color:#d97706;display:flex;align-items:center;gap:5px}
        .badge-review::before{content:'';width:7px;height:7px;border-radius:50%;background:#fbbf24;display:inline-block}

        /* ── Explorador ── */
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
        
        /* ── Nuevos estilos Calendario ── */
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

        /* ── Footer ── */
        footer{height:40px;background:var(--navy);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .footer-content{display:flex;align-items:center;justify-content:center;gap:10px}
        .footer-logo{height:20px;width:auto;object-fit:contain;display:block}
        footer p{font-size:11.5px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0}
        footer b{color:#7a9cc0}

        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}

        /* ── Responsive grids ── */
        .content-wrapper { flex: 1; display: flex; flex-direction: row; overflow: hidden; }
        .caract-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        .porta-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.2rem; }

        @media(max-width:1200px){
          .content-wrapper { flex-direction: column; overflow-y: auto; }
          main { overflow-y: visible; flex: none; }
          .rpanel { display: flex; flex-direction: row; flex-wrap: wrap; width: 100%; height: auto; border-left: none; border-top: 1.5px solid var(--gray2); overflow-y: visible; }
          .rpanel > .rp-sec { flex: 1; min-width: 250px; }
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
          .topbar{padding:0 16px; height: auto; padding-top: 10px; padding-bottom: 10px; flex-wrap: wrap; gap: 10px;}
          .tb-nav{display:none}
          .tb-left { width: 100%; justify-content: space-between; }
          .tb-right { width: 100%; justify-content: flex-end; }
          .sysname{font-size:18px}
          .main-inner{padding:1.2rem 1rem}
          .porta-grid{grid-template-columns:1fr}
          .content-title h1{font-size:22px}
          .exp-hero{padding:1.2rem}
          .exp-search-wrap{flex-direction:column; align-items:stretch}
          .exp-filters{flex-wrap:wrap}
          .stats { grid-template-columns: 1fr; }
        }
        @media(max-width:480px){
          aside{width:60px}
          .tb-search{display:none}
          .sysname{display:none}
          .tb-left{gap:0; justify-content: center;}
          .tb-right{justify-content: center;}
          .tb-right > div > div:nth-child(2) { display: none; }
          .pcard-dark, .pcard-teal, .pcard-light{padding:1rem}
          .exp-card-actions{flex-direction:column; align-items:flex-start; gap:10px}
          .stat{flex-direction:row; align-items:center; padding: 1rem;}
          .stat-num{font-size:28px}
          .content-bar { flex-direction: column; gap: 10px; }
        }

        /* ── Estilos Historial ── */
        .exp-search-wrap { position: relative; }
        .exp-history-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: calc(100% - 100px); /* Ajustado para el botón buscar */
            background: #fff;
            border: 1.5px solid var(--gray2);
            border-radius: 9px;
            margin-top: 5px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 100;
            max-height: 200px;
            overflow-y: auto;
        }
        @media (max-width: 768px) { .exp-history-dropdown { width: 100%; } }
        .exp-history-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            font-size: 13px;
            color: var(--text);
            cursor: pointer;
            transition: background 0.2s;
        }
        .exp-history-item:hover { background: var(--gray); }
        .exp-history-item svg { width: 12px; height: 12px; color: var(--muted); }
        .exp-history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 14px;
            border-bottom: 1px solid var(--gray);
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-clear-history {
            color: var(--blue);
            cursor: pointer;
            text-transform: none;
            font-weight: 600;
        }
        .btn-clear-history:hover { text-decoration: underline; }
        .btn-remove-history {
            padding: 4px;
            border-radius: 4px;
            color: var(--muted);
            opacity: 0;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .exp-history-item:hover .btn-remove-history { opacity: 1; }
        .btn-remove-history:hover { background: rgba(220,38,38,0.1); color: #ef4444; }
        .btn-remove-history svg { width: 14px !important; height: 14px !important; }
        
        /* ── CV TEMPLATE STYLES ── */
        .cv-wrapper { display: flex; justify-content: center; padding-bottom: 40px; }
        .cv-container { width: 210mm; min-height: 297mm; background: #fff; box-shadow: 0 10px 40px rgba(0,0,0,0.15); display: flex; overflow: hidden; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; }
        .cv-left { width: 35%; background-color: #3b82f6; color: #fff; padding: 30px 25px; display: flex; flex-direction: column; position: relative; }
        .cv-right { width: 65%; background-color: #fff; padding: 40px 35px; }
        .cv-photo-box { background-color: #1e293b; padding: 15px; margin-bottom: 30px; position: relative; z-index: 1; }
        .cv-photo { width: 100%; height: auto; border: 3px solid #93c5fd; display: block; object-fit: cover; aspect-ratio: 1; }
        .cv-section-left { margin-bottom: 30px; position: relative; z-index: 1; }
        .cv-title-left { font-size: 14px; font-weight: 700; border-top: 1px solid rgba(255,255,255,0.4); border-bottom: 1px solid rgba(255,255,255,0.4); padding: 8px 0; margin-bottom: 15px; letter-spacing: 1px; text-transform: uppercase; }
        .cv-contact-item { display: flex; align-items: center; gap: 10px; font-size: 11px; margin-bottom: 12px; line-height: 1.4; }
        .cv-contact-item svg { width: 14px; height: 14px; flex-shrink: 0; }
        .cv-list-left, .cv-list-right, .cv-job-desc { list-style: none; padding: 0; margin: 0; }
        .cv-list-left li, .cv-list-right li, .cv-job-desc li { font-size: 11.5px; margin-bottom: 8px; position: relative; padding-left: 12px; line-height: 1.4; }
        .cv-list-left li::before { content: ""; width: 4px; height: 4px; background: #fff; border-radius: 50%; position: absolute; left: 0; top: 6px; }
        .cv-list-right li, .cv-job-desc li { font-size: 12px; margin-bottom: 6px; }
        .cv-list-right li::before, .cv-job-desc li::before { content: ""; width: 4px; height: 4px; background: #1e293b; border-radius: 50%; position: absolute; left: 0; top: 6px; }
        .cv-text-left { font-size: 11.5px; line-height: 1.6; text-align: justify; }
        .cv-name { font-size: 38px; font-weight: 800; color: #3b82f6; line-height: 1.1; margin-bottom: 35px; font-family: Arial, sans-serif; }
        .cv-section-right { margin-bottom: 25px; }
        .cv-title-right { font-size: 14px; font-weight: 700; color: #1e293b; border-bottom: 2px solid #93c5fd; padding-bottom: 5px; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .cv-job-container { margin-bottom: 15px; }
        .cv-job-date { font-size: 11px; color: #475569; margin-bottom: 3px; }
        .cv-job-title { font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
        .cv-job-achievements { font-size: 12px; font-weight: 700; margin-top: 6px; margin-bottom: 4px; }
        .cv-bg-pattern { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIDIwaDQwTTIwIDB2NDAiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9zdmc+'); pointer-events: none; }
        .btn-export{background:var(--blue);color:#fff;border:none;border-radius:9px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:8px;transition:background .2s;box-shadow:0 4px 12px rgba(37,99,235,0.2)}
        .btn-export:hover{background:var(--blue2)}
        .btn-export svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

        /* ── TEMPLATE SELECTOR & NEW TEMPLATES ── */
        .template-selector { display: flex; gap: 10px; margin-bottom: 20px; }
        .ts-btn { padding: 8px 16px; border-radius: 8px; border: 1px solid var(--gray2); background: #fff; color: var(--muted); font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: "DM Sans", sans-serif; }
        .ts-btn:hover { border-color: var(--blue); color: var(--blue); }
        .ts-btn.active { background: var(--blue); color: #fff; border-color: var(--blue); }
        .cv-template-view:not(.active-tpl) { display: none !important; }

        /* CV TEMPLATE 2 (Clásico) */
        #cv-template-2 { flex-direction: column; padding: 50px; font-family: 'Times New Roman', Times, serif; }
        #cv-template-2 .cv2-header { text-align: center; border-bottom: 2px solid #1e293b; padding-bottom: 20px; margin-bottom: 30px; }
        #cv-template-2 .cv2-name { font-size: 32px; font-weight: bold; color: #1e293b; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 2px; }
        #cv-template-2 .cv2-contact { font-size: 13px; color: #475569; display: flex; justify-content: center; gap: 15px; }
        #cv-template-2 .cv2-section { margin-bottom: 25px; }
        #cv-template-2 .cv2-title { font-size: 16px; font-weight: bold; color: #1e293b; text-transform: uppercase; border-bottom: 1px solid #cbd5e1; padding-bottom: 5px; margin-bottom: 15px; }
        #cv-template-2 .cv2-item { margin-bottom: 15px; }
        #cv-template-2 .cv2-item-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 5px; }
        #cv-template-2 .cv2-item-title { font-weight: bold; font-size: 14px; }
        #cv-template-2 .cv2-item-date { font-style: italic; font-size: 13px; color: #64748b; }
        #cv-template-2 ul { list-style-type: disc; padding-left: 20px; font-size: 13px; color: #334155; line-height: 1.5; }

        /* CV TEMPLATE 3 (Minimalista) */
        #cv-template-3 { font-family: 'Helvetica Neue', Arial, sans-serif; padding: 40px; display: grid; grid-template-columns: 1fr 2.5fr; gap: 30px; }
        #cv-template-3 .cv3-left { border-right: 1px solid #e2e8f0; padding-right: 20px; }
        #cv-template-3 .cv3-name { font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 5px; line-height: 1.1; }
        #cv-template-3 .cv3-role { font-size: 14px; color: #64748b; font-weight: 500; margin-bottom: 30px; }
        #cv-template-3 .cv3-section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; margin-bottom: 15px; margin-top: 30px; }
        #cv-template-3 .cv3-contact-item { font-size: 12px; color: #475569; margin-bottom: 8px; word-break: break-all; }
        #cv-template-3 .cv3-skill { display: inline-block; background: #f1f5f9; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 500; color: #334155; margin: 0 4px 6px 0; }
        #cv-template-3 .cv3-job { margin-bottom: 20px; }
        #cv-template-3 .cv3-job-date { font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500; }
        #cv-template-3 .cv3-job-title { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px; }
        #cv-template-3 .cv3-job-desc { font-size: 13px; color: #475569; line-height: 1.5; }

        /* CV TEMPLATE 4 (Elegante - Gris/Azul) */
        #cv-template-4 { display: flex; font-family: 'Helvetica', Arial, sans-serif; color: #333; position: relative; padding-top: 180px; }
        #cv-template-4 .cv4-header { position: absolute; top: 0; left: 0; width: 100%; height: 210px; background: #374856; clip-path: polygon(0 0, 100% 0, 100% 75%, 0 100%); display: flex; z-index: 1; }
        #cv-template-4 .cv4-name-box { margin-left: 35%; padding-top: 35px; text-align: right; width: 60%; color: #fff; }
        #cv-template-4 .cv4-name { font-size: 38px; font-weight: bold; margin-bottom: 5px; letter-spacing: 1px; }
        #cv-template-4 .cv4-role { font-size: 16px; text-transform: uppercase; letter-spacing: 2px; color: #cbd5e1; }
        #cv-template-4 .cv4-photo { position: absolute; top: 40px; left: 5%; width: 150px; height: 150px; border-radius: 50%; object-fit: cover; z-index: 2; border: 6px solid #fff; }
        #cv-template-4 .cv4-left { width: 33%; background: #eef1f4; padding: 40px 20px 20px; z-index: 0; }
        #cv-template-4 .cv4-right { width: 67%; padding: 40px 30px 20px; background: #fff; z-index: 0; }
        #cv-template-4 .cv4-title { font-size: 15px; font-weight: bold; text-transform: uppercase; color: #1e293b; border-bottom: 2px solid #1e293b; padding-bottom: 5px; margin-bottom: 15px; margin-top: 25px; }
        #cv-template-4 .cv4-title:first-child { margin-top: 0; }
        #cv-template-4 .cv4-text { font-size: 13px; line-height: 1.5; color: #475569; margin-bottom: 15px; }
        #cv-template-4 .cv4-list { list-style: none; padding: 0; margin: 0; font-size: 13px; color: #1e293b; }
        #cv-template-4 .cv4-list li { margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        #cv-template-4 .cv4-list-bullet { list-style-type: disc; padding-left: 20px; font-size: 13px; color: #475569; line-height: 1.5; }
        #cv-template-4 .cv4-job { margin-bottom: 20px; }
        #cv-template-4 .cv4-job-title { font-weight: bold; font-size: 14px; color: #1e293b; margin-bottom: 2px; }
        #cv-template-4 .cv4-job-meta { font-size: 13px; font-style: italic; color: #64748b; margin-bottom: 8px; }
        #cv-template-4 .cv4-bar { width: 100%; height: 8px; background: #cbd5e1; border-radius: 4px; margin-top: 6px; }
        #cv-template-4 .cv4-bar-fill { height: 100%; background: #475a68; border-radius: 4px; }

        /* CV TEMPLATE 5 (Creativo - Verde/Rosa) */
        #cv-template-5 { display: flex; font-family: 'Georgia', serif; position: relative; }
        #cv-template-5 .cv5-left { width: 35%; background: #6a9a98; color: #fff; padding: 200px 30px 30px; display: flex; flex-direction: column; }
        #cv-template-5 .cv5-right { width: 65%; background: #fff; padding: 180px 40px 30px; position: relative; }
        #cv-template-5 .cv5-banner { position: absolute; top: 40px; left: 35%; width: 65%; height: 120px; background: #b88a8d; z-index: 1; display: flex; flex-direction: column; justify-content: center; padding-left: 110px; color: #fff; }
        #cv-template-5 .cv5-photo { position: absolute; top: 20px; left: 10%; width: 160px; height: 160px; border-radius: 50%; object-fit: cover; z-index: 2; border: 4px solid #fff; }
        #cv-template-5 .cv5-name { font-size: 30px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; line-height: 1.2; margin-bottom: 5px; }
        #cv-template-5 .cv5-role { font-size: 15px; font-style: italic; opacity: 0.9; }
        #cv-template-5 .cv5-title-left { font-size: 15px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; margin-top: 35px; }
        #cv-template-5 .cv5-title-left:first-child { margin-top: 0; }
        #cv-template-5 .cv5-text-left { font-size: 13px; line-height: 1.6; font-family: 'Helvetica', sans-serif; }
        #cv-template-5 .cv5-contact-item { font-family: 'Helvetica', sans-serif; font-size: 13px; margin-bottom: 12px; display: flex; align-items: center; gap: 10px; }
        #cv-template-5 .cv5-title-right { font-size: 16px; font-weight: bold; color: #2d3748; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; margin-top: 25px; display: flex; align-items: center; gap: 8px; }
        #cv-template-5 .cv5-title-right:first-child { margin-top: 0; }
        #cv-template-5 .cv5-title-icon { color: #6a9a98; font-size: 20px; font-weight: bold; }
        #cv-template-5 .cv5-item { font-family: 'Helvetica', sans-serif; margin-bottom: 15px; }
        #cv-template-5 .cv5-item-title { font-weight: bold; font-size: 13px; color: #1e293b; text-transform: uppercase; letter-spacing: 1px; }
        #cv-template-5 .cv5-item-meta { font-size: 13px; color: #64748b; font-style: italic; margin-bottom: 6px; }
        #cv-template-5 .cv5-list { padding-left: 20px; font-size: 13px; color: #475569; line-height: 1.6; }

        /* CV TEMPLATE 6 (Moderno - Malva) */
        #cv-template-6 { display: flex; font-family: 'Helvetica', sans-serif; position: relative; padding-top: 160px; }
        #cv-template-6 .cv6-banner { position: absolute; top: 0; right: 0; width: 62%; height: 160px; background: #ab8589; color: #fff; padding: 30px 40px; display: flex; flex-direction: column; justify-content: center; }
        #cv-template-6 .cv6-name { font-size: 34px; font-weight: 300; margin-bottom: 5px; }
        #cv-template-6 .cv6-role { font-size: 14px; text-transform: uppercase; letter-spacing: 3px; font-weight: 600; margin-bottom: 12px; opacity: 0.9; }
        #cv-template-6 .cv6-banner-text { font-size: 12px; line-height: 1.5; opacity: 0.85; }
        #cv-template-6 .cv6-photo { position: absolute; top: 30px; left: 8%; width: 140px; height: 140px; border-radius: 50%; object-fit: cover; z-index: 2; border: 5px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        #cv-template-6 .cv6-left { width: 38%; background: #f8f9fa; padding: 40px 30px; border-right: 1px solid #e2e8f0; }
        #cv-template-6 .cv6-right { width: 62%; background: #fff; padding: 40px; }
        #cv-template-6 .cv6-title { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #1e293b; margin-bottom: 20px; margin-top: 30px; }
        #cv-template-6 .cv6-title:first-child { margin-top: 0; }
        #cv-template-6 .cv6-item { margin-bottom: 20px; }
        #cv-template-6 .cv6-item-title { font-weight: 600; font-size: 14px; color: #0f172a; }
        #cv-template-6 .cv6-item-meta { font-size: 12px; color: #64748b; margin-bottom: 5px; }
        #cv-template-6 .cv6-list { list-style-type: none; padding: 0; margin: 0; font-size: 13px; color: #475569; }
        #cv-template-6 .cv6-list li { margin-bottom: 8px; position: relative; padding-left: 14px; line-height: 1.5; }
        #cv-template-6 .cv6-list li::before { content: '•'; position: absolute; left: 0; top: 0; color: #ab8589; font-weight: bold; font-size: 16px; }
        #cv-template-6 .cv6-contact-item { font-size: 13px; color: #475569; margin-bottom: 12px; display: flex; align-items: center; gap: 10px; }

        @media print {
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            body * { visibility: hidden; }
            #view-reportes, #view-reportes * { visibility: visible; }
            #view-reportes { position: absolute; left: 0; top: 0; width: 100%; min-height: 100vh; }
            .topbar, aside, .rpanel, .content-bar, footer, .template-selector { display: none !important; }
            .cv-template-view { display: none !important; }
            .cv-template-view.active-tpl { display: flex !important; }
            main { background: #fff; padding: 0; overflow: visible; width: 100%; min-height: 100vh; display: block; }
            .main-inner { padding: 0; display: block; }
            .cv-wrapper { padding-bottom: 0; justify-content: flex-start; min-height: 100vh; }
            .cv-container { box-shadow: none; width: 100%; min-height: 100vh; }
            @page { size: auto; margin: 0; }
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
            <button onclick="showView('menu')" class="tb-link" style="background:none;border:none;cursor:pointer;font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);font-family:'DM Sans',sans-serif;padding:0;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Inicio</button>
            <button onclick="showView('caracteristicas')" class="tb-link" style="background:none;border:none;cursor:pointer;font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);font-family:'DM Sans',sans-serif;padding:0;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Características</button>
            <button onclick="showView('portafolios')" class="tb-link" style="background:none;border:none;cursor:pointer;font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);font-family:'DM Sans',sans-serif;padding:0;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Portafolios</button>
            <button onclick="showView('explorador')" class="tb-link" style="background:none;border:none;cursor:pointer;font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.65);font-family:'DM Sans',sans-serif;padding:0;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.65)'">Explorador</button>
        </nav>
        @php
            $supabaseBase = rtrim(config('services.supabase.url'), '/')
                        . '/storage/v1/object/public/'
                        . config('services.supabase.bucket');
            $fotoNavbar = auth()->user()->foto_perfil
                ? $supabaseBase . '/' . ltrim(auth()->user()->foto_perfil, '/')
                : null;
        @endphp

        <div class="tb-right" style="display:flex;align-items:center;gap:12px;">
            <div class="tb-bell" style="cursor:pointer;">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>

            <div style="position:relative;">
                <button onclick="toggleNavMenu()"
                        style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);
                            border:1px solid rgba(255,255,255,0.15);border-radius:10px;
                            padding:6px 12px 6px 6px;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.14)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.08)'">

                    <div class="sb-av" id="sidebarAv" style="width:32px;height:32px;font-size:12px;">
                        @if($fotoNavbar)
                            <img src="{{ $fotoNavbar }}" alt=""
                                style="width:100%;height:100%;object-fit:cover;border-radius:50%"
                                onerror="this.style.display='none'">
                        @else
                            {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellido ?? '', 0, 1)) }}
                        @endif
                    </div>

                    <div style="text-align:left;">
                        <div style="font-size:13px;color:#fff;font-weight:600;white-space:nowrap;">
                            {{ auth()->user()->nombre }}
                        </div>
                        <div style="font-size:10px;color:#8ba5c8;">Mi cuenta ▾</div>
                    </div>
                </button>

                <!-- Minimenu -->
                <div id="navUserMenu"
                    style="display:none;position:absolute;top:calc(100% + 10px);right:0;
                            background:#fff;border-radius:14px;width:240px;
                            box-shadow:0 8px 30px rgba(0,0,0,0.18);border:1px solid #e2e8f0;
                            overflow:hidden;z-index:9999;">

                    <!-- Header -->
                    <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;
                                display:flex;align-items:center;gap:10px;">
                        <div style="width:40px;height:40px;border-radius:50%;overflow:hidden;flex-shrink:0;
                                    background:linear-gradient(135deg,#3b82f6,#0d9488);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:14px;font-weight:700;color:#fff;">
                            @if($fotoNavbar)
                                <img src="{{ $fotoNavbar }}" alt=""
                                    style="width:100%;height:100%;object-fit:cover;"
                                    onerror="this.style.display='none'">
                            @else
                                {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellido ?? '', 0, 1)) }}
                            @endif
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:13.5px;font-weight:700;color:#0f172a;
                                        overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                            </div>
                            <div style="font-size:11px;color:#64748b;
                                        overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>

                    <!-- Opciones -->
                    <div style="padding:6px;">
                        <button onclick="showView('perfil');cerrarNavMenu()"
                                style="width:100%;display:flex;align-items:center;gap:10px;
                                    padding:9px 12px;border-radius:8px;border:none;background:none;
                                    cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;
                                    color:#1e293b;text-align:left;transition:background .15s;"
                                onmouseover="this.style.background='#f1f5f9'"
                                onmouseout="this.style.background='none'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#64748b" stroke-width="2" stroke-linecap="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            Mi Perfil
                        </button>

                        <button onclick="showView('reportes');cerrarNavMenu()"
                                style="width:100%;display:flex;align-items:center;gap:10px;
                                    padding:9px 12px;border-radius:8px;border:none;background:none;
                                    cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;
                                    color:#1e293b;text-align:left;transition:background .15s;"
                                onmouseover="this.style.background='#f1f5f9'"
                                onmouseout="this.style.background='none'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#64748b" stroke-width="2" stroke-linecap="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                            </svg>
                            Reportes
                        </button>
                    </div>

                    <!-- Divider -->
                    <div style="height:1px;background:#f1f5f9;margin:0 6px;"></div>

                    <!-- Cerrar sesión -->
                    <div style="padding:6px;">
                        <button onclick="confirmarLogout()"
                                style="width:100%;display:flex;align-items:center;gap:10px;
                                    padding:9px 12px;border-radius:8px;border:none;background:none;
                                    cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;
                                    color:#dc2626;text-align:left;transition:background .15s;"
                                onmouseover="this.style.background='#fef2f2'"
                                onmouseout="this.style.background='none'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#dc2626" stroke-width="2" stroke-linecap="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Cerrar sesión
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="body-row">

        <!-- Sidebar -->
        <aside>
            <div class="sb-top">
                <button class="sb-item active" id="btn-menu" onclick="showView('menu')">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <span>Menú principal</span>
                </button>
                <div class="sb-div"></div>

                <button id="btn-portafolios" class="sb-item" onclick="showView('portafolios')">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    <span>Portafolios</span>
                </button>


                <a href="{{ route('academico') }}" class="sb-item {{ request()->routeIs('academico') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
    <span>Académico</span>
</a>
                <button id="btn-reportes" class="sb-item" onclick="showView('reportes')" style="background:none;border-top:none;border-right:none;border-bottom:none;width:100%;text-align:left;">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>Reportes</span>
                </button>
                <button id="btn-perfil" class="sb-item" onclick="showView('perfil')" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font-family:inherit;">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Mi Perfil</span>
                </button>
            </div>

            
            <form method="POST" action="{{ route('logout') }}" id="formLogout">
                @csrf
                <button type="button" onclick="confirmarLogout()" class="btn-logout">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>

            <!-- Modal confirmación logout -->
            <div id="modalLogout" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
                <div style="background:#fff;border-radius:20px;padding:32px;width:90%;max-width:340px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
                   <div style="width:52px;height:52px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </div>
                    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:#0f172a;margin-bottom:8px;">¿Cerrar sesión?</div>
                    <div style="font-size:13px;color:#64748b;margin-bottom:24px;">¿Estás seguro que deseas salir de tu cuenta?</div>
                    <div style="display:flex;gap:10px;">
                        <button onclick="document.getElementById('modalLogout').style.display='none'" style="flex:1;padding:12px;border-radius:12px;border:1.5px solid #e2e8f0;background:transparent;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">Cancelar</button>
                        <button onclick="ejecutarLogout(this)" style="flex:1;padding:12px;border-radius:12px;border:none;background:#2563eb;color:#fff;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px;">
                            <svg id="logoutSpinner" style="display:none;width:16px;height:16px;animation:spin .7s linear infinite;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                            </svg>
                            <span id="logoutBtnLabel">Sí, salir</span>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <div class="content-wrapper">
        <!-- Main content -->
        <main>
            <div class="main-inner">

                <!-- ══ VISTA MENÚ ══ -->
                <div class="view active" id="view-menu">
                    <div class="content-bar">
                        <div class="content-title">
                            <h1>Sistema de Portafolios</h1>
                            <p>Gestión institucional de activos digitales – UMSS</p>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="tb-search" style="background:#fff;border:1.5px solid var(--gray2);">
                                <svg viewBox="0 0 24 24" style="stroke:var(--muted)"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input type="text" placeholder="Search" style="color:var(--text);width:140px;">
                            </div>
                            <button onclick="abrirModalPortafolio()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:var(--blue);color:#fff;border-radius:10px;font-size:13px;font-weight:600;border:none;cursor:pointer;">
                                <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Crear portafolio
                            </button>
                        </div>
                    </div>

                    <!-- Stats -->
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
                        @foreach($portafolios as $index => $portafolio)
                        @php
                            $nArchivos   = $portafolio->archivos->count();
                            $publicado   = $portafolio->estado === 'publicado';
                            $estadoBadge = $publicado ? 'Publicado' : 'Borrador';
                        @endphp
                        @if($publicado)
                        <div class="pcard-teal">
                            <div class="pcard-top">
                                <div class="pcard-ico"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></div>
                                <div>
                                    <div class="pcard-name">{{ $portafolio->nombre }}</div>
                                    <div class="pcard-sub">{{ Str::limit($portafolio->descripcion, 60) }}</div>
                                </div>
                            </div>
                            <div class="pcard-bot">
                                <div>
                                    <div class="pcard-num">{{ $nArchivos }} <small>ARCHIVOS</small></div>
                                    <div class="pcard-st"><span class="dot dg"></span> Publicado</div>
                                </div>
                                <a href="#" class="btn-ver" onclick="verPortafolio({{ $portafolio->id }});return false;">Ver Panel</a>
                            </div>
                        </div>
                        @else
                        <div class="pcard-light">
                            <div class="pcard-top">
                                <div class="pcard-ico"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                <div>
                                    <div class="pcard-name">{{ $portafolio->nombre }}</div>
                                    <div class="pcard-sub">{{ Str::limit($portafolio->descripcion, 60) }}</div>
                                </div>
                            </div>
                            <div class="pcard-bot">
                                <div>
                                    <div class="pcard-num">{{ $nArchivos }} <small>ARCHIVOS</small></div>
                                    <div class="pcard-st"><span class="dot dy"></span> Borrador</div>
                                </div>
                                <a href="#" class="btn-ver-dk" onclick="verPortafolio({{ $portafolio->id }});return false;">Ver Panel</a>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div style="text-align:center;padding:3rem 1rem;color:var(--muted)">
                        <svg viewBox="0 0 24 24" style="width:48px;height:48px;fill:none;stroke:var(--gray3);stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;margin:0 auto 1rem;display:block"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                        <p style="font-size:15px;font-weight:600;color:var(--text);margin-bottom:6px">Sin portafolios aún</p>
                        <p style="font-size:13px">Crea tu primer portafolio para comenzar.</p>
                        <button onclick="abrirModalPortafolio()" style="display:inline-block;margin-top:1rem;padding:9px 22px;background:var(--blue);color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;border:none;cursor:pointer">Crear portafolio</button>
                    </div>
                    @endif
                </div>

                <!-- ══ VISTA EXPLORADOR ══ -->
                <div class="view" id="view-explorador">
                    <div class="exp-hero">
                        <div class="exp-hero-bg"></div>
                        <div class="exp-hero-content">
                            <div class="exp-hero-title">Sistema de Portafolios</div>
                            <div class="exp-hero-sub">Gestión Institucional de Activos Digitales · UMSS</div>
                            <div class="exp-search-wrap">
                                <div class="exp-search-box">
                                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    <input type="text" id="expSearch" placeholder="Buscar... (Ctrl + K)" onfocus="expShowHistory()" onkeydown="if(event.key==='Enter') expSearchAction()"/>
                                </div>
                                <button class="btn-buscar" onclick="expSearchAction()">Buscar</button>
                                <div id="expHistory" class="exp-history-dropdown" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="exp-filters">
                        <button class="exp-filter active" onclick="expSetFilter(this,'todos')">Todos</button>
                        <button class="exp-filter" onclick="expSetFilter(this,'proyecto')">Proyectos</button>
                        <button class="exp-filter" onclick="expSetFilter(this,'perfil')">Perfiles</button>
                        <button class="exp-filter" onclick="expSetFilter(this,'documento')">Documentos</button>
                        <button class="exp-filter" onclick="expSetFilter(this,'habilidad')">Habilidades</button>
                    </div>

                    <div class="exp-results-bar">
                        <span class="exp-count" id="expCount">0 Resultados</span>
                        @if(isset($busquedas) && count($busquedas) > 0)
                            <span style="background: #dcfce7; color: #166534; padding: 2px 10px; border-radius: 5px; font-size: 11px; font-weight: bold; margin-left: 10px;">
                                DIFUSION: BASE DE DATOS ACTIVA
                            </span>
                        @endif
                        <div id="sortContainer" style="position: relative; display: inline-block;">
                            <button class="exp-filter" onclick="document.getElementById('sortMenu').style.display = document.getElementById('sortMenu').style.display === 'block' ? 'none' : 'block'" style="display:inline-flex; align-items:center; gap:6px;">
                                <span id="sortLabel">Ordenar por relevancia</span>
                                <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="sortMenu" style="display: none; position: absolute; right: 0; top: 110%; background: #fff; border: 1.5px solid var(--gray2); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 10; min-width: 160px; overflow: hidden;">
                                <div onclick="expSetSort('relevancia', 'Ordenar por relevancia')" style="padding: 8px 16px; font-size: 13px; font-family:'DM Sans',sans-serif; cursor: pointer; transition: background 0.2s; color: var(--text);" onmouseover="this.style.background='var(--gray)'" onmouseout="this.style.background='transparent'">Relevancia</div>
                                <div onclick="expSetSort('az', 'Ordenar: A - Z')" style="padding: 8px 16px; font-size: 13px; font-family:'DM Sans',sans-serif; cursor: pointer; transition: background 0.2s; color: var(--text);" onmouseover="this.style.background='var(--gray)'" onmouseout="this.style.background='transparent'">A - Z</div>
                                <div onclick="expSetSort('za', 'Ordenar: Z - A')" style="padding: 8px 16px; font-size: 13px; font-family:'DM Sans',sans-serif; cursor: pointer; transition: background 0.2s; color: var(--text);" onmouseover="this.style.background='var(--gray)'" onmouseout="this.style.background='transparent'">Z - A</div>
                            </div>
                        </div>
                    </div>
                    <div class="exp-grid" id="expGrid"></div>
                </div>
            <!-- ══ VISTA CARACTERÍSTICAS ══ -->
                <div class="view" id="view-caracteristicas">
                    <div class="content-bar">
                        <div class="content-title">
                            <h1>Características</h1>
                            <p>Todo lo que SansiFolios ofrece para ti</p>
                        </div>
                    </div>
                    <div class="caract-grid">
                        <div style="border-left:4px solid #2563eb;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
                            <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">Diseño Adaptable</h3>
                            <p style="font-size:13px;color:var(--muted);margin-top:6px;">Plantillas profesionales diseñadas para resaltar lo mejor de cada carrera.</p>
                        </div>
                        <div style="border-left:4px solid #7c3aed;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
                            <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">Editor Intuitivo</h3>
                            <p style="font-size:13px;color:var(--muted);margin-top:6px;">Crea y organiza tu información sin complicaciones.</p>
                        </div>
                        <div style="border-left:4px solid #ec4899;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
                            <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">Marca Personal</h3>
                            <p style="font-size:13px;color:var(--muted);margin-top:6px;">Personaliza colores, tipografías y secciones de tu perfil.</p>
                        </div>
                        <div style="border-left:4px solid #f97316;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
                            <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">Exportación Inteligente</h3>
                            <p style="font-size:13px;color:var(--muted);margin-top:6px;">Genera una versión en PDF optimizada con un solo clic.</p>
                        </div>
                        <div style="border-left:4px solid #10b981;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
                            <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">Enlace Único</h3>
                            <p style="font-size:13px;color:var(--muted);margin-top:6px;">Obtén una URL personalizada para compartir en redes sociales.</p>
                        </div>
                    </div>
                </div>

              <!-- ══ VISTA PORTAFOLIOS ══ -->
<div class="view" id="view-portafolios">
    <div class="content-bar">
        <div class="content-title">
            <h1>Inspírate con profesionales reales</h1>
            <p>Explora cómo otros expertos destacan en su industria usando SansiFolios.</p>
        </div>
    </div>

    <!-- Filtros -->
    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:1.4rem;">
        <button style="padding:7px 20px;border-radius:999px;background:var(--blue);color:#fff;border:none;font-size:13px;font-weight:600;cursor:pointer;">Todos</button>
        <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">🎨 Creativos</button>
        <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">🩺 Salud</button>
        <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">💼 Negocios</button>
        <button style="padding:7px 20px;border-radius:999px;background:#fff;border:1.5px solid var(--gray2);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;">🎓 Educación</button>
    </div>

    <!-- Grid -->
    <div class="porta-grid">

        <div style="background:#D9EBFF;border-radius:24px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'">
            <div style="position:relative;height:180px;overflow:hidden;">
                <img src="{{ asset('images/arqui.png') }}" style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute;top:10px;left:10px;background:#ec4899;color:#fff;font-size:9px;font-weight:700;padding:3px 10px;border-radius:999px;letter-spacing:1px;text-transform:uppercase;">Arquitectura</div>
            </div>
            <div style="padding:1rem;">
                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:#1e293b;">Arq. Roberto Méndez</div>
                <div style="font-size:11.5px;color:var(--muted);margin-top:3px;">Diseño Sostenible • Cochabamba</div>
                <button style="margin-top:10px;width:100%;padding:9px;background:#f8fafc;color:#1e293b;border:none;border-radius:14px;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .3s;" onmouseover="this.style.background='#2563eb';this.style.color='#fff'" onmouseout="this.style.background='#f8fafc';this.style.color='#1e293b'">Ver Perfil →</button>
            </div>
        </div>

        <div style="background:#D9EBFF;border-radius:24px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'">
            <div style="position:relative;height:180px;overflow:hidden;">
                <img src="{{ asset('images/fisio.png') }}" style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute;top:10px;left:10px;background:#10b981;color:#fff;font-size:9px;font-weight:700;padding:3px 10px;border-radius:999px;letter-spacing:1px;text-transform:uppercase;">Fisioterapia</div>
            </div>
            <div style="padding:1rem;">
                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:#1e293b;">Dra. Elena Vargas</div>
                <div style="font-size:11.5px;color:var(--muted);margin-top:3px;">Rehabilitación Deportiva • La Paz</div>
                <button style="margin-top:10px;width:100%;padding:9px;background:#f8fafc;color:#1e293b;border:none;border-radius:14px;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .3s;" onmouseover="this.style.background='#2563eb';this.style.color='#fff'" onmouseout="this.style.background='#f8fafc';this.style.color='#1e293b'">Ver Perfil →</button>
            </div>
        </div>

        <div style="background:#D9EBFF;border-radius:24px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'">
            <div style="position:relative;height:180px;overflow:hidden;">
                <img src="{{ asset('images/contador.png') }}" style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute;top:10px;left:10px;background:#3b82f6;color:#fff;font-size:9px;font-weight:700;padding:3px 10px;border-radius:999px;letter-spacing:1px;text-transform:uppercase;">Consultoría</div>
            </div>
            <div style="padding:1rem;">
                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:#1e293b;">Lic. Carlos Duarte</div>
                <div style="font-size:11.5px;color:var(--muted);margin-top:3px;">Estrategia Financiera • Santa Cruz</div>
                <button style="margin-top:10px;width:100%;padding:9px;background:#f8fafc;color:#1e293b;border:none;border-radius:14px;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .3s;" onmouseover="this.style.background='#2563eb';this.style.color='#fff'" onmouseout="this.style.background='#f8fafc';this.style.color='#1e293b'">Ver Perfil →</button>
            </div>
        </div>

        <div style="background:#D9EBFF;border-radius:24px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'">
            <div style="position:relative;height:180px;overflow:hidden;">
                <img src="{{ asset('images/prof.png') }}" style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute;top:10px;left:10px;background:#f59e0b;color:#fff;font-size:9px;font-weight:700;padding:3px 10px;border-radius:999px;letter-spacing:1px;text-transform:uppercase;">Docencia</div>
            </div>
            <div style="padding:1rem;">
                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:#1e293b;">Msc. Ana Jiménez</div>
                <div style="font-size:11.5px;color:var(--muted);margin-top:3px;">Metodologías Activas • Sucre</div>
                <button style="margin-top:10px;width:100%;padding:9px;background:#f8fafc;color:#1e293b;border:none;border-radius:14px;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .3s;" onmouseover="this.style.background='#2563eb';this.style.color='#fff'" onmouseout="this.style.background='#f8fafc';this.style.color='#1e293b'">Ver Perfil →</button>
            </div>
        </div>

    </div>
</div>

                <!-- ══ VISTA REPORTES ══ -->
                <div class="view" id="view-reportes">
                    @php
                        $r_user = auth()->user();
                        $r_exp = $r_user ? $r_user->experiencias()->orderBy('fecha_inicio', 'desc')->get() : [];
                        $r_form = $r_user ? $r_user->formaciones()->orderBy('fecha_inicio', 'desc')->get() : [];
                        $r_habF = $r_user ? $r_user->habilidades()->where('tipo', 'fuerte')->get() : [];
                        $r_habB = $r_user ? $r_user->habilidades()->where('tipo', 'blanda')->get() : [];
                        $r_cert = $r_user ? $r_user->certificaciones()->orderBy('fecha_obtencion', 'desc')->get() : [];
                    @endphp
                    <div class="content-bar">
                        <div class="content-title">
                            <h1>Reportes y Documentos</h1>
                            <p>Genera y exporta planillas, hojas de vida y curriculum vitae en formato PDF.</p>
                        </div>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <button id="btn-edit-cv" class="btn-export" onclick="toggleEditCV()" style="background: #e2e8f0; color: #1e293b; border: none;">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Editar en pantalla
                            </button>
                            <button class="btn-export" onclick="window.print()">
                                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Exportar PDF
                            </button>
                        </div>
                    </div>

                    <div class="template-selector" style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px; background: #f8fafc; padding: 15px 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <label for="cv-template-select" style="font-size: 14px; font-weight: 600; color: #475569; margin: 0;">Seleccionar Plantilla:</label>
                        <select id="cv-template-select" onchange="selectTemplate(this.value)" style="padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; font-weight: 500; color: #1e293b; outline: none; cursor: pointer; flex: 1; max-width: 320px; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                            <option value="cv-template-1">Moderno (Azul)</option>
                            <option value="cv-template-2">Clásico (Formal)</option>
                            <option value="cv-template-3">Minimalista</option>
                            <option value="cv-template-4">Elegante (Gris)</option>
                            <option value="cv-template-5">Creativo (Verde/Rosa)</option>
                            <option value="cv-template-6">Moderno (Malva)</option>
                        </select>
                    </div>

                    @php
                        $supabaseBase = rtrim(config('services.supabase.url'), '/')
                                    . '/storage/v1/object/public/'
                                    . config('services.supabase.bucket');
                        $fotoCV = auth()->user()->foto_perfil
                            ? $supabaseBase . '/' . ltrim(auth()->user()->foto_perfil, '/')
                            : null;
                    @endphp

                    <div class="cv-wrapper">
                        <!-- CV TEMPLATE 1 (Moderno) -->
                        <div class="cv-container cv-template-view active-tpl" id="cv-template-1">
                            <div class="cv-left">
                                <div class="cv-bg-pattern"></div>
                                <div class="cv-photo-box">
                                    @if($fotoCV)
                                        <img src="{{ $fotoCV }}" alt="Foto" class="cv-photo">
                                    @else
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
                                        @if(count($r_habB) > 0)
                                            @foreach($r_habB as $hab)
                                                <li>{{ $hab->nombre }}</li>
                                            @endforeach
                                        @else
                                            <li>Trabajo en equipo.</li>
                                            <li>Iniciativa.</li>
                                            <li>Resoluci&oacute;n de problemas.</li>
                                            <li>Aprendizaje fluido.</li>
                                            <li>Comunicaci&oacute;n efectiva.</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="cv-section-left">
                                    <div class="cv-title-left">RESUMEN PROFESIONAL</div>
                                    <div class="cv-text-left">
                                        @if(auth()->check() && auth()->user()->biografia)
                                            {{ auth()->user()->biografia }}
                                        @else
                                            Programadora web con m&aacute;s de 5 a&ntilde;os de trayectoria desarrolladas en el eCommerce. A lo largo de estos a&ntilde;os, he tenido el privilegio de formar parte en la creaci&oacute;n de webs como geekletics.es y peternappi.es, las cuales han cultivado un gran &eacute;xito, tanto en tr&aacute;fico como en conversiones.
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="cv-right">
                                <h1 class="cv-name">
                                    @if(auth()->check())
                                        {{ auth()->user()->nombre }}<br>{{ auth()->user()->apellido }}
                                    @else
                                        Eva S&aacute;nchez<br>Linares
                                    @endif
                                </h1>

                                <div class="cv-section-right">
                                    <div class="cv-title-right">HABILIDADES INFORM&Aacute;TICAS</div>
                                    <ul class="cv-list-right">
                                        @if(count($r_habF) > 0)
                                            @foreach($r_habF as $hab)
                                                <li>{{ $hab->nombre }}{{ $hab->nivel ? ' ('.$hab->nivel.')' : '' }}</li>
                                            @endforeach
                                        @else
                                            <li>Programaci&oacute;n con JavaScript, CSS, HTML, C#, SQL.</li>
                                            <li>Conocimientos avanzados de Prestashop.</li>
                                            <li>Manejo de MySQL, MariaDB, Mongodb.</li>
                                            <li>Desarrollo de aplicaciones m&oacute;viles.</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="cv-section-right">
                                    <div class="cv-title-right">CURSOS Y CERTIFICADOS</div>
                                    <ul class="cv-list-right">
                                        @if(count($r_cert) > 0)
                                            @foreach($r_cert as $cert)
                                                <li>{{ $cert->nombre }} ({{ $cert->fecha_obtencion ? $cert->fecha_obtencion->format('Y') : '' }}) - {{ $cert->organizacion }}</li>
                                            @endforeach
                                        @else
                                            <li>Programaci&oacute;n avanzada en JavaScript (200 horas) - Edx</li>
                                            <li>Adobe Illustrator para dise&ntilde;o gr&aacute;fico (140 horas) - Domestika</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="cv-section-right">
                                    <div class="cv-title-right">HISTORIAL LABORAL</div>
                                    @if(count($r_exp) > 0)
                                        @foreach($r_exp as $exp)
                                            <div class="cv-job-container">
                                                <div class="cv-job-date">{{ $exp->fecha_inicio ? $exp->fecha_inicio->format('M Y') : '' }} - {{ $exp->actual ? 'Actualidad' : ($exp->fecha_fin ? $exp->fecha_fin->format('M Y') : '') }}</div>
                                                <div class="cv-job-title">{{ $exp->cargo }} &middot; {{ $exp->empresa }}</div>
                                                @if($exp->descripcion)
                                                    <div class="cv-job-desc" style="white-space: pre-line; line-height: 1.5;">{{ $exp->descripcion }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="cv-job-container">
                                            <div class="cv-job-date">Junio 2017 - Marzo 2020</div>
                                            <div class="cv-job-title">Desarrolladora web eCommerce Hays Response, Zaragoza</div>
                                            <ul class="cv-job-desc">
                                                <li>Maquetaci&oacute;n mediante CSS.</li>
                                                <li>Optimizaci&oacute;n de SEO on page.</li>
                                                <li>Programaci&oacute;n con JavaScript.</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="cv-section-right" style="margin-bottom: 0;">
                                    <div class="cv-title-right">FORMACI&Oacute;N</div>
                                    @if(count($r_form) > 0)
                                        @foreach($r_form as $form)
                                            <div class="cv-job-container" style="margin-bottom: 10px;">
                                                <div class="cv-job-date" style="color: #1e293b; font-weight: 700; margin-bottom: 2px;">{{ $form->fecha_inicio ? $form->fecha_inicio->format('Y') : '' }}</div>
                                                <div style="font-size: 12px;">{{ $form->titulo }} - {{ $form->institucion }}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="cv-job-container" style="margin-bottom: 0;">
                                            <div class="cv-job-date" style="color: #1e293b; font-weight: 700; margin-bottom: 2px;">2015</div>
                                            <div style="font-size: 12px;">Grado Superior en Desarrollo de Aplicaciones Web</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- CV TEMPLATE 2 (Clásico) -->
                        <div class="cv-container cv-template-view" id="cv-template-2">
                            <div class="cv2-header">
                                <div class="cv2-name">
                                    @if(auth()->check())
                                        {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                                    @else
                                        Eva S&aacute;nchez Linares
                                    @endif
                                </div>
                                <div class="cv2-contact">
                                    <span>Avda. de Andaluc&iacute;a, 41</span>
                                    <span>|</span>
                                    <span>692 454 731</span>
                                    <span>|</span>
                                    <span>{{ auth()->check() ? auth()->user()->email : 'evasanchezlinares@gmail.com' }}</span>
                                </div>
                            </div>

                            <div class="cv2-section">
                                <div class="cv2-title">Resumen Profesional</div>
                                <div style="font-size: 13px; line-height: 1.5; color: #334155;">
                                    @if(auth()->check() && auth()->user()->biografia)
                                        {{ auth()->user()->biografia }}
                                    @else
                                        Programadora web con m&aacute;s de 5 a&ntilde;os de trayectoria desarrolladas en el eCommerce. A lo largo de estos a&ntilde;os, he tenido el privilegio de formar parte en la creaci&oacute;n de webs de gran &eacute;xito. Busco formar parte de Gesico Sistemas para mi capacidad creativa al siguiente nivel, aportando mis amplio conocimientos en CSS y Prestashop.
                                    @endif
                                </div>
                            </div>

                            <div class="cv2-section">
                                <div class="cv2-title">Experiencia Laboral</div>
                                @if(count($r_exp) > 0)
                                    @foreach($r_exp as $exp)
                                        <div class="cv2-item">
                                            <div class="cv2-item-header">
                                                <div class="cv2-item-title">{{ $exp->cargo }} - {{ $exp->empresa }}</div>
                                                <div class="cv2-item-date">{{ $exp->fecha_inicio ? $exp->fecha_inicio->format('M Y') : '' }} - {{ $exp->actual ? 'Actualidad' : ($exp->fecha_fin ? $exp->fecha_fin->format('M Y') : '') }}</div>
                                            </div>
                                            @if($exp->descripcion)
                                                <div style="font-size: 13px; color: #334155; line-height: 1.5; white-space: pre-line; padding-left: 10px;">{{ $exp->descripcion }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv2-item">
                                        <div class="cv2-item-header">
                                            <div class="cv2-item-title">Desarrolladora web eCommerce - Hays Response</div>
                                            <div class="cv2-item-date">Junio 2017 - Marzo 2020</div>
                                        </div>
                                        <ul>
                                            <li>Maquetaci&oacute;n mediante CSS y Optimizaci&oacute;n SEO on page.</li>
                                            <li>Programaci&oacute;n con JavaScript e implementaci&oacute;n de BBDD.</li>
                                            <li>Incremento en un 30% del tr&aacute;fico de clientes.</li>
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="cv2-section">
                                <div class="cv2-title">Formaci&oacute;n Acad&eacute;mica</div>
                                @if(count($r_form) > 0)
                                    @foreach($r_form as $form)
                                        <div class="cv2-item">
                                            <div class="cv2-item-header">
                                                <div class="cv2-item-title">{{ $form->titulo }} - {{ $form->institucion }}</div>
                                                <div class="cv2-item-date">{{ $form->fecha_inicio ? $form->fecha_inicio->format('Y') : '' }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv2-item">
                                        <div class="cv2-item-header">
                                            <div class="cv2-item-title">Grado Superior en Desarrollo de Aplicaciones Web</div>
                                            <div class="cv2-item-date">2015</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="cv2-section">
                                <div class="cv2-title">Habilidades e Idiomas</div>
                                <div style="display: flex; gap: 40px; font-size: 13px; color: #334155; line-height: 1.5;">
                                    <div>
                                        <strong>Competencias:</strong><br>
                                        @if(count($r_habB) > 0)
                                            @foreach($r_habB as $hab)
                                                {{ $hab->nombre }}<br>
                                            @endforeach
                                        @else
                                            Trabajo en equipo<br>Iniciativa
                                        @endif
                                    </div>
                                    <div>
                                        <strong>Inform&aacute;tica:</strong><br>
                                        @if(count($r_habF) > 0)
                                            @foreach($r_habF as $hab)
                                                {{ $hab->nombre }}{{ $hab->nivel ? ' ('.$hab->nivel.')' : '' }}<br>
                                            @endforeach
                                        @else
                                            JavaScript, CSS, HTML, SQL<br>MySQL, MariaDB
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CV TEMPLATE 3 (Minimalista) -->
                        <div class="cv-container cv-template-view" id="cv-template-3">
                            <div class="cv3-left">
                                <div class="cv3-name">
                                    @if(auth()->check())
                                        {{ auth()->user()->nombre }}<br>{{ auth()->user()->apellido }}
                                    @else
                                        Eva<br>S&aacute;nchez
                                    @endif
                                </div>
                                <div class="cv3-role">{{ auth()->check() && auth()->user()->profesion ? auth()->user()->profesion : 'Programadora Web' }}</div>

                                <div class="cv3-section-title">Contacto</div>
                                <div class="cv3-contact-item">Avda. de Andaluc&iacute;a, 41</div>
                                <div class="cv3-contact-item">692 454 731</div>
                                <div class="cv3-contact-item">{{ auth()->check() ? auth()->user()->email : 'evasanchezlinares@gmail.com' }}</div>

                                <div class="cv3-section-title">Habilidades</div>
                                <div>
                                    @if(count($r_habF) > 0 || count($r_habB) > 0)
                                        @foreach($r_habF as $hab)
                                            <span class="cv3-skill">{{ $hab->nombre }}</span>
                                        @endforeach
                                        @foreach($r_habB as $hab)
                                            <span class="cv3-skill">{{ $hab->nombre }}</span>
                                        @endforeach
                                    @else
                                        <span class="cv3-skill">JavaScript</span>
                                        <span class="cv3-skill">CSS</span>
                                        <span class="cv3-skill">HTML</span>
                                        <span class="cv3-skill">SQL</span>
                                    @endif
                                </div>
                            </div>
                            <div style="padding-left: 20px;">
                                <div class="cv3-section-title" style="margin-top:0;">Perfil</div>
                                <div style="font-size:13px; color:#475569; line-height:1.6; margin-bottom: 30px;">
                                    @if(auth()->check() && auth()->user()->biografia)
                                        {{ auth()->user()->biografia }}
                                    @else
                                        Programadora web con m&aacute;s de 5 a&ntilde;os de trayectoria desarrolladas en el eCommerce. A lo largo de estos a&ntilde;os, he tenido el privilegio de formar parte en la creaci&oacute;n de webs como geekletics.es y peternappi.es.
                                    @endif
                                </div>

                                <div class="cv3-section-title">Experiencia</div>
                                @if(count($r_exp) > 0)
                                    @foreach($r_exp as $exp)
                                        <div class="cv3-job">
                                            <div class="cv3-job-date">{{ $exp->fecha_inicio ? $exp->fecha_inicio->format('M Y') : '' }} - {{ $exp->actual ? 'Actualidad' : ($exp->fecha_fin ? $exp->fecha_fin->format('M Y') : '') }}</div>
                                            <div class="cv3-job-title">{{ $exp->cargo }} &middot; {{ $exp->empresa }}</div>
                                            @if($exp->descripcion)
                                                <div class="cv3-job-desc" style="white-space: pre-line;">{{ $exp->descripcion }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv3-job">
                                        <div class="cv3-job-date">Junio 2017 - Marzo 2020</div>
                                        <div class="cv3-job-title">Desarrolladora web eCommerce &middot; Hays Response</div>
                                        <div class="cv3-job-desc">
                                            Maquetaci&oacute;n mediante CSS y Optimizaci&oacute;n SEO on page. Programaci&oacute;n con JavaScript.
                                        </div>
                                    </div>
                                @endif

                                <div class="cv3-section-title">Educaci&oacute;n</div>
                                @if(count($r_form) > 0)
                                    @foreach($r_form as $form)
                                        <div class="cv3-job" style="margin-bottom:15px;">
                                            <div class="cv3-job-date">{{ $form->fecha_inicio ? $form->fecha_inicio->format('Y') : '' }}</div>
                                            <div class="cv3-job-title">{{ $form->titulo }} &middot; {{ $form->institucion }}</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv3-job" style="margin-bottom:0;">
                                        <div class="cv3-job-date">2015</div>
                                        <div class="cv3-job-title">Grado Superior en Desarrollo de Aplicaciones Web</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- CV TEMPLATE 4 (Elegante) -->
                        <div class="cv-container cv-template-view" id="cv-template-4">
                            <div class="cv4-header">
                                <div class="cv4-name-box">
                                    <div class="cv4-name">{!! auth()->check() ? auth()->user()->nombre . ' ' . auth()->user()->apellido : 'Nombres Apellidos' !!}</div>
                                    <div class="cv4-role">{!! auth()->check() && auth()->user()->profesion ? auth()->user()->profesion : 'Puesto Ocupado' !!}</div>
                                </div>
                            </div>
                            @if(auth()->check() && auth()->user()->foto_perfil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="Foto" class="cv4-photo">
                            @else
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop" alt="Foto" class="cv4-photo">
                            @endif
                            <div class="cv4-left">
                                <div class="cv4-title" style="margin-top:0;">Contacto</div>
                                <div class="cv4-text">
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        692 454 731
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;word-break:break-all;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                        {{ auth()->check() ? auth()->user()->email : 'nombre.apellido@mail.com' }}
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        Ciudad, Pa&iacute;s
                                    </div>
                                </div>

                                <div class="cv4-title">Idiomas</div>
                                <div class="cv4-text">
                                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                        <span>Ingl&eacute;s</span><div style="width:60%;height:6px;background:#475a68;border-radius:3px;"></div>
                                    </div>
                                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                        <span>Franc&eacute;s</span><div style="width:40%;height:6px;background:#475a68;border-radius:3px;"></div>
                                    </div>
                                </div>

                                <div class="cv4-title">Habilidades</div>
                                <ul class="cv4-list">
                                    @if(count($r_habB) > 0 || count($r_habF) > 0)
                                        @foreach($r_habF as $hab)
                                            <li>{{ $hab->nombre }}</li>
                                        @endforeach
                                        @foreach($r_habB as $hab)
                                            <li>{{ $hab->nombre }}</li>
                                        @endforeach
                                    @else
                                        <li>Trabajo en equipo</li>
                                        <li>Comunicaci&oacute;n</li>
                                        <li>Capacidad de adaptaci&oacute;n</li>
                                        <li>Creatividad</li>
                                        <li>Liderazgo</li>
                                    @endif
                                </ul>

                                <div class="cv4-title">Intereses</div>
                                <ul class="cv4-list">
                                    <li>Lectura</li>
                                    <li>Arte</li>
                                    <li>Deportes</li>
                                </ul>
                            </div>
                            
                            <div class="cv4-right">
                                <div class="cv4-title" style="margin-top:0;">Perfil</div>
                                <div class="cv4-text">
                                    @if(auth()->check() && auth()->user()->biografia)
                                        {{ auth()->user()->biografia }}
                                    @else
                                        En este apartado de tu hoja de vida debes escribir tu experiencia profesional y habilidades m&aacute;s importantes.
                                    @endif
                                </div>

                                <div class="cv4-title">Experiencia Profesional</div>
                                @if(count($r_exp) > 0)
                                    @foreach($r_exp as $exp)
                                        <div class="cv4-job">
                                            <div class="cv4-job-title">{{ $exp->cargo }}</div>
                                            <div class="cv4-job-meta"><strong>{{ $exp->empresa }}</strong> | {{ $exp->fecha_inicio ? $exp->fecha_inicio->format('Y') : '' }} - {{ $exp->actual ? 'Actualidad' : ($exp->fecha_fin ? $exp->fecha_fin->format('Y') : '') }}</div>
                                            @if($exp->descripcion)
                                                <ul class="cv4-list-bullet">
                                                    <li>{{ $exp->descripcion }}</li>
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv4-job">
                                        <div class="cv4-job-title">Puesto ocupado</div>
                                        <div class="cv4-job-meta"><strong>NOMBRE DE LA EMPRESA</strong> | 20XX - 20XX</div>
                                        <ul class="cv4-list-bullet">
                                            <li>Descripci&oacute;n de las actividades realizadas.</li>
                                        </ul>
                                    </div>
                                @endif

                                <div class="cv4-title">Formaci&oacute;n</div>
                                @if(count($r_form) > 0)
                                    @foreach($r_form as $form)
                                        <div class="cv4-job">
                                            <div class="cv4-job-title">{{ $form->titulo }}</div>
                                            <div class="cv4-job-meta"><strong>{{ $form->institucion }}</strong> | {{ $form->fecha_inicio ? $form->fecha_inicio->format('Y') : '' }}</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv4-job">
                                        <div class="cv4-job-title">Nombre del grado o t&iacute;tulo obtenido</div>
                                        <div class="cv4-job-meta"><strong>Nombre de la instituci&oacute;n</strong> | 20XX</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- CV TEMPLATE 5 (Creativo) -->
                        <div class="cv-container cv-template-view" id="cv-template-5">
                            <div class="cv5-banner">
                                <div class="cv5-name">{!! auth()->check() ? auth()->user()->nombre . '<br>' . auth()->user()->apellido : 'Nombres<br>Apellidos' !!}</div>
                                <div class="cv5-role">{!! auth()->check() && auth()->user()->profesion ? auth()->user()->profesion : 'Lic. Ingenier&iacute;a de Sistemas' !!}</div>
                            </div>
                            @if(auth()->check() && auth()->user()->foto_perfil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="Foto" class="cv5-photo">
                            @else
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop" alt="Foto" class="cv5-photo">
                            @endif

                            <div class="cv5-left">
                                <div class="cv5-title-left">Perfil</div>
                                <div class="cv5-text-left" style="margin-bottom:30px;">
                                    @if(auth()->check() && auth()->user()->biografia)
                                        {{ auth()->user()->biografia }}
                                    @else
                                        Ingeniero de Sistemas, responsable y comprometido con el aprendizaje continuo. Poseo grandes expectativas de desarrollo profesional.
                                    @endif
                                </div>

                                <div class="cv5-title-left">Contacto</div>
                                <div class="cv5-contact-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    692 454 731
                                </div>
                                <div class="cv5-contact-item" style="word-break:break-all;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    {{ auth()->check() ? auth()->user()->email : 'correo@ejemplo.com' }}
                                </div>
                                <div class="cv5-contact-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    Cochabamba, Bolivia
                                </div>
                            </div>

                            <div class="cv5-right">
                                <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Educaci&oacute;n</div>
                                @if(count($r_form) > 0)
                                    @foreach($r_form as $form)
                                        <ul class="cv5-list" style="margin-bottom:10px;list-style:disc;">
                                            <li><strong>{{ $form->institucion }}</strong><br>{{ $form->titulo }}</li>
                                        </ul>
                                    @endforeach
                                @else
                                    <ul class="cv5-list" style="margin-bottom:10px;list-style:disc;">
                                        <li><strong>UNIVERSIDAD MAYOR DE SAN SIMON</strong><br>Carrera en licenciatura de ingenier&iacute;a de sistemas</li>
                                    </ul>
                                @endif

                                <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Lenguaje</div>
                                <ul class="cv5-list" style="list-style:disc;">
                                    <li>Espa&ntilde;ol: Nativo</li>
                                    <li>Ingl&eacute;s: B&aacute;sico</li>
                                </ul>

                                <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Habilidades (T&eacute;cnicas)</div>
                                <ul class="cv5-list" style="list-style:disc;">
                                    @if(count($r_habF) > 0)
                                        @foreach($r_habF as $hab)
                                            <li><strong>{{ $hab->nombre }}</strong>: Nivel {{ $hab->nivel ?: 'Básico' }}</li>
                                        @endforeach
                                    @else
                                        <li><strong>Curso de Python b&aacute;sico</strong>: manejo b&aacute;sico de lenguaje.</li>
                                        <li><strong>Java</strong>: manejo de fundamentos de programaci&oacute;n.</li>
                                    @endif
                                </ul>

                                <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Certificados</div>
                                <ul class="cv5-list" style="list-style:disc;">
                                    @if(count($r_cert) > 0)
                                        @foreach($r_cert as $cert)
                                            <li>Certificado de {{ $cert->nombre }}</li>
                                        @endforeach
                                    @else
                                        <li>Certificado de participaci&oacute;n de agente censal</li>
                                    @endif
                                </ul>

                                <div class="cv5-title-right"><span class="cv5-title-icon">❯</span> Experiencia Laboral</div>
                                <ul class="cv5-list" style="list-style:disc;">
                                    @if(count($r_exp) > 0)
                                        @foreach($r_exp as $exp)
                                            <li><strong>{{ $exp->empresa }}</strong><br>{{ $exp->cargo }}</li>
                                        @endforeach
                                    @else
                                        <li><strong>SISTEMA DE INVENTARIO Y VENTAS</strong><br>Desarrollador</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- CV TEMPLATE 6 (Moderno) -->
                        <div class="cv-container cv-template-view" id="cv-template-6">
                            <div class="cv6-banner">
                                <div class="cv6-name">{!! auth()->check() ? auth()->user()->nombre . ' ' . auth()->user()->apellido : 'Emilia Ram&iacute;rez' !!}</div>
                                <div class="cv6-role">{!! auth()->check() && auth()->user()->profesion ? auth()->user()->profesion : 'ESTUDIANTE' !!}</div>
                                <div class="cv6-banner-text">
                                    @if(auth()->check() && auth()->user()->biografia)
                                        {{ auth()->user()->biografia }}
                                    @else
                                        Estudiante de Administraci&oacute;n de Empresas. Me considero una persona responsable y ordenada.
                                    @endif
                                </div>
                            </div>
                            @if(auth()->check() && auth()->user()->foto_perfil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="Foto" class="cv6-photo">
                            @else
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=300&auto=format&fit=crop" alt="Foto" class="cv6-photo">
                            @endif

                            <div class="cv6-left">
                                <div class="cv6-title">Educaci&oacute;n</div>
                                @if(count($r_form) > 0)
                                    @foreach($r_form as $form)
                                        <div class="cv6-item">
                                            <ul class="cv6-list">
                                                <li>{{ $form->institucion }}<br>
                                                <span style="color:#64748b;">{{ $form->fecha_inicio ? $form->fecha_inicio->format('Y') : '' }}</span><br>
                                                {{ $form->titulo }}</li>
                                            </ul>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv6-item">
                                        <ul class="cv6-list">
                                            <li>Universidad Borcelle<br>
                                            <span style="color:#64748b;">2019-2023</span><br>
                                            Carrera de Derecho, en Curso.</li>
                                        </ul>
                                    </div>
                                @endif

                                <div class="cv6-title">Idiomas</div>
                                <ul class="cv6-list">
                                    <li>Idioma Ingl&eacute;s Avanzado<br>
                                    <span style="color:#64748b;">Nivel Oral: Biling&uuml;e</span></li>
                                </ul>

                                <div class="cv6-title" style="margin-top:40px;">Contacto</div>
                                <div class="cv6-contact-item">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    {{ auth()->check() ? auth()->user()->email : 'hola@sitio.com' }}
                                </div>
                                <div class="cv6-contact-item">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    Celular: 1234-5678
                                </div>
                            </div>

                            <div class="cv6-right">
                                <div class="cv6-title" style="margin-top:0;">Experiencia Laboral</div>
                                @if(count($r_exp) > 0)
                                    @foreach($r_exp as $exp)
                                        <div class="cv6-item">
                                            <div class="cv6-item-title">{{ $exp->cargo }}</div>
                                            <div class="cv6-item-meta">En {{ $exp->empresa }}, {{ $exp->fecha_inicio ? $exp->fecha_inicio->format('M Y') : '' }} - {{ $exp->actual ? 'presente' : ($exp->fecha_fin ? $exp->fecha_fin->format('M Y') : '') }}</div>
                                            @if($exp->descripcion)
                                                <ul class="cv6-list" style="margin-top:8px;">
                                                    <li>{{ $exp->descripcion }}</li>
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cv6-item">
                                        <div class="cv6-item-title">Vendedora, Atenci&oacute;n al cliente.</div>
                                        <div class="cv6-item-meta">En Casa Colombia, marzo 2021 - presente</div>
                                        <ul class="cv6-list" style="margin-top:8px;">
                                            <li>Atenci&oacute;n al cliente.</li>
                                            <li>Control de caja.</li>
                                        </ul>
                                    </div>
                                @endif

                                <div class="cv6-title">Habilidades y Conocimientos</div>
                                <ul class="cv6-list">
                                    @if(count($r_habF) > 0 || count($r_habB) > 0)
                                        @foreach($r_habF as $hab)
                                            <li>{{ $hab->nombre }}</li>
                                        @endforeach
                                        @foreach($r_habB as $hab)
                                            <li>{{ $hab->nombre }}</li>
                                        @endforeach
                                    @else
                                        <li>Procesador de texto, hoja de c&aacute;lculos y presentaci&oacute;n de Diapositivas.</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                </div>

            </div>{{-- ← cierra view-reportes --}}

                <div class="view" id="view-perfil">
                    @include('perfil.index')
                </div>
            </div>
        </main>

        <!-- Right panel -->
        <div class="rpanel">
            <div class="rp-sec">
                <div class="cal-hd" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                    <div class="cal-month" id="cal-title" style="flex:1;">Abril 2026</div>
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
                    <div class="cal-grid" id="cal-grid">
                        <div class="cdn">Do</div><div class="cdn">Lu</div><div class="cdn">Ma</div>
                        <div class="cdn">Mi</div><div class="cdn">Ju</div><div class="cdn">Vi</div><div class="cdn">Sá</div>
                    </div>
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
    </div>

    <footer>
        <div class="footer-content">
            <img src="{{ asset('images/InfinityCode.jpeg') }}" alt="Logo Footer" class="footer-logo">
            <p><b>Infinity Code</b> © 2026 Infinity Code. Todos los derechos reservados.</p>
        </div>
    </footer>
</div>

<!-- Modal detalle del día -->
<div id="modalDia" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
  <div style="width:90%;max-width:440px;background:#fff;border-radius:28px;overflow:hidden;max-height:90vh;overflow-y:auto;box-shadow:0 24px 60px rgba(0,0,0,0.2);">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;padding:28px 28px 0;">
      <div>
        <div style="font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:#64748b;margin-bottom:4px;">Detalle del día</div>
        <div id="modalFecha" style="font-size:24px;font-weight:700;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif;"></div>
      </div>
      <button onclick="cerrarModal()" style="width:36px;height:36px;border-radius:50%;border:1px solid #e2e8f0;background:transparent;cursor:pointer;font-size:16px;color:#64748b;">✕</button>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px;padding:20px 28px 0;" id="listaEventos"></div>
    <div style="padding:16px 28px 0;">
      <div style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#64748b;margin-bottom:10px;">Nuevo evento</div>
      <input id="nuevoEventoInput" type="text" placeholder="Nombre del evento..."
        style="width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid #e2e8f0;font-family:'DM Sans',sans-serif;font-size:13px;outline:none;margin-bottom:8px;">
      <input id="nuevoEventoHora" type="text" placeholder="Hora (ej: 10:00 AM)"
        style="width:100%;padding:10px 14px;border-radius:12px;border:1.5px solid #e2e8f0;font-family:'DM Sans',sans-serif;font-size:13px;outline:none;">
    </div>
    <div style="display:flex;gap:12px;padding:16px 28px 28px;">
      <button onclick="cerrarModal()" style="flex:1;padding:13px;border-radius:12px;border:1px solid #e2e8f0;background:transparent;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">Cerrar</button>
      <button onclick="agregarEvento()" style="flex:1.3;display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;border-radius:12px;border:none;background:#2563eb;color:#fff;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="12" x2="12" y1="14" y2="18"/><line x1="10" x2="14" y1="16" y2="16"/></svg>
        Agregar evento
      </button>
    </div>
  </div>
</div>

<script>
    /* ══ Eventos calendario ══ */
    const months_es = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    let eventos = JSON.parse(localStorage.getItem('eventos') || '{}');
    let modalDia = null, modalMes = null, modalAnio = null;

    function guardarEventos(){ localStorage.setItem('eventos', JSON.stringify(eventos)); }
    function keyFecha(d,m,y){ return `${y}-${m}-${d}`; }

    function abrirModal(dia,mes,anio){
        modalDia=dia; modalMes=mes; modalAnio=anio;
        document.getElementById('modalFecha').textContent = dia+' de '+months_es[mes]+', '+anio;
        document.getElementById('nuevoEventoInput').value='';
        document.getElementById('nuevoEventoHora').value='';
        renderEventosModal();
        document.getElementById('modalDia').style.display='flex';
    }

    function cerrarModal(){ document.getElementById('modalDia').style.display='none'; }

    function renderEventosModal(){
        const key=keyFecha(modalDia,modalMes,modalAnio);
        const lista=eventos[key]||[];
        const container=document.getElementById('listaEventos');
        if(lista.length===0){
            container.innerHTML=`<div style="display:flex;flex-direction:column;align-items:center;padding:18px;border-radius:16px;border:2px dashed #e2e8f0;gap:4px;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="16"/><line x1="8" x2="16" y1="12" y2="12"/></svg><span style="font-size:10px;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;color:#94a3b8;">Sin eventos</span></div>`;
            return;
        }
        container.innerHTML=lista.map((ev,i)=>`
            <div style="display:flex;align-items:flex-start;gap:14px;padding:14px;background:#f0f4f8;border-radius:4px 16px 16px 4px;border-left:4px solid #2563eb;">
                <div style="width:34px;height:34px;border-radius:10px;background:#e8eefb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:600;color:#0f172a;">${ev.nombre}</div>
                    ${ev.hora?`<div style="display:flex;align-items:center;gap:5px;color:#64748b;margin-top:4px;"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><span style="font-size:12px;">${ev.hora}</span></div>`:''}
                </div>
                <button onclick="eliminarEvento(${i})" style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;display:flex;align-items:center;" title="Eliminar">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </button>
            </div>`).join('');
    }

    function agregarEvento(){
        const nombre=document.getElementById('nuevoEventoInput').value.trim();
        const hora=document.getElementById('nuevoEventoHora').value.trim();
        if(!nombre) return;
        const key=keyFecha(modalDia,modalMes,modalAnio);
        if(!eventos[key]) eventos[key]=[];
        eventos[key].push({nombre,hora});
        guardarEventos(); renderEventosModal(); renderCal();
        document.getElementById('nuevoEventoInput').value='';
        document.getElementById('nuevoEventoHora').value='';
    }

    function eliminarEvento(idx){
        const key=keyFecha(modalDia,modalMes,modalAnio);
        eventos[key].splice(idx,1);
        if(eventos[key].length===0) delete eventos[key];
        guardarEventos(); renderEventosModal(); renderCal();
    }

    /* ══ Vista switcher ══ */
    function showView(name){
        document.querySelectorAll('.view').forEach(v=>v.classList.remove('active'));
        document.getElementById('view-'+name).classList.add('active');
        document.querySelectorAll('.sb-item').forEach(b=>b.classList.remove('active'));
        const btn=document.getElementById('btn-'+name);
        if(btn) btn.classList.add('active');
        document.querySelector('main').scrollTop=0;
    }

    /* ── Atajos de Teclado ── */
    document.addEventListener('keydown', function(e) {
        // Ctrl + K para buscar
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            showView('explorador');
            document.getElementById('expSearch').focus();
        }
        // Esc para cerrar buscador o limpiar
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

    /* ══ Explorador ══ */
    const dbCards = @json($busquedas ?? []);
    
    const fallbackCards = [
        {type:"PROYECTO",avClass:"av-blue",avLetter:"P",title:"Programa de Optimización Fiscal 2024",desc:"Iniciativa estratégica para la mejora de flujos de caja institucionales.",tags:["#FINANCE","#FISCAL","#STRATEGY"],cat:"proyecto"},
        {type:"PROYECTO",avClass:"av-green",avLetter:"P",title:"Programa de Desarrollo Ambiental 2020",desc:"Iniciativa estratégica para la mejora del desarrollo ambiental.",tags:["#FINANCE","#LIFE","#STRATEGY"],cat:"proyecto"},
        {type:"HABILIDAD",avClass:"av-orange",avLetter:"H",title:"Programación en PHP / Symfony",desc:"Capacidad funcional en el desarrollo de frameworks para diseño y sistemas.",tags:["#PHP","#BACKEND"],cat:"habilidad",hasUsers:true},
        {type:"DOCUMENTO",avClass:"av-teal",avLetter:"D",title:"Protocolos de Seguridad Interna V2",desc:"Documentación técnica sobre buenas prácticas en encriptación.",tags:["#SECURITY","#PDF"],cat:"documento"},
    ];

    const expCards = dbCards.length > 0 ? dbCards.map(c => ({
        type: (c.tipo || 'S/T').toUpperCase(),
        avClass: c.avatar_class || 'av-blue',
        avLetter: c.avatar_letter || '?',
        title: c.titulo || 'Sin título',
        desc: c.descripcion || 'Sin descripción',
        tags: Array.isArray(c.tags) ? c.tags : (typeof c.tags === 'string' ? JSON.parse(c.tags || '[]') : []),
        cat: c.tipo || 'otros',
        hasUsers: !!c.has_users
    })) : fallbackCards;

    const originalExpCards = [...expCards];

    let expActiveFilter='todos';

    function expHL(text){
        const q=document.getElementById('expSearch').value.trim();
        if(!q) return escapeHTML(text);
        const escapedText = escapeHTML(text);
        const re=new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`,'gi');
        return escapedText.replace(re,'<mark>$1</mark>');
    }

    function escapeHTML(str) {
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    }

    function expRender(cards){
        const countEl = document.getElementById('expCount');
        if (cards.length === 0) {
            countEl.textContent = "0 Resultados";
            document.getElementById('expGrid').innerHTML = `
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--muted);">
                    <svg viewBox="0 0 24 24" style="width:48px;height:48px;margin-bottom:1rem;stroke:var(--gray3);fill:none;stroke-width:1.5;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <p style="font-weight:600; color:var(--text);">No se encontraron resultados</p>
                    <p style="font-size:13px;">Intenta con otros términos o filtros.</p>
                </div>`;
            return;
        }
        countEl.textContent=`${cards.length} Resultado${cards.length!==1?'s':''} Encontrado${cards.length!==1?'s':''}`;
        document.getElementById('expGrid').innerHTML=cards.map(c=>`
            <div class="exp-card">
                <div class="exp-card-type">${escapeHTML(c.type)}</div>
                <div class="exp-card-top"><div class="exp-avatar ${escapeHTML(c.avClass)}">${escapeHTML(c.avLetter)}</div><div class="exp-card-title">${expHL(c.title)}</div></div>
                <div class="exp-card-desc">${escapeHTML(c.desc)}</div>
                <div class="exp-card-actions">
                    <div class="exp-tags">${c.tags.map(t=>`<span class="exp-tag">${escapeHTML(t)}</span>`).join('')}</div>
                    <div class="exp-icons">
                        ${c.hasUsers?`<div style="display:flex;align-items:center"><div style="width:18px;height:18px;border-radius:50%;background:#1a56db;border:2px solid #fff"></div><div style="width:18px;height:18px;border-radius:50%;background:#059669;border:2px solid #fff;margin-left:-5px"></div></div>`:''}
                        <button class="exp-icon-btn" title="Guardar"><svg viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg></button>
                        <button class="exp-icon-btn" title="Descargar"><svg viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg></button>
                    </div>
                </div>
                <div class="trend-icon"><svg viewBox="0 0 38 26" fill="none" stroke="#1a56db" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="2,20 10,12 16,16 26,6 36,10"/></svg></div>
            </div>`).join('');
    }

    /* ── Historial ── */
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
        if (history.length === 0) {
            div.style.display = 'none';
            return;
        }
        div.innerHTML = `
            <div class="exp-history-header">
                <span>Búsquedas recientes</span>
                <span class="btn-clear-history" onclick="expClearHistory()">Limpiar</span>
            </div>
            ${history.map((h, i) => `
                <div class="exp-history-item">
                    <div style="flex:1; display:flex; align-items:center; gap:10px;" onclick="expSelectHistory('${h.replace(/'/g, "\\'")}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>${escapeHTML(h)}</span>
                    </div>
                    <button class="btn-remove-history" onclick="event.stopPropagation(); expRemoveHistoryItem(${i})" title="Eliminar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
            `).join('')}
        `;
        div.style.display = 'block';
    }

    function expSelectHistory(val) {
        const input = document.getElementById('expSearch');
        input.value = val;
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

    // Cerrar historial al hacer click fuera
    document.addEventListener('click', function(e) {
        const wrap = document.querySelector('.exp-search-wrap');
        if (wrap && !wrap.contains(e.target)) {
            document.getElementById('expHistory').style.display = 'none';
        }
    });

    function expFilter(){
        const q=document.getElementById('expSearch').value.toLowerCase();
        expRender(expCards.filter(c => {
            const matchText = c.title.toLowerCase().includes(q) || 
                              c.desc.toLowerCase().includes(q) || 
                              (c.tags && c.tags.some(t => t.toLowerCase().includes(q)));
            const matchCat = expActiveFilter === 'todos' || c.cat === expActiveFilter;
            return matchText && matchCat;
        }));
    }

    function expSetFilter(btn,cat){
        expActiveFilter=cat;
        document.querySelectorAll('.exp-filter').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        expFilter();
    }

    function expSetSort(mode, label) {
        document.getElementById('sortLabel').innerText = label;
        document.getElementById('sortMenu').style.display = 'none';
        
        if (mode === 'az') {
            expCards.sort((a,b) => a.title.localeCompare(b.title));
        } else if (mode === 'za') {
            expCards.sort((a,b) => b.title.localeCompare(a.title));
        } else if (mode === 'relevancia') {
            expCards.length = 0;
            expCards.push(...originalExpCards);
        }
        expFilter();
    }

    document.addEventListener('click', function(e) {
        const sortContainer = document.getElementById('sortContainer');
        if (sortContainer && !sortContainer.contains(e.target)) {
            const menu = document.getElementById('sortMenu');
            if(menu) menu.style.display = 'none';
        }
    });

    expRender(expCards);

    /* ══ Calendario ══ */
    let cur = new Date();
    let currentCalView = 'dias';
    
    // Feriados y Fechas Cívicas de Bolivia (Formato: DD-MM)
    const boliviaHolidays = {
        "01-01": "Año Nuevo",
        "22-01": "Día del Estado Plurinacional",
        "19-03": "Día del Padre",
        "12-04": "Día del Niño",
        "01-05": "Día del Trabajo",
        "27-05": "Día de la Madre",
        "21-06": "Año Nuevo Aymara",
        "06-08": "Día de la Independencia",
        "17-08": "Día de la Bandera",
        "21-09": "Día de la Primavera y del Estudiante",
        "11-10": "Día de la Mujer Boliviana",
        "02-11": "Día de los Difuntos",
        "25-12": "Navidad"
    };

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

                html += `<div class="${cls}" ${titleAttr} style="cursor:pointer;" onclick="abrirModal(${i},${m},${y})">${i}</div>`;
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

    document.getElementById('btn-menu').classList.add('active');
    function confirmarLogout(){
        document.getElementById('modalLogout').style.display='flex';
    }

    function selectTemplate(tplId) {
        document.querySelectorAll('.cv-template-view').forEach(el => {
            el.classList.remove('active-tpl');
        });
        document.getElementById(tplId).classList.add('active-tpl');
    }

    let isEditingCV = false;
    function toggleEditCV() {
        isEditingCV = !isEditingCV;
        const btn = document.getElementById('btn-edit-cv');
        
        if (isEditingCV) {
            document.querySelectorAll('.cv-template-view').forEach(tpl => {
                tpl.setAttribute('contenteditable', 'true');
                tpl.style.outline = '2px dashed #3b82f6';
                tpl.style.outlineOffset = '4px';
            });
            btn.innerHTML = '<svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> Finalizar Edición';
            btn.style.background = '#3b82f6';
            btn.style.color = '#fff';
        } else {
            document.querySelectorAll('.cv-template-view').forEach(tpl => {
                tpl.setAttribute('contenteditable', 'false');
                tpl.style.outline = 'none';
            });
            btn.innerHTML = '<svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Editar en pantalla';
            btn.style.background = '#e2e8f0';
            btn.style.color = '#1e293b';
        }
    }

    function toggleNavMenu() {
        const menu = document.getElementById('navUserMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    function cerrarNavMenu() {
        document.getElementById('navUserMenu').style.display = 'none';
    }
    // Cerrar al hacer click fuera
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('navUserMenu');
        const btn  = menu?.previousElementSibling;
        if (menu && !menu.contains(e.target) && btn && !btn.contains(e.target)) {
            cerrarNavMenu();
        }
    });


    function ejecutarLogout(btn) {
        btn.disabled = true;
        document.getElementById('logoutSpinner').style.display = 'block';
        document.getElementById('logoutBtnLabel').textContent = 'Cerrando sesión...';
        btn.style.opacity = '0.85';
        document.getElementById('formLogout').submit();
    }
</script>

<!-- ══ MODAL CREAR PORTAFOLIO ══ -->
<style>
    .mp-overlay{position:fixed;inset:0;background:rgba(15,23,42,0.55);z-index:9000;display:none;align-items:center;justify-content:center;padding:24px}
    .mp-overlay.open{display:flex}
    .mp-modal{background:#fff;border-radius:16px;width:100%;max-width:640px;max-height:90vh;overflow-y:auto;box-shadow:0 24px 60px rgba(0,0,0,0.18);color:var(--text)}
    .mp-header{padding:28px 32px 20px;border-bottom:1px solid var(--gray2)}
    .mp-header h2{font-family:"Plus Jakarta Sans",sans-serif;font-size:22px;font-weight:800;color:var(--text);margin-bottom:4px}
    .mp-header p{font-size:12.5px;color:var(--muted)}
    .mp-body{padding:24px 32px;background:#fff}
    .mp-section{margin-bottom:24px}
    .mp-section-label{display:flex;align-items:center;gap:8px;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:14px}
    .mp-section-label svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .mp-field{margin-bottom:14px}
    .mp-label{display:block;font-size:11.5px;font-weight:600;color:var(--text);margin-bottom:6px;letter-spacing:.03em}
    .mp-label span{color:#ef4444;margin-left:2px}
    .mp-input,.mp-textarea{width:100%;background:var(--gray);border:1px solid var(--gray2);border-radius:9px;padding:10px 14px;font-size:13px;color:var(--text);font-family:"DM Sans",sans-serif;outline:none;transition:border-color .2s}
    .mp-input:focus,.mp-textarea:focus{border-color:var(--blue);background:#fff}
    .mp-textarea{min-height:90px;resize:vertical}
    .mp-drop{border:2px dashed var(--gray3);border-radius:12px;padding:32px 20px;text-align:center;color:var(--muted);cursor:pointer;transition:border-color .2s;background:var(--gray)}
    .mp-drop:hover{border-color:var(--blue);color:var(--blue)}
    .mp-drop svg{width:32px;height:32px;fill:none;stroke:currentColor;stroke-width:1.4;stroke-linecap:round;stroke-linejoin:round;margin:0 auto 10px;display:block}
    .mp-drop p{font-size:13px;font-weight:500;margin-bottom:4px;color:var(--text)}
    .mp-drop span{font-size:11.5px}
    .mp-footer{padding:20px 32px;border-top:1px solid var(--gray2);display:flex;align-items:center;justify-content:space-between;gap:12px;background:#fff}
    .mp-btn-ghost{background:#fff;color:var(--muted);border:1px solid var(--gray2);border-radius:9px;padding:9px 20px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;transition:all .2s}
    .mp-btn-ghost:hover{border-color:var(--blue);color:var(--blue)}
    .mp-btn-primary{background:var(--blue);color:#fff;border:none;border-radius:9px;padding:9px 22px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:8px;transition:background .2s;box-shadow:0 4px 12px rgba(37,99,235,0.25)}
    .mp-btn-primary:hover{background:var(--blue2)}
    .mp-btn-primary svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .mp-close{position:absolute;top:20px;right:24px;background:var(--gray);border:1px solid var(--gray2);border-radius:8px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);transition:all .2s}
    .mp-close:hover{background:var(--gray2);color:var(--text)}
    .mp-close svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .mp-header-wrap{position:relative}
</style>

<div class="mp-overlay" id="modalPortafolio" onclick="cerrarModalPortafolio(event)">
    <div class="mp-modal">
        <div class="mp-header-wrap">
            <div class="mp-header">
                <h2>Crear Nuevo Portafolio</h2>
                <p>Configure su proyecto para la red SansiFolios.</p>
            </div>
            <button class="mp-close" onclick="mpCerrar()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="mp-body">
            <!-- Información del proyecto -->
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    Información del Proyecto
                </div>
                <div class="mp-field">
                    <label class="mp-label">Título del Proyecto <span>*</span></label>
                    <input class="mp-input" id="mpNombre" type="text" maxlength="100" placeholder="p.ej. Neural Engine v2" oninput="mpCheckBtns()">
                    <div class="mp-err" id="mpErrNombre">Este campo es obligatorio para continuar.</div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">Descripción Técnica <span>*</span></label>
                    <textarea class="mp-textarea" id="mpDesc" maxlength="500" placeholder="Describa la arquitectura, lenguajes y stacks utilizados..." oninput="mpCheckBtns();document.getElementById('mpDescCount').textContent=this.value.length"></textarea>
                    <div style="text-align:right;font-size:11px;color:var(--muted);margin-top:3px"><span id="mpDescCount">0</span>/500</div>
                    <div class="mp-err" id="mpErrDesc">Se requiere una descripción detallada del proyecto.</div>
                </div>
            </div>
            <!-- Vinculación de repositorio -->
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    Vinculación de Repositorio
                </div>
                <div class="mp-field">
                    <label class="mp-label">Enlace de GitHub</label>
                    <div class="mp-url-wrap">
                        <input class="mp-input" id="mpRepo" type="text" maxlength="500" placeholder="https://github.com/usuario/repositorio" oninput="mpValidarUrl()" style="padding-right:36px">
                        <svg class="mp-url-tick" id="mpUrlTick" viewBox="0 0 24 24"></svg>
                    </div>
                    <div class="mp-err" id="mpErrRepo">Ingresa una URL válida (ej. https://github.com/...).</div>
                </div>
            </div>
            <!-- Cargar archivos -->
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Cargar Archivos
                </div>
                <input type="file" id="mpFileInput" multiple accept=".pdf,.zip,.png,.jpg,.jpeg" style="display:none" onchange="mpHandleFiles(this.files)">
                <div class="mp-drop" id="mpDrop"
                     onclick="document.getElementById('mpFileInput').click()"
                     ondragover="event.preventDefault();this.classList.add('dragover')"
                     ondragleave="this.classList.remove('dragover')"
                     ondrop="event.preventDefault();this.classList.remove('dragover');mpHandleFiles(event.dataTransfer.files)">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p>Arrastra tus archivos aquí</p>
                    <span>o haz clic para explorar · .pdf .zip .png .jpg (máx. 10MB)</span>
                </div>
                <div class="mp-file-errs" id="mpFileErrs"></div>
                <div class="mp-flist" id="mpFlist"></div>
            </div>
        </div>
        <div class="mp-footer">
            <button class="mp-btn-ghost" id="mpBtnBorrador" onclick="mpGuardar('borrador')" disabled>Guardar como borrador</button>
            <button class="mp-btn-primary" id="mpBtnPublicar" onclick="mpGuardar('publicado')" disabled>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Publicar Proyecto
            </button>
        </div>
    </div>
</div>

<!-- Modal Ver Portafolio -->
<div class="vp-overlay" id="modalVerPortafolio" onclick="if(event.target===this)vpCerrar()">
    <div class="vp-box">
        <div class="vp-head">
            <div>
                <div class="vp-title" id="vpNombre"></div>
                <span class="vp-badge" id="vpBadge"></span>
            </div>
            <button class="vp-close" onclick="vpCerrar()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vp-body">
            <p class="vp-desc" id="vpDesc"></p>
            <div class="vp-row" id="vpRepoWrap" style="display:none">
                <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <a id="vpRepo" href="#" target="_blank" rel="noopener"></a>
            </div>
            <div class="vp-row">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span id="vpFecha"></span>
            </div>
            <div class="vp-sec">Archivos adjuntos</div>
            <div id="vpArchivos"></div>
        </div>
        <div class="vp-foot">
            <button class="vp-btn-del" id="vpBtnEliminar" onclick="vpConfirmarEliminar()">Eliminar portafolio</button>
            <button class="vp-btn-edit" id="vpBtnEditar" onclick="vpAbrirEditar()">Editar</button>
            <button class="vp-btn-close" onclick="vpCerrar()">Cerrar</button>
        </div>
    </div>
</div>

<!-- Modal Confirmación -->
<div class="conf-overlay" id="modalConf">
    <div class="conf-box">
        <div class="conf-ico" id="confIco">
            <svg id="confIcoSvg" viewBox="0 0 24 24"></svg>
        </div>
        <div class="conf-title" id="confTitle"></div>
        <div class="conf-desc" id="confDesc"></div>
        <div class="conf-btns">
            <button class="conf-btn-cancel" onclick="confCerrar()">Cancelar</button>
            <button class="conf-btn-ok" id="confBtnOk">Confirmar</button>
        </div>
    </div>
</div>

<!-- Modal Editar Portafolio -->
<div class="mp-overlay" id="modalEditarPortafolio" onclick="if(event.target===this)epCerrar()">
    <div class="mp-modal">
        <div class="mp-header-wrap">
            <div class="mp-header">
                <h2>Editar Portafolio</h2>
                <p>Modifica la información de tu proyecto.</p>
            </div>
            <button class="mp-close" onclick="epCerrar()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="mp-body">
            <input type="hidden" id="epId">
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Información del Proyecto
                </div>
                <div class="mp-field">
                    <label class="mp-label">Nombre del proyecto <span style="color:#ef4444">*</span></label>
                    <input class="mp-input" id="epNombre" type="text" maxlength="100" placeholder="Ej. Sistema de inventario" oninput="epCheckBtns()">
                    <div class="mp-err" id="epErrNombre">El nombre es obligatorio.</div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">Descripción <span style="color:#ef4444">*</span></label>
                    <textarea class="mp-textarea" id="epDesc" maxlength="500" rows="3" placeholder="Describe brevemente tu proyecto..." oninput="epCheckBtns();document.getElementById('epDescCount').textContent=this.value.length"></textarea>
                    <div style="text-align:right;font-size:11px;color:var(--muted);margin-top:3px"><span id="epDescCount">0</span>/500</div>
                    <div class="mp-err" id="epErrDesc">La descripción es obligatoria.</div>
                </div>
            </div>
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    Vinculación de Repositorio
                </div>
                <div class="mp-field">
                    <label class="mp-label">Enlace de GitHub</label>
                    <div class="mp-url-wrap">
                        <input class="mp-input" id="epRepo" type="text" maxlength="500" placeholder="https://github.com/usuario/repositorio" oninput="epValidarUrl()" style="padding-right:36px">
                        <svg class="mp-url-tick" id="epUrlTick" viewBox="0 0 24 24"></svg>
                    </div>
                    <div class="mp-err" id="epErrRepo">Ingresa una URL válida.</div>
                </div>
            </div>
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Agregar Archivos
                </div>
                <input type="file" id="epFileInput" multiple accept=".pdf,.zip,.png,.jpg,.jpeg" style="display:none" onchange="epHandleFiles(this.files)">
                <div class="mp-drop" id="epDrop"
                     onclick="document.getElementById('epFileInput').click()"
                     ondragover="event.preventDefault();this.classList.add('dragover')"
                     ondragleave="this.classList.remove('dragover')"
                     ondrop="event.preventDefault();this.classList.remove('dragover');epHandleFiles(event.dataTransfer.files)">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p>Arrastra archivos nuevos aquí</p>
                    <span>o haz clic para explorar · .pdf .zip .png .jpg (máx. 10MB)</span>
                </div>
                <div class="mp-file-errs" id="epFileErrs"></div>
                <div class="mp-flist" id="epFlist"></div>
            </div>
        </div>
        <div class="mp-footer">
            <button class="mp-btn-ghost" id="epBtnBorrador" onclick="epConfirmarGuardar('borrador')" disabled>Guardar como borrador</button>
            <button class="mp-btn-primary" id="epBtnPublicar" onclick="epConfirmarGuardar('publicado')" disabled>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Guardar cambios
            </button>
        </div>
    </div>
</div>

<style>
    .mp-err{font-size:11.5px;color:#ef4444;margin-top:5px;display:none}
    .mp-input.mp-invalid,.mp-textarea.mp-invalid{border-color:#ef4444!important;background:#fff5f5!important}
    .mp-input.mp-ok{border-color:#22c55e!important}
    .mp-url-wrap{position:relative}
    .mp-url-tick{position:absolute;right:11px;top:50%;transform:translateY(-50%);display:none;width:16px;height:16px;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .mp-file-errs{margin-top:8px;display:flex;flex-direction:column;gap:5px}
    .mp-ferr{display:flex;align-items:flex-start;gap:8px;background:#fff5f5;border:1px solid #fecaca;border-radius:8px;padding:8px 12px;font-size:11.5px;color:#dc2626}
    .mp-ferr svg{width:13px;height:13px;flex-shrink:0;margin-top:1px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .mp-flist{margin-top:8px;display:flex;flex-direction:column;gap:4px}
    .mp-fitem{display:flex;align-items:center;justify-content:space-between;background:var(--gray);border-radius:7px;padding:7px 12px;font-size:12px}
    .mp-fitem-name{font-weight:500;color:var(--text)}
    .mp-fitem-size{color:var(--muted);font-size:11px;margin-left:8px}
    .mp-frem{background:none;border:none;cursor:pointer;color:var(--muted);padding:0;margin-left:8px}
    .mp-frem:hover{color:#ef4444}
    .mp-frem svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .mp-btn-primary:disabled,.mp-btn-ghost:disabled{opacity:.45;cursor:not-allowed}
    .mp-drop.dragover{border-color:var(--blue)!important;background:#eff6ff!important}
    /* Modal Ver Portafolio */
    .vp-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1100;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .2s}
    .vp-overlay.open{opacity:1;pointer-events:all}
    .vp-box{background:#fff;border-radius:18px;width:min(680px,95vw);max-height:88vh;overflow-y:auto;box-shadow:0 24px 64px rgba(0,0,0,.18);transform:translateY(16px);transition:transform .2s}
    .vp-overlay.open .vp-box{transform:translateY(0)}
    .vp-head{display:flex;align-items:flex-start;justify-content:space-between;padding:24px 28px 0}
    .vp-title{font-size:20px;font-weight:700;color:var(--text)}
    .vp-badge{display:inline-block;margin-top:6px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:.4px}
    .vp-badge.publicado{background:#d1fae5;color:#065f46}
    .vp-badge.borrador{background:#fef3c7;color:#92400e}
    .vp-close{background:none;border:none;cursor:pointer;color:var(--muted);padding:4px}
    .vp-close:hover{color:var(--text)}
    .vp-close svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round}
    .vp-body{padding:20px 28px 28px}
    .vp-desc{font-size:14px;color:var(--muted);line-height:1.6;margin-bottom:16px;word-break:break-word;white-space:pre-wrap;max-height:160px;overflow-y:auto}
    .vp-title{font-size:20px;font-weight:700;color:var(--text);word-break:break-word}
    .vp-row{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted);margin-bottom:10px}
    .vp-row svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;flex-shrink:0}
    .vp-row a{color:var(--blue);text-decoration:none;word-break:break-all}
    .vp-row a:hover{text-decoration:underline}
    .vp-sec{font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;margin:18px 0 8px}
    .vp-file{display:flex;align-items:center;gap:10px;background:var(--gray);border-radius:8px;padding:9px 14px;margin-bottom:6px;font-size:13px}
    .vp-file svg{width:16px;height:16px;fill:none;stroke:var(--blue);stroke-width:2;stroke-linecap:round;flex-shrink:0}
    .vp-file-name{font-weight:500;color:var(--text);flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .vp-file-size{color:var(--muted);font-size:11px;flex-shrink:0}
    .vp-empty{text-align:center;padding:14px;color:var(--muted);font-size:13px}
    .vp-foot{display:flex;justify-content:flex-end;padding:0 28px 24px;gap:10px}
    .vp-btn-del{padding:8px 18px;border-radius:9px;border:1.5px solid #fca5a5;background:#fff;color:#ef4444;font-size:13px;font-weight:600;cursor:pointer}
    .vp-btn-del:hover{background:#fef2f2}
    .vp-btn-close{padding:8px 18px;border-radius:9px;border:none;background:var(--blue);color:#fff;font-size:13px;font-weight:600;cursor:pointer}
    .vp-btn-edit{padding:8px 18px;border-radius:9px;border:1.5px solid var(--blue);background:#fff;color:var(--blue);font-size:13px;font-weight:600;cursor:pointer}
    .vp-btn-edit:hover{background:#eff6ff}
    /* Modal Confirmación */
    .conf-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9500;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .2s}
    .conf-overlay.open{opacity:1;pointer-events:all}
    .conf-box{background:#fff;border-radius:20px;width:min(400px,92vw);padding:32px 28px 24px;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,.18);transform:translateY(16px);transition:transform .2s}
    .conf-overlay.open .conf-box{transform:translateY(0)}
    .conf-ico{width:64px;height:64px;border-radius:18px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 18px}
    .conf-ico svg{width:28px;height:28px;fill:none;stroke:var(--blue);stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
    .conf-ico.danger{background:#fff5f5}
    .conf-ico.danger svg{stroke:#ef4444}
    .conf-title{font-size:18px;font-weight:700;color:var(--text);margin-bottom:8px}
    .conf-desc{font-size:13.5px;color:var(--muted);line-height:1.5;margin-bottom:24px}
    .conf-btns{display:flex;gap:10px;justify-content:center}
    .conf-btn-cancel{flex:1;padding:10px;border-radius:10px;border:1.5px solid var(--gray2);background:#fff;color:var(--text);font-size:14px;font-weight:600;cursor:pointer}
    .conf-btn-cancel:hover{background:var(--gray)}
    .conf-btn-ok{flex:1;padding:10px;border-radius:10px;border:none;background:var(--blue);color:#fff;font-size:14px;font-weight:600;cursor:pointer}
    .conf-btn-ok:hover{background:#1d4ed8}
    .conf-btn-ok.danger{background:#ef4444}
    .conf-btn-ok.danger:hover{background:#dc2626}
</style>

<script>
    const VP_DATA = @json($portafolios ?? []);

    function verPortafolio(id) {
        const p = VP_DATA.find(x => x.id == id);
        if (!p) return;
        document.getElementById('vpNombre').textContent = p.nombre;
        document.getElementById('vpDesc').textContent   = p.descripcion || '';
        const badge = document.getElementById('vpBadge');
        badge.textContent  = p.estado === 'publicado' ? 'Publicado' : 'Borrador';
        badge.className    = 'vp-badge ' + p.estado;
        const repoWrap = document.getElementById('vpRepoWrap');
        if (p.repositorio_url) {
            document.getElementById('vpRepo').href        = p.repositorio_url;
            document.getElementById('vpRepo').textContent = p.repositorio_url;
            repoWrap.style.display = 'flex';
        } else {
            repoWrap.style.display = 'none';
        }
        const fecha = new Date(p.updated_at);
        document.getElementById('vpFecha').textContent = 'Actualizado: ' + fecha.toLocaleDateString('es-BO', {day:'2-digit',month:'long',year:'numeric'});
        const archDiv = document.getElementById('vpArchivos');
        if (p.archivos && p.archivos.length > 0) {
            archDiv.innerHTML = p.archivos.map(a => `
                <div class="vp-file">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span class="vp-file-name">${a.nombre_original}</span>
                    <span class="vp-file-size">${(a.tamanio/1024).toFixed(0)} KB</span>
                </div>`).join('');
        } else {
            archDiv.innerHTML = '<div class="vp-empty">Sin archivos adjuntos</div>';
        }
        document.getElementById('vpBtnEliminar').dataset.id = id;
        document.getElementById('vpBtnEditar').dataset.id  = id;
        document.getElementById('modalVerPortafolio').classList.add('open');
    }

    function vpCerrar() {
        document.getElementById('modalVerPortafolio').classList.remove('open');
    }

    // ── Confirmación genérica ──
    let _confCallback = null;
    function vpConfirm({ ico, danger, title, desc, btnText, onConfirm }) {
        const icoEl = document.getElementById('confIco');
        icoEl.className = 'conf-ico' + (danger ? ' danger' : '');
        document.getElementById('confIcoSvg').innerHTML = ico;
        document.getElementById('confTitle').textContent = title;
        document.getElementById('confDesc').textContent  = desc;
        const btn = document.getElementById('confBtnOk');
        btn.textContent = btnText;
        btn.className   = 'conf-btn-ok' + (danger ? ' danger' : '');
        _confCallback = onConfirm;
        btn.onclick = () => { confCerrar(); _confCallback && _confCallback(); };
        document.getElementById('modalConf').classList.add('open');
    }
    function confCerrar() {
        document.getElementById('modalConf').classList.remove('open');
    }

    function vpConfirmarEliminar() {
        const id = document.getElementById('vpBtnEliminar').dataset.id;
        vpConfirm({
            ico: '<path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>',
            danger: true,
            title: '¿Eliminar portafolio?',
            desc: 'Esta acción no se puede deshacer. Se eliminarán todos los archivos adjuntos.',
            btnText: 'Sí, eliminar',
            onConfirm: () => vpEliminar(id),
        });
    }

    async function vpEliminar(id) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        try {
            const res  = await fetch('/mis-portafolios/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token } });
            const text = await res.text();
            let json; try { json = JSON.parse(text); } catch(_) { throw new Error('Error del servidor (' + res.status + ')'); }
            if (json.ok) { vpCerrar(); location.reload(); return; }
            alert('Error al eliminar el portafolio.');
        } catch(err) { alert(err.message); }
    }

    // ── Modal Editar ──
    let epFiles = [];
    function vpAbrirEditar() {
        const id = document.getElementById('vpBtnEditar').dataset.id;
        const p  = VP_DATA.find(x => x.id == id);
        if (!p) return;

        // Cerrar Ver modal instantáneamente (sin transición) para evitar overlays apilados
        const verModal = document.getElementById('modalVerPortafolio');
        verModal.style.transition = 'none';
        verModal.classList.remove('open');
        setTimeout(() => { verModal.style.transition = ''; }, 50);

        document.getElementById('epId').value      = p.id;
        document.getElementById('epNombre').value  = p.nombre;
        document.getElementById('epDesc').value    = p.descripcion || '';
        document.getElementById('epRepo').value    = p.repositorio_url || '';
        epFiles = [];
        document.getElementById('epFlist').innerHTML    = '';
        document.getElementById('epFileErrs').innerHTML = '';
        document.getElementById('epDescCount').textContent = (p.descripcion || '').length;
        epValidarUrl();
        epCheckBtns();
        document.getElementById('modalEditarPortafolio').classList.add('open');
    }
    function epCerrar() {
        document.getElementById('modalEditarPortafolio').classList.remove('open');
    }
    function epCheckBtns() {
        const ok = document.getElementById('epNombre').value.trim() && document.getElementById('epDesc').value.trim();
        document.getElementById('epBtnBorrador').disabled = !ok;
        document.getElementById('epBtnPublicar').disabled = !ok;
    }
    function epValidarUrl() {
        const val  = document.getElementById('epRepo').value.trim();
        const tick = document.getElementById('epUrlTick');
        const err  = document.getElementById('epErrRepo');
        if (!val) { tick.style.display='none'; err.style.display='none'; document.getElementById('epRepo').classList.remove('mp-invalid','mp-ok'); return true; }
        const ok = /^https?:\/\/.+\..+/.test(val);
        document.getElementById('epRepo').classList.toggle('mp-invalid', !ok);
        document.getElementById('epRepo').classList.toggle('mp-ok', ok);
        tick.style.display = ok ? 'block' : 'none';
        tick.innerHTML     = ok ? '<polyline points="20 6 9 17 4 12" stroke="#22c55e"/>' : '';
        err.style.display  = ok ? 'none' : 'block';
        return ok || !val;
    }
    function epHandleFiles(files) {
        const errs = []; const maxSize = 10*1024*1024;
        Array.from(files).forEach(f => {
            const ext = f.name.split('.').pop().toLowerCase();
            if (!['pdf','zip','png','jpg','jpeg'].includes(ext)) { errs.push(f.name + ': formato no permitido'); return; }
            if (f.size > maxSize) { errs.push(f.name + ': excede 10 MB'); return; }
            epFiles.push(f);
        });
        document.getElementById('epFileErrs').innerHTML = errs.map(e => `<div class="mp-ferr"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>${e}</div>`).join('');
        epRenderFlist();
    }
    function epRenderFlist() {
        document.getElementById('epFlist').innerHTML = epFiles.map((f,i) =>
            `<div class="mp-fitem"><span class="mp-fitem-name">${f.name}</span>
            <span><span class="mp-fitem-size">${(f.size/1024).toFixed(0)} KB</span>
            <button class="mp-frem" onclick="epRemoveFile(${i})"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></span>
            </div>`).join('');
    }
    function epRemoveFile(i) { epFiles.splice(i,1); epRenderFlist(); }

    function epConfirmarGuardar(estado) {
        const nombre = document.getElementById('epNombre').value.trim();
        const desc   = document.getElementById('epDesc').value.trim();
        let valid = true;
        if (!nombre) { document.getElementById('epErrNombre').style.display='block'; document.getElementById('epNombre').classList.add('mp-invalid'); valid=false; }
        else          { document.getElementById('epErrNombre').style.display='none';  document.getElementById('epNombre').classList.remove('mp-invalid'); }
        if (!desc)   { document.getElementById('epErrDesc').style.display='block';   document.getElementById('epDesc').classList.add('mp-invalid');   valid=false; }
        else          { document.getElementById('epErrDesc').style.display='none';    document.getElementById('epDesc').classList.remove('mp-invalid'); }
        if (!epValidarUrl()) valid = false;
        if (!valid) return;
        vpConfirm({
            ico: '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>',
            danger: false,
            title: '¿Guardar cambios?',
            desc: 'Se actualizará la información del portafolio en el sistema.',
            btnText: 'Sí, guardar',
            onConfirm: () => epGuardar(estado),
        });
    }

    async function epGuardar(estado) {
        const id    = document.getElementById('epId').value;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const form  = new FormData();
        form.append('nombre',          document.getElementById('epNombre').value.trim());
        form.append('descripcion',     document.getElementById('epDesc').value.trim());
        form.append('repositorio_url', document.getElementById('epRepo').value.trim());
        form.append('estado',          estado);
        form.append('_token',          token);
        epFiles.forEach(f => form.append('archivos[]', f));
        const btnB = document.getElementById('epBtnBorrador');
        const btnP = document.getElementById('epBtnPublicar');
        btnB.disabled = btnP.disabled = true;
        btnP.innerHTML = 'Guardando...';
        try {
            const res  = await fetch('/mis-portafolios/' + id, { method: 'POST', body: form });
            const text = await res.text();
            let json; try { json = JSON.parse(text); } catch(_) { throw new Error('Error del servidor (' + res.status + ')'); }
            if (json.ok) { epCerrar(); location.reload(); return; }
            const msg = json.errors ? Object.values(json.errors).flat().join('\n') : 'Error al guardar.';
            alert(msg);
        } catch(err) { alert(err.message); }
        btnB.disabled = btnP.disabled = false;
        btnP.innerHTML = '<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> Guardar cambios';
    }

    const MP_FORMATOS = ['pdf','zip','png','jpg','jpeg'];
    const MP_MAX     = 10 * 1024 * 1024;
    let mpFiles      = [];

    function abrirModalPortafolio() {
        mpReset();
        document.getElementById('modalPortafolio').classList.add('open');
    }
    function cerrarModalPortafolio(e) {
        if (e.target === document.getElementById('modalPortafolio')) mpCerrar();
    }
    function mpCerrar() {
        document.getElementById('modalPortafolio').classList.remove('open');
    }
    function mpReset() {
        ['mpNombre','mpDesc','mpRepo'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.value = ''; el.classList.remove('mp-invalid','mp-ok'); }
        });
        ['mpErrNombre','mpErrDesc','mpErrRepo'].forEach(id => {
            const el = document.getElementById(id); if (el) el.style.display = 'none';
        });
        const tick = document.getElementById('mpUrlTick');
        if (tick) tick.style.display = 'none';
        document.getElementById('mpFileErrs').innerHTML = '';
        document.getElementById('mpFlist').innerHTML = '';
        mpFiles = [];
        mpCheckBtns();
    }
    function mpCheckBtns() {
        const ok = document.getElementById('mpNombre').value.trim() !== '' &&
                   document.getElementById('mpDesc').value.trim() !== '';
        document.getElementById('mpBtnBorrador').disabled = !ok;
        document.getElementById('mpBtnPublicar').disabled = !ok;
    }
    function mpValidarUrl() {
        const val  = document.getElementById('mpRepo').value.trim();
        const tick = document.getElementById('mpUrlTick');
        const err  = document.getElementById('mpErrRepo');
        if (!val) { tick.style.display='none'; err.style.display='none'; document.getElementById('mpRepo').classList.remove('mp-invalid','mp-ok'); return true; }
        let valid = false;
        try { new URL(val); valid = true; } catch(_) {}
        tick.style.display = 'block';
        tick.style.stroke   = valid ? '#22c55e' : '#ef4444';
        tick.innerHTML      = valid ? '<polyline points="20 6 9 17 4 12"/>' : '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>';
        err.style.display   = valid ? 'none' : 'block';
        document.getElementById('mpRepo').classList.toggle('mp-invalid', !valid);
        document.getElementById('mpRepo').classList.toggle('mp-ok', valid);
        return valid;
    }
    function mpHandleFiles(files) {
        const errBox = document.getElementById('mpFileErrs');
        errBox.innerHTML = '';
        Array.from(files).forEach(f => {
            const ext = f.name.split('.').pop().toLowerCase();
            if (!MP_FORMATOS.includes(ext)) {
                errBox.innerHTML += `<div class="mp-ferr"><svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>Formato de archivo no válido — "${f.name}". Formatos aceptados: .pdf .zip .png .jpg</div>`;
                return;
            }
            if (f.size > MP_MAX) {
                errBox.innerHTML += `<div class="mp-ferr"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Tamaño de archivo excedido — "${f.name}" (${(f.size/1024/1024).toFixed(1)}MB). Máximo 10MB.</div>`;
                return;
            }
            mpFiles.push(f);
        });
        mpRenderFlist();
    }
    function mpRenderFlist() {
        const box = document.getElementById('mpFlist');
        box.innerHTML = mpFiles.map((f,i) =>
            `<div class="mp-fitem">
                <span class="mp-fitem-name">${f.name}</span>
                <span><span class="mp-fitem-size">${(f.size/1024).toFixed(0)} KB</span>
                <button class="mp-frem" onclick="mpRemoveFile(${i})"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></span>
            </div>`
        ).join('');
    }
    function mpRemoveFile(i) { mpFiles.splice(i,1); mpRenderFlist(); }

    async function mpGuardar(estado) {
        const nombre = document.getElementById('mpNombre').value.trim();
        const desc   = document.getElementById('mpDesc').value.trim();
        let valid = true;
        if (!nombre) { document.getElementById('mpErrNombre').style.display='block'; document.getElementById('mpNombre').classList.add('mp-invalid'); valid=false; }
        else          { document.getElementById('mpErrNombre').style.display='none';  document.getElementById('mpNombre').classList.remove('mp-invalid'); }
        if (!desc)   { document.getElementById('mpErrDesc').style.display='block';   document.getElementById('mpDesc').classList.add('mp-invalid');   valid=false; }
        else          { document.getElementById('mpErrDesc').style.display='none';    document.getElementById('mpDesc').classList.remove('mp-invalid'); }
        if (!mpValidarUrl()) valid = false;
        if (!valid) return;

        const form = new FormData();
        form.append('nombre',          nombre);
        form.append('descripcion',     desc);
        form.append('repositorio_url', document.getElementById('mpRepo').value.trim());
        form.append('estado',          estado);
        form.append('_token',          document.querySelector('meta[name="csrf-token"]').content);
        mpFiles.forEach(f => form.append('archivos[]', f));

        const btnB = document.getElementById('mpBtnBorrador');
        const btnP = document.getElementById('mpBtnPublicar');
        btnB.disabled = btnP.disabled = true;
        btnP.innerHTML = 'Guardando...';

        try {
            const res  = await fetch('/mis-portafolios', { method: 'POST', body: form });
            const text = await res.text();
            let json;
            try { json = JSON.parse(text); } catch(_) { throw new Error('Error del servidor (' + res.status + ')'); }
            if (json.ok) { mpCerrar(); location.reload(); return; }
            const msg = json.errors ? Object.values(json.errors).flat().join('\n') : 'Error al guardar.';
            alert(msg);
        } catch(err) {
            alert(err.message);
        }
        btnB.disabled = btnP.disabled = false;
        btnP.innerHTML = '<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> Publicar Proyecto';
    }
</script>
</body>
</html>