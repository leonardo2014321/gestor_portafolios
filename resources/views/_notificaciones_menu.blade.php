{{-- ============================================================
     _notificaciones_menu.blade.php
     Partial: campanita de notificaciones (HTML + JS)
     Uso: @include('_notificaciones_menu')
     ============================================================ --}}

<script>
    let notifPanelAbierto = false;
    let notifDatos = [];

    async function notifCargar() {
        try {
            const res  = await fetch('/mis-notificaciones', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            const data = await res.json();
            notifDatos = data.notificaciones || [];
            const noLeidas = data.no_leidas || 0;

            const badge = document.getElementById('notif-badge');
            if (noLeidas > 0) {
                badge.textContent = noLeidas > 9 ? '9+' : noLeidas;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }

            notifRenderLista();
        } catch(e) {
            console.error('Error cargando notificaciones', e);
        }
    }

    function notifRenderLista() {
    const lista = document.getElementById('notif-lista');
    if (!notifDatos.length) {
        lista.innerHTML = `<div style="padding:32px;text-align:center">
            <svg viewBox="0 0 24 24" style="width:36px;height:36px;fill:none;stroke:#cbd5e1;stroke-width:1.5;margin:0 auto 8px;display:block">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <p style="color:#94a3b8;font-size:13px;margin:0">Sin notificaciones</p>
        </div>`;
        return;
    }

    lista.innerHTML = notifDatos.map(n => {
        const esLarga = n.mensaje.length > 80;
        const preview = esLarga ? n.mensaje.substring(0, 80) + '...' : n.mensaje;

        // Badge y color de acento según tipo
        const esContacto  = n.es_contacto === true;
        const accentColor = esContacto ? '#d97706' : '#2563eb';
        const bgNoLeida   = esContacto ? '#fffbeb' : '#eff6ff';
        const dotColor    = esContacto ? '#d97706' : '#2563eb';
        const btnBorder   = esContacto ? '#fde68a' : '#bfdbfe';

        const badgeContacto = esContacto ? `
            <div style="display:inline-flex;align-items:center;gap:4px;font-size:10px;
                        font-weight:700;padding:2px 7px;border-radius:999px;
                        background:#fef3c7;color:#92400e;margin-bottom:6px">
                ✉ Mensaje de usuario${n.remitente ? ': ' + escapeHtml(n.remitente) : ''}
            </div>` : '';

        return `
        <div id="notif-item-${n.id}"
             style="display:flex;gap:10px;padding:14px 16px;border-bottom:1px solid #f1f5f9;
                    background:${n.leida ? '#fff' : bgNoLeida};
                    border-left:3px solid ${n.leida ? 'transparent' : accentColor};
                    transition:all .3s">

            <div style="width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px;
                        background:${n.leida ? 'transparent' : dotColor}">
            </div>

            <div style="flex:1;min-width:0">
                ${badgeContacto}
                <div style="font-size:13px;font-weight:${n.leida ? '500' : '700'};
                            color:#0f172a;margin-bottom:4px">
                    ${escapeHtml(n.titulo)}
                </div>

                <div id="notif-msg-${n.id}"
                     style="font-size:12px;color:#475569;line-height:1.5">
                    ${escapeHtml(preview)}
                </div>

                ${esLarga ? `
                <button onclick="notifExpandir(${n.id})"
                    style="font-size:11px;color:${accentColor};background:none;border:none;
                           cursor:pointer;padding:2px 0;margin-top:2px;font-weight:600">
                    Ver más
                </button>` : ''}

                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:6px">
                    <span style="font-size:10px;color:#94a3b8">
                        ${new Date(n.created_at).toLocaleDateString('es-BO',{
                            day:'2-digit',month:'short',
                            hour:'2-digit',minute:'2-digit'
                        })}
                    </span>
                    ${!n.leida ? `
                    <button onclick="notifMarcarLeida(${n.id})"
                        style="font-size:10px;color:${accentColor};background:none;border:1px solid ${btnBorder};
                               border-radius:6px;padding:2px 8px;cursor:pointer;font-weight:600">
                        ✓ Marcar leída
                    </button>` : `
                    <span style="font-size:10px;color:#94a3b8;font-style:italic">Leída</span>`}
                </div>
            </div>
        </div>`;
    }).join('');
}

function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function notifExpandir(id) {
    const notif = notifDatos.find(n => n.id === id);
    if (!notif) return;

    document.getElementById('modal-titulo').textContent = notif.titulo;
    document.getElementById('modal-mensaje').textContent = notif.mensaje;
    document.getElementById('modal-notificacion').style.display = 'flex';

    // Marcar como leída automáticamente al abrir el mensaje completo
    if (!notif.leida) {
        notifMarcarLeida(id, true).then(() => notifRenderLista());
    }
}

function cerrarModalNotificacion() {
    document.getElementById('modal-notificacion').style.display = 'none';
}

// Cerrar modal si se hace clic fuera del contenido
document.addEventListener('click', function(event) {
    const modal = document.getElementById('modal-notificacion');
    if (event.target === modal) {
        cerrarModalNotificacion();
    }
});

    function notifToggle() {
        const panel = document.getElementById('notif-panel');
        notifPanelAbierto = !notifPanelAbierto;
        panel.style.display = notifPanelAbierto ? 'block' : 'none';
        if (notifPanelAbierto) notifCargar();
    }

    async function notifMarcarLeida(id, silencioso = false) {
        // Feedback visual inmediato en el botón (solo si no es llamada silenciosa)
        if (!silencioso) {
            const btn = document.querySelector(`#notif-item-${id} button[onclick*="notifMarcarLeida"]`);
            if (btn) {
                btn.disabled = true;
                btn.textContent = '⏳ Marcando...';
                btn.style.opacity = '0.6';
                btn.style.cursor = 'not-allowed';
            }
        }

        const token = document.querySelector('meta[name="csrf-token"]').content;
        await fetch(`/mis-notificaciones/${id}/leida`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token }
        });

        // Actualizar el array local y re-renderizar
        const notif = notifDatos.find(n => n.id === id);
        if (notif && !notif.leida) {
            notif.leida = true;

            const badge = document.getElementById('notif-badge');
            let count = Math.max(0, (parseInt(badge.textContent) || 0) - 1);
            badge.textContent = count > 9 ? '9+' : count;
            if (count === 0) badge.style.display = 'none';
        }

        if (!silencioso) notifRenderLista();
    }

    async function notifMarcarTodasLeidas() {
        for (const n of notifDatos.filter(x => !x.leida)) {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            await fetch(`/mis-notificaciones/${n.id}/leida`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token }
            });
        }
        notifCargar();
    }

    // Cerrar panel al hacer click fuera
    // (excluir el modal para que cerrarlo no cierre también el panel)
    document.addEventListener('click', function(e) {
        const wrap  = document.getElementById('notif-wrap');
        const modal = document.getElementById('modal-notificacion');
        if (wrap && !wrap.contains(e.target) && !modal?.contains(e.target)) {
            const panel = document.getElementById('notif-panel');
            if (panel) panel.style.display = 'none';
            notifPanelAbierto = false;
        }
    });
    // Cargar badge al iniciar y polling cada 60s
    notifCargar();
    setInterval(notifCargar, 60000);
</script>