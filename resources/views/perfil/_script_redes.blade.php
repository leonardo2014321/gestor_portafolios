{{--
    Partial: perfil/_script_redes.blade.php
    JavaScript exclusivo del tab de Redes Sociales.
    Depende de: CSRF(), mostrarAlertaTray()
--}}
<script>
// ─── Carga inicial de redes ───────────────────
function cargarRedes() {
    fetch('/perfil/redes', {
        headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' }
    })
    .then(r => { if (!r.ok) throw new Error(); return r.json(); })
    .then(data => {
        data.forEach(red => {
            const urlEl     = document.getElementById(red.tipo + '_url');
            const visEl     = document.getElementById(red.tipo + '_visible');
            if (urlEl)  urlEl.value     = red.url ?? '';
            if (visEl)  visEl.checked   = !!red.visible;
            _actualizarLinkPreview(red.tipo, red.url);
        });
    })
    .catch(() => mostrarAlertaTray());
}

// ─── Guardar redes ────────────────────────────
function guardarRedes() {
    const btn = document.getElementById('btnGuardarRedes');
    btn.classList.add('loading'); btn.disabled = true;
    document.getElementById('redesMensaje').innerHTML = '';

    const REDES = ['linkedin','github','twitter','portfolio'];
    const redes = REDES.map(tipo => ({
        tipo,
        url:     (document.getElementById(tipo + '_url')?.value     || '').trim(),
        visible: document.getElementById(tipo + '_visible')?.checked ?? false,
    }));

    fetch('/perfil/redes', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN':  CSRF(),
            'Content-Type':  'application/json',
            'Accept':        'application/json',
        },
        body: JSON.stringify({ redes }),
    })
    .then(r => { if (!r.ok) throw new Error(); return r.json(); })
    .then(data => {
        btn.classList.remove('loading'); btn.disabled = false;
        _mostrarMensajeRedes(data.mensaje || 'Redes guardadas correctamente.', 'success');
    })
    .catch(() => {
        btn.classList.remove('loading'); btn.disabled = false;
        _mostrarMensajeRedes('Error al guardar. Inténtalo de nuevo.', 'error');
    });
}

// ─── Preview de URL en tiempo real ───────────
function _actualizarLinkPreview(tipo, url) {
    const link = document.getElementById(tipo + '_link');
    if (!link) return;
    if (!url || !url.trim()) { link.style.display = 'none'; return; }
    const href = url.startsWith('http://') || url.startsWith('https://') ? url : 'https://' + url;
    link.href        = href;
    link.textContent = '🔗 ' + href;
    link.style.display = 'block';
}

// Asocia eventos input a cada campo de URL al cargar el pane
function _initRedesPreview() {
    ['linkedin','github','twitter','portfolio'].forEach(tipo => {
        const el = document.getElementById(tipo + '_url');
        if (el) el.addEventListener('input', e => _actualizarLinkPreview(tipo, e.target.value));
    });
}

// ─── Mensaje de estado ────────────────────────
function _mostrarMensajeRedes(texto, tipo) {
    const contenedor = document.getElementById('redesMensaje');
    const color = tipo === 'success' ? '#dcfce7;color:#15803d;border:1px solid #bbf7d0'
                                     : '#fee2e2;color:#b91c1c;border:1px solid #fecaca';
    contenedor.innerHTML = `
        <div style="background:${color};padding:10px 14px;border-radius:8px;font-size:13px;
                    font-weight:500;display:flex;align-items:center;gap:8px;margin-bottom:.75rem">
            ${texto}
        </div>`;
    setTimeout(() => { contenedor.innerHTML = ''; }, 3500);
}
</script>