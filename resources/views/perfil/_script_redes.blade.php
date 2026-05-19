{{--
    Partial: perfil/_script_redes.blade.php
    JavaScript exclusivo del tab de Redes Sociales.
    Depende de: CSRF(), mostrarAlertaTray()
    Redes: linkedin, github, twitter, facebook, instagram, tiktok
--}}
<script>
// ─── Lista canónica de redes ─────────────────
const REDES = ['linkedin','github','twitter','facebook','instagram','tiktok'];

// Flag para evitar recargar innecesariamente
let redesCargadas = false;

// ─── Carga inicial de redes ──────────────────
function cargarRedes() {
    if (redesCargadas) return;
    fetch('/perfil/redes', {
        headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' }
    })
    .then(r => { if (!r.ok) throw new Error(); return r.json(); })
    .then(data => {
        redesCargadas = true;
        data.forEach(red => {
            const urlEl = document.getElementById(red.tipo + '_url');
            const visEl = document.getElementById(red.tipo + '_visible');
            if (urlEl) {
                urlEl.value = red.url ?? '';
                _actualizarLinkPreview(red.tipo, red.url);
            }
            if (visEl) visEl.checked = !!red.visible;
        });
    })
    .catch(() => mostrarAlertaTray && mostrarAlertaTray());
}

function guardarRedes() {
    const btn    = document.getElementById('btnGuardarRedes');
    const msgEl  = document.getElementById('redesMensaje');
    const msgOk  = msgEl.dataset.msgOk;
    const msgErr = msgEl.dataset.msgErr;

    btn.classList.add('loading');
    btn.disabled = true;
    msgEl.innerHTML = '';

    const payload = REDES.map(tipo => ({
        tipo,
        url:     (document.getElementById(tipo + '_url')?.value || '').trim(),
        visible:  document.getElementById(tipo + '_visible')?.checked ?? false,
    }));

    fetch('/perfil/redes', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF(),
            'Content-Type': 'application/json',
            'Accept':       'application/json',
        },
        body: JSON.stringify({ redes: payload }),
    })
    .then(r => { if (!r.ok) throw new Error(); return r.json(); })
    .then(data => {
        btn.classList.remove('loading');
        btn.disabled = false;
        _mostrarMensajeRedes(data.mensaje || msgOk, 'success');
        _sincronizarRedesEnExplorador(payload);
    })
    .catch(() => {
        btn.classList.remove('loading');
        btn.disabled = false;
        _mostrarMensajeRedes(msgErr, 'error');
    });
}

// ─── Preview de URL en tiempo real ───────────
function _actualizarLinkPreview(tipo, url) {
    const link = document.getElementById(tipo + '_link');
    if (!link) return;
    const val = (url || '').trim();
    if (!val) { link.classList.remove('show'); return; }
    const href = /^https?:\/\//i.test(val) ? val : 'https://' + val;
    link.href = href;
    const svgEl = link.querySelector('svg');
    link.textContent = href.replace(/^https?:\/\//, '');
    if (svgEl) link.prepend(svgEl);
    link.classList.add('show');
}

// ─── Mensaje de estado ────────────────────────
function _mostrarMensajeRedes(texto, tipo) {
    const contenedor = document.getElementById('redesMensaje');
    const iconoOk  = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>`;
    const iconoErr = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
    contenedor.innerHTML = `
        <div class="alert-redes ${tipo}">
            ${tipo === 'success' ? iconoOk : iconoErr}
            ${texto}
        </div>`;
    setTimeout(() => { contenedor.innerHTML = ''; }, 3500);
}

// ─── Sincroniza las redes en la tarjeta del explorador sin recargar ──────────
function _sincronizarRedesEnExplorador(payload) {
    const userId = '{{ Auth::id() }}';
    const card   = document.querySelector(`.exp-card[data-user-id="${userId}"]`);
    if (!card) return; // El usuario no está visible en el explorador ahora mismo

    const redesContainer = card.querySelector('.exp-card-redes');
    if (!redesContainer) return;

    // SVGs idénticos a los que usa el explorador (stroke, no fill)
    const svgs = {
        github:    `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>`,
        linkedin:  `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>`,
        twitter:   `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>`,
        instagram: `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>`,
        facebook:  `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>`,
        tiktok:    `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>`,
    };
    const svgDefault = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>`;

    // Solo las redes visibles con URL, máximo 3 (igual que el explorador)
    const redesVisibles = payload
        .filter(r => r.visible && r.url)
        .slice(0, 3);

    redesContainer.innerHTML = redesVisibles
        .map(r => {
            const href = /^https?:\/\//i.test(r.url) ? r.url : 'https://' + r.url;
            return `<a href="${href}" target="_blank" rel="noopener"
                       class="exp-red-btn" title="${r.tipo}">
                       ${svgs[r.tipo] ?? svgDefault}
                   </a>`;
        })
        .join('');
}

// ─── Precarga automática al cargar el script ──
// No espera al click del tab: los datos ya están listos cuando el usuario llega
cargarRedes();
</script>