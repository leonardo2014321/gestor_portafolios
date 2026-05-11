    {{-- _styles_menu.blade.php --}}
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
      
        html,body{font-family:"DM Sans",sans-serif;color:var(--text);}
        .app{display:flex;flex-direction:column;}
        .app-locked{height:100%;overflow:hidden;}
        .app-locked .app{height:100vh;}

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
        .rep-tab{padding:10px 20px;background:none;border:none;border-bottom:3px solid transparent;font-size:14px;font-weight:700;color:var(--muted);cursor:pointer;transition:all 0.2s;font-family:"DM Sans",sans-serif;}
        .rep-tab:hover{color:var(--blue);background:#f8fafc;}
        .rep-tab.active{color:var(--blue);border-bottom-color:var(--blue);background:#f1f5f9;}
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
        /* Plantilla 7 - Portafolio Hexágonos */
        #cv-template-7{width:297mm;min-height:210mm;display:flex;font-family:'Helvetica',sans-serif;position:relative;background:#fcd34d;overflow:hidden;}
        #cv-template-7 .cv7-bg{position:absolute;top:0;left:0;width:100%;height:100%;z-index:0;pointer-events:none;}
        #cv-template-7 .cv7-hex-big{position:absolute;top:-10%;right:-5%;width:600px;height:600px;background:#f59e0b;clip-path:polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);}
        #cv-template-7 .cv7-hex-photo-wrap{position:absolute;top:15%;right:10%;width:350px;height:350px;clip-path:polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);background:#fff;display:flex;align-items:center;justify-content:center;}
        #cv-template-7 .cv7-photo{width:330px;height:330px;object-fit:cover;clip-path:polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);}
        #cv-template-7 .cv7-hex-small1{position:absolute;top:70%;right:35%;width:150px;height:150px;border:8px solid #333;clip-path:polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);}
        #cv-template-7 .cv7-hex-small2{position:absolute;top:40%;left:-5%;width:200px;height:200px;border:2px solid #333;clip-path:polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);}
        #cv-template-7 .cv7-content{position:relative;z-index:1;padding:50px;width:60%;display:flex;flex-direction:column;justify-content:center;height:100%;}
        #cv-template-7 .cv7-header{margin-bottom:40px;background:rgba(255,255,255,0.7);padding:20px 30px;border-radius:10px;border-left:8px solid #f59e0b;}
        #cv-template-7 .cv7-name{font-size:42px;color:#1e293b;margin-bottom:5px;font-weight:800;letter-spacing:1px;}
        #cv-template-7 .cv7-role{font-size:22px;color:#334155;font-weight:600;}
        #cv-template-7 .cv7-projects{display:flex;flex-direction:column;gap:20px;padding-left:20px;}
        #cv-template-7 .cv7-project{border-left:4px solid #333;padding-left:15px;}
        #cv-template-7 .cv7-proj-title{font-size:16px;font-weight:700;color:#1e293b;margin-bottom:5px;}
        #cv-template-7 .cv7-proj-desc{font-size:14px;color:#475569;line-height:1.5;}
        #cv-template-7 .cv7-footer{position:absolute;bottom:0;left:0;width:100%;background:rgba(255,255,255,0.85);padding:15px 50px;font-size:18px;font-weight:700;color:#1e293b;text-align:center;}

        /* Plantilla 8 - Portafolio Timeline Azul */
        #cv-template-8{width:297mm;min-height:210mm;display:flex;font-family:'Helvetica',sans-serif;background:#fff;}
        #cv-template-8 .cv8-left{width:32%;background:linear-gradient(180deg, #0284c7 0%, #38bdf8 100%);color:#fff;padding:60px 30px;display:flex;flex-direction:column;align-items:center;position:relative;clip-path:polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%);}
        #cv-template-8 .cv8-photo-container{width:180px;height:240px;border-radius:90px 90px 40px 40px;overflow:hidden;border:6px solid #1e293b;margin-bottom:30px;box-shadow:0 10px 20px rgba(0,0,0,0.3);}
        #cv-template-8 .cv8-photo{width:100%;height:100%;object-fit:cover;}
        #cv-template-8 .cv8-name{font-size:32px;font-weight:800;text-align:center;line-height:1.1;margin-bottom:15px;color:#1e293b;text-transform:uppercase;}
        #cv-template-8 .cv8-bio{font-size:14px;text-align:center;line-height:1.6;}
        #cv-template-8 .cv8-right{width:68%;padding:50px;display:flex;flex-direction:column;}
        #cv-template-8 .cv8-header{display:flex;justify-content:flex-end;margin-bottom:40px;}
        #cv-template-8 .cv8-header h2{font-size:24px;font-weight:700;color:#1e293b;}
        #cv-template-8 .cv8-main-title{font-size:20px;font-weight:700;color:#0284c7;text-align:center;letter-spacing:4px;margin-bottom:40px;}
        #cv-template-8 .cv8-timeline-container{display:flex;gap:40px;}
        #cv-template-8 .cv8-col{flex:1;}
        #cv-template-8 .cv8-col-title{display:flex;align-items:center;gap:10px;font-size:16px;font-weight:800;color:#1e293b;margin-bottom:30px;}
        #cv-template-8 .cv8-timeline{border-left:2px solid #0284c7;padding-left:20px;}
        #cv-template-8 .cv8-time-item{position:relative;margin-bottom:25px;background:#f8fafc;padding:15px;border:1px solid #e2e8f0;border-radius:8px;}
        #cv-template-8 .cv8-time-item::before{content:'';position:absolute;left:-27px;top:20px;width:12px;height:12px;border-radius:50%;background:#0284c7;}
        #cv-template-8 .cv8-time-date{font-size:12px;color:#0284c7;font-weight:700;margin-bottom:5px;}
        #cv-template-8 .cv8-time-title{font-size:14px;font-weight:800;color:#1e293b;margin-bottom:5px;text-transform:uppercase;}
        #cv-template-8 .cv8-time-desc{font-size:13px;color:#475569;}

        /* Plantilla 9 - Portafolio Elegante (Círculos) */
        #cv-template-9{width:297mm;min-height:210mm;display:flex;flex-direction:column;font-family:'Helvetica',sans-serif;background:#fff;}
        #cv-template-9 .cv9-top{height:35%;background:#333;position:relative;display:flex;align-items:center;justify-content:flex-end;padding-right:60px;}
        #cv-template-9 .cv9-top::before{content:'';position:absolute;left:0;top:0;width:300px;height:100%;background:repeating-linear-gradient(90deg, #ccc, #ccc 2px, transparent 2px, transparent 10px);opacity:0.3;}
        #cv-template-9 .cv9-top-text{font-size:26px;color:#fff;text-align:right;line-height:1.2;font-weight:300;}
        #cv-template-9 .cv9-photo-wrapper{position:absolute;left:150px;top:50px;width:240px;height:240px;border-radius:50%;background:#2563eb;padding:10px;z-index:10;}
        #cv-template-9 .cv9-photo{width:100%;height:100%;border-radius:50%;object-fit:cover;border:6px solid #fff;}
        #cv-template-9 .cv9-bottom{height:65%;display:flex;background:#1e3a8a;color:#fff;}
        #cv-template-9 .cv9-bottom-left{width:40%;padding:120px 40px 40px;position:relative;overflow:hidden;}
        #cv-template-9 .cv9-contact{display:flex;flex-direction:column;gap:15px;position:relative;z-index:2;}
        #cv-template-9 .cv9-contact-row{display:flex;font-size:13px;}
        #cv-template-9 .cv9-label{width:100px;font-weight:700;}
        #cv-template-9 .cv9-val{flex:1;opacity:0.9;}
        #cv-template-9 .cv9-bottom-right{width:60%;padding:60px 60px 40px 0;}
        #cv-template-9 .cv9-name-box{border-bottom:2px solid rgba(255,255,255,0.3);padding-bottom:20px;margin-bottom:30px;}
        #cv-template-9 .cv9-name{font-size:42px;font-weight:800;margin-bottom:10px;}
        #cv-template-9 .cv9-role{font-size:18px;opacity:0.8;}
        #cv-template-9 .cv9-projects{display:flex;flex-direction:column;gap:20px;}
        #cv-template-9 .cv9-project{background:rgba(255,255,255,0.05);padding:15px;border-radius:8px;}
        #cv-template-9 .cv9-proj-title{font-size:16px;font-weight:700;margin-bottom:8px;}
        #cv-template-9 .cv9-proj-desc{font-size:13px;line-height:1.5;opacity:0.8;}

        /* Plantilla 10 - Portafolio Columnas Minimalista */
        #cv-template-10{width:297mm;min-height:210mm;display:flex;font-family:'Georgia',serif;background:#f3f4f6;}
        #cv-template-10 .cv10-col-left{width:25%;background:#27272a;color:#fff;padding:40px 20px;display:flex;flex-direction:column;align-items:center;}
        #cv-template-10 .cv10-photo-wrap{width:140px;height:180px;background:#fff;padding:5px;margin-bottom:30px;}
        #cv-template-10 .cv10-photo{width:100%;height:100%;object-fit:cover;}
        #cv-template-10 .cv10-name{font-size:24px;text-align:center;margin-bottom:40px;color:#fda4af;line-height:1.2;}
        #cv-template-10 .cv10-contact{width:100%;display:flex;flex-direction:column;gap:15px;margin-top:auto;}
        #cv-template-10 .cv10-contact-item{display:flex;align-items:center;gap:10px;font-size:12px;font-family:'Helvetica',sans-serif;}
        #cv-template-10 .cv10-icon{width:24px;height:24px;border-radius:50%;background:#fda4af;display:flex;align-items:center;justify-content:center;color:#27272a;}
        #cv-template-10 .cv10-col-mid{width:35%;background:#e0a59e;padding:40px 30px;color:#27272a;}
        #cv-template-10 .cv10-col-right{width:40%;background:#f8fafc;padding:40px 30px;color:#27272a;}
        #cv-template-10 .cv10-title{font-size:28px;font-weight:400;margin-bottom:30px;}
        #cv-template-10 .cv10-title small{font-style:italic;font-size:22px;}
        #cv-template-10 .cv10-timeline{border-left:2px solid #27272a;padding-left:15px;}
        #cv-template-10 .cv10-timeline-alt{border-left:2px solid #94a3b8;}
        #cv-template-10 .cv10-item{position:relative;margin-bottom:25px;font-family:'Helvetica',sans-serif;}
        #cv-template-10 .cv10-item::before{content:'';position:absolute;left:-21px;top:5px;width:10px;height:10px;border-radius:50%;background:#27272a;}
        #cv-template-10 .cv10-timeline-alt .cv10-item::before{background:#94a3b8;}
        #cv-template-10 .cv10-item-title{font-size:14px;font-weight:700;color:#27272a;}
        #cv-template-10 .cv10-item-sub{font-size:13px;font-style:italic;color:#475569;margin-top:2px;}
        #cv-template-10 .cv10-item-date{font-size:12px;color:#64748b;margin:4px 0;}
        #cv-template-10 .cv10-item-desc{font-size:12px;line-height:1.4;color:#333;}
        #cv-template-10 .cv10-box{background:#fff;padding:20px;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.05);margin-bottom:20px;font-family:'Helvetica',sans-serif;}
        #cv-template-10 .cv10-box-title{font-size:18px;font-weight:400;margin-bottom:15px;font-family:'Georgia',serif;}
        #cv-template-10 .cv10-list{list-style:none;padding:0;}
        #cv-template-10 .cv10-list li{font-size:12px;margin-bottom:8px;display:flex;align-items:center;gap:8px;}
        
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
            .topbar,aside,.rpanel,.content-bar,footer,.template-selector,.reportes-tabs{display:none !important;}
            .cv-template-view{display:none !important;}
            .cv-template-view.active-tpl{display:flex !important;}
            main{background:#fff;padding:0;overflow:visible;width:100%;min-height:100vh;display:block;}
            .main-inner{padding:0;display:block;}
            .cv-wrapper{padding-bottom:0;justify-content:flex-start;min-height:100vh;}
            .cv-container{box-shadow:none;width:100%;min-height:100vh;}
        }
        @media print {
            @page { margin: 0; }
            body { margin: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            body.print-landscape {
                /* landscape is handled by javascript */
            }
        }
        
        /* Regla inyectada dinámicamente si es necesario */
    </style>