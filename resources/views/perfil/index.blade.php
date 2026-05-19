<style>
    :root{
        --navy:#1a2340;--navy2:#1e2d50;--blue:#2563eb;--blue2:#3b82f6;
        --teal:#0d9488;--red:#dc2626;--white:#fff;--gray:#f0f2f8;
        --gray2:#e2e8f0;--gray3:#cbd5e1;--text:#1e293b;--muted:#64748b;
    }
        /* Alerts */
        .alert{padding:12px 16px;border-radius:10px;font-size:13.5px;font-weight:500;margin-bottom:1.2rem;display:flex;align-items:center;gap:10px}
        .alert-success{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
        .alert-success svg{stroke:#15803d}
        .alert svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;stroke-linecap:round;stroke-linejoin:round}
        .alert-error{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca}
        .alert-error svg{stroke:#b91c1c}
        .alert-retry{background:#fef3c7;color:#92400e;border:1px solid #fde68a}
        .alert-retry svg{stroke:#d97706}
        .mode-toggle{display:flex;align-items:center;gap:8px;padding:6px 14px;border-radius:8px;border:1.5px solid var(--gray2);background:#fff;font-size:13px;font-weight:500;cursor:pointer;transition:all .2s;font-family:"DM Sans",sans-serif;color:var(--text)}
        .mode-toggle:hover{border-color:var(--blue2);color:var(--blue)}
        .mode-toggle svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .mode-toggle.active{background:var(--navy);color:#fff;border-color:var(--navy)}
        .profile-grid{display:grid;grid-template-columns:220px 1fr;gap:1.2rem}
        .photo-card{background:#fff;border-radius:14px;padding:1.2rem;border:1.5px solid var(--gray2);display:flex;flex-direction:column;align-items:center;gap:14px;align-self:start}
        .photo-wrap{position:relative;width:120px;height:120px}
        .photo-avatar{width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--gray2)}
        .photo-initials{width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:36px;font-weight:700;color:#fff;border:3px solid var(--gray2)}
        .photo-overlay{position:absolute;inset:0;border-radius:50%;background:rgba(0,0,0,0.45);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;cursor:pointer}
        .photo-overlay svg{width:22px;height:22px;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .photo-wrap:hover .photo-overlay{opacity:1}
        .photo-hint{font-size:11px;color:var(--muted);text-align:center;line-height:1.5}
        .photo-error{font-size:11.5px;color:var(--red);text-align:center;font-weight:500;display:none}
        .form-card{background:#fff;border-radius:14px;padding:1.4rem;border:1.5px solid var(--gray2)}
        .card-title{font-family:"Plus Jakarta Sans",sans-serif;font-size:15px;font-weight:700;color:var(--text);margin-bottom:1.1rem;padding-bottom:.7rem;border-bottom:1px solid var(--gray2)}
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
        textarea.field{resize:vertical;min-height:110px;line-height:1.5;word-break:break-word;overflow-wrap:break-word;white-space:pre-wrap}
        .bio-footer{display:flex;justify-content:space-between;align-items:center;margin-top:4px}
        .bio-counter{font-size:11.5px;color:var(--muted);font-weight:500}
        .bio-counter.over{color:var(--red);font-weight:700}
        .form-actions{display:flex;align-items:center;gap:10px;margin-top:1.2rem;padding-top:1rem;border-top:1px solid var(--gray2)}
        .btn-save{background:linear-gradient(135deg,var(--blue),var(--blue2));color:#fff;border:none;border-radius:9px;padding:10px 26px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;transition:opacity .2s;display:inline-flex;align-items:center;gap:8px}
        .btn-save:hover{opacity:.9}
        .btn-save:disabled{opacity:.5;cursor:not-allowed}
        .btn-save .spinner{width:14px;height:14px;border:2px solid rgba(255,255,255,0.4);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;display:none}
        .btn-save.loading .spinner{display:block}
        .btn-save.loading .btn-label{opacity:.5}
        .btn-cancel{background:#fff;color:var(--text);border:1.5px solid var(--gray2);border-radius:9px;padding:10px 22px;font-size:13.5px;font-weight:500;cursor:pointer;font-family:"DM Sans",sans-serif;transition:background .2s}
        .btn-cancel:hover:not(:disabled){background:var(--gray)}
        .btn-cancel:disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
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
        .tray-modal{background:#fff;border-radius:20px;width:100%;max-width:680px;max-height:88vh;display:flex;flex-direction:column;box-shadow:0 24px 60px rgba(0,0,0,0.25);transform:translateY(16px);transition:transform .25s}
        .modal-overlay.show .tray-modal{transform:translateY(0)}
        .tray-modal-head{display:flex;align-items:center;justify-content:space-between;padding:1.4rem 1.6rem 0}
        .tray-modal-head h2{font-family:"Plus Jakarta Sans",sans-serif;font-size:18px;font-weight:800;color:var(--text)}
        .tray-close{background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;border-radius:6px;transition:background .15s;display:flex}
        .tray-close:hover{background:var(--gray)}
        .tray-close svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round}
        .tray-tabs{display:flex;gap:0;border-bottom:2px solid var(--gray2);padding:0 1.6rem;margin-top:1rem}
        .tray-tab{background:none;border:none;padding:10px 18px;font-size:13.5px;font-weight:600;color:var(--muted);cursor:pointer;font-family:"DM Sans",sans-serif;border-bottom:2px solid transparent;margin-bottom:-2px;transition:color .15s,border-color .15s}
        .tray-tab.active{color:var(--blue);border-bottom-color:var(--blue)}
        .tray-body{flex:1;overflow-y:auto;padding:1.2rem 1.6rem}
        .tray-pane{display:none}
        .tray-pane.active{display:block}
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
        .stars{display:flex;gap:4px;cursor:pointer}
        .star{font-size:22px;color:var(--gray3);transition:color .1s;line-height:1;user-select:none}
        .star.on{color:#f59e0b}
        .ac-wrap{position:relative}
        .ac-drop{position:absolute;top:100%;left:0;right:0;background:#fff;border:1.5px solid var(--blue2);border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.1);z-index:200;max-height:180px;overflow-y:auto;display:none}
        .ac-item{padding:9px 12px;font-size:13px;cursor:pointer;color:var(--text)}
        .ac-item:hover{background:var(--gray)}
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
        .tray-check{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--text)}
        .tray-check input{width:15px;height:15px;accent-color:var(--blue);cursor:pointer}
        .tray-alert{display:none;background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:9px 12px;font-size:12.5px;color:#92400e;margin-bottom:.75rem;align-items:center;gap:8px}
        .tray-alert.show{display:flex}
        .tray-alert button{margin-left:auto;background:none;border:none;font-weight:700;color:#92400e;cursor:pointer;font-family:inherit;font-size:12.5px}
        .del-overlay{position:fixed;inset:0;background:rgba(15,23,42,0.5);z-index:300;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(2px);opacity:0;pointer-events:none;transition:opacity .2s}
        .del-overlay.show{opacity:1;pointer-events:all}
        .btn-edit-item{background:none;border:none;cursor:pointer;color:var(--muted);padding:4px;transition:color .15s;display:flex;flex-shrink:0}
        .btn-edit-item:hover{color:var(--blue)}
        .btn-edit-item svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .item-card-actions{display:flex;gap:2px;flex-shrink:0;align-items:flex-start}
        .btn-cancel-edit{display:none;background:none;border:1.5px solid var(--gray2);border-radius:8px;padding:7px 13px;font-size:12.5px;font-weight:500;cursor:pointer;font-family:"DM Sans",sans-serif;color:var(--muted);transition:all .15s;align-items:center;gap:5px}
        .btn-cancel-edit:hover{border-color:var(--red);color:var(--red)}
        .btn-cancel-edit.show{display:inline-flex}
        .tray-form.editing{background:#eff6ff;border:1.5px solid #bfdbfe}
        .tray-form-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
        .tipo-toggle{display:flex;gap:6px;margin-top:2px}
        .tipo-btn{flex:1;padding:7px 10px;border-radius:8px;border:1.5px solid var(--gray2);background:#fff;font-size:12px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;color:var(--muted);transition:all .15s;text-align:center}
        .tipo-btn.active-fuerte{border-color:#2563eb;background:#dbeafe;color:#1d4ed8}
        .tipo-btn.active-blanda{border-color:#0d9488;background:#ccfbf1;color:#0f766e}
        .badge-fuerte{background:#dbeafe;color:#1d4ed8}
        .badge-blanda{background:#ccfbf1;color:#0f766e}
        .hab-section-label{font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);padding:6px 0 4px;border-bottom:1px solid var(--gray2);margin-bottom:6px}
        .extra-actions{display:flex;gap:10px;margin-top:1rem}
        .btn-tray{background:#fff;color:var(--navy);border:1.5px solid var(--gray2);border-radius:9px;padding:10px 18px;font-size:13px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:7px;transition:all .2s}
        .btn-tray:hover{border-color:var(--blue2);color:var(--blue)}
        .btn-tray svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .btn-deactivate{background:#fff;color:var(--red);border:1.5px solid #fecaca;border-radius:9px;padding:10px 18px;font-size:13px;font-weight:600;cursor:pointer;font-family:"DM Sans",sans-serif;display:inline-flex;align-items:center;gap:7px;transition:all .2s}
        .btn-deactivate:hover{background:#fee2e2}
        .btn-deactivate svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .preview-card{background:linear-gradient(140deg,#1e2d50,#1a2340);border-radius:14px;padding:1.4rem;color:#fff;display:none}
        .preview-card.show{display:block}
        .preview-av{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#0d9488);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:#fff;margin-bottom:12px;overflow:hidden}
        .preview-av img{width:100%;height:100%;object-fit:cover}
        .preview-name{font-family:"Plus Jakarta Sans",sans-serif;font-size:18px;font-weight:800}
        .preview-prof{font-size:13px;color:#93c5fd;margin-top:3px;font-weight:500}
        .preview-bio{font-size:13px;color:#cbd5e1;margin-top:10px;line-height:1.6;white-space:pre-wrap;word-break:break-word;overflow-wrap:break-word}
        .preview-lbl{font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#5a7fa0;margin-bottom:10px}
        footer{height:44px;background:var(--navy);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .footer-content{display:flex;align-items:center;gap:10px}
        .footer-logo{height:22px;width:auto;object-fit:contain}
        footer p{font-size:12px;color:#5a7fa0;display:flex;align-items:center;gap:6px;margin:0}
        footer b{color:#7a9cc0}
        @media(max-width:992px){
            .profile-grid{grid-template-columns:1fr}
            .form-row{grid-template-columns:1fr}
        }
        @keyframes spin{to{transform:rotate(360deg)}}
        ::-webkit-scrollbar{width:4px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}
</style>

@php
    $supabaseBase = rtrim(config('services.supabase.url'), '/')
                  . '/storage/v1/object/public/'
                  . config('services.supabase.bucket');

    $fotoActual = null;
    if (auth()->user()->foto_perfil) {
        if (str_starts_with(auth()->user()->foto_perfil, 'http')) {
            $fotoActual = auth()->user()->foto_perfil;
        } else {
            $fotoActual = $supabaseBase . '/' . ltrim(auth()->user()->foto_perfil, '/');
        }
    }

    // ── Todas las cadenas traducidas disponibles para el JS ──
    $t = [
        'sin_profesion'           => __('app.perfil.sin_profesion'),
        'sin_biografia'           => __('app.perfil.sin_biografia'),
        'preview_label'           => __('app.perfil.preview_label'),
        'ocultar_preview'         => __('app.perfil.ocultar_preview'),
        'vista_previa'            => __('app.perfil.vista_previa'),
        'foto_formato_error'      => __('app.perfil.foto_formato_error'),
        'foto_size_error'         => __('app.perfil.foto_size_error'),
        'nombre_error'            => __('app.perfil.nombre_error'),
        'apellido_error'          => __('app.perfil.apellido_error'),
        'profesion_error'         => __('app.perfil.profesion_error'),
        'biografia_error_vacia'   => __('app.perfil.biografia_error_vacia'),
        'biografia_error_limite'  => __('app.perfil.biografia_error_limite'),
        'chars_prohibidos'        => __('app.perfil.chars_prohibidos'),
        'error_conexion'          => __('app.perfil.error_conexion'),
        'reintentar'              => __('app.perfil.reintentar'),
        'success_actualizado'     => __('app.perfil.success_actualizado'),
        'fallo_momentaneo'        => __('app.perfil.fallo_momentaneo'),
        // Habilidades
        'agregar_habilidad'       => __('app.perfil.agregar_habilidad'),
        'editar_habilidad'        => __('app.perfil.editar_habilidad'),
        'hab_nombre_error'        => __('app.perfil.hab_nombre_error'),
        'hab_dup_error'           => __('app.perfil.hab_dup_error'),
        'hab_nivel_error'         => __('app.perfil.hab_nivel_error'),
        'hab_tipo_error'          => __('app.perfil.hab_tipo_error'),
        'hab_nivel_hint'          => __('app.perfil.hab_nivel_hint'),
        'hab_tipo_fuerte'         => __('app.perfil.hab_tipo_fuerte'),
        'hab_tipo_blanda'         => __('app.perfil.hab_tipo_blanda'),
        'hab_nivel_principiante'  => __('app.perfil.hab_nivel_principiante'),
        'hab_nivel_intermedio'    => __('app.perfil.hab_nivel_intermedio'),
        'hab_nivel_avanzado'      => __('app.perfil.hab_nivel_avanzado'),
        'hab_seccion_fuertes'     => __('app.perfil.hab_seccion_fuertes'),
        'hab_seccion_blandas'     => __('app.perfil.hab_seccion_blandas'),
        'hab_empty'               => __('app.perfil.hab_empty'),
        'confirm_agregar_hab'     => __('app.perfil.confirm_agregar_hab'),
        'confirm_editar_hab'      => __('app.perfil.confirm_editar_hab'),
        'cancelar_edicion'        => __('app.perfil.cancelar_edicion'),
        // Experiencia
        'agregar_experiencia'     => __('app.perfil.agregar_experiencia'),
        'editar_experiencia'      => __('app.perfil.editar_experiencia'),
        'exp_empresa_error'       => __('app.perfil.exp_empresa_error'),
        'exp_cargo_error'         => __('app.perfil.exp_cargo_error'),
        'exp_inicio_error'        => __('app.perfil.exp_inicio_error'),
        'exp_fin_error'           => __('app.perfil.exp_fin_error'),
        'exp_presente'            => __('app.perfil.exp_presente'),
        'exp_empty'               => __('app.perfil.exp_empty'),
        'confirm_agregar_exp'     => __('app.perfil.confirm_agregar_exp'),
        'confirm_editar_exp'      => __('app.perfil.confirm_editar_exp'),
        // Formación
        'agregar_formacion'       => __('app.perfil.agregar_formacion'),
        'editar_formacion'        => __('app.perfil.editar_formacion'),
        'for_inst_error'          => __('app.perfil.for_inst_error'),
        'for_nivel_error'         => __('app.perfil.for_nivel_error'),
        'for_inicio_error'        => __('app.perfil.for_inicio_error'),
        'for_fin_error'           => __('app.perfil.for_fin_error'),
        'for_en_curso'            => __('app.perfil.for_en_curso'),
        'for_empty'               => __('app.perfil.for_empty'),
        'confirm_agregar_for'     => __('app.perfil.confirm_agregar_for'),
        'confirm_editar_for'      => __('app.perfil.confirm_editar_for'),
        // Certificaciones
        'agregar_cert'            => __('app.perfil.agregar_cert'),
        'editar_cert'             => __('app.perfil.editar_cert'),
        'cert_nombre_error'       => __('app.perfil.cert_nombre_error'),
        'cert_empty'              => __('app.perfil.cert_empty'),
        'confirm_agregar_cert'    => __('app.perfil.confirm_agregar_cert'),
        'confirm_editar_cert'     => __('app.perfil.confirm_editar_cert'),
        // Eliminar / confirmar
        'eliminar_titulo'         => __('app.perfil.eliminar_titulo'),
        'eliminar_desc'           => __('app.perfil.eliminar_desc'),
        'si_eliminar'             => __('app.perfil.si_eliminar'),
        'confirmar_accion'        => __('app.perfil.confirmar_accion'),
        'confirmar'               => __('app.perfil.confirmar'),
        'agregar'                 => __('app.perfil.agregar'),
        'guardar_cambios'         => __('app.perfil.guardar_cambios'),
        'cargando'                => __('app.perfil.cargando'),
        'editar'                  => __('app.perfil.editar'),
        'eliminar'                => __('app.perfil.eliminar'),
        'cancelar'                => __('app.perfil.cancelar'),
        // Modales perfil
        'modal_guardar_titulo'    => __('app.perfil.modal_guardar_titulo'),
        'modal_guardar_desc'      => __('app.perfil.modal_guardar_desc'),
        'si_guardar'              => __('app.perfil.si_guardar'),
        'modal_desactivar_titulo' => __('app.perfil.modal_desactivar_titulo'),
        'modal_desactivar_desc'   => __('app.perfil.modal_desactivar_desc'),
        'si_desactivar'           => __('app.perfil.si_desactivar'),
    ];
@endphp

<div class="content-bar">
    <div class="content-title">
        <h1>{{ __('app.perfil.titulo') }}</h1>
        <p>{{ __('app.perfil.subtitulo') }}</p>
    </div>
    <button type="button" class="mode-toggle" id="btnPreview" onclick="togglePreview()">
        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        {{ __('app.perfil.vista_previa') }}
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
    {{ __('app.perfil.error_conexion') }}
    <button onclick="retrySubmit()" style="margin-left:auto;background:none;border:none;font-weight:700;color:#92400e;cursor:pointer;font-family:inherit">{{ __('app.perfil.reintentar') }}</button>
</div>

{{-- Vista previa --}}
<div class="preview-card" id="previewCard">
    <div class="preview-lbl">
        <svg viewBox="0 0 24 24" style="width:11px;height:11px;fill:none;stroke:currentColor;stroke-width:2;display:inline;margin-right:4px"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        {{ __('app.perfil.preview_label') }}
    </div>
    <div class="preview-av" id="prevAv">
        @if($fotoActual)
            <img src="{{ $fotoActual }}" alt="foto" style="width:100%;height:100%;object-fit:cover">
        @else
            {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellido ?? '', 0, 1)) }}
        @endif
    </div>
    <div class="preview-name" id="prevName">{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</div>
    <div class="preview-prof" id="prevProf">{{ auth()->user()->profesion ?? __('app.perfil.sin_profesion') }}</div>
    <div class="preview-bio" id="prevBio">{{ auth()->user()->biografia ?? __('app.perfil.sin_biografia') }}</div>
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
                    <div class="photo-initials" id="photoInitials" style="{{ $fotoActual ? 'display:none' : 'display:flex' }}">
                        {{ strtoupper(substr(auth()->user()->nombre ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellido ?? '', 0, 1)) }}
                    </div>
                    @if($fotoActual)
                    <img id="photoPreview" class="photo-avatar"
                        src="{{ $fotoActual }}"
                        data-original="{{ $fotoActual }}"
                        alt=""
                        onerror="this.style.display='none';document.getElementById('photoInitials').style.display='flex'">
                    @endif
                    <div class="photo-overlay">
                        <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    </div>
                </div>
                <input type="file" id="inputFoto" name="foto_perfil" accept=".jpg,.jpeg,.png" style="display:none" onchange="handlePhoto(this)">
                <p class="photo-hint">{{ __('app.perfil.foto_hint') }}<br>{{ __('app.perfil.foto_hint2') }}</p>
                <p class="photo-error" id="photoError"></p>
            </div>
        </div>

        {{-- Información personal + biografía --}}
        <div>
            <div class="form-card" style="margin-bottom:1.2rem">
                <div class="card-title">{{ __('app.perfil.info_personal') }}</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>{{ __('app.perfil.nombre') }} <span class="req">*</span></label>
                        <input type="text" name="nombre" id="fNombre" class="field"
                               value="{{ old('nombre', auth()->user()->nombre) }}"
                               placeholder="{{ __('app.perfil.nombre_placeholder') }}"
                               maxlength="100"
                               oninput="charCheck(this,'errNombre');syncCancelBtn()">
                        <span class="field-err" id="errNombre">{{ __('app.perfil.nombre_error') }}</span>
                    </div>
                    <div class="form-group">
                        <label>{{ __('app.perfil.apellido') }} <span class="req">*</span></label>
                        <input type="text" name="apellido" id="fApellido" class="field"
                               value="{{ old('apellido', auth()->user()->apellido) }}"
                               placeholder="{{ __('app.perfil.apellido_placeholder') }}"
                               maxlength="100"
                               oninput="charCheck(this,'errApellido');syncCancelBtn()">
                        <span class="field-err" id="errApellido">{{ __('app.perfil.apellido_error') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>{{ __('app.perfil.profesion') }} <span class="req">*</span></label>
                    <input type="text" name="profesion" id="fProfesion" class="field"
                           value="{{ old('profesion', auth()->user()->profesion) }}"
                           placeholder="{{ __('app.perfil.profesion_placeholder') }}"
                           maxlength="150"
                           oninput="charCheck(this,'errProfesion');syncCancelBtn()">
                    <span class="field-err" id="errProfesion">{{ __('app.perfil.profesion_error') }}</span>
                </div>
            </div>

            <div class="form-card">
                <div class="card-title">{{ __('app.perfil.biografia_titulo') }}</div>

                <div class="form-group">
                    <label>{{ __('app.perfil.biografia') }}</label>
                    <textarea name="biografia" id="fBiografia" class="field"
                              placeholder="{{ __('app.perfil.biografia_placeholder') }}"
                              maxlength="1100"
                              oninput="updateCounter();charCheck(this,'errBiografia');syncCancelBtn()">{{ old('biografia', auth()->user()->biografia) }}</textarea>
                    <div class="bio-footer">
                        <span class="field-err" id="errBiografia" style="margin-top:0"></span>
                        <span class="bio-counter" id="bioCounter">0 / 1000</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-save" id="btnSave" onclick="abrirModalGuardar()">
                        <div class="spinner"></div>
                        <span class="btn-label">{{ __('app.perfil.guardar') }}</span>
                    </button>
                    <button type="button" class="btn-cancel" id="btnCancel" onclick="cancelarEdicion()" disabled>{{ __('app.perfil.cancelar') }}</button>
                </div>
            </div>

            {{-- Botones extra --}}
            <div class="extra-actions">
                <button type="button" class="btn-tray" onclick="abrirTrayectoria()">
                    <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    {{ __('app.perfil.mi_trayectoria') }}
                </button>
                <button type="button" class="btn-deactivate" onclick="abrirModalDesactivar()">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                    {{ __('app.perfil.desactivar_cuenta') }}
                </button>
            </div>
        </div>
    </div>
</form>

{{-- Modal: Confirmar guardar --}}
<div class="modal-overlay" id="modalGuardar">
<div class="modal">
<div class="modal-ico blue">
    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
</div>
<h3>{{ __('app.perfil.modal_guardar_titulo') }}</h3>
<p>{{ __('app.perfil.modal_guardar_desc') }}</p>
<div class="modal-actions">
    <button class="btn-cancel" onclick="pCerrarModal('modalGuardar')">{{ __('app.perfil.cancelar') }}</button>
    <button class="btn-save" onclick="pCerrarModal('modalGuardar');submitPerfil()">
        <div class="spinner"></div>
        <span class="btn-label">{{ __('app.perfil.si_guardar') }}</span>
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
<h3>{{ __('app.perfil.modal_desactivar_titulo') }}</h3>
<p>{{ __('app.perfil.modal_desactivar_desc') }}</p>
<div class="modal-actions">
    <button class="btn-cancel" onclick="pCerrarModal('modalDesactivar')">{{ __('app.perfil.cancelar') }}</button>
    <button class="btn-danger" onclick="desactivarCuenta()">{{ __('app.perfil.si_desactivar') }}</button>
</div>
</div>
</div>

{{-- Modal: Mi Trayectoria --}}
<div class="modal-overlay" id="modalTrayectoria" style="align-items:flex-start;padding:3vh 1rem">
<div class="tray-modal">
<div class="tray-modal-head">
    <h2>{{ __('app.perfil.trayectoria_titulo') }}</h2>
    <button class="tray-close" onclick="pCerrarModal('modalTrayectoria')">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
</div>

<div class="tray-tabs">
    <button class="tray-tab active" onclick="switchTab('habilidades')">{{ __('app.perfil.tab_habilidades') }}</button>
    <button class="tray-tab" onclick="switchTab('experiencia')">{{ __('app.perfil.tab_experiencia') }}</button>
    <button class="tray-tab" onclick="switchTab('formacion')">{{ __('app.perfil.tab_formacion') }}</button>
    <button class="tray-tab" onclick="switchTab('certificacion')">{{ __('app.perfil.tab_certificacion') }}</button>
    <button class="tray-tab" onclick="switchTab('redes')">{{ __('app.perfil.tab_redes') }}</button>
</div>

<div class="tray-body">

    {{-- Alerta de error de red --}}
    <div class="tray-alert" id="trayAlert">
        <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
        {{ __('app.perfil.fallo_momentaneo') }}
        <button onclick="retryTray()">{{ __('app.perfil.reintentar') }}</button>
    </div>

    {{-- Tab: Habilidades --}}
    <div class="tray-pane active" id="pane-habilidades">
        <div class="tray-form" id="formHab">
            <div class="tray-form-title" id="titleHab">{{ __('app.perfil.agregar_habilidad') }}</div>
            <div class="tray-fg ac-wrap">
                <label>{{ __('app.perfil.hab_nombre') }} <span class="req">*</span></label>
                <input type="text" id="habNombre" placeholder="{{ __('app.perfil.hab_nombre_placeholder') }}" autocomplete="off"
                       oninput="acFilter(this.value);charCheck(this,'errHabNombre')" onblur="setTimeout(()=>closeAc(),200)">
                <div class="ac-drop" id="acDrop"></div>
                <span class="tray-err" id="errHabNombre">{{ __('app.perfil.hab_nombre_error') }}</span>
                <span class="tray-err" id="errHabDup">{{ __('app.perfil.hab_dup_error') }}</span>
            </div>
            <div class="tray-row">
                <div class="tray-fg">
                    <label>{{ __('app.perfil.hab_nivel') }} <span class="req">*</span></label>
                    <div class="stars" id="starsWrap">
                        <span class="star" data-v="1" onclick="setStar(1)">★</span>
                        <span class="star" data-v="2" onclick="setStar(2)">★</span>
                        <span class="star" data-v="3" onclick="setStar(3)">★</span>
                        <span class="star" data-v="4" onclick="setStar(4)">★</span>
                        <span class="star" data-v="5" onclick="setStar(5)">★</span>
                    </div>
                    <span style="font-size:11px;color:var(--muted);margin-top:3px" id="nivelLabel">{{ __('app.perfil.hab_nivel_hint') }}</span>
                    <span class="tray-err" id="errHabNivel">{{ __('app.perfil.hab_nivel_error') }}</span>
                </div>
                <div class="tray-fg">
                    <label>{{ __('app.perfil.hab_tipo') }} <span class="req">*</span></label>
                    <div class="tipo-toggle">
                        <button type="button" class="tipo-btn active-fuerte" id="btnTipoFuerte" onclick="setTipo('fuerte')">{{ __('app.perfil.hab_tipo_fuerte') }}</button>
                        <button type="button" class="tipo-btn" id="btnTipoBlanda" onclick="setTipo('blanda')">{{ __('app.perfil.hab_tipo_blanda') }}</button>
                    </div>
                    <span style="font-size:11px;color:var(--muted);margin-top:4px">{{ __('app.perfil.hab_tipo_hint') }}</span>
                    <span class="tray-err" id="errHabTipo">{{ __('app.perfil.hab_tipo_error') }}</span>
                </div>
            </div>
            <div class="tray-form-actions">
                <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addHabilidad()">
                    <div class="spinner"></div>
                    <span class="btn-label">{{ __('app.perfil.agregar') }}</span>
                </button>
                <button type="button" class="btn-cancel-edit" id="cancelEditHab" onclick="cancelEditHabilidad()">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    {{ __('app.perfil.cancelar_edicion') }}
                </button>
            </div>
        </div>
        <div class="item-list" id="listHabilidades">
            <div class="empty-state">{{ __('app.perfil.cargando') }}</div>
        </div>
    </div>

    {{-- Tab: Experiencia --}}
    <div class="tray-pane" id="pane-experiencia">
        <div class="tray-form" id="formExp">
            <div class="tray-form-title" id="titleExp">{{ __('app.perfil.agregar_experiencia') }}</div>
            <div class="tray-row">
                <div class="tray-fg">
                    <label>{{ __('app.perfil.exp_empresa') }} <span class="req">*</span></label>
                    <input type="text" id="expEmpresa" placeholder="{{ __('app.perfil.exp_empresa_placeholder') }}" maxlength="150" oninput="charCheck(this,'errExpEmpresa')">
                    <span class="tray-err" id="errExpEmpresa">{{ __('app.perfil.exp_empresa_error') }}</span>
                </div>
                <div class="tray-fg">
                    <label>{{ __('app.perfil.exp_cargo') }} <span class="req">*</span></label>
                    <input type="text" id="expCargo" placeholder="{{ __('app.perfil.exp_cargo_placeholder') }}" maxlength="150" oninput="charCheck(this,'errExpCargo')">
                    <span class="tray-err" id="errExpCargo">{{ __('app.perfil.exp_cargo_error') }}</span>
                </div>
            </div>
            <div class="tray-row">
                <div class="tray-fg">
                    <label>{{ __('app.perfil.exp_inicio') }} <span class="req">*</span></label>
                    <input type="date" id="expInicio" onchange="checkFechaCoherencia()">
                    <span class="tray-err" id="errExpInicio">{{ __('app.perfil.exp_inicio_error') }}</span>
                </div>
                <div class="tray-fg" id="fgExpFin">
                    <label>{{ __('app.perfil.exp_fin') }}</label>
                    <input type="date" id="expFin" onchange="checkFechaCoherencia()">
                    <span class="tray-err" id="errExpFin">{{ __('app.perfil.exp_fin_error') }}</span>
                </div>
            </div>
            <div class="tray-fg">
                <label class="tray-check">
                    <input type="checkbox" id="expActual" onchange="toggleActual()">
                    {{ __('app.perfil.exp_actual') }}
                </label>
            </div>
            <div class="tray-fg">
                <label>{{ __('app.perfil.exp_descripcion') }}</label>
                <textarea id="expDesc" placeholder="{{ __('app.perfil.exp_desc_placeholder') }}" maxlength="2000" oninput="charCheck(this,'errExpDesc')"></textarea>
                <span class="tray-err" id="errExpDesc"></span>
            </div>
            <div class="tray-form-actions">
                <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addExperiencia()">
                    <div class="spinner"></div>
                    <span class="btn-label">{{ __('app.perfil.agregar') }}</span>
                </button>
                <button type="button" class="btn-cancel-edit" id="cancelEditExp" onclick="cancelEditExperiencia()">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    {{ __('app.perfil.cancelar_edicion') }}
                </button>
            </div>
        </div>
        <div class="item-list" id="listExperiencias">
            <div class="empty-state">{{ __('app.perfil.cargando') }}</div>
        </div>
    </div>

    {{-- Tab: Formación --}}
    <div class="tray-pane" id="pane-formacion">
        <div class="tray-form" id="formFor">
            <div class="tray-form-title" id="titleFor">{{ __('app.perfil.agregar_formacion') }}</div>
            <div class="tray-fg">
                <label>{{ __('app.perfil.for_institucion') }} <span class="req">*</span></label>
                <input type="text" id="forInstitucion" placeholder="{{ __('app.perfil.for_inst_placeholder') }}" maxlength="200" oninput="charCheck(this,'errForInstitucion')">
                <span class="tray-err" id="errForInstitucion">{{ __('app.perfil.for_inst_error') }}</span>
            </div>
            <div class="tray-fg">
                <label>{{ __('app.perfil.for_nivel') }} <span class="req">*</span></label>
                <select id="forNivel" onchange="updateForTitulo()">
                    <option value="">{{ __('app.perfil.for_nivel_placeholder') }}</option>
                    <option value="Primaria / Secundaria">{{ __('app.perfil.for_nivel_primaria') }}</option>
                    <option value="Técnico / Técnico Superior">{{ __('app.perfil.for_nivel_tecnico') }}</option>
                    <option value="Pregrado">{{ __('app.perfil.for_nivel_pregrado') }}</option>
                    <option value="Postgrado">{{ __('app.perfil.for_nivel_postgrado') }}</option>
                    <option value="Curso / Diplomado">{{ __('app.perfil.for_nivel_curso') }}</option>
                </select>
                <span class="tray-err" id="errForNivel">{{ __('app.perfil.for_nivel_error') }}</span>
            </div>
            <div class="tray-fg" id="fgForTitulo" style="display:none">
                <label>{{ __('app.perfil.for_titulo') }}</label>
                <input type="text" id="forTitulo" placeholder="" maxlength="200" oninput="charCheck(this,'errForTitulo')">
                <span class="hint" id="forTituloHint" style="font-size:11px;color:var(--muted);margin-top:2px"></span>
                <span class="tray-err" id="errForTitulo"></span>
            </div>
            <div class="tray-row">
                <div class="tray-fg">
                    <label>{{ __('app.perfil.for_inicio') }} <span class="req">*</span></label>
                    <input type="date" id="forInicio" onchange="checkFormFecha()">
                    <span class="tray-err" id="errForInicio">{{ __('app.perfil.for_inicio_error') }}</span>
                </div>
                <div class="tray-fg">
                    <label>{{ __('app.perfil.for_fin') }}</label>
                    <input type="date" id="forFin" onchange="checkFormFecha()">
                    <span class="tray-err" id="errForFin">{{ __('app.perfil.for_fin_error') }}</span>
                </div>
            </div>
            <div class="tray-form-actions">
                <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addFormacion()">
                    <div class="spinner"></div>
                    <span class="btn-label">{{ __('app.perfil.agregar') }}</span>
                </button>
                <button type="button" class="btn-cancel-edit" id="cancelEditFor" onclick="cancelEditFormacion()">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    {{ __('app.perfil.cancelar_edicion') }}
                </button>
            </div>
        </div>
        <div class="item-list" id="listFormaciones">
            <div class="empty-state">{{ __('app.perfil.cargando') }}</div>
        </div>
    </div>

    {{-- Tab: Certificaciones --}}
    <div class="tray-pane" id="pane-certificacion">
        <div class="tray-form" id="formCert">
            <div class="tray-form-title" id="titleCert">{{ __('app.perfil.agregar_cert') }}</div>
            <div class="tray-fg">
                <label>{{ __('app.perfil.cert_nombre') }} <span class="req">*</span></label>
                <input type="text" id="certNombre" placeholder="{{ __('app.perfil.cert_nombre_placeholder') }}" maxlength="200" oninput="charCheck(this,'errCertNombre')">
                <span class="tray-err" id="errCertNombre">{{ __('app.perfil.cert_nombre_error') }}</span>
            </div>
            <div class="tray-row">
                <div class="tray-fg">
                    <label>{{ __('app.perfil.cert_org') }}</label>
                    <input type="text" id="certOrg" placeholder="{{ __('app.perfil.cert_org_placeholder') }}" maxlength="200" oninput="charCheck(this,'errCertOrg')">
                    <span class="tray-err" id="errCertOrg"></span>
                </div>
                <div class="tray-fg">
                    <label>{{ __('app.perfil.cert_fecha') }}</label>
                    <input type="date" id="certFecha">
                </div>
            </div>
            <div class="tray-fg">
                <label>{{ __('app.perfil.cert_descripcion') }}</label>
                <textarea id="certDesc" placeholder="{{ __('app.perfil.cert_desc_placeholder') }}" maxlength="1000" oninput="charCheck(this,'errCertDesc')"></textarea>
                <span class="tray-err" id="errCertDesc"></span>
            </div>
            <div class="tray-form-actions">
                <button type="button" class="btn-save" style="padding:8px 18px;font-size:13px" onclick="addCertificacion()">
                    <div class="spinner"></div>
                    <span class="btn-label">{{ __('app.perfil.agregar') }}</span>
                </button>
                <button type="button" class="btn-cancel-edit" id="cancelEditCert" onclick="cancelEditCertificacion()">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    {{ __('app.perfil.cancelar_edicion') }}
                </button>
            </div>
        </div>
        <div class="item-list" id="listCertificaciones">
            <div class="empty-state">{{ __('app.perfil.cargando') }}</div>
        </div>
    </div>

{{-- Tab: Redes --}}
    @include('perfil._tab_redes')

    </div>{{-- end tray-body --}}
</div>
</div>

{{-- Mini-modal confirmación borrar --}}
<div class="del-overlay" id="delOverlay">
<div class="modal" style="max-width:360px">
<div class="modal-ico red">
    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
</div>
<h3>{{ __('app.perfil.eliminar_titulo') }}</h3>
<p>{{ __('app.perfil.eliminar_desc') }}</p>
<div class="modal-actions">
    <button class="btn-cancel" onclick="cerrarDelOverlay()">{{ __('app.perfil.cancelar') }}</button>
    <button class="btn-danger" id="btnConfirmDel" onclick="confirmarDel()">{{ __('app.perfil.si_eliminar') }}</button>
</div>
</div>
</div>

{{-- Mini-modal confirmación agregar / editar --}}
<div class="del-overlay" id="confirmOverlay">
<div class="modal" style="max-width:380px">
<div class="modal-ico blue">
    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
</div>
<h3 id="confirmTitle">{{ __('app.perfil.confirmar_accion') }}</h3>
<p id="confirmMsg"></p>
<div class="modal-actions">
    <button class="btn-cancel" onclick="cerrarConfirmOverlay()">{{ __('app.perfil.cancelar') }}</button>
    <button class="btn-save" onclick="ejecutarConfirm()">
        <div class="spinner"></div>
        <span class="btn-label" id="confirmBtnLabel">{{ __('app.perfil.confirmar') }}</span>
    </button>
</div>
</div>
</div>

<script>
    // ── Traducciones inyectadas desde PHP para uso en JS ──────────────────────
    const T = @json($t);

    // Valores originales para comparar y cancelar
    const original = {
        nombre:    '{{ addslashes(auth()->user()->nombre ?? '') }}',
        apellido:  '{{ addslashes(auth()->user()->apellido ?? '') }}',
        profesion: '{{ addslashes(auth()->user()->profesion ?? '') }}',
        biografia: `{{ addslashes(auth()->user()->biografia ?? '') }}`,
    };

    let pendingFormData = null;

    // ── Botón Cancelar inteligente ────────────────────────────────────────────
    function hasChanges() {
        return document.getElementById('fNombre').value    !== original.nombre    ||
               document.getElementById('fApellido').value  !== original.apellido  ||
               document.getElementById('fProfesion').value !== original.profesion ||
               document.getElementById('fBiografia').value !== original.biografia ||
               document.getElementById('inputFoto').files.length > 0;
    }

    function syncCancelBtn() {
        document.getElementById('btnCancel').disabled = !hasChanges();
    }

    document.getElementById('inputFoto').addEventListener('change', syncCancelBtn);

    // ── Contador de biografía ─────────────────────────────────────────────────
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
            err.textContent = T.biografia_error_limite;
            err.classList.add('show');
        } else {
            cnt.classList.remove('over');
            btn.disabled = false;
            err.textContent = '';
            err.classList.remove('show');
        }
        updatePreview();
    }

    // ── Preview en tiempo real ────────────────────────────────────────────────
    function updatePreview() {
        document.getElementById('prevName').textContent =
            (document.getElementById('fNombre').value || '') + ' ' +
            (document.getElementById('fApellido').value || '');
        document.getElementById('prevProf').textContent =
            document.getElementById('fProfesion').value || T.sin_profesion;
        document.getElementById('prevBio').textContent =
            document.getElementById('fBiografia').value || T.sin_biografia;
    }

    ['fNombre','fApellido','fProfesion'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
    });

    // ── Toggle vista previa ───────────────────────────────────────────────────
    function togglePreview() {
        const card = document.getElementById('previewCard');
        const btn  = document.getElementById('btnPreview');
        updatePreview();
        card.classList.toggle('show');
        btn.classList.toggle('active');
        btn.innerHTML = card.classList.contains('show')
            ? `<svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round"><line x1="1" y1="1" x2="23" y2="23"/><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/></svg> ${T.ocultar_preview}`
            : `<svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> ${T.vista_previa}`;
    }

    // ── Foto de perfil ────────────────────────────────────────────────────────
    function handlePhoto(input) {
        const file     = input.files[0];
        const errEl    = document.getElementById('photoError');
        const initials = document.getElementById('photoInitials');

        errEl.style.display = 'none';
        errEl.textContent   = '';

        if (!file) return;

        const allowed = ['image/jpeg','image/jpg','image/png'];
        if (!allowed.includes(file.type)) {
            errEl.textContent   = T.foto_formato_error;
            errEl.style.display = 'block';
            input.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            errEl.textContent   = T.foto_size_error;
            errEl.style.display = 'block';
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            const src  = e.target.result;
            const wrap = document.querySelector('.photo-wrap');

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

            document.getElementById('prevAv').innerHTML = '<img src="' + src + '" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
            document.getElementById('sidebarAv').innerHTML = '<img src="' + src + '" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
        };
        reader.readAsDataURL(file);
    }

    // ── Validación front-end ──────────────────────────────────────────────────
    function validateForm() {
        let valid = true;

        const fields = [
            { id: 'fNombre',    err: 'errNombre',   msg: T.nombre_error   },
            { id: 'fApellido',  err: 'errApellido',  msg: T.apellido_error  },
            { id: 'fProfesion', err: 'errProfesion', msg: T.profesion_error },
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

        const bio    = document.getElementById('fBiografia');
        const errBio = document.getElementById('errBiografia');
        if (bio.value.trim() === '') {
            errBio.textContent = T.biografia_error_vacia;
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

    // ── Submit perfil ─────────────────────────────────────────────────────────
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

    // ─── Sincroniza foto en tarjeta del explorador ────────────────────────────
function _sincronizarFotoEnExplorador(fotoUrl) {
    const userId = '{{ Auth::id() }}';
    const card   = document.querySelector(`.exp-card[data-user-id="${userId}"]`);
    if (!card) return;

    const av = card.querySelector('.exp-av');
    if (!av) return;

    if (av.tagName === 'IMG') {
        // Ya es una imagen, solo cambia el src
        av.src = fotoUrl;
    } else {
        // Es un div con iniciales, reemplazar por img
        const img = document.createElement('img');
        img.src       = fotoUrl;
        img.alt       = '';
        img.className = 'exp-av exp-av-foto';
        img.style     = 'object-fit:cover;border-radius:13px;';
        av.replaceWith(img);
    }
}

function _sincronizarFotoEnPortafolios(fotoUrl) {
    const userId = '{{ Auth::id() }}';
    const cards  = document.querySelectorAll(`.porta-card[data-user-id="${userId}"]`);
    if (!cards.length) return;

    cards.forEach(card => {
        const cover = card.querySelector('.porta-card-cover');
        if (!cover) return;

        const bg     = cover.querySelector('.porta-cover-bg');
        const avatar = cover.querySelector('.porta-cover-avatar');

        if (bg && avatar) {
            // Ya tenía foto — solo actualiza el src
            bg.src     = fotoUrl;
            avatar.src = fotoUrl;
        } else {
            // Tenía iniciales — reemplaza todo el contenido del cover con foto
            const badge = cover.querySelector('.porta-badge');
            cover.innerHTML = `
                <img src="${fotoUrl}" class="porta-cover-bg" alt="">
                <div class="porta-cover-overlay"></div>
                <img src="${fotoUrl}" class="porta-cover-avatar" alt="">
                <div class="porta-cover-name"><span></span></div>
            `;
            // Restaura el badge
            if (badge) cover.appendChild(badge);
        }
    });
}

function sendRequest(formData, btn) {
    fetch('{{ route("perfil.update") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData,
    })
    .then(res => {
        if (res.status === 422) {
            return res.json().then(errData => {
                btn.classList.remove('loading');
                btn.disabled = false;
                const msgs = errData.errors ? Object.values(errData.errors).flat() : [];
                const msg  = msgs.length ? msgs[0] : T.chars_prohibidos;
                let alertEl = document.getElementById('perfilAlertError');
                if (!alertEl) {
                    alertEl = document.createElement('div');
                    alertEl.id = 'perfilAlertError';
                    alertEl.className = 'alert alert-error';
                    alertEl.innerHTML = '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> <span id="perfilAlertErrorMsg"></span>';
                    document.getElementById('perfilForm').before(alertEl);
                }
                document.getElementById('perfilAlertErrorMsg').textContent = msg;
                alertEl.style.display = 'flex';
                setTimeout(() => { alertEl.style.display = 'none'; }, 5000);
            });
        }
 
        if (!res.ok) throw new Error('Server error ' + res.status);
        return res.json();
    })
    .then(data => {
        if (!data) return;
        btn.classList.remove('loading');
        btn.disabled = false;
 
        const nombre   = document.getElementById('fNombre').value;
        const apellido = document.getElementById('fApellido').value;
 
        if (data.foto_url) {
            const fotoConCache = data.foto_url + '?t=' + Date.now();
 
            // ── Foto en el formulario ──
            const initials = document.getElementById('photoInitials');
            const wrap     = document.querySelector('.photo-wrap');
            let img        = document.getElementById('photoPreview');
            if (!img) {
                img = document.createElement('img');
                img.id        = 'photoPreview';
                img.className = 'photo-avatar';
                img.alt       = '';
                wrap.insertBefore(img, wrap.firstChild);
            }
            img.src              = fotoConCache;
            img.dataset.original = data.foto_url;
            img.style.display    = 'block';
            if (initials) initials.style.display = 'none';
 
            // ── Vista previa ──
            document.getElementById('prevAv').innerHTML =
                `<img src="${fotoConCache}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">`;
 
            // ── Sidebar ──
            const sidebarAv = document.getElementById('sidebarAv');
            if (sidebarAv) sidebarAv.innerHTML =
                `<img src="${fotoConCache}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">`;
 
            // ── Navbar ──
            if (typeof actualizarNavbar === 'function') {
                actualizarNavbar(nombre, apellido, fotoConCache);
            }
 
            // ── Explorador (foto + nombre en tiempo real) ──
            if (typeof _sincronizarFotoEnExplorador === 'function') {
                _sincronizarFotoEnExplorador(fotoConCache);
            }

            if (typeof _sincronizarFotoEnPortafolios === 'function') {
                _sincronizarFotoEnPortafolios(fotoConCache);
            }
 
        } else {
            // Sin foto nueva: solo actualiza nombre en navbar y explorador
            if (typeof actualizarNavbar === 'function') {
                actualizarNavbar(nombre, apellido, null);
            }

        }
 
        original.nombre    = nombre;
        original.apellido  = apellido;
        original.profesion = document.getElementById('fProfesion').value;
        original.biografia = document.getElementById('fBiografia').value;
        syncCancelBtn();
 
        document.getElementById('inputFoto').value = '';
 
        let alertEl = document.getElementById('perfilAlertSuccess');
        if (!alertEl) {
            alertEl = document.createElement('div');
            alertEl.id = 'perfilAlertSuccess';
            alertEl.className = 'alert alert-success';
            alertEl.innerHTML = '<svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg> <span id="perfilAlertSuccessMsg"></span>';
            document.getElementById('perfilForm').before(alertEl);
        }
        document.getElementById('perfilAlertSuccessMsg').textContent = T.success_actualizado;
        alertEl.style.display = 'flex';
        setTimeout(() => { alertEl.style.display = 'none'; }, 4000);
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

    // ── Cancelar edición ──────────────────────────────────────────────────────
    function cancelarEdicion() {
        document.getElementById('fNombre').value    = original.nombre;
        document.getElementById('fApellido').value  = original.apellido;
        document.getElementById('fProfesion').value = original.profesion;
        document.getElementById('fBiografia').value = original.biografia;

        document.getElementById('inputFoto').value = '';
        const initials = document.getElementById('photoInitials');
        const img      = document.getElementById('photoPreview');
        if (img) {
            const originalSrc = img.dataset.original || '';
            if (originalSrc) {
                img.src           = originalSrc;
                img.style.display = 'block';
                if (initials) initials.style.display = 'none';
            } else {
                img.style.display = 'none';
                if (initials) initials.style.display = 'flex';
            }
        }

        ['fNombre','fApellido','fProfesion','fBiografia'].forEach(id => {
            document.getElementById(id).classList.remove('error');
        });
        ['errNombre','errApellido','errProfesion','errBiografia'].forEach(id => {
            document.getElementById(id).classList.remove('show');
        });

        updateCounter();
        updatePreview();
        syncCancelBtn();
    }

    // Inicializar
    updateCounter();
    syncCancelBtn();

    // ── Modales ───────────────────────────────────────────────────────────────
    function abrirModalGuardar() {
        if (!validateForm()) return;
        document.getElementById('modalGuardar').classList.add('show');
    }

    function abrirModalDesactivar() {
        document.getElementById('modalDesactivar').classList.add('show');
    }

    function pCerrarModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', function(e) {
            if (e.target === this) pCerrarModal(this.id);
        });
    });

    function desactivarCuenta() {
        pCerrarModal('modalDesactivar');
        fetch('{{ route("perfil.desactivar") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        }).then(() => window.location.href = '/home');
    }

    // ── Restricción de caracteres ─────────────────────────────────────────────
    const CHARS_PROHIBIDOS = /[<>";\`\\{}]/;

    function charCheck(inputEl, errId) {
        const errEl = errId ? document.getElementById(errId) : null;
        if (CHARS_PROHIBIDOS.test(inputEl.value)) {
            inputEl.classList.add('error');
            if (errEl) { errEl.textContent = T.chars_prohibidos; errEl.classList.add('show'); }
            return false;
        }
        if (errEl && errEl.textContent === T.chars_prohibidos) {
            errEl.textContent = '';
            errEl.classList.remove('show');
            inputEl.classList.remove('error');
        }
        return true;
    }

    // ── TRAYECTORIA ───────────────────────────────────────────────────────────
    const CSRF = () => document.querySelector('meta[name="csrf-token"]').content;
    let starValue = 0;
    let habTipo   = 'fuerte';
    let trayData  = { habilidades: [], experiencias: [], formaciones: [], certificaciones: [] };
    let pendingDel = null;
    let pendingConfirm = null;
    let lastTrayAction = null;
    const editing = { habilidades: null, experiencias: null, formaciones: null, certificaciones: null };

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
        cargarRedes();
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

    // ── TABS ──────────────────────────────────────────────────────────────────
    function switchTab(tab) {
        document.querySelectorAll('.tray-tab').forEach((t, i) => {
            const names = ['habilidades','experiencia','formacion','certificacion','redes'];
            t.classList.toggle('active', names[i] === tab);
        });
        document.querySelectorAll('.tray-pane').forEach(p => p.classList.remove('active'));
        document.getElementById('pane-' + tab).classList.add('active');
        ocultarAlertaTray();
        if (tab === 'redes') cargarRedes()
    }

    // ── ALERTAS ───────────────────────────────────────────────────────────────
    function mostrarAlertaTray() { document.getElementById('trayAlert').classList.add('show'); }
    function ocultarAlertaTray() { document.getElementById('trayAlert').classList.remove('show'); }
    function retryTray() { ocultarAlertaTray(); if (lastTrayAction) lastTrayAction(); }

    // ── CONFIRM OVERLAY ───────────────────────────────────────────────────────
    function pedirConfirm(title, msg, btnLabel, fn) {
        document.getElementById('confirmTitle').textContent = title;
        document.getElementById('confirmMsg').textContent = msg;
        document.getElementById('confirmBtnLabel').textContent = btnLabel;
        pendingConfirm = fn;
        document.getElementById('confirmOverlay').classList.add('show');
    }
    function cerrarConfirmOverlay() {
        pendingConfirm = null;
        document.getElementById('confirmOverlay').classList.remove('show');
    }
    function ejecutarConfirm() {
        const fn = pendingConfirm;
        cerrarConfirmOverlay();
        if (fn) fn();
    }
    document.getElementById('confirmOverlay').addEventListener('click', function(e) {
        if (e.target === this) cerrarConfirmOverlay();
    });

    // ── AUTOCOMPLETE ──────────────────────────────────────────────────────────
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
    function closeAc() { document.getElementById('acDrop').style.display = 'none'; }

    // ── STARS ─────────────────────────────────────────────────────────────────
    function setStar(n) {
        starValue = n;
        document.querySelectorAll('.star').forEach(s => {
            s.classList.toggle('on', parseInt(s.dataset.v) <= n);
        });
        const labels = {
            1: T.hab_nivel_principiante,
            2: T.hab_nivel_principiante,
            3: T.hab_nivel_intermedio,
            4: T.hab_nivel_avanzado,
            5: T.hab_nivel_avanzado
        };
        document.getElementById('nivelLabel').textContent = n + ' ★ — ' + labels[n];
        document.getElementById('errHabNivel').classList.remove('show');
    }

    function nivelFromStars(n) {
        if (n <= 2) return 'principiante';
        if (n === 3) return 'intermedio';
        return 'avanzado';
    }

    // ── TIPO HABILIDAD ────────────────────────────────────────────────────────
    function setTipo(tipo) {
        habTipo = tipo;
        document.getElementById('btnTipoFuerte').className = 'tipo-btn' + (tipo === 'fuerte' ? ' active-fuerte' : '');
        document.getElementById('btnTipoBlanda').className = 'tipo-btn' + (tipo === 'blanda' ? ' active-blanda' : '');
        document.getElementById('errHabTipo')?.classList.remove('show');
    }

    // ── HABILIDADES ───────────────────────────────────────────────────────────
    function addHabilidad() {
        const nombre = document.getElementById('habNombre').value.trim();
        let valid = true;
        ['errHabNombre','errHabDup','errHabNivel','errHabTipo'].forEach(id => document.getElementById(id)?.classList.remove('show'));
        if (!nombre) { document.getElementById('errHabNombre').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('habNombre'), 'errHabNombre')) { valid = false; }
        if (!starValue) { document.getElementById('errHabNivel').classList.add('show'); valid = false; }
        if (!habTipo)   { document.getElementById('errHabTipo').classList.add('show'); valid = false; }
        if (!valid) return;

        const nivel = nivelFromStars(starValue);
        const isEdit = editing.habilidades !== null;
        const tipoLabel = habTipo === 'fuerte' ? T.hab_tipo_fuerte : T.hab_tipo_blanda;
        pedirConfirm(
            isEdit ? T.confirm_editar_hab : T.confirm_agregar_hab,
            `"${nombre}" — ${tipoLabel}`,
            isEdit ? T.guardar_cambios : T.agregar,
            () => _doHabilidad(nombre, nivel, habTipo)
        );
    }

    function _doHabilidad(nombre, nivel, tipo) {
        const isEdit = editing.habilidades !== null;
        const id = editing.habilidades;
        const btn = document.querySelector('#pane-habilidades .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const url    = isEdit ? '/trayectoria/habilidades/' + id : '/trayectoria/habilidades';
        const method = isEdit ? 'PUT' : 'POST';

        const action = () => fetch(url, {
            method,
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ nombre, nivel, tipo }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status === 422 && body.error) {
                document.getElementById('errHabDup').textContent = T.hab_dup_error;
                document.getElementById('errHabDup').classList.add('show');
                return;
            }
            if (status !== 200 && status !== 201) throw new Error();
            if (isEdit) {
                const idx = trayData.habilidades.findIndex(h => h.id === id);
                if (idx !== -1) trayData.habilidades[idx] = body;
            } else {
                trayData.habilidades.push(body);
            }
            trayData.habilidades.sort((a,b) => a.nombre.localeCompare(b.nombre));
            renderHabilidades();
            cancelEditHabilidad();
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function editHabilidad(id) {
        const h = trayData.habilidades.find(x => x.id === id);
        if (!h) return;
        editing.habilidades = id;
        document.getElementById('habNombre').value = h.nombre;
        const nMap = { principiante: 1, intermedio: 3, avanzado: 5 };
        setStar(nMap[h.nivel] || 1);
        setTipo(h.tipo || 'fuerte');
        document.getElementById('titleHab').textContent = T.editar_habilidad;
        document.getElementById('formHab').classList.add('editing');
        document.getElementById('cancelEditHab').classList.add('show');
        document.querySelector('#pane-habilidades .btn-save .btn-label').textContent = T.guardar_cambios;
        document.getElementById('formHab').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function cancelEditHabilidad() {
        editing.habilidades = null;
        document.getElementById('habNombre').value = '';
        starValue = 0;
        document.querySelectorAll('.star').forEach(s => s.classList.remove('on'));
        document.getElementById('nivelLabel').textContent = T.hab_nivel_hint;
        setTipo('fuerte');
        document.getElementById('titleHab').textContent = T.agregar_habilidad;
        document.getElementById('formHab').classList.remove('editing');
        document.getElementById('cancelEditHab').classList.remove('show');
        document.querySelector('#pane-habilidades .btn-save .btn-label').textContent = T.agregar;
        ['errHabNombre','errHabDup','errHabNivel','errHabTipo'].forEach(id => document.getElementById(id)?.classList.remove('show'));
    }

    function renderHabilidades() {
        const list = document.getElementById('listHabilidades');
        if (!trayData.habilidades.length) {
            list.innerHTML = `<div class="empty-state">${T.hab_empty}</div>`;
            return;
        }
        const badge  = { principiante: 'badge-p', intermedio: 'badge-i', avanzado: 'badge-a' };
        const label  = { principiante: T.hab_nivel_principiante, intermedio: T.hab_nivel_intermedio, avanzado: T.hab_nivel_avanzado };
        const fuertes = trayData.habilidades.filter(h => (h.tipo || 'fuerte') === 'fuerte');
        const blandas = trayData.habilidades.filter(h => h.tipo === 'blanda');

        const cardHtml = h => `
            <div class="item-card">
                <div class="item-card-body">
                    <strong>${escH(h.nombre)}</strong>
                    <div style="display:flex;gap:4px;flex-wrap:wrap;margin-top:3px">
                        <span class="item-badge ${badge[h.nivel] || 'badge-p'}">${label[h.nivel] || h.nivel}</span>
                        <span class="item-badge ${h.tipo === 'blanda' ? 'badge-blanda' : 'badge-fuerte'}">${h.tipo === 'blanda' ? T.hab_tipo_blanda : T.hab_tipo_fuerte}</span>
                    </div>
                </div>
                <div class="item-card-actions">
                    <button class="btn-edit-item" onclick="editHabilidad(${h.id})" title="${T.editar}">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="btn-del-item" onclick="pedirDel('habilidades',${h.id})" title="${T.eliminar}">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                </div>
            </div>`;

        let html = '';
        if (fuertes.length) {
            html += `<div class="hab-section-label">${T.hab_seccion_fuertes}</div>`;
            html += fuertes.map(cardHtml).join('');
        }
        if (blandas.length) {
            html += `<div class="hab-section-label" style="margin-top:10px">${T.hab_seccion_blandas}</div>`;
            html += blandas.map(cardHtml).join('');
        }
        list.innerHTML = html;
    }

    // ── EXPERIENCIA ───────────────────────────────────────────────────────────
    function toggleActual() {
        const chk = document.getElementById('expActual');
        const fg  = document.getElementById('fgExpFin');
        if (chk.checked) {
            fg.innerHTML = `<label>${T.exp_fin}</label><input type="text" value="${T.exp_presente}" disabled style="background:#f0f2f8;color:var(--muted)">`;
        } else {
            fg.innerHTML = `<label>${T.exp_fin}</label><input type="date" id="expFin" onchange="checkFechaCoherencia()"><span class="tray-err" id="errExpFin">${T.exp_fin_error}</span>`;
        }
    }

    function checkFechaCoherencia() {
        const ini = document.getElementById('expInicio')?.value;
        const fin = document.getElementById('expFin')?.value;
        const err = document.getElementById('errExpFin');
        if (ini && fin && fin < ini) { err?.classList.add('show'); }
        else { err?.classList.remove('show'); }
    }

    function checkFormFecha() {
        const ini = document.getElementById('forInicio')?.value;
        const fin = document.getElementById('forFin')?.value;
        const err = document.getElementById('errForFin');
        if (ini && fin && fin < ini) { err?.classList.add('show'); }
        else { err?.classList.remove('show'); }
    }

    function addExperiencia() {
        const empresa = document.getElementById('expEmpresa').value.trim();
        const cargo   = document.getElementById('expCargo').value.trim();
        const inicio  = document.getElementById('expInicio').value;
        const actual  = document.getElementById('expActual').checked;
        const fin     = actual ? null : document.getElementById('expFin')?.value || null;
        const desc    = document.getElementById('expDesc').value.trim();

        let valid = true;
        ['errExpEmpresa','errExpCargo','errExpInicio','errExpFin'].forEach(id => document.getElementById(id)?.classList.remove('show'));
        if (!empresa) { document.getElementById('errExpEmpresa').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('expEmpresa'), 'errExpEmpresa')) { valid = false; }
        if (!cargo)   { document.getElementById('errExpCargo').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('expCargo'), 'errExpCargo')) { valid = false; }
        if (!inicio)  { document.getElementById('errExpInicio').classList.add('show'); valid = false; }
        if (fin && inicio && fin < inicio) { document.getElementById('errExpFin')?.classList.add('show'); valid = false; }
        if (desc && !charCheck(document.getElementById('expDesc'), 'errExpDesc')) { valid = false; }
        if (!valid) return;

        const isEdit = editing.experiencias !== null;
        pedirConfirm(
            isEdit ? T.confirm_editar_exp : T.confirm_agregar_exp,
            `"${cargo}" — ${empresa}`,
            isEdit ? T.guardar_cambios : T.agregar,
            () => _doExperiencia(empresa, cargo, inicio, fin, actual, desc)
        );
    }

    function _doExperiencia(empresa, cargo, inicio, fin, actual, desc) {
        const isEdit = editing.experiencias !== null;
        const id = editing.experiencias;
        const btn = document.querySelector('#pane-experiencia .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const url    = isEdit ? '/trayectoria/experiencias/' + id : '/trayectoria/experiencias';
        const method = isEdit ? 'PUT' : 'POST';

        const action = () => fetch(url, {
            method,
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ empresa, cargo, fecha_inicio: inicio, fecha_fin: fin, actual, descripcion: desc }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status !== 200 && status !== 201) throw new Error(JSON.stringify(body));
            if (isEdit) {
                const idx = trayData.experiencias.findIndex(e => e.id === id);
                if (idx !== -1) trayData.experiencias[idx] = body;
            } else {
                trayData.experiencias.unshift(body);
            }
            renderExperiencias();
            cancelEditExperiencia();
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function editExperiencia(id) {
        const e = trayData.experiencias.find(x => x.id === id);
        if (!e) return;
        editing.experiencias = id;
        document.getElementById('expEmpresa').value = e.empresa || '';
        document.getElementById('expCargo').value   = e.cargo   || '';
        document.getElementById('expInicio').value  = e.fecha_inicio ? e.fecha_inicio.substring(0,10) : '';
        document.getElementById('expActual').checked = e.actual || false;
        toggleActual();
        if (!e.actual && e.fecha_fin) {
            const finEl = document.getElementById('expFin');
            if (finEl) finEl.value = e.fecha_fin.substring(0,10);
        }
        document.getElementById('expDesc').value = e.descripcion || '';
        document.getElementById('titleExp').textContent = T.editar_experiencia;
        document.getElementById('formExp').classList.add('editing');
        document.getElementById('cancelEditExp').classList.add('show');
        document.querySelector('#pane-experiencia .btn-save .btn-label').textContent = T.guardar_cambios;
        document.getElementById('formExp').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function cancelEditExperiencia() {
        editing.experiencias = null;
        ['expEmpresa','expCargo','expInicio','expDesc'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
        document.getElementById('expActual').checked = false;
        toggleActual();
        document.getElementById('titleExp').textContent = T.agregar_experiencia;
        document.getElementById('formExp').classList.remove('editing');
        document.getElementById('cancelEditExp').classList.remove('show');
        document.querySelector('#pane-experiencia .btn-save .btn-label').textContent = T.agregar;
        ['errExpEmpresa','errExpCargo','errExpInicio','errExpFin'].forEach(id => document.getElementById(id)?.classList.remove('show'));
    }

    function renderExperiencias() {
        const list = document.getElementById('listExperiencias');
        if (!trayData.experiencias.length) {
            list.innerHTML = `<div class="empty-state">${T.exp_empty}</div>`;
            return;
        }
        list.innerHTML = trayData.experiencias.map(e => {
            const finLabel = e.actual ? T.exp_presente : (e.fecha_fin ? e.fecha_fin.substring(0,7) : '');
            const periodo  = e.fecha_inicio ? e.fecha_inicio.substring(0,7) + (finLabel ? ' — ' + finLabel : '') : '';
            return `
            <div class="item-card">
                <div class="item-card-body">
                    <strong>${escH(e.cargo)} · ${escH(e.empresa)}</strong>
                    <span>${escH(periodo)}</span>
                    ${e.descripcion ? `<p>${escH(e.descripcion)}</p>` : ''}
                </div>
                <div class="item-card-actions">
                    <button class="btn-edit-item" onclick="editExperiencia(${e.id})" title="${T.editar}">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="btn-del-item" onclick="pedirDel('experiencias',${e.id})" title="${T.eliminar}">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    // ── FORMACIÓN ─────────────────────────────────────────────────────────────
    function addFormacion() {
        const nivel  = document.getElementById('forNivel').value;
        const inst   = document.getElementById('forInstitucion').value.trim();
        const titulo = document.getElementById('forTitulo').value.trim();
        const inicio = document.getElementById('forInicio').value;
        const fin    = document.getElementById('forFin').value || null;

        let valid = true;
        ['errForInstitucion','errForNivel','errForInicio','errForFin'].forEach(id => document.getElementById(id)?.classList.remove('show'));
        if (!inst)  { document.getElementById('errForInstitucion').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('forInstitucion'), 'errForInstitucion')) { valid = false; }
        if (!nivel) { document.getElementById('errForNivel').classList.add('show'); valid = false; }
        if (!inicio){ document.getElementById('errForInicio').classList.add('show'); valid = false; }
        if (fin && inicio && fin < inicio) { document.getElementById('errForFin').classList.add('show'); valid = false; }
        if (titulo && !charCheck(document.getElementById('forTitulo'), 'errForTitulo')) { valid = false; }
        if (!valid) return;

        const isEdit = editing.formaciones !== null;
        pedirConfirm(
            isEdit ? T.confirm_editar_for : T.confirm_agregar_for,
            `"${inst}"`,
            isEdit ? T.guardar_cambios : T.agregar,
            () => _doFormacion(inst, nivel, titulo, inicio, fin)
        );
    }

    function _doFormacion(inst, nivel, titulo, inicio, fin) {
        const isEdit = editing.formaciones !== null;
        const id = editing.formaciones;
        const btn = document.querySelector('#pane-formacion .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const url    = isEdit ? '/trayectoria/formaciones/' + id : '/trayectoria/formaciones';
        const method = isEdit ? 'PUT' : 'POST';

        const action = () => fetch(url, {
            method,
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ institucion: inst, nivel, titulo: titulo || null, fecha_inicio: inicio, fecha_fin: fin }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status !== 200 && status !== 201) throw new Error();
            if (isEdit) {
                const idx = trayData.formaciones.findIndex(f => f.id === id);
                if (idx !== -1) trayData.formaciones[idx] = body;
            } else {
                trayData.formaciones.unshift(body);
            }
            renderFormaciones();
            cancelEditFormacion();
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function editFormacion(id) {
        const f = trayData.formaciones.find(x => x.id === id);
        if (!f) return;
        editing.formaciones = id;
        document.getElementById('forInstitucion').value = f.institucion || '';
        document.getElementById('forNivel').value        = f.nivel       || '';
        updateForTitulo();
        document.getElementById('forTitulo').value       = f.titulo      || '';
        document.getElementById('forInicio').value       = f.fecha_inicio ? f.fecha_inicio.substring(0,10) : '';
        document.getElementById('forFin').value          = f.fecha_fin   ? f.fecha_fin.substring(0,10)   : '';
        document.getElementById('titleFor').textContent  = T.editar_formacion;
        document.getElementById('formFor').classList.add('editing');
        document.getElementById('cancelEditFor').classList.add('show');
        document.querySelector('#pane-formacion .btn-save .btn-label').textContent = T.guardar_cambios;
        document.getElementById('formFor').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function cancelEditFormacion() {
        editing.formaciones = null;
        ['forInstitucion','forTitulo','forInicio','forFin'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
        document.getElementById('forNivel').value = '';
        updateForTitulo();
        document.getElementById('titleFor').textContent = T.agregar_formacion;
        document.getElementById('formFor').classList.remove('editing');
        document.getElementById('cancelEditFor').classList.remove('show');
        document.querySelector('#pane-formacion .btn-save .btn-label').textContent = T.agregar;
        ['errForInstitucion','errForNivel','errForTitulo','errForInicio','errForFin'].forEach(id => document.getElementById(id)?.classList.remove('show'));
    }

    function renderFormaciones() {
        const list = document.getElementById('listFormaciones');
        if (!trayData.formaciones.length) {
            list.innerHTML = `<div class="empty-state">${T.for_empty}</div>`;
            return;
        }
        const nivelBadge = {
            'Primaria / Secundaria':      'badge-p',
            'Técnico / Técnico Superior': 'badge-i',
            'Pregrado':                   'badge-a',
            'Postgrado':                  'badge-a',
            'Curso / Diplomado':          'badge-p',
        };
        list.innerHTML = trayData.formaciones.map(f => {
            const finLabel = f.fecha_fin ? f.fecha_fin.substring(0,7) : T.for_en_curso;
            const periodo  = f.fecha_inicio ? f.fecha_inicio.substring(0,7) + ' — ' + finLabel : '';
            const badge    = nivelBadge[f.nivel] || 'badge-p';
            return `
            <div class="item-card">
                <div class="item-card-body">
                    <strong>${escH(f.institucion)}</strong>
                    ${f.nivel   ? `<span class="item-badge ${badge}">${escH(f.nivel)}</span>` : ''}
                    ${f.titulo  ? `<span>${escH(f.titulo)}</span>` : ''}
                    <span style="margin-top:2px">${escH(periodo)}</span>
                </div>
                <div class="item-card-actions">
                    <button class="btn-edit-item" onclick="editFormacion(${f.id})" title="${T.editar}">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="btn-del-item" onclick="pedirDel('formaciones',${f.id})" title="${T.eliminar}">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    // ── CERTIFICACIONES ───────────────────────────────────────────────────────
    function addCertificacion() {
        const nombre = document.getElementById('certNombre').value.trim();
        const org    = document.getElementById('certOrg').value.trim();
        const fecha  = document.getElementById('certFecha').value || null;
        const desc   = document.getElementById('certDesc').value.trim();

        let valid = true;
        ['errCertNombre','errCertOrg','errCertDesc'].forEach(id => document.getElementById(id)?.classList.remove('show'));
        if (!nombre) { document.getElementById('errCertNombre').classList.add('show'); valid = false; }
        else if (!charCheck(document.getElementById('certNombre'), 'errCertNombre')) { valid = false; }
        if (org  && !charCheck(document.getElementById('certOrg'),  'errCertOrg'))  { valid = false; }
        if (desc && !charCheck(document.getElementById('certDesc'), 'errCertDesc')) { valid = false; }
        if (!valid) return;

        const isEdit = editing.certificaciones !== null;
        pedirConfirm(
            isEdit ? T.confirm_editar_cert : T.confirm_agregar_cert,
            `"${nombre}"`,
            isEdit ? T.guardar_cambios : T.agregar,
            () => _doCertificacion(nombre, org, fecha, desc)
        );
    }

    function _doCertificacion(nombre, org, fecha, desc) {
        const isEdit = editing.certificaciones !== null;
        const id = editing.certificaciones;
        const btn = document.querySelector('#pane-certificacion .btn-save');
        btn.classList.add('loading'); btn.disabled = true;
        ocultarAlertaTray();

        const url    = isEdit ? '/trayectoria/certificaciones/' + id : '/trayectoria/certificaciones';
        const method = isEdit ? 'PUT' : 'POST';

        const action = () => fetch(url, {
            method,
            headers: { 'X-CSRF-TOKEN': CSRF(), 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ nombre, organizacion: org || null, fecha_obtencion: fecha, descripcion: desc || null }),
        })
        .then(r => r.json().then(j => ({ status: r.status, body: j })))
        .then(({ status, body }) => {
            btn.classList.remove('loading'); btn.disabled = false;
            if (status !== 200 && status !== 201) throw new Error();
            if (isEdit) {
                const idx = trayData.certificaciones.findIndex(c => c.id === id);
                if (idx !== -1) trayData.certificaciones[idx] = body;
            } else {
                trayData.certificaciones.unshift(body);
            }
            renderCertificaciones();
            cancelEditCertificacion();
        })
        .catch(() => { btn.classList.remove('loading'); btn.disabled = false; lastTrayAction = action; mostrarAlertaTray(); });

        lastTrayAction = action;
        action();
    }

    function editCertificacion(id) {
        const c = trayData.certificaciones.find(x => x.id === id);
        if (!c) return;
        editing.certificaciones = id;
        document.getElementById('certNombre').value = c.nombre          || '';
        document.getElementById('certOrg').value    = c.organizacion    || '';
        document.getElementById('certFecha').value  = c.fecha_obtencion ? c.fecha_obtencion.substring(0,10) : '';
        document.getElementById('certDesc').value   = c.descripcion     || '';
        document.getElementById('titleCert').textContent = T.editar_cert;
        document.getElementById('formCert').classList.add('editing');
        document.getElementById('cancelEditCert').classList.add('show');
        document.querySelector('#pane-certificacion .btn-save .btn-label').textContent = T.guardar_cambios;
        document.getElementById('formCert').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function cancelEditCertificacion() {
        editing.certificaciones = null;
        ['certNombre','certOrg','certFecha','certDesc'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
        document.getElementById('titleCert').textContent = T.agregar_cert;
        document.getElementById('formCert').classList.remove('editing');
        document.getElementById('cancelEditCert').classList.remove('show');
        document.querySelector('#pane-certificacion .btn-save .btn-label').textContent = T.agregar;
        ['errCertNombre','errCertOrg','errCertDesc'].forEach(id => document.getElementById(id)?.classList.remove('show'));
    }

    function renderCertificaciones() {
        const list = document.getElementById('listCertificaciones');
        if (!trayData.certificaciones.length) {
            list.innerHTML = `<div class="empty-state">${T.cert_empty}</div>`;
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
                <div class="item-card-actions">
                    <button class="btn-edit-item" onclick="editCertificacion(${c.id})" title="${T.editar}">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="btn-del-item" onclick="pedirDel('certificaciones',${c.id})" title="${T.eliminar}">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    // ── ELIMINAR ──────────────────────────────────────────────────────────────
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

    document.getElementById('delOverlay').addEventListener('click', function(e) {
        if (e.target === this) cerrarDelOverlay();
    });

    // ── Utilidad escape HTML ──────────────────────────────────────────────────
    function escH(str) {
        if (!str) return '';
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // ── Formación: hints de título por nivel ──────────────────────────────────
    const FOR_TITULO_HINTS = {
        'Primaria / Secundaria':      ['Ej: Bachillerato, 6to de Secundaria...', 'Nivel o año completado (opcional)'],
        'Técnico / Técnico Superior': ['Ej: Técnico en Electricidad Industrial...', 'Nombre de la carrera técnica'],
        'Pregrado':                   ['Ej: Ingeniería de Sistemas, Lic. en Administración...', 'Nombre completo de la carrera'],
        'Postgrado':                  ['Ej: Maestría en Ciencias de Datos, Doctorado en Física...', 'Nombre del postgrado'],
        'Curso / Diplomado':          ['Ej: Diplomado en Marketing Digital, Curso de AWS...', 'Nombre del curso o diplomado'],
    };

    function updateForTitulo() {
        const val  = document.getElementById('forNivel').value;
        const fg   = document.getElementById('fgForTitulo');
        const inp  = document.getElementById('forTitulo');
        const hint = document.getElementById('forTituloHint');
        if (!val) { fg.style.display = 'none'; inp.value = ''; return; }
        fg.style.display = 'flex';
        const [placeholder, hintText] = FOR_TITULO_HINTS[val] || ['', ''];
        inp.placeholder = placeholder;
        hint.textContent = hintText;
        document.getElementById('errForNivel').classList.remove('show');
    }
</script>
@include('perfil._script_redes')