{{-- ============================================================
     _modales_crear_portafolio.blade.php
     Partial: los 4 modales de gestión de portafolios + estilos
     Incluye: Crear · Ver · Confirmar · Editar
     Uso: @include('_modales_crear_portafolio')
     ============================================================ --}}

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
    .mp-btn-primary:disabled,.mp-btn-ghost:disabled{opacity:.45;cursor:not-allowed}
    .mp-close{position:absolute;top:20px;right:24px;background:var(--gray);border:1px solid var(--gray2);border-radius:8px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);transition:all .2s}
    .mp-close:hover{background:var(--gray2);color:var(--text)}
    .mp-close svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .mp-header-wrap{position:relative}
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
    .mp-drop.dragover{border-color:var(--blue)!important;background:#eff6ff!important}
    /* Card portafolio con banner */
    .pcard-pf{border-radius:16px;overflow:hidden;background:#fff;border:1px solid var(--gray2);box-shadow:0 2px 8px rgba(0,0,0,.07);display:flex;flex-direction:column;cursor:pointer;transition:transform .15s,box-shadow .15s}
    .pcard-pf:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.13)}
    .pcard-pf-top{position:relative;height:90px;overflow:hidden;flex-shrink:0}
    .pcard-pf-banner-img{width:100%;height:100%;object-fit:cover;display:block}
    .pcard-pf-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.08) 0%,rgba(0,0,0,.38) 100%)}
    .pcard-pf-logo{position:absolute;bottom:10px;left:14px;width:36px;height:36px;border-radius:8px;border:2px solid rgba(255,255,255,.85);overflow:hidden;background:rgba(255,255,255,.15);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center}
    .pcard-pf-logo img{width:100%;height:100%;object-fit:cover}
    .pcard-pf-logo-ico{background:rgba(255,255,255,.18)}
    .pcard-pf-body{padding:10px 14px 12px;flex:1;display:flex;flex-direction:column;justify-content:space-between}
    .pcard-pf-name{font-size:13.5px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .pcard-pf-desc{font-size:11.5px;color:var(--muted);overflow:hidden;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;margin-top:3px}
    .pcard-pf-footer{display:flex;align-items:center;justify-content:space-between;margin-top:8px}
    /* Modal Crear Portafolio (Modal 5) */
    .pf-img-zone{border:2px dashed var(--gray3);border-radius:12px;cursor:pointer;transition:border-color .2s,background .2s;overflow:hidden;position:relative;background:var(--gray)}
    .pf-img-zone:hover{border-color:var(--blue)}
    .pf-img-zone.has-img{border-color:var(--blue);background:#eff6ff}
    .pf-banner-zone{width:100%;height:130px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:6px}
    .pf-banner-zone img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:10px}
    .pf-logo-zone{width:96px;height:96px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:4px;flex-shrink:0}
    .pf-logo-zone img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:10px}
    .pf-img-placeholder{display:flex;flex-direction:column;align-items:center;gap:6px;color:var(--muted);pointer-events:none}
    .pf-img-placeholder svg{width:28px;height:28px;fill:none;stroke:currentColor;stroke-width:1.4;stroke-linecap:round;stroke-linejoin:round}
    .pf-img-placeholder p{font-size:12px;font-weight:500;color:var(--text);margin:0}
    .pf-img-placeholder span{font-size:10.5px}
    .pf-remove{position:absolute;top:6px;right:6px;background:rgba(0,0,0,.5);color:#fff;border:none;border-radius:6px;width:24px;height:24px;display:none;align-items:center;justify-content:center;cursor:pointer;font-size:14px;line-height:1}
    .pf-img-zone.has-img .pf-remove{display:flex}
    /* Modal Ver */
    .vp-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1100;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .2s}
    .vp-overlay.open{opacity:1;pointer-events:all}
    .vp-box{background:#fff;border-radius:18px;width:min(680px,95vw);max-height:88vh;overflow-y:auto;box-shadow:0 24px 64px rgba(0,0,0,.18);transform:translateY(16px);transition:transform .2s}
    .vp-overlay.open .vp-box{transform:translateY(0)}
    .vp-head{display:flex;align-items:flex-start;justify-content:space-between;padding:24px 28px 0}
    .vp-title{font-size:20px;font-weight:700;color:var(--text);word-break:break-word}
    .vp-badge{display:inline-block;margin-top:6px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:.4px}
    .vp-badge.publicado{background:#d1fae5;color:#065f46}
    .vp-badge.borrador{background:#fef3c7;color:#92400e}
    .vp-close{background:none;border:none;cursor:pointer;color:var(--muted);padding:4px}
    .vp-close:hover{color:var(--text)}
    .vp-close svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round}
    .vp-body{padding:20px 28px 28px}
    .vp-desc{font-size:14px;color:var(--muted);line-height:1.6;margin-bottom:16px;word-break:break-word;white-space:pre-wrap;max-height:160px;overflow-y:auto}
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
    /* Proyectos en modal Ver */
    .vp-proj-card{border:1px solid var(--gray2);border-radius:12px;padding:14px;margin-bottom:10px;background:var(--gray)}
    .vp-proj-head{display:flex;align-items:flex-start;justify-content:space-between;gap:8px;margin-bottom:6px}
    .vp-proj-name{font-size:14px;font-weight:700;color:var(--text)}
    .vp-proj-desc{font-size:12px;color:var(--muted);margin-top:3px;line-height:1.4;word-break:break-word}
    .vp-proj-files{display:flex;flex-direction:column;gap:4px;margin-top:8px}
    .vp-proj-no-files{font-size:11.5px;color:var(--muted);padding:4px 0}
    .vp-proj-links{display:flex;gap:8px;margin-top:8px;flex-wrap:wrap}
    .vp-proj-link{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:6px;font-size:11.5px;font-weight:600;text-decoration:none;transition:opacity .15s}
    .vp-proj-link:hover{opacity:.8}
    .vp-proj-link-gh{background:#24292e;color:#fff}
    .vp-proj-link-deploy{background:#10b981;color:#fff}
    .vp-proj-link svg{width:12px;height:12px;fill:currentColor;flex-shrink:0}
    .vp-proj-add-file{display:inline-flex;align-items:center;gap:4px;margin-top:8px;cursor:pointer;color:var(--blue);font-size:12px;font-weight:600;user-select:none}
    .vp-proj-add-file:hover span{text-decoration:underline}
    .vp-proj-actions{display:flex;gap:6px;margin-top:10px;border-top:1px solid var(--gray2);padding-top:10px}
    .vp-proj-btn-edit{flex:1;padding:6px 10px;border-radius:7px;border:1.5px solid var(--blue);background:#fff;color:var(--blue);font-size:12px;font-weight:600;cursor:pointer;transition:background .15s}
    .vp-proj-btn-edit:hover{background:#eff6ff}
    .vp-proj-btn-del2{flex:1;padding:6px 10px;border-radius:7px;border:1.5px solid #fca5a5;background:#fff;color:#ef4444;font-size:12px;font-weight:600;cursor:pointer;transition:background .15s}
    .vp-proj-btn-del2:hover{background:#fef2f2}
    .vp-proj-edit-form{display:flex;flex-direction:column;gap:10px}
    .vp-proj-edit-input{width:100%;background:var(--gray);border:1px solid var(--gray2);border-radius:8px;padding:8px 12px;font-size:13px;color:var(--text);font-family:"DM Sans",sans-serif;outline:none;transition:border-color .2s;box-sizing:border-box}
    .vp-proj-edit-input:focus{border-color:var(--blue);background:#fff}
    .vp-proj-edit-textarea{min-height:72px;resize:vertical}
    .vp-proj-edit-url-wrap{display:flex;gap:8px}
    .vp-proj-edit-url-wrap .vp-proj-edit-input{flex:1}
    .vp-proj-edit-btns{display:flex;gap:8px}
    .vp-file-dl{color:var(--blue);font-size:11px;font-weight:600;text-decoration:none;padding:2px 6px;border-radius:4px;white-space:nowrap;flex-shrink:0}
    .vp-file-dl:hover{text-decoration:underline}
    .vp-file-del{background:none;border:none;cursor:pointer;color:var(--muted);padding:0 0 0 4px;flex-shrink:0}
    .vp-file-del:hover{color:#ef4444}
    .vp-file-del svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    /* Previews de imágenes en proyectos */
    .vp-img-preview{display:flex;align-items:center;gap:10px;background:var(--gray);border-radius:8px;padding:8px;margin-bottom:4px}
    .vp-img-thumb{width:52px;height:52px;object-fit:cover;border-radius:6px;border:1px solid var(--gray2);flex-shrink:0;cursor:pointer;transition:opacity .15s}
    .vp-img-thumb:hover{opacity:.85}
    .vp-img-meta{flex:1;min-width:0;display:flex;flex-direction:column;gap:2px}
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

{{-- ══ MODAL 1 · Añadir Proyecto ══ --}}
<div class="mp-overlay" id="modalPortafolio" onclick="cerrarModalPortafolio(event)">
    <div class="mp-modal">
        <div class="mp-header-wrap">
            <div class="mp-header">
                <h2>{{ __('app.modales_pf.modal1_titulo') }}</h2>
                <p>{{ __('app.modales_pf.modal1_subtitulo') }}</p>
            </div>
            <button class="mp-close" onclick="mpCerrar()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="mp-body">

            {{-- Portafolio destino --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    {{ __('app.modales_pf.seccion_destino') }}
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.selecciona_portafolio') }} <span>*</span></label>
                    <select class="mp-input" id="mpPortafolioId" onchange="mpCheckBtns()">
                        <option value="">{{ __('app.modales_pf.elige_portafolio') }}</option>
                    </select>
                    <div class="mp-err" id="mpErrPortafolio">{{ __('app.modales_pf.err_portafolio') }}</div>
                </div>
            </div>

            {{-- Información del proyecto --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    {{ __('app.modales_pf.seccion_info_proyecto') }}
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.nombre_proyecto') }} <span>*</span></label>
                    <input class="mp-input" id="mpNombre" type="text" maxlength="100"
                           placeholder="{{ __('app.modales_pf.nombre_proyecto_placeholder') }}" oninput="mpCheckBtns()">
                    <div class="mp-err" id="mpErrNombre">{{ __('app.modales_pf.err_nombre') }}</div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.descripcion') }} <span>*</span></label>
                    <textarea class="mp-textarea" id="mpDesc" maxlength="500" rows="3"
                              placeholder="{{ __('app.modales_pf.desc_proyecto_placeholder') }}"
                              oninput="mpCheckBtns();document.getElementById('mpDescCount').textContent=this.value.length"></textarea>
                    <div style="text-align:right;font-size:11px;color:var(--muted);margin-top:3px">
                        <span id="mpDescCount">0</span>/500
                    </div>
                    <div class="mp-err" id="mpErrDesc">{{ __('app.modales_pf.err_descripcion') }}</div>
                </div>
            </div>

            {{-- Vínculos --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    {{ __('app.modales_pf.seccion_vinculos') }} <span style="font-weight:400;text-transform:none;letter-spacing:0">({{ __('app.modales_pf.opcional') }})</span>
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.repo_github') }}</label>
                    <div class="mp-url-wrap">
                        <input class="mp-input" id="mpRepo" type="text" maxlength="500"
                               placeholder="{{ __('app.modales_pf.repo_placeholder') }}"
                               oninput="mpValidarUrl('mpRepo','mpRepoTick','mpErrRepo')"
                               style="padding-right:36px">
                        <svg class="mp-url-tick" id="mpRepoTick" viewBox="0 0 24 24"></svg>
                    </div>
                    <div class="mp-err" id="mpErrRepo">{{ __('app.modales_pf.err_url') }}</div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.url_deploy') }}</label>
                    <div class="mp-url-wrap">
                        <input class="mp-input" id="mpDeploy" type="text" maxlength="500"
                               placeholder="{{ __('app.modales_pf.deploy_placeholder') }}"
                               oninput="mpValidarUrl('mpDeploy','mpDeployTick','mpErrDeploy')"
                               style="padding-right:36px">
                        <svg class="mp-url-tick" id="mpDeployTick" viewBox="0 0 24 24"></svg>
                    </div>
                    <div class="mp-err" id="mpErrDeploy">{{ __('app.modales_pf.err_url') }}</div>
                </div>
            </div>

            {{-- Archivos adjuntos --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/></svg>
                    {{ __('app.modales_pf.seccion_archivos') }} <span style="font-weight:400;text-transform:none;letter-spacing:0">({{ __('app.modales_pf.opcional') }})</span>
                </div>
                <div class="mp-drop" id="mpDropZone"
                     onclick="document.getElementById('mpFileInput').click()"
                     ondragover="event.preventDefault();this.classList.add('dragover')"
                     ondragleave="this.classList.remove('dragover')"
                     ondrop="event.preventDefault();this.classList.remove('dragover');mpHandleFiles(event.dataTransfer.files)">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p>{{ __('app.modales_pf.drop_texto') }}</p>
                    <span>{{ __('app.modales_pf.drop_hint') }}</span>
                </div>
                <input type="file" id="mpFileInput" multiple
                       accept="image/*,.zip,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                       style="display:none" onchange="mpHandleFiles(this.files)">
                <div class="mp-flist" id="mpFlist"></div>
            </div>

        </div>
        <div class="mp-footer">
            <button class="mp-btn-ghost" id="mpBtnBorrador" onclick="mpGuardar('borrador')" disabled>
                {{ __('app.modales_pf.guardar_borrador') }}
            </button>
            <button class="mp-btn-primary" id="mpBtnPublicar" onclick="mpGuardar('publicado')" disabled>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ __('app.modales_pf.btn_anadir_proyecto') }}
            </button>
        </div>
    </div>
</div>

{{-- ══ MODAL 2 · Ver Portafolio ══ --}}
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
            <div class="vp-sec" style="margin-top:20px">{{ __('app.modales_pf.proyectos') }}</div>
            <div id="vpProyectosList"><div class="vp-empty">{{ __('app.modales_pf.cargando') }}</div></div>
        </div>
        <div class="vp-foot">
            <button class="vp-btn-del" id="vpBtnEliminar" onclick="vpConfirmarEliminar()">{{ __('app.modales_pf.eliminar_portafolio') }}</button>
            <button class="vp-btn-edit" id="vpBtnEditar" onclick="vpAbrirEditar()">{{ __('app.modales_pf.editar') }}</button>
            <button class="vp-btn-close" onclick="vpCerrar()">{{ __('app.modales_pf.cerrar') }}</button>
        </div>
    </div>
</div>

{{-- ══ MODAL 3 · Confirmación ══ --}}
<div class="conf-overlay" id="modalConf">
    <div class="conf-box">
        <div class="conf-ico" id="confIco">
            <svg id="confIcoSvg" viewBox="0 0 24 24"></svg>
        </div>
        <div class="conf-title" id="confTitle"></div>
        <div class="conf-desc"  id="confDesc"></div>
        <div class="conf-btns">
            <button class="conf-btn-cancel" onclick="confCerrar()">{{ __('app.modales_pf.cancelar') }}</button>
            <button class="conf-btn-ok"     id="confBtnOk">{{ __('app.modales_pf.confirmar') }}</button>
        </div>
    </div>
</div>

{{-- ══ MODAL 4 · Editar Portafolio ══ --}}
<div class="mp-overlay" id="modalEditarPortafolio" onclick="if(event.target===this)epCerrar()">
    <div class="mp-modal">
        <div class="mp-header-wrap">
            <div class="mp-header">
                <h2>{{ __('app.modales_pf.modal4_titulo') }}</h2>
                <p>{{ __('app.modales_pf.modal4_subtitulo') }}</p>
            </div>
            <button class="mp-close" onclick="epCerrar()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="mp-body">
            <input type="hidden" id="epId">

            {{-- Información --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    {{ __('app.modales_pf.seccion_info_pf') }}
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.nombre') }} <span>*</span></label>
                    <input class="mp-input" id="epNombre" type="text" maxlength="100"
                           placeholder="{{ __('app.modales_pf.nombre_pf_placeholder') }}" oninput="epCheckBtns()">
                    <div class="mp-err" id="epErrNombre">{{ __('app.modales_pf.err_nombre') }}</div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.descripcion') }} <span>*</span></label>
                    <textarea class="mp-textarea" id="epDesc" maxlength="500" rows="3"
                              placeholder="{{ __('app.modales_pf.desc_pf_placeholder') }}"
                              oninput="epCheckBtns();document.getElementById('epDescCount').textContent=this.value.length"></textarea>
                    <div style="text-align:right;font-size:11px;color:var(--muted);margin-top:3px">
                        <span id="epDescCount">0</span>/500
                    </div>
                    <div class="mp-err" id="epErrDesc">{{ __('app.modales_pf.err_descripcion') }}</div>
                </div>
            </div>

            {{-- Banner --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    {{ __('app.modales_pf.seccion_banner') }}
                </div>
                <input type="file" id="epBannerInput" accept="image/png,image/jpeg,image/jpg"
                       style="display:none" onchange="epHandleImg('banner',this.files[0])">
                <div class="pf-img-zone pf-banner-zone" id="epBannerZone"
                     onclick="document.getElementById('epBannerInput').click()"
                     ondragover="event.preventDefault();this.classList.add('has-img')"
                     ondragleave="epDragLeave('banner',event)"
                     ondrop="event.preventDefault();epHandleImg('banner',event.dataTransfer.files[0])">
                    <img id="epBannerPreview" src="" alt="" style="display:none">
                    <div class="pf-img-placeholder" id="epBannerPlaceholder">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p>{{ __('app.modales_pf.drop_cambiar') }}</p>
                        <span>{{ __('app.modales_pf.banner_hint') }}</span>
                    </div>
                    <button class="pf-remove" onclick="event.stopPropagation();epQuitarImg('banner')">&times;</button>
                </div>
            </div>

            {{-- Logo --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    {{ __('app.modales_pf.seccion_logo') }}
                </div>
                <input type="file" id="epLogoInput" accept="image/png,image/jpeg,image/jpg"
                       style="display:none" onchange="epHandleImg('logo',this.files[0])">
                <div style="display:flex;align-items:flex-start;gap:16px">
                    <div class="pf-img-zone pf-logo-zone" id="epLogoZone"
                         onclick="document.getElementById('epLogoInput').click()"
                         ondragover="event.preventDefault();this.classList.add('has-img')"
                         ondragleave="epDragLeave('logo',event)"
                         ondrop="event.preventDefault();epHandleImg('logo',event.dataTransfer.files[0])">
                        <img id="epLogoPreview" src="" alt="" style="display:none">
                        <div class="pf-img-placeholder" id="epLogoPlaceholder">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        </div>
                        <button class="pf-remove" onclick="event.stopPropagation();epQuitarImg('logo')">&times;</button>
                    </div>
                    <div style="padding-top:6px">
                        <p style="font-size:13px;font-weight:600;color:var(--text);margin:0 0 4px">{{ __('app.modales_pf.logo_titulo') }}</p>
                        <p style="font-size:12px;color:var(--muted);margin:0">{{ __('app.modales_pf.logo_hint') }}</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="mp-footer">
            <button class="mp-btn-ghost" id="epBtnBorrador" onclick="epConfirmarGuardar('borrador')" disabled>
                {{ __('app.modales_pf.guardar_borrador') }}
            </button>
            <button class="mp-btn-primary" id="epBtnPublicar" onclick="epConfirmarGuardar('publicado')" disabled>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ __('app.modales_pf.btn_guardar_cambios') }}
            </button>
        </div>
    </div>
</div>

{{-- ══ MODAL 5 · Crear Portafolio (contenedor con banner/logo) ══ --}}
<div class="mp-overlay" id="modalCrearPf" onclick="if(event.target===this)pfCerrar()">
    <div class="mp-modal">
        <div class="mp-header-wrap">
            <div class="mp-header">
                <h2>{{ __('app.modales_pf.modal5_titulo') }}</h2>
                <p>{{ __('app.modales_pf.modal5_subtitulo') }}</p>
            </div>
            <button class="mp-close" onclick="pfCerrar()">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="mp-body">

            {{-- Información --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9"/><rect x="13" y="2" width="9" height="9"/><rect x="2" y="13" width="9" height="9"/><rect x="13" y="13" width="9" height="9"/></svg>
                    {{ __('app.modales_pf.seccion_info_pf') }}
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.nombre_pf_label') }} <span>*</span></label>
                    <input class="mp-input" id="pfNombre" type="text" maxlength="100"
                           placeholder="{{ __('app.modales_pf.nombre_pf_placeholder') }}" oninput="pfCheckBtns()">
                    <div class="mp-err" id="pfErrNombre">{{ __('app.modales_pf.err_campo_obligatorio') }}</div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">{{ __('app.modales_pf.descripcion') }} <span>*</span></label>
                    <textarea class="mp-textarea" id="pfDesc" maxlength="500" rows="3"
                              placeholder="{{ __('app.modales_pf.desc_pf_placeholder') }}"
                              oninput="pfCheckBtns();document.getElementById('pfDescCount').textContent=this.value.length"></textarea>
                    <div style="text-align:right;font-size:11px;color:var(--muted);margin-top:3px">
                        <span id="pfDescCount">0</span>/500
                    </div>
                    <div class="mp-err" id="pfErrDesc">{{ __('app.modales_pf.err_descripcion') }}</div>
                </div>
            </div>

            {{-- Banner --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    {{ __('app.modales_pf.seccion_banner') }}
                </div>
                <input type="file" id="pfBannerInput" accept="image/png,image/jpeg,image/jpg"
                       style="display:none" onchange="pfHandleImg('banner',this.files[0])">
                <div class="pf-img-zone pf-banner-zone" id="pfBannerZone"
                     onclick="document.getElementById('pfBannerInput').click()"
                     ondragover="event.preventDefault();this.classList.add('has-img')"
                     ondragleave="pfDragLeave('banner',event)"
                     ondrop="event.preventDefault();pfHandleImg('banner',event.dataTransfer.files[0])">
                    <img id="pfBannerPreview" src="" alt="" style="display:none">
                    <div class="pf-img-placeholder" id="pfBannerPlaceholder">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p>{{ __('app.modales_pf.drop_texto') }}</p>
                        <span>{{ __('app.modales_pf.banner_hint_full') }}</span>
                    </div>
                    <button class="pf-remove" onclick="event.stopPropagation();pfQuitarImg('banner')">&times;</button>
                </div>
            </div>

            {{-- Logo --}}
            <div class="mp-section">
                <div class="mp-section-label">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    {{ __('app.modales_pf.seccion_logo') }}
                </div>
                <input type="file" id="pfLogoInput" accept="image/png,image/jpeg,image/jpg"
                       style="display:none" onchange="pfHandleImg('logo',this.files[0])">
                <div style="display:flex;align-items:flex-start;gap:16px">
                    <div class="pf-img-zone pf-logo-zone" id="pfLogoZone"
                         onclick="document.getElementById('pfLogoInput').click()"
                         ondragover="event.preventDefault();this.classList.add('has-img')"
                         ondragleave="pfDragLeave('logo',event)"
                         ondrop="event.preventDefault();pfHandleImg('logo',event.dataTransfer.files[0])">
                        <img id="pfLogoPreview" src="" alt="" style="display:none">
                        <div class="pf-img-placeholder" id="pfLogoPlaceholder">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        </div>
                        <button class="pf-remove" onclick="event.stopPropagation();pfQuitarImg('logo')">&times;</button>
                    </div>
                    <div style="padding-top:6px">
                        <p style="font-size:13px;font-weight:600;color:var(--text);margin:0 0 4px">{{ __('app.modales_pf.logo_titulo') }}</p>
                        <p style="font-size:12px;color:var(--muted);margin:0">{{ __('app.modales_pf.logo_hint') }}</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="mp-footer">
            <button class="mp-btn-ghost" id="pfBtnBorrador" onclick="pfGuardar('borrador')" disabled>
                {{ __('app.modales_pf.guardar_borrador') }}
            </button>
            <button class="mp-btn-primary" id="pfBtnPublicar" onclick="pfGuardar('publicado')" disabled>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ __('app.modales_pf.btn_publicar') }}
            </button>
        </div>
    </div>
</div>

<script>
    // Textos JS desde Laravel (necesarios para strings dinámicos en JavaScript)
    const _t = {
        cargando:               @json(__('app.modales_pf.cargando')),
        error_cargar:           @json(__('app.modales_pf.error_cargar_proyectos')),
        actualizado:            @json(__('app.modales_pf.actualizado_prefijo')),
        publicado:              @json(__('app.modales_pf.badge_publicado')),
        borrador:               @json(__('app.modales_pf.badge_borrador')),
        sin_archivos:           @json(__('app.modales_pf.sin_archivos')),
        sin_proyectos:          @json(__('app.modales_pf.sin_proyectos')),
        subir_archivos:         @json(__('app.modales_pf.subir_archivos')),
        editar:                 @json(__('app.modales_pf.editar')),
        eliminar:               @json(__('app.modales_pf.eliminar')),
        cancelar:               @json(__('app.modales_pf.cancelar')),
        guardar_cambios:        @json(__('app.modales_pf.btn_guardar_cambios')),
        guardando:              @json(__('app.modales_pf.guardando')),
        conf_elim_pf_titulo:    @json(__('app.modales_pf.conf_elim_pf_titulo')),
        conf_elim_pf_desc:      @json(__('app.modales_pf.conf_elim_pf_desc')),
        conf_elim_proj_titulo:  @json(__('app.modales_pf.conf_elim_proj_titulo')),
        conf_elim_proj_desc:    @json(__('app.modales_pf.conf_elim_proj_desc')),
        conf_guardar_titulo:    @json(__('app.modales_pf.conf_guardar_titulo')),
        conf_guardar_desc_pf:   @json(__('app.modales_pf.conf_guardar_desc_pf')),
        conf_guardar_desc_proj: @json(__('app.modales_pf.conf_guardar_desc_proj')),
        si_eliminar:            @json(__('app.modales_pf.si_eliminar')),
        si_guardar:             @json(__('app.modales_pf.si_guardar')),
        err_elim_pf:            @json(__('app.modales_pf.err_elim_pf')),
        err_elim_proj:          @json(__('app.modales_pf.err_elim_proj')),
        err_guardar:            @json(__('app.modales_pf.err_guardar')),
        err_servidor:           @json(__('app.modales_pf.err_servidor')),
        err_url_repo:           @json(__('app.modales_pf.err_url_repo')),
        err_url_deploy:         @json(__('app.modales_pf.err_url_deploy')),
        err_nombre_desc:        @json(__('app.modales_pf.err_nombre_desc')),
        solo_png_jpg:           @json(__('app.modales_pf.solo_png_jpg')),
        limite_banner:          @json(__('app.modales_pf.limite_banner')),
        limite_logo:            @json(__('app.modales_pf.limite_logo')),
        limite_archivo:         @json(__('app.modales_pf.limite_archivo')),
        elige_portafolio_opt:   @json(__('app.modales_pf.elige_portafolio')),
    };

    const VP_DATA = @json($portafolios ?? []);
    let mpFiles = [];
    let vpProyectosCache = {}, vpPortafolioIdActual = null;

    /* ══ MODAL 2 · Ver ══ */
    async function verPortafolio(id) {
        const p = VP_DATA.find(x => x.id == id);
        if (!p) return;
        document.getElementById('vpNombre').textContent = p.nombre;
        document.getElementById('vpDesc').textContent   = p.descripcion || '';
        const badge = document.getElementById('vpBadge');
        badge.textContent = p.estado === 'publicado' ? _t.publicado : _t.borrador;
        badge.className   = 'vp-badge ' + p.estado;
        const repoWrap = document.getElementById('vpRepoWrap');
        if (p.repositorio_url) {
            document.getElementById('vpRepo').href        = p.repositorio_url;
            document.getElementById('vpRepo').textContent = p.repositorio_url;
            repoWrap.style.display = 'flex';
        } else {
            repoWrap.style.display = 'none';
        }
        const fecha = new Date(p.updated_at);
        document.getElementById('vpFecha').textContent = _t.actualizado + ' ' + fecha.toLocaleDateString('{{ app()->getLocale() }}-BO', {day:'2-digit',month:'long',year:'numeric'});
        document.getElementById('vpBtnEliminar').dataset.id = id;
        document.getElementById('vpBtnEditar').dataset.id  = id;
        document.getElementById('vpProyectosList').innerHTML = '<div class="vp-empty">' + _t.cargando + '</div>';
        document.getElementById('modalVerPortafolio').classList.add('open');
        try {
            const res  = await fetch('/portafolio-proyecto/portafolio/' + id);
            const json = await res.json();
            if (json.ok) vpRenderProyectos(json.proyectos, id);
            else document.getElementById('vpProyectosList').innerHTML = '<div class="vp-empty">' + _t.error_cargar + '</div>';
        } catch(e) {
            document.getElementById('vpProyectosList').innerHTML = '<div class="vp-empty">' + _t.error_cargar + '</div>';
        }
    }
    function vpCerrar() {
        document.getElementById('modalVerPortafolio').classList.remove('open');
    }

    /* ══ MODAL 3 · Confirmación ══ */
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
        _confCallback   = onConfirm;
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
            title: _t.conf_elim_pf_titulo,
            desc:  _t.conf_elim_pf_desc,
            btnText: _t.si_eliminar,
            onConfirm: () => vpEliminar(id),
        });
    }
    async function vpEliminar(id) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        try {
            const res  = await fetch('/mis-portafolios/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token } });
            const text = await res.text();
            let json; try { json = JSON.parse(text); } catch(_) { throw new Error(_t.err_servidor + ' (' + res.status + ')'); }
            if (json.ok) { vpCerrar(); location.reload(); return; }
            alert(_t.err_elim_pf);
        } catch(err) { alert(err.message); }
    }

    /* ══ MODAL 4 · Editar ══ */
    let epBannerFile = null, epLogoFile = null;

    function vpAbrirEditar() {
        const id = document.getElementById('vpBtnEditar').dataset.id;
        const p  = VP_DATA.find(x => x.id == id);
        if (!p) return;
        const verModal = document.getElementById('modalVerPortafolio');
        verModal.style.transition = 'none';
        verModal.classList.remove('open');
        setTimeout(() => { verModal.style.transition = ''; }, 50);
        document.getElementById('epId').value     = p.id;
        document.getElementById('epNombre').value = p.nombre;
        document.getElementById('epDesc').value   = p.descripcion || '';
        document.getElementById('epDescCount').textContent = (p.descripcion || '').length;
        epBannerFile = null;
        epLogoFile   = null;
        if (p.banner_ruta) {
            document.getElementById('epBannerPreview').src = '/storage/' + p.banner_ruta;
            document.getElementById('epBannerPreview').style.display = 'block';
            document.getElementById('epBannerPlaceholder').style.display = 'none';
            document.getElementById('epBannerZone').classList.add('has-img');
        } else { epQuitarImg('banner'); }
        if (p.logo_ruta) {
            document.getElementById('epLogoPreview').src = '/storage/' + p.logo_ruta;
            document.getElementById('epLogoPreview').style.display = 'block';
            document.getElementById('epLogoPlaceholder').style.display = 'none';
            document.getElementById('epLogoZone').classList.add('has-img');
        } else { epQuitarImg('logo'); }
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
    function epHandleImg(tipo, file) {
        if (!file) return;
        if (!file.type.match(/image\/(png|jpe?g)/)) { alert(_t.solo_png_jpg); return; }
        const maxBytes = tipo === 'banner' ? 5 * 1024 * 1024 : 2 * 1024 * 1024;
        if (file.size > maxBytes) { alert(tipo === 'banner' ? _t.limite_banner : _t.limite_logo); return; }
        if (tipo === 'banner') epBannerFile = file; else epLogoFile = file;
        const preview     = document.getElementById(tipo === 'banner' ? 'epBannerPreview' : 'epLogoPreview');
        const placeholder = document.getElementById(tipo === 'banner' ? 'epBannerPlaceholder' : 'epLogoPlaceholder');
        const zone        = document.getElementById(tipo === 'banner' ? 'epBannerZone' : 'epLogoZone');
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            zone.classList.add('has-img');
        };
        reader.readAsDataURL(file);
    }
    function epQuitarImg(tipo) {
        const preview     = document.getElementById(tipo === 'banner' ? 'epBannerPreview' : 'epLogoPreview');
        const placeholder = document.getElementById(tipo === 'banner' ? 'epBannerPlaceholder' : 'epLogoPlaceholder');
        const zone        = document.getElementById(tipo === 'banner' ? 'epBannerZone' : 'epLogoZone');
        const input       = document.getElementById(tipo === 'banner' ? 'epBannerInput' : 'epLogoInput');
        preview.src = ''; preview.style.display = 'none';
        placeholder.style.display = '';
        zone.classList.remove('has-img');
        if (input) input.value = '';
        if (tipo === 'banner') epBannerFile = null; else epLogoFile = null;
    }
    function epDragLeave(tipo, event) {
        const zone = document.getElementById(tipo === 'banner' ? 'epBannerZone' : 'epLogoZone');
        if (!zone.querySelector('img')?.src) zone.classList.remove('has-img');
    }
    function epConfirmarGuardar(estado) {
        const nombre = document.getElementById('epNombre').value.trim();
        const desc   = document.getElementById('epDesc').value.trim();
        let valid = true;
        if (!nombre) { document.getElementById('epErrNombre').style.display='block'; document.getElementById('epNombre').classList.add('mp-invalid'); valid=false; }
        else          { document.getElementById('epErrNombre').style.display='none';  document.getElementById('epNombre').classList.remove('mp-invalid'); }
        if (!desc)    { document.getElementById('epErrDesc').style.display='block';   document.getElementById('epDesc').classList.add('mp-invalid');   valid=false; }
        else          { document.getElementById('epErrDesc').style.display='none';    document.getElementById('epDesc').classList.remove('mp-invalid'); }
        if (!valid) return;
        vpConfirm({
            ico: '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>',
            danger: false, title: _t.conf_guardar_titulo,
            desc: _t.conf_guardar_desc_pf,
            btnText: _t.si_guardar, onConfirm: () => epGuardar(estado),
        });
    }
    async function epGuardar(estado) {
        const id    = document.getElementById('epId').value;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const form  = new FormData();
        form.append('nombre',      document.getElementById('epNombre').value.trim());
        form.append('descripcion', document.getElementById('epDesc').value.trim());
        form.append('estado',      estado);
        form.append('_token',      token);
        if (epBannerFile) form.append('banner', epBannerFile);
        if (epLogoFile)   form.append('logo',   epLogoFile);
        const btnB = document.getElementById('epBtnBorrador');
        const btnP = document.getElementById('epBtnPublicar');
        btnB.disabled = btnP.disabled = true;
        btnP.innerHTML = _t.guardando;
        try {
            const res  = await fetch('/mis-portafolios/' + id, { method: 'POST', body: form });
            const text = await res.text();
            let json; try { json = JSON.parse(text); } catch(_) { throw new Error(_t.err_servidor + ' (' + res.status + ')'); }
            if (json.ok) { epCerrar(); location.reload(); return; }
            const msg = json.errors ? Object.values(json.errors).flat().join('\n') : _t.err_guardar;
            alert(msg);
        } catch(err) { alert(err.message); }
        btnB.disabled = btnP.disabled = false;
        btnP.innerHTML = '<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> ' + _t.guardar_cambios;
    }

    /* ══ MODAL 1 · Añadir Proyecto ══ */
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
    function mpValidarUrl(inputId, tickId, errId) {
        const val = document.getElementById(inputId).value.trim();
        const inp = document.getElementById(inputId);
        const tick = document.getElementById(tickId);
        const err  = document.getElementById(errId);
        if (!val) { tick.style.display='none'; err.style.display='none'; inp.classList.remove('mp-invalid','mp-ok'); return true; }
        const ok = /^https?:\/\/.+\..+/.test(val);
        inp.classList.toggle('mp-invalid', !ok);
        inp.classList.toggle('mp-ok', ok);
        tick.style.display = ok ? 'block' : 'none';
        tick.innerHTML     = ok ? '<polyline points="20 6 9 17 4 12" stroke="#22c55e"/>' : '';
        err.style.display  = ok ? 'none' : 'block';
        return ok || !val;
    }

    function mpReset() {
        ['mpNombre','mpDesc','mpRepo','mpDeploy'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.value = ''; el.classList.remove('mp-invalid','mp-ok'); }
        });
        ['mpErrNombre','mpErrDesc','mpErrPortafolio','mpErrRepo','mpErrDeploy'].forEach(id => {
            const el = document.getElementById(id); if (el) el.style.display = 'none';
        });
        ['mpRepoTick','mpDeployTick'].forEach(id => {
            const el = document.getElementById(id); if (el) el.style.display = 'none';
        });
        document.getElementById('mpDescCount').textContent = '0';
        const sel = document.getElementById('mpPortafolioId');
        sel.innerHTML = '<option value="">' + _t.elige_portafolio_opt + '</option>';
        VP_DATA.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.nombre + (p.estado === 'publicado' ? '' : ' (' + _t.borrador + ')');
            sel.appendChild(opt);
        });
        mpFiles = [];
        document.getElementById('mpFlist').innerHTML = '';
        const fi = document.getElementById('mpFileInput');
        if (fi) fi.value = '';
        mpCheckBtns();
    }
    function mpCheckBtns() {
        const ok = document.getElementById('mpPortafolioId').value !== '' &&
                   document.getElementById('mpNombre').value.trim() !== '' &&
                   document.getElementById('mpDesc').value.trim()   !== '';
        document.getElementById('mpBtnBorrador').disabled = !ok;
        document.getElementById('mpBtnPublicar').disabled = !ok;
    }

    /* ══ MODAL 5 · Crear Portafolio ══ */
    let pfBannerFile = null, pfLogoFile = null;

    function abrirModalCrearPf() {
        pfReset();
        document.getElementById('modalCrearPf').classList.add('open');
    }
    function pfCerrar() {
        document.getElementById('modalCrearPf').classList.remove('open');
    }
    function pfReset() {
        ['pfNombre','pfDesc'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.value = ''; el.classList.remove('mp-invalid','mp-ok'); }
        });
        ['pfErrNombre','pfErrDesc'].forEach(id => {
            const el = document.getElementById(id); if (el) el.style.display = 'none';
        });
        document.getElementById('pfDescCount').textContent = '0';
        pfQuitarImg('banner');
        pfQuitarImg('logo');
        pfBannerFile = null;
        pfLogoFile   = null;
        pfCheckBtns();
    }
    function pfCheckBtns() {
        const ok = document.getElementById('pfNombre').value.trim() !== '' &&
                   document.getElementById('pfDesc').value.trim()   !== '';
        document.getElementById('pfBtnBorrador').disabled = !ok;
        document.getElementById('pfBtnPublicar').disabled = !ok;
    }
    function pfHandleImg(tipo, file) {
        if (!file) return;
        if (!file.type.match(/image\/(png|jpe?g)/)) { alert(_t.solo_png_jpg); return; }
        const maxBytes = tipo === 'banner' ? 5 * 1024 * 1024 : 2 * 1024 * 1024;
        if (file.size > maxBytes) { alert(tipo === 'banner' ? _t.limite_banner : _t.limite_logo); return; }
        if (tipo === 'banner') pfBannerFile = file;
        else                   pfLogoFile   = file;
        const reader   = new FileReader();
        const preview  = document.getElementById(tipo === 'banner' ? 'pfBannerPreview' : 'pfLogoPreview');
        const placeholder = document.getElementById(tipo === 'banner' ? 'pfBannerPlaceholder' : 'pfLogoPlaceholder');
        const zone     = document.getElementById(tipo === 'banner' ? 'pfBannerZone' : 'pfLogoZone');
        reader.onload = e => {
            preview.src          = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            zone.classList.add('has-img');
        };
        reader.readAsDataURL(file);
    }
    function pfQuitarImg(tipo) {
        const preview     = document.getElementById(tipo === 'banner' ? 'pfBannerPreview' : 'pfLogoPreview');
        const placeholder = document.getElementById(tipo === 'banner' ? 'pfBannerPlaceholder' : 'pfLogoPlaceholder');
        const zone        = document.getElementById(tipo === 'banner' ? 'pfBannerZone' : 'pfLogoZone');
        const input       = document.getElementById(tipo === 'banner' ? 'pfBannerInput' : 'pfLogoInput');
        preview.src = '';
        preview.style.display     = 'none';
        placeholder.style.display = '';
        zone.classList.remove('has-img');
        input.value = '';
        if (tipo === 'banner') pfBannerFile = null;
        else                   pfLogoFile   = null;
    }
    function pfDragLeave(tipo, event) {
        const zone = document.getElementById(tipo === 'banner' ? 'pfBannerZone' : 'pfLogoZone');
        if (!zone.querySelector('img[src]')?.src) zone.classList.remove('has-img');
    }
    async function pfGuardar(estado) {
        const nombre = document.getElementById('pfNombre').value.trim();
        const desc   = document.getElementById('pfDesc').value.trim();
        let valid = true;
        if (!nombre) {
            document.getElementById('pfErrNombre').style.display = 'block';
            document.getElementById('pfNombre').classList.add('mp-invalid');
            valid = false;
        } else {
            document.getElementById('pfErrNombre').style.display = 'none';
            document.getElementById('pfNombre').classList.remove('mp-invalid');
        }
        if (!desc) {
            document.getElementById('pfErrDesc').style.display = 'block';
            document.getElementById('pfDesc').classList.add('mp-invalid');
            valid = false;
        } else {
            document.getElementById('pfErrDesc').style.display = 'none';
            document.getElementById('pfDesc').classList.remove('mp-invalid');
        }
        if (!valid) return;
        const form = new FormData();
        form.append('nombre',      nombre);
        form.append('descripcion', desc);
        form.append('estado',      estado);
        form.append('_token',      document.querySelector('meta[name="csrf-token"]').content);
        if (pfBannerFile) form.append('banner', pfBannerFile);
        if (pfLogoFile)   form.append('logo',   pfLogoFile);
        const btnB = document.getElementById('pfBtnBorrador');
        const btnP = document.getElementById('pfBtnPublicar');
        btnB.disabled = btnP.disabled = true;
        btnP.innerHTML = _t.guardando;
        try {
            const res  = await fetch('/portafolios', { method: 'POST', body: form });
            const text = await res.text();
            let json;
            try { json = JSON.parse(text); } catch(_) { throw new Error(_t.err_servidor + ' (' + res.status + ')'); }
            if (json.ok) { pfCerrar(); location.reload(); return; }
            const msg = json.errors ? Object.values(json.errors).flat().join('\n') : _t.err_guardar;
            alert(msg);
        } catch(err) { alert(err.message); }
        btnB.disabled = btnP.disabled = false;
        btnP.innerHTML = '<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> ' + _t.btn_publicar;
    }

    async function mpGuardar(estado) {
        const portafolioId = document.getElementById('mpPortafolioId').value;
        const nombre       = document.getElementById('mpNombre').value.trim();
        const desc         = document.getElementById('mpDesc').value.trim();
        let valid = true;
        if (!portafolioId) {
            document.getElementById('mpErrPortafolio').style.display = 'block';
            document.getElementById('mpPortafolioId').classList.add('mp-invalid');
            valid = false;
        } else {
            document.getElementById('mpErrPortafolio').style.display = 'none';
            document.getElementById('mpPortafolioId').classList.remove('mp-invalid');
        }
        if (!nombre) { document.getElementById('mpErrNombre').style.display='block'; document.getElementById('mpNombre').classList.add('mp-invalid'); valid=false; }
        else          { document.getElementById('mpErrNombre').style.display='none';  document.getElementById('mpNombre').classList.remove('mp-invalid'); }
        if (!desc)    { document.getElementById('mpErrDesc').style.display='block';   document.getElementById('mpDesc').classList.add('mp-invalid');   valid=false; }
        else          { document.getElementById('mpErrDesc').style.display='none';    document.getElementById('mpDesc').classList.remove('mp-invalid'); }
        if (!mpValidarUrl('mpRepo',   'mpRepoTick',   'mpErrRepo'))   valid = false;
        if (!mpValidarUrl('mpDeploy', 'mpDeployTick', 'mpErrDeploy')) valid = false;
        if (!valid) return;
        const form = new FormData();
        form.append('portafolio_id',   portafolioId);
        form.append('nombre',          nombre);
        form.append('descripcion',     desc);
        form.append('estado',          estado);
        form.append('repositorio_url', document.getElementById('mpRepo').value.trim());
        form.append('deploy_url',      document.getElementById('mpDeploy').value.trim());
        form.append('_token',          document.querySelector('meta[name="csrf-token"]').content);
        const btnB = document.getElementById('mpBtnBorrador');
        const btnP = document.getElementById('mpBtnPublicar');
        btnB.disabled = btnP.disabled = true;
        btnP.innerHTML = _t.guardando;
        try {
            const res  = await fetch('/portafolio-proyecto', { method: 'POST', body: form });
            const text = await res.text();
            let json;
            try { json = JSON.parse(text); } catch(_) { throw new Error(_t.err_servidor + ' (' + res.status + ')'); }
            if (json.ok) {
                if (mpFiles.length > 0) {
                    const token2 = document.querySelector('meta[name="csrf-token"]').content;
                    const ff = new FormData();
                    ff.append('proyecto_id', json.proyecto.id);
                    ff.append('_token', token2);
                    mpFiles.forEach(f => ff.append('archivos[]', f));
                    await fetch('/portafolio-archivos', { method: 'POST', body: ff });
                }
                mpCerrar();
                location.reload();
                return;
            }
            const msg = json.errors ? Object.values(json.errors).flat().join('\n') : _t.err_guardar;
            alert(msg);
        } catch(err) { alert(err.message); }
        btnB.disabled = btnP.disabled = false;
        btnP.innerHTML = '<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> ' + _t.btn_anadir_proyecto;
    }

    /* ══ Archivos en Modal 1 ══ */
    function mpHandleFiles(files) {
        for (const f of files) {
            if (f.size > 20 * 1024 * 1024) { alert('"' + f.name + '" ' + _t.limite_archivo); continue; }
            mpFiles.push(f);
        }
        mpRenderFlist();
    }
    function mpRenderFlist() {
        const list = document.getElementById('mpFlist');
        if (!list) return;
        list.innerHTML = mpFiles.map((f, i) =>
            '<div class="mp-fitem">' +
            '<span class="mp-fitem-name">' + escHtml(f.name) + '</span>' +
            '<span class="mp-fitem-size">' + fmtSize(f.size) + '</span>' +
            '<button class="mp-frem" onclick="mpRemoveFile(' + i + ')">' +
            '<svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
            '</button></div>'
        ).join('');
    }
    function mpRemoveFile(i) { mpFiles.splice(i, 1); mpRenderFlist(); }

    /* ══ Render proyectos en Modal 2 ══ */
    function vpRenderProyectos(proyectos, portafolioId) {
        vpPortafolioIdActual = portafolioId;
        vpProyectosCache = {};
        if (proyectos) proyectos.forEach(p => { vpProyectosCache[p.id] = p; });
        const container = document.getElementById('vpProyectosList');
        if (!proyectos || !proyectos.length) {
            container.innerHTML = '<div class="vp-empty">' + _t.sin_proyectos + '</div>';
            return;
        }
        container.innerHTML = proyectos.map(proj => vpRenderProjCard(proj)).join('');
    }

    function vpRenderProjCard(proj) {
        const portafolioId = vpPortafolioIdActual;
        const archivosHtml = proj.archivos && proj.archivos.length
            ? '<div class="vp-proj-files">' + proj.archivos.map(a => {
                const delBtn = '<button class="vp-file-del" onclick="vpEliminarArchivo(' + a.id + ')" title="' + _t.eliminar + '">' +
                    '<svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
                if (esImagen(a.nombre_original)) {
                    return '<div class="vp-img-preview" id="vf-' + a.id + '">' +
                        '<a href="' + a.url + '" target="_blank">' +
                        '<img src="' + a.url + '" alt="' + escHtml(a.nombre_original) + '" class="vp-img-thumb">' +
                        '</a>' +
                        '<div class="vp-img-meta">' +
                        '<span class="vp-file-name">' + escHtml(a.nombre_original) + '</span>' +
                        '</div>' +
                        '<span class="vp-file-size">' + fmtSize(a.tamanio) + '</span>' +
                        delBtn + '</div>';
                }
                return '<div class="vp-file" id="vf-' + a.id + '">' +
                    '<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>' +
                    '<span class="vp-file-name">' + escHtml(a.nombre_original) + '</span>' +
                    '<span class="vp-file-size">' + fmtSize(a.tamanio) + '</span>' +
                    delBtn + '</div>';
            }).join('') + '</div>'
            : '<div class="vp-proj-no-files">' + _t.sin_archivos + '</div>';
        const vinculosHtml = (proj.repositorio_url || proj.deploy_url)
            ? '<div class="vp-proj-links">' +
              (proj.repositorio_url ? '<a href="' + proj.repositorio_url + '" target="_blank" rel="noopener" class="vp-proj-link vp-proj-link-gh">' +
              '<svg viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/></svg>' +
              'GitHub</a>' : '') +
              (proj.deploy_url ? '<a href="' + proj.deploy_url + '" target="_blank" rel="noopener" class="vp-proj-link vp-proj-link-deploy">' +
              '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="fill:none"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>' +
              'Deploy</a>' : '') +
              '</div>'
            : '';
        return '<div class="vp-proj-card" id="proj-card-' + proj.id + '">' +
            '<div class="vp-proj-head">' +
            '<div><div class="vp-proj-name">' + escHtml(proj.nombre) + '</div>' +
            '<div class="vp-proj-desc">' + escHtml(proj.descripcion || '') + '</div></div>' +
            '<span class="vp-badge ' + proj.estado + '">' + (proj.estado === 'publicado' ? _t.publicado : _t.borrador) + '</span>' +
            '</div>' + vinculosHtml + archivosHtml +
            '<label class="vp-proj-add-file">' +
            '<input type="file" multiple accept="image/*,.zip,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" style="display:none" ' +
            'onchange="vpAgregarArchivos(' + proj.id + ',' + portafolioId + ',this)">' +
            '<span>+ ' + _t.subir_archivos + '</span>' +
            '</label>' +
            '<div class="vp-proj-actions">' +
            '<button class="vp-proj-btn-edit" onclick="vpEditarProyecto(' + proj.id + ')">' + _t.editar + '</button>' +
            '<button class="vp-proj-btn-del2" onclick="vpConfirmarEliminarProyecto(' + proj.id + ')">' + _t.eliminar + '</button>' +
            '</div></div>';
    }

    function vpEditarProyecto(id) {
        const proj = vpProyectosCache[id];
        if (!proj) return;
        const card = document.getElementById('proj-card-' + id);
        if (!card) return;
        card.innerHTML =
            '<div class="vp-proj-edit-form">' +
            '<input class="vp-proj-edit-input" id="vpe-nombre-' + id + '" type="text" maxlength="100" ' +
            'placeholder="' + _t.nombre_proyecto + '" value="' + escHtml(proj.nombre) + '">' +
            '<textarea class="vp-proj-edit-input vp-proj-edit-textarea" id="vpe-desc-' + id + '" maxlength="500" ' +
            'placeholder="' + _t.descripcion + '">' + escHtml(proj.descripcion || '') + '</textarea>' +
            '<div class="vp-proj-edit-url-wrap">' +
            '<input class="vp-proj-edit-input" id="vpe-repo-' + id + '" type="text" maxlength="500" ' +
            'placeholder="GitHub URL (' + _t.opcional + ')" value="' + escHtml(proj.repositorio_url || '') + '">' +
            '<input class="vp-proj-edit-input" id="vpe-deploy-' + id + '" type="text" maxlength="500" ' +
            'placeholder="Deploy URL (' + _t.opcional + ')" value="' + escHtml(proj.deploy_url || '') + '">' +
            '</div>' +
            '<select class="vp-proj-edit-input" id="vpe-estado-' + id + '">' +
            '<option value="borrador"' + (proj.estado === 'borrador' ? ' selected' : '') + '>' + _t.borrador + '</option>' +
            '<option value="publicado"' + (proj.estado === 'publicado' ? ' selected' : '') + '>' + _t.publicado + '</option>' +
            '</select>' +
            '<div class="vp-proj-edit-btns">' +
            '<button class="vp-proj-btn-del2" style="flex:1" onclick="vpCancelarEditarProyecto(' + id + ')">' + _t.cancelar + '</button>' +
            '<button class="vp-proj-btn-edit" style="flex:2" onclick="vpConfirmarGuardarProyecto(' + id + ')">' + _t.guardar_cambios + '</button>' +
            '</div></div>';
    }

    function vpCancelarEditarProyecto(id) {
        const proj = vpProyectosCache[id];
        if (!proj) return;
        const card = document.getElementById('proj-card-' + id);
        if (!card) return;
        card.outerHTML = vpRenderProjCard(proj);
    }

    function vpConfirmarGuardarProyecto(id) {
        const nombre = (document.getElementById('vpe-nombre-' + id) || {}).value?.trim();
        const desc   = (document.getElementById('vpe-desc-'   + id) || {}).value?.trim();
        if (!nombre || !desc) { alert(_t.err_nombre_desc); return; }
        const repo   = (document.getElementById('vpe-repo-'   + id) || {}).value?.trim();
        const deploy = (document.getElementById('vpe-deploy-' + id) || {}).value?.trim();
        if (repo   && !/^https?:\/\/.+\..+/.test(repo))   { alert(_t.err_url_repo); return; }
        if (deploy && !/^https?:\/\/.+\..+/.test(deploy)) { alert(_t.err_url_deploy); return; }
        const estado = document.getElementById('vpe-estado-' + id).value;
        vpConfirm({
            ico: '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>',
            danger: false, title: _t.conf_guardar_titulo,
            desc: _t.conf_guardar_desc_proj,
            btnText: _t.si_guardar, onConfirm: () => vpGuardarProyecto(id, estado),
        });
    }

    async function vpGuardarProyecto(id, estado) {
        const nombre = document.getElementById('vpe-nombre-' + id).value.trim();
        const desc   = document.getElementById('vpe-desc-'   + id).value.trim();
        const repo   = document.getElementById('vpe-repo-'   + id).value.trim();
        const deploy = document.getElementById('vpe-deploy-' + id).value.trim();
        const token  = document.querySelector('meta[name="csrf-token"]').content;
        const form   = new FormData();
        form.append('nombre',          nombre);
        form.append('descripcion',     desc);
        form.append('estado',          estado);
        form.append('repositorio_url', repo);
        form.append('deploy_url',      deploy);
        form.append('_token',          token);
        try {
            const res  = await fetch('/portafolio-proyecto/' + id, { method: 'POST', body: form });
            const text = await res.text();
            let json; try { json = JSON.parse(text); } catch(_) { throw new Error(_t.err_servidor + ' (' + res.status + ')'); }
            if (json.ok) {
                const r2 = await fetch('/portafolio-proyecto/portafolio/' + vpPortafolioIdActual);
                const j2 = await r2.json();
                if (j2.ok) vpRenderProyectos(j2.proyectos, vpPortafolioIdActual);
                return;
            }
            const msg = json.errors ? Object.values(json.errors).flat().join('\n') : _t.err_guardar;
            alert(msg);
        } catch(err) { alert(err.message); }
    }

    function vpConfirmarEliminarProyecto(id) {
        const proj = vpProyectosCache[id];
        vpConfirm({
            ico: '<path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>',
            danger: true,
            title: _t.conf_elim_proj_titulo,
            desc: _t.conf_elim_proj_desc.replace(':nombre', proj ? escHtml(proj.nombre) : ''),
            btnText: _t.si_eliminar,
            onConfirm: () => vpEliminarProyecto(id),
        });
    }

    async function vpEliminarProyecto(id) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        try {
            const res  = await fetch('/portafolio-proyecto/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token } });
            const text = await res.text();
            let json; try { json = JSON.parse(text); } catch(_) { throw new Error(_t.err_servidor + ' (' + res.status + ')'); }
            if (json.ok) {
                delete vpProyectosCache[id];
                const card = document.getElementById('proj-card-' + id);
                if (card) card.remove();
                if (!Object.keys(vpProyectosCache).length) {
                    document.getElementById('vpProyectosList').innerHTML = '<div class="vp-empty">' + _t.sin_proyectos + '</div>';
                }
                return;
            }
            alert(_t.err_elim_proj);
        } catch(err) { alert(err.message); }
    }

    async function vpEliminarArchivo(id) {
        if (!confirm(_t.conf_elim_archivo)) return;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        try {
            const res  = await fetch('/portafolio-archivos/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': token } });
            const json = await res.json();
            if (json.ok) { const el = document.getElementById('vf-' + id); if (el) el.remove(); }
            else alert(_t.err_elim_archivo);
        } catch(e) { alert(_t.err_elim_archivo); }
    }

    async function vpAgregarArchivos(proyectoId, portafolioId, input) {
        if (!input.files.length) return;
        const MAX = 20 * 1024 * 1024;
        for (const f of input.files) {
            if (f.size > MAX) {
                alert('"' + f.name + '" ' + _t.limite_archivo);
                input.value = '';
                return;
            }
        }
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const form  = new FormData();
        form.append('proyecto_id', proyectoId);
        form.append('_token', token);
        for (const f of input.files) form.append('archivos[]', f);
        try {
            const res  = await fetch('/portafolio-archivos', { method: 'POST', body: form });
            const text = await res.text();
            let json;
            try { json = JSON.parse(text); } catch(_) { throw new Error(_t.err_servidor + ' (' + res.status + ')'); }
            if (json.ok) {
                const r2 = await fetch('/portafolio-proyecto/portafolio/' + portafolioId);
                const j2 = await r2.json();
                if (j2.ok) vpRenderProyectos(j2.proyectos, portafolioId);
            } else {
                const msg = json.errors ? Object.values(json.errors).flat().join('\n') : (json.message || _t.err_guardar);
                alert(msg);
            }
        } catch(e) { alert(e.message); }
        input.value = '';
    }

    function escHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
    function fmtSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }
    function esImagen(nombre) {
        return /\.(png|jpe?g|gif|webp|svg)$/i.test(nombre);
    }
</script>