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
                                        <input type="text" name="nombre" id="fNombre" class="field" value="{{ old('nombre', $usuario->nombre) }}" placeholder="Tu nombre" maxlength="100">
                                        <span class="field-err" id="errNombre">El nombre es obligatorio.</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido <span class="req">*</span></label>
                                        <input type="text" name="apellido" id="fApellido" class="field" value="{{ old('apellido', $usuario->apellido) }}" placeholder="Tu apellido" maxlength="100">
                                        <span class="field-err" id="errApellido">El apellido es obligatorio.</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Profesión <span class="req">*</span></label>
                                    <input type="text" name="profesion" id="fProfesion" class="field" value="{{ old('profesion', $usuario->profesion) }}" placeholder="Ej: Ingeniero de Software" maxlength="150">
                                    <span class="field-err" id="errProfesion">La profesión es obligatoria.</span>
                                </div>
                            </div>

                            <div class="form-card">
                                <div class="card-title">Biografía Profesional</div>

                                <div class="form-group">
                                    <label>Biografía</label>
                                    <textarea name="biografia" id="fBiografia" class="field" placeholder="Cuéntanos sobre ti, tu experiencia y objetivos profesionales..." maxlength="1100" oninput="updateCounter()">{{ old('biografia', $usuario->biografia) }}</textarea>
                                    <div class="bio-footer">
                                        <span class="field-err" id="errBiografia" style="margin-top:0"></span>
                                        <span class="bio-counter" id="bioCounter">0 / 1000</span>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-save" id="btnSave" onclick="submitPerfil()">
                                        <div class="spinner"></div>
                                        <span class="btn-label">Guardar</span>
                                    </button>
                                    <button type="button" class="btn-cancel" onclick="cancelarEdicion()">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
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
            } else {
                el.classList.remove('error');
                err.classList.remove('show');
            }
        });

        // Biografía vacía
        const bio    = document.getElementById('fBiografia');
        const errBio = document.getElementById('errBiografia');
        if (bio.value.trim() === '') {
            errBio.textContent = 'La biografía no puede estar vacía.';
            errBio.classList.add('show');
            bio.classList.add('error');
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
</script>
</body>
</html>
