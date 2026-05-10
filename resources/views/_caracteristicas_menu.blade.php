{{-- ============================================================
     _caracteristicas_menu.blade.php
     Partial: contenido de la vista "Características" para menu.blade.php
     Uso: @include('_caracteristicas_menu')
     ============================================================ --}}

<div class="content-bar">
    <div class="content-title">
        <h1>{{ __('app.menu.caracteristicas') }}</h1>
        <p>{{ __('app.menu.caract_subtitulo') }}</p>
    </div>
</div>

<div class="caract-grid">
    <div style="border-left:4px solid #2563eb;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
        <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">
            {{ __('app.menu.disenio') }}
        </h3>
        <p style="font-size:13px;color:var(--muted);margin-top:6px;">{{ __('app.menu.disenio_desc') }}</p>
    </div>
    <div style="border-left:4px solid #7c3aed;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
        <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">
            {{ __('app.menu.editor') }}
        </h3>
        <p style="font-size:13px;color:var(--muted);margin-top:6px;">{{ __('app.menu.editor_desc') }}</p>
    </div>
    <div style="border-left:4px solid #ec4899;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
        <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">
            {{ __('app.menu.marca') }}
        </h3>
        <p style="font-size:13px;color:var(--muted);margin-top:6px;">{{ __('app.menu.marca_desc') }}</p>
    </div>
    <div style="border-left:4px solid #f97316;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
        <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">
            {{ __('app.menu.exportacion') }}
        </h3>
        <p style="font-size:13px;color:var(--muted);margin-top:6px;">{{ __('app.menu.exportacion_desc') }}</p>
    </div>
    <div style="border-left:4px solid #10b981;padding:1rem 1.2rem;background:#fff;border-radius:0 12px 12px 0;">
        <h3 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;">
            {{ __('app.menu.enlace') }}
        </h3>
        <p style="font-size:13px;color:var(--muted);margin-top:6px;">{{ __('app.menu.enlace_desc') }}</p>
    </div>
</div>