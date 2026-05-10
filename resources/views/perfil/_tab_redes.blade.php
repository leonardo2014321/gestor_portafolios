{{--
    Partial: perfil/_tab_redes.blade.php
    Contenido del tab "Redes" dentro del modal Mi Trayectoria.
    Incluye: LinkedIn, GitHub, Twitter/X, Facebook, Instagram, TikTok.
--}}

<style>
    /* ── Variables locales ── */
    #pane-redes {
        --red-radius: 14px;
        --red-icon-size: 38px;
        --red-gap: .75rem;
        --anim: .18s cubic-bezier(.4,0,.2,1);
    }

    /* ── Info banner ── */
    .redes-info {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 11px 14px;
        margin-bottom: 1.1rem;
        font-size: 12.5px;
        color: #1d4ed8;
        line-height: 1.5;
    }
    .redes-info svg {
        width: 16px; height: 16px;
        fill: none; stroke: currentColor; stroke-width: 2;
        flex-shrink: 0; margin-top: 1px;
    }

    /* ── Grid de tarjetas ── */
    .redes-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .65rem;
        margin-bottom: 1rem;
    }

    /* ── Tarjeta individual ── */
    .red-card {
        background: #fff;
        border: 1.5px solid #e4e7f0;
        border-radius: var(--red-radius);
        padding: .9rem 1rem 1rem;
        transition: border-color var(--anim), box-shadow var(--anim);
        cursor: default;
    }
    .red-card:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }

    /* ── Cabecera de tarjeta ── */
    .red-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .7rem;
    }
    .red-card-meta {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    /* ── Ícono de red ── */
    .red-icon {
        width: var(--red-icon-size);
        height: var(--red-icon-size);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: transform var(--anim);
    }
    .red-card:focus-within .red-icon { transform: scale(1.07); }
    .red-icon svg { width: 17px; height: 17px; }

    /* Colores por red */
    .red-icon.linkedin    { background: #e8f0fe; color: #0a66c2; }
    .red-icon.github      { background: #f0f2f8; color: #1e293b; }
    .red-icon.twitter     { background: #e7f3ff; color: #1d9bf0; }
    .red-icon.facebook    { background: #eef2ff; color: #1877f2; }
    .red-icon.instagram   { background: #fdf2f8; color: #c2185b; }
    .red-icon.tiktok      { background: #f0faf8; color: #010101; }

    .red-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--text, #111827);
        letter-spacing: -.1px;
    }

    /* ── Toggle visible ── */
    .visible-toggle {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: #94a3b8;
        cursor: pointer;
        user-select: none;
    }
    .toggle-switch {
        position: relative;
        width: 30px; height: 16px;
        flex-shrink: 0;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .toggle-track {
        position: absolute; inset: 0;
        background: #e2e8f0;
        border-radius: 16px;
        cursor: pointer;
        transition: background var(--anim);
    }
    .toggle-track::before {
        content: '';
        position: absolute;
        width: 10px; height: 10px;
        left: 3px; top: 3px;
        border-radius: 50%;
        background: #fff;
        transition: transform var(--anim);
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .toggle-switch input:checked + .toggle-track { background: #2563eb; }
    .toggle-switch input:checked + .toggle-track::before { transform: translateX(14px); }

    /* ── Input URL ── */
    .red-url-input {
        width: 100%;
        border: 1.5px solid #e4e7f0;
        border-radius: 8px;
        padding: 7px 10px;
        font-size: 12.5px;
        color: var(--text, #111827);
        font-family: "DM Sans", sans-serif;
        outline: none;
        background: #f8faff;
        transition: border-color var(--anim), background var(--anim);
        box-sizing: border-box;
    }
    .red-url-input::placeholder { color: #b0b9cc; font-size: 12px; }
    .red-url-input:focus { border-color: #3b82f6; background: #fff; }

    /* ── Link preview ── */
    .red-link-preview {
        display: none;
        margin-top: 5px;
        font-size: 11.5px;
        font-weight: 600;
        color: #2563eb;
        text-decoration: none;
        word-break: break-all;
        opacity: .85;
        transition: opacity var(--anim);
    }
    .red-link-preview:hover { opacity: 1; text-decoration: underline; }
    .red-link-preview.show { display: flex; align-items: center; gap: 4px; }
    .red-link-preview svg { width: 11px; height: 11px; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 2.5; }

    /* ── Botón guardar ── */
    .btn-guardar-redes {
        width: 100%;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11.5px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: "DM Sans", sans-serif;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: opacity var(--anim), transform var(--anim);
        margin-top: .1rem;
        letter-spacing: .1px;
    }
    .btn-guardar-redes:hover { opacity: .92; transform: translateY(-1px); }
    .btn-guardar-redes:active { opacity: 1; transform: translateY(0); }
    .btn-guardar-redes:disabled { opacity: .5; cursor: not-allowed; transform: none; }
    .btn-guardar-redes .spinner {
        width: 14px; height: 14px;
        border: 2px solid rgba(255,255,255,.35);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin .6s linear infinite;
        display: none;
    }
    .btn-guardar-redes.loading .spinner { display: block; }
    .btn-guardar-redes.loading .btn-label { opacity: .55; }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── Mensaje de estado ── */
    #redesMensaje .alert-redes {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px;
        border-radius: 9px;
        font-size: 13px; font-weight: 500;
        margin-bottom: .8rem;
        animation: fadeInDown .25s ease;
    }
    .alert-redes.success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .alert-redes.error   { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .alert-redes svg { width: 15px; height: 15px; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 2.5; }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Responsive: 1 columna en pantallas pequeñas ── */
    @media (max-width: 520px) {
        .redes-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="tray-pane" id="pane-redes">

    {{-- Mensaje de estado --}}
    <div id="redesMensaje"
         data-msg-ok="{{ __('app.perfil.redes_guardadas') }}"
         data-msg-err="{{ __('app.perfil.redes_error') }}">
    </div>

    {{-- Info --}}
    <div class="redes-info">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ __('app.perfil.redes_info') }}
        <strong>{{ __('app.perfil.redes_info_visible') }}</strong>
        {{ __('app.perfil.redes_info_sufijo') }}
    </div>

    <div class="redes-grid">

        {{-- LinkedIn --}}
        <div class="red-card">
            <div class="red-card-header">
                <div class="red-card-meta">
                    <div class="red-icon linkedin">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452H17.23v-5.569c0-1.328-.025-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.925V9h3.09v1.561h.043c.43-.815 1.48-1.673 3.046-1.673 3.258 0 3.861 2.145 3.861 4.934v6.63zM5.337 7.433a1.791 1.791 0 1 1 0-3.582 1.791 1.791 0 0 1 0 3.582zm1.595 13.019H3.74V9h3.192v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </div>
                    <span class="red-name">LinkedIn</span>
                </div>
                <label class="visible-toggle">
                    {{ __('app.perfil.redes_visible') }}
                    <label class="toggle-switch">
                        <input type="checkbox" id="linkedin_visible">
                        <span class="toggle-track"></span>
                    </label>
                </label>
            </div>
            <input type="url" id="linkedin_url" class="red-url-input"
                   placeholder="{{ __('app.perfil.redes_placeholder_li') }}"
                   oninput="_actualizarLinkPreview('linkedin', this.value)">
            <a id="linkedin_link" class="red-link-preview" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>

        {{-- GitHub --}}
        <div class="red-card">
            <div class="red-card-header">
                <div class="red-card-meta">
                    <div class="red-icon github">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                        </svg>
                    </div>
                    <span class="red-name">GitHub</span>
                </div>
                <label class="visible-toggle">
                    {{ __('app.perfil.redes_visible') }}
                    <label class="toggle-switch">
                        <input type="checkbox" id="github_visible">
                        <span class="toggle-track"></span>
                    </label>
                </label>
            </div>
            <input type="url" id="github_url" class="red-url-input"
                   placeholder="{{ __('app.perfil.redes_placeholder_gh') }}"
                   oninput="_actualizarLinkPreview('github', this.value)">
            <a id="github_link" class="red-link-preview" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>

        {{-- Twitter / X --}}
        <div class="red-card">
            <div class="red-card-header">
                <div class="red-card-meta">
                    <div class="red-icon twitter">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.91-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </div>
                    <span class="red-name">Twitter / X</span>
                </div>
                <label class="visible-toggle">
                    {{ __('app.perfil.redes_visible') }}
                    <label class="toggle-switch">
                        <input type="checkbox" id="twitter_visible">
                        <span class="toggle-track"></span>
                    </label>
                </label>
            </div>
            <input type="url" id="twitter_url" class="red-url-input"
                   placeholder="{{ __('app.perfil.redes_placeholder_tw') }}"
                   oninput="_actualizarLinkPreview('twitter', this.value)">
            <a id="twitter_link" class="red-link-preview" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>

        {{-- Facebook --}}
        <div class="red-card">
            <div class="red-card-header">
                <div class="red-card-meta">
                    <div class="red-icon facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    <span class="red-name">Facebook</span>
                </div>
                <label class="visible-toggle">
                    {{ __('app.perfil.redes_visible') }}
                    <label class="toggle-switch">
                        <input type="checkbox" id="facebook_visible">
                        <span class="toggle-track"></span>
                    </label>
                </label>
            </div>
            <input type="url" id="facebook_url" class="red-url-input"
                   placeholder="{{ __('app.perfil.redes_placeholder_fb') }}"
                   oninput="_actualizarLinkPreview('facebook', this.value)">
            <a id="facebook_link" class="red-link-preview" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>

        {{-- Instagram --}}
        <div class="red-card">
            <div class="red-card-header">
                <div class="red-card-meta">
                    <div class="red-icon instagram">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                        </svg>
                    </div>
                    <span class="red-name">Instagram</span>
                </div>
                <label class="visible-toggle">
                    {{ __('app.perfil.redes_visible') }}
                    <label class="toggle-switch">
                        <input type="checkbox" id="instagram_visible">
                        <span class="toggle-track"></span>
                    </label>
                </label>
            </div>
            <input type="url" id="instagram_url" class="red-url-input"
                   placeholder="{{ __('app.perfil.redes_placeholder_ig') }}"
                   oninput="_actualizarLinkPreview('instagram', this.value)">
            <a id="instagram_link" class="red-link-preview" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>

        {{-- TikTok --}}
        <div class="red-card">
            <div class="red-card-header">
                <div class="red-card-meta">
                    <div class="red-icon tiktok">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </div>
                    <span class="red-name">TikTok</span>
                </div>
                <label class="visible-toggle">
                    {{ __('app.perfil.redes_visible') }}
                    <label class="toggle-switch">
                        <input type="checkbox" id="tiktok_visible">
                        <span class="toggle-track"></span>
                    </label>
                </label>
            </div>
            <input type="url" id="tiktok_url" class="red-url-input"
                   placeholder="{{ __('app.perfil.redes_placeholder_tt') }}"
                   oninput="_actualizarLinkPreview('tiktok', this.value)">
            <a id="tiktok_link" class="red-link-preview" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>

    </div>{{-- fin redes-grid --}}

    {{-- Botón guardar --}}
    <button id="btnGuardarRedes" class="btn-guardar-redes" onclick="guardarRedes()">
        <div class="spinner"></div>
        <span class="btn-label">{{ __('app.perfil.redes_guardar') }}</span>
    </button>

</div>{{-- fin pane-redes --}}