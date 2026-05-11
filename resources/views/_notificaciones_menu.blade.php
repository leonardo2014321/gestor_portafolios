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
        if (!lista) return;
        if (!notifDatos.length) {
            lista.innerHTML = `<div style="padding:32px;text-align:center">
                <svg viewBox="0 0 24 24" style="width:36px;height:36px;fill:none;stroke:#cbd5e1;stroke-width:1.5;margin:0 auto 8px;display:block"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <p style="color:#94a3b8;font-size:13px;margin:0">Sin notificaciones</p>
            </div>`;
            return;
        }
        lista.innerHTML = notifDatos.map(n => `
            <div onclick="notifMarcarLeida(${n.id}, this)"
                 style="display:flex;gap:12px;padding:14px 18px;border-bottom:1px solid #f8fafc;cursor:pointer;transition:background .15s;background:${n.leida ? '#fff' : '#f0f6ff'}"
                 onmouseover="this.style.background='#f8fafc'"
                 onmouseout="this.style.background='${n.leida ? '#fff' : '#f0f6ff'}'">
                <div style="width:8px;height:8px;border-radius:50%;background:${n.leida ? 'transparent' : '#2563eb'};flex-shrink:0;margin-top:5px"></div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:13px;font-weight:${n.leida ? '400' : '600'};color:#0f172a;margin-bottom:2px">${n.titulo}</div>
                    <div style="font-size:12px;color:#64748b;line-height:1.4;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">${n.mensaje}</div>
                    <div style="font-size:10px;color:#94a3b8;margin-top:4px">${new Date(n.created_at).toLocaleDateString('es-BO',{day:'2-digit',month:'short',hour:'2-digit',minute:'2-digit'})}</div>
                </div>
            </div>`).join('');
    }

    function notifToggle() {
        const panel = document.getElementById('notif-panel');
        notifPanelAbierto = !notifPanelAbierto;
        panel.style.display = notifPanelAbierto ? 'block' : 'none';
        if (notifPanelAbierto) notifCargar();
    }

    async function notifMarcarLeida(id, el) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        await fetch(`/mis-notificaciones/${id}/leida`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token }
        });
        el.style.background = '#fff';
        el.querySelector('div[style*="border-radius:50%"]').style.background = 'transparent';
        el.querySelector('div > div:first-child').style.fontWeight = '400';
        const badge = document.getElementById('notif-badge');
        let count = parseInt(badge.textContent) || 0;
        count = Math.max(0, count - 1);
        badge.textContent = count > 9 ? '9+' : count;
        if (count === 0) badge.style.display = 'none';
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
    document.addEventListener('click', function(e) {
        const wrap = document.getElementById('notif-wrap');
        if (wrap && !wrap.contains(e.target)) {
            const panel = document.getElementById('notif-panel');
            if (panel) panel.style.display = 'none';
            notifPanelAbierto = false;
        }
    });

    // Cargar badge al iniciar y polling cada 60s
    notifCargar();
    setInterval(notifCargar, 60000);
</script>