{{-- ============================================================
     notificaciones_admin.blade.php
     Partial: vista de notificaciones del panel admin
     Uso: @include('notificaciones_admin')
     ============================================================ --}}

<!-- ═══ VISTA: NOTIFICACIONES (ADMIN) ═══ -->
<div id="view-notificaciones" class="admin-view" style="display:none">
    <div class="admin-hero" style="margin-bottom:1.5rem">
        <div class="hero-content">
            <h1 class="hero-title">{{ __('app.admin.notif_titulo') }}</h1>
            <p class="hero-sub">{{ __('app.admin.notif_sub') }}</p>
        </div>
    </div>

    <!-- Formulario envío -->
    <div class="panel" style="margin-bottom:1.5rem">
        <div class="panel-header" style="padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray2)">
            <h2 class="panel-title">{{ __('app.admin.notif_nueva') }}</h2>
        </div>
        <div style="padding:1.5rem">
            <div id="notif-success" style="display:none;background:#d1fae5;color:#065f46;padding:10px 16px;border-radius:10px;font-size:13px;margin-bottom:1rem;font-weight:600;">
                {{ __('app.admin.notif_enviada_ok') }}
            </div>

            <!-- Título -->
            <div style="margin-bottom:1rem">
                <label style="display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em">{{ __('app.admin.notif_campo_titulo') }} <span style="color:#ef4444">*</span></label>
                <input id="notif-titulo" type="text" maxlength="150" placeholder="{{ __('app.admin.notif_placeholder_titulo') }}"
                    style="width:100%;padding:10px 14px;border:1px solid var(--gray2);border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background:var(--gray);color:var(--text)">
            </div>

            <!-- Mensaje -->
            <div style="margin-bottom:1rem">
                <label style="display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em">{{ __('app.admin.notif_campo_mensaje') }} <span style="color:#ef4444">*</span></label>
                <textarea id="notif-mensaje" maxlength="1000" rows="4" placeholder="{{ __('app.admin.notif_placeholder_mensaje') }}"
                    style="width:100%;padding:10px 14px;border:1px solid var(--gray2);border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background:var(--gray);color:var(--text);resize:vertical"></textarea>
                <div style="text-align:right;font-size:11px;color:var(--muted);margin-top:3px">
                    <span id="notif-msg-count">0</span>/1000
                </div>
            </div>

            <!-- Tipo de envío -->
            <div style="margin-bottom:1rem">
                <label style="display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em">{{ __('app.admin.notif_destinatario') }} <span style="color:#ef4444">*</span></label>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <label style="display:flex;align-items:center;gap:8px;padding:10px 18px;border:1.5px solid var(--gray2);border-radius:10px;cursor:pointer;font-size:13px;background:#fff;transition:all .2s" id="lbl-todos">
                        <input type="radio" name="notif-tipo" value="todos" onchange="notifTipoChange(this)" style="accent-color:#7c3aed"> {{ __('app.admin.notif_todos') }}
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;padding:10px 18px;border:1.5px solid var(--gray2);border-radius:10px;cursor:pointer;font-size:13px;background:#fff;transition:all .2s" id="lbl-rol">
                        <input type="radio" name="notif-tipo" value="rol" onchange="notifTipoChange(this)" style="accent-color:#7c3aed"> {{ __('app.admin.notif_solo_admins') }}
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;padding:10px 18px;border:1.5px solid var(--gray2);border-radius:10px;cursor:pointer;font-size:13px;background:#fff;transition:all .2s" id="lbl-individual">
                        <input type="radio" name="notif-tipo" value="individual" onchange="notifTipoChange(this)" style="accent-color:#7c3aed"> {{ __('app.admin.notif_usuario_especifico') }}
                    </label>
                </div>
            </div>

            <!-- Selector usuario (solo si individual) -->
            <div id="notif-selector-usuario" style="display:none;margin-bottom:1rem">
                <label style="display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em">{{ __('app.admin.notif_seleccionar_usuario') }} <span style="color:#ef4444">*</span></label>
                <select id="notif-destinatario" style="width:100%;padding:10px 14px;border:1px solid var(--gray2);border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background:#fff;color:var(--text);cursor:pointer">
                    <option value="">{{ __('app.admin.notif_elige_usuario') }}</option>
                    @foreach($todos_usuarios as $u)
                        <option value="{{ $u->id }}">{{ $u->nombre }} {{ $u->apellido }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Botón enviar -->
            <button onclick="notifEnviar()" style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;background:#7c3aed;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .2s">
                <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                {{ __('app.admin.notif_btn_enviar') }}
            </button>
        </div>
    </div>

    <!-- Historial de enviadas -->
    <div class="panel">
        <div class="panel-header" style="padding:1.2rem 1.5rem;border-bottom:1px solid var(--gray2);display:flex;align-items:center;justify-content:space-between">
            <h2 class="panel-title">{{ __('app.admin.notif_historial') }}</h2>
            <button onclick="notifCargarHistorial()" style="font-size:12px;color:var(--blue);background:none;border:none;cursor:pointer;font-weight:600">{{ __('app.admin.notif_actualizar') }}</button>
        </div>
        <div id="notif-historial" style="padding:1rem 1.5rem">
            <p style="color:var(--muted);font-size:13px">{{ __('app.admin.cargando') }}</p>
        </div>
    </div>
</div><!-- /view-notificaciones -->

<script>
    // ── Contador de caracteres del mensaje ───────────────────
    document.getElementById('notif-mensaje')?.addEventListener('input', function () {
        document.getElementById('notif-msg-count').textContent = this.value.length;
    });

    // ── Mostrar/ocultar selector de usuario ─────────────────
    function notifTipoChange(radio) {
        document.getElementById('notif-selector-usuario').style.display =
            radio.value === 'individual' ? 'block' : 'none';
    }

    // ── Enviar notificación ──────────────────────────────────
    async function notifEnviar() {
        const titulo  = document.getElementById('notif-titulo').value.trim();
        const mensaje = document.getElementById('notif-mensaje').value.trim();
        const tipoEl  = document.querySelector('input[name="notif-tipo"]:checked');
        const tipo    = tipoEl ? tipoEl.value : '';
        const destId  = document.getElementById('notif-destinatario')?.value;

        if (!titulo || !mensaje || !tipo) {
            alert('Completa todos los campos obligatorios.'); return;
        }
        if (tipo === 'individual' && !destId) {
            alert('Selecciona un usuario destinatario.'); return;
        }

        // Feedback visual en el botón
        const btn = document.querySelector('button[onclick="notifEnviar()"]');
        const textoOriginal = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `
            <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;animation:spin 1s linear infinite">
                <circle cx="12" cy="12" r="10" stroke-opacity="0.3"/>
                <path d="M12 2a10 10 0 0 1 10 10"/>
            </svg>
            Enviando...`;

        const token = document.querySelector('meta[name="csrf-token"]').content;

        // ✅ JSON en lugar de FormData para preservar saltos de línea
        //    y cualquier carácter especial sin truncar ni corromper
        const payload = { titulo, mensaje, tipo_envio: tipo };
        if (tipo === 'individual') payload.destinatario_id = destId;

        try {
            const res  = await fetch('/admin/notificaciones', {
                method:  'POST',
                headers: {
                    'X-CSRF-TOKEN':  token,
                    'Content-Type':  'application/json',
                    'Accept':        'application/json',
                },
                body: JSON.stringify(payload),
            });
            const json = await res.json().catch(() => ({}));

            if (res.ok) {
                document.getElementById('notif-titulo').value  = '';
                document.getElementById('notif-mensaje').value = '';
                document.getElementById('notif-msg-count').textContent = '0';
                document.querySelectorAll('input[name="notif-tipo"]').forEach(r => r.checked = false);
                document.getElementById('notif-selector-usuario').style.display = 'none';
                const ok = document.getElementById('notif-success');
                ok.style.display = 'block';
                setTimeout(() => ok.style.display = 'none', 3000);
                notifCargarHistorial();
            } else {
                alert('Error: ' + (json.error || 'Revisa los campos.'));
            }
        } catch (e) {
            alert('Error de conexión.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = textoOriginal;
        }
    }

    // ── Historial de notificaciones enviadas ─────────────────
    async function notifCargarHistorial() {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const res   = await fetch('/admin/notificaciones', {
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        });
        const lista = await res.json().catch(() => []);
        const box   = document.getElementById('notif-historial');

        if (!lista.length) {
            box.innerHTML = '<p style="color:var(--muted);font-size:13px">{{ __('app.admin.notif_sin_enviadas') }}</p>';
            return;
        }

        box.innerHTML = lista.map(n => {
            // Detectar si es un mensaje de contacto enviado por un usuario
            const esContacto = n.titulo && n.titulo.startsWith('[Usuario]');
            const tituloMostrar = esContacto ? n.titulo.replace('[Usuario] ', '') : n.titulo;

            // Badge de remitente (quién envió)
            const remitenteHtml = n.remitente ? `
                <span style="display:inline-flex;align-items:center;gap:4px;font-size:10px;
                             font-weight:700;padding:2px 8px;border-radius:999px;
                             background:${esContacto ? '#fef3c7' : '#f1f5f9'};
                             color:${esContacto ? '#92400e' : '#475569'}">
                    ${esContacto ? '✉ ' : ''}${n.remitente}${n.remitente_email ? ' · ' + n.remitente_email : ''}
                </span>` : '';

            return `
            <div style="display:flex;align-items:flex-start;justify-content:space-between;
                        padding:14px 0;border-bottom:1px solid var(--gray2)">
                <div style="flex:1;min-width:0">
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px">
                        ${esContacto ? `<span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;background:#fef3c7;color:#92400e">✉ Contacto de usuario</span>` : ''}
                        <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;
                            background:${n.tipo_envio==='todos'?'#dbeafe':n.tipo_envio==='rol'?'#ede9fe':'#d1fae5'};
                            color:${n.tipo_envio==='todos'?'#1e40af':n.tipo_envio==='rol'?'#5b21b6':'#065f46'}">
                            ${n.tipo_envio==='todos'?'{{ __('app.admin.notif_tag_todos') }}':n.tipo_envio==='rol'?'{{ __('app.admin.notif_tag_admins') }}':'{{ __('app.admin.notif_tag_individual') }}'}
                        </span>
                    </div>
                    <div style="font-size:13px;font-weight:600;color:var(--text);margin-bottom:3px">${tituloMostrar}</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:2px;white-space:pre-wrap;line-height:1.5">${n.mensaje}</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;align-items:center">
                        ${remitenteHtml}
                        <span style="font-size:11px;color:var(--muted)">
                            ${new Date(n.created_at).toLocaleDateString('{{ app()->getLocale() }}-BO',{day:'2-digit',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'})}
                        </span>
                    </div>
                </div>
                <button onclick="notifEliminar(${n.id},this)"
                        style="background:none;border:none;cursor:pointer;color:#ef4444;
                               font-size:11px;font-weight:600;white-space:nowrap;margin-left:12px;flex-shrink:0">
                    {{ __('app.admin.eliminar') }}
                </button>
            </div>`;
        }).join('');
    }

    // ── Eliminar notificación ────────────────────────────────
    async function notifEliminar(id, btn) {
        if (!confirm('{{ __('app.admin.js_confirm_eliminar_notif') }}')) return;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const res   = await fetch(`/admin/notificaciones/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': token }
        });
        if (res.ok) btn.closest('div[style]').remove();
    }

    // Cargar historial al iniciar la vista
    if (document.getElementById('view-notificaciones')) {
        notifCargarHistorial();
    }
</script>