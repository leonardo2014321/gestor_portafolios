{{--
    Partial: perfil/_tab_redes.blade.php
    Contenido del tab "Redes" dentro del modal Mi Trayectoria.
    Incluye: LinkedIn, GitHub, Twitter/X y Portfolio personal.
    Estilo coherente con los demás tabs (sin Bootstrap).
--}}

<style>
    /* ── Red item ── */
    .red-item {
        background: #fff;
        border: 1.5px solid var(--gray2);
        border-radius: 12px;
        padding: 1rem 1.1rem;
        margin-bottom: .85rem;
        transition: border-color .2s;
    }
    .red-item:focus-within { border-color: var(--blue2); }

    .red-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .6rem;
    }
    .red-label {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .red-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .red-icon svg { width: 18px; height: 18px; fill: currentColor; }
    .red-icon.linkedin  { background: #e8f0fe; color: #0a66c2; }
    .red-icon.github    { background: #f0f2f8; color: #1e293b; }
    .red-icon.twitter   { background: #e7f3ff; color: #1d9bf0; }
    .red-icon.portfolio { background: #f0fdf4; color: #15803d; }

    .red-name { font-size: 13.5px; font-weight: 700; color: var(--text); }

    /* Toggle visible */
    .visible-toggle {
        display: flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 700; letter-spacing: .6px;
        text-transform: uppercase; color: var(--muted); cursor: pointer;
    }
    .toggle-switch {
        position: relative; width: 34px; height: 18px;
        flex-shrink: 0;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-track {
        position: absolute; inset: 0;
        background: var(--gray2); border-radius: 18px;
        transition: background .2s; cursor: pointer;
    }
    .toggle-track::before {
        content: ''; position: absolute;
        width: 12px; height: 12px;
        left: 3px; top: 3px;
        border-radius: 50%; background: #fff;
        transition: transform .2s;
    }
    .toggle-switch input:checked + .toggle-track { background: var(--blue); }
    .toggle-switch input:checked + .toggle-track::before { transform: translateX(16px); }

    /* Input URL */
    .red-url-wrap { position: relative; }
    .red-url-input {
        width: 100%;
        border: 1.5px solid var(--gray2); border-radius: 8px;
        padding: 8px 12px; font-size: 13px;
        color: var(--text); font-family: "DM Sans", sans-serif;
        outline: none; background: var(--gray);
        transition: border-color .2s, background .2s;
    }
    .red-url-input:focus { border-color: var(--blue2); background: #fff; }

    /* Link preview */
    .red-link-preview {
        display: none;
        margin-top: 5px;
        font-size: 12px; font-weight: 600;
        color: var(--blue); text-decoration: underline;
        cursor: pointer; word-break: break-all;
    }
    .red-link-preview.show { display: block; }

    /* Info banner */
    .redes-info {
        background: #eff6ff; border: 1px solid #bfdbfe;
        border-radius: 10px; padding: 10px 14px;
        font-size: 12.5px; color: #1d4ed8;
        display: flex; align-items: flex-start; gap: 8px;
        margin-bottom: 1rem;
    }
    .redes-info svg { width: 15px; height: 15px; fill: none; stroke: currentColor; stroke-width: 2; flex-shrink: 0; margin-top: 1px; }

    /* Botón guardar redes */
    .btn-guardar-redes {
        width: 100%;
        background: linear-gradient(135deg, var(--blue), var(--blue2));
        color: #fff; border: none; border-radius: 9px;
        padding: 11px; font-size: 13.5px; font-weight: 600;
        cursor: pointer; font-family: "DM Sans", sans-serif;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: opacity .2s; margin-top: .25rem;
    }
    .btn-guardar-redes:hover { opacity: .9; }
    .btn-guardar-redes:disabled { opacity: .5; cursor: not-allowed; }
    .btn-guardar-redes .spinner {
        width: 14px; height: 14px;
        border: 2px solid rgba(255,255,255,.4); border-top-color: #fff;
        border-radius: 50%; animation: spin .6s linear infinite; display: none;
    }
    .btn-guardar-redes.loading .spinner { display: block; }
    .btn-guardar-redes.loading .btn-label { opacity: .5; }
</style>

<div class="tray-pane" id="pane-redes">

    {{-- Mensaje de estado (éxito / error) --}}
    <div id="redesMensaje"></div>

    {{-- Info --}}
    <div class="redes-info">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Vincular tus redes te permite mostrar tu presencia profesional en tu portafolio.
        Activa el toggle "Visible" para que aparezcan públicamente.
    </div>

    {{-- LinkedIn --}}
    <div class="red-item">
        <div class="red-header">
            <div class="red-label">
                <div class="red-icon linkedin">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                        <rect x="2" y="9" width="4" height="12"/>
                        <circle cx="4" cy="4" r="2"/>
                    </svg>
                </div>
                <span class="red-name">LinkedIn</span>
            </div>
            <label class="visible-toggle">
                Visible
                <label class="toggle-switch">
                    <input type="checkbox" id="linkedin_visible">
                    <span class="toggle-track"></span>
                </label>
            </label>
        </div>
        <div class="red-url-wrap">
            <input type="url" id="linkedin_url" class="red-url-input"
                   placeholder="https://linkedin.com/in/tu-usuario"
                   oninput="_actualizarLinkPreview('linkedin', this.value)">
        </div>
        <a id="linkedin_link" class="red-link-preview" target="_blank" rel="noopener"></a>
    </div>

    {{-- GitHub --}}
    <div class="red-item">
        <div class="red-header">
            <div class="red-label">
                <div class="red-icon github">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>
                    </svg>
                </div>
                <span class="red-name">GitHub</span>
            </div>
            <label class="visible-toggle">
                Visible
                <label class="toggle-switch">
                    <input type="checkbox" id="github_visible">
                    <span class="toggle-track"></span>
                </label>
            </label>
        </div>
        <div class="red-url-wrap">
            <input type="url" id="github_url" class="red-url-input"
                   placeholder="https://github.com/tu-usuario"
                   oninput="_actualizarLinkPreview('github', this.value)">
        </div>
        <a id="github_link" class="red-link-preview" target="_blank" rel="noopener"></a>
    </div>

    {{-- Twitter / X 
    <div class="red-item">
        <div class="red-header">
            <div class="red-label">
                <div class="red-icon twitter">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/>
                    </svg>
                </div>
                <span class="red-name">Twitter / X</span>
            </div>
            <label class="visible-toggle">
                Visible
                <label class="toggle-switch">
                    <input type="checkbox" id="twitter_visible">
                    <span class="toggle-track"></span>
                </label>
            </label>
        </div>
        <div class="red-url-wrap">
            <input type="url" id="twitter_url" class="red-url-input"
                   placeholder="https://twitter.com/tu-usuario"
                   oninput="_actualizarLinkPreview('twitter', this.value)">
        </div>
        <a id="twitter_link" class="red-link-preview" target="_blank" rel="noopener"></a>
    </div>--}}

    {{-- Portfolio 
    <div class="red-item">
        <div class="red-header">
            <div class="red-label">
                <div class="red-icon portfolio">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="2" y1="12" x2="22" y2="12"/>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                </div>
                <span class="red-name">Portfolio / Web personal</span>
            </div>
            <label class="visible-toggle">
                Visible
                <label class="toggle-switch">
                    <input type="checkbox" id="portfolio_visible">
                    <span class="toggle-track"></span>
                </label>
            </label>
        </div>
        <div class="red-url-wrap">
            <input type="url" id="portfolio_url" class="red-url-input"
                   placeholder="https://tu-sitio.com"
                   oninput="_actualizarLinkPreview('portfolio', this.value)">
        </div>
        <a id="portfolio_link" class="red-link-preview" target="_blank" rel="noopener"></a>
    </div>--}}

    {{-- Botón guardar --}}
    <button id="btnGuardarRedes" class="btn-guardar-redes" onclick="guardarRedes()">
        <div class="spinner"></div>
        <span class="btn-label">Guardar redes</span>
    </button>

</div>{{-- fin pane-redes --}}