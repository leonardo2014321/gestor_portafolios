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
</script>