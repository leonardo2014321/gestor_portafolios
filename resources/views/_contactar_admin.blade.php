{{-- ============================================================
     _contactar_admin.blade.php
     Partial: modal + botón "Ayuda / Contactar al admin"
     Uso: reemplaza el enlace Ayuda en menu.blade.php
     ============================================================ --}}

{{-- ── Botón Ayuda (reemplaza el <a href="#"> de ayuda) ─────── --}}
<a href="#" class="enlace" onclick="abrirContactarAdmin(event)">
    <div class="en-ico gray">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.82 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <div class="en-lbl">{{ __('app.menu.ayuda') }}</div>
</a>

{{-- ── Modal contactar admin ────────────────────────────────── --}}
<div id="modal-contactar-admin"
     style="display:none;position:fixed;inset:0;z-index:9999;
            background:rgba(15,23,42,0.55);backdrop-filter:blur(4px);
            align-items:center;justify-content:center;">

    <div style="background:#fff;border-radius:20px;padding:2rem;
                width:480px;max-width:92vw;box-shadow:0 24px 64px rgba(0,0,0,0.18);
                animation:fadeInScale .18s ease;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem">
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:38px;height:38px;border-radius:12px;background:#eff6ff;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:#2563eb;stroke-width:2;stroke-linecap:round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:16px;font-weight:800;color:#0f172a;font-family:'Plus Jakarta Sans',sans-serif">
                        Contactar al administrador
                    </div>
                    <div style="font-size:12px;color:#64748b;margin-top:1px">Tu mensaje llegará directamente al admin</div>
                </div>
            </div>
            <button onclick="cerrarContactarAdmin()"
                    style="background:none;border:none;cursor:pointer;color:#94a3b8;
                           font-size:22px;line-height:1;padding:4px">×</button>
        </div>

        {{-- Alerta éxito --}}
        <div id="contactar-success"
             style="display:none;background:#d1fae5;color:#065f46;padding:10px 14px;
                    border-radius:10px;font-size:13px;margin-bottom:1rem;font-weight:600">
            ✓ Mensaje enviado correctamente. El administrador lo recibirá pronto.
        </div>

        {{-- Alerta error --}}
        <div id="contactar-error"
             style="display:none;background:#fee2e2;color:#991b1b;padding:10px 14px;
                    border-radius:10px;font-size:13px;margin-bottom:1rem;font-weight:600">
        </div>

        {{-- Asunto --}}
        <div style="margin-bottom:1rem">
            <label style="display:block;font-size:11px;font-weight:700;color:#64748b;
                          margin-bottom:6px;text-transform:uppercase;letter-spacing:.06em">
                Asunto <span style="color:#ef4444">*</span>
            </label>
            <input id="contactar-asunto" type="text" maxlength="150"
                   placeholder="¿En qué necesitas ayuda?"
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;
                          border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;
                          outline:none;color:#0f172a;box-sizing:border-box;transition:border-color .2s"
                   onfocus="this.style.borderColor='#2563eb'"
                   onblur="this.style.borderColor='#e2e8f0'">
        </div>

        {{-- Mensaje --}}
        <div style="margin-bottom:1.2rem">
            <label style="display:block;font-size:11px;font-weight:700;color:#64748b;
                          margin-bottom:6px;text-transform:uppercase;letter-spacing:.06em">
                Mensaje <span style="color:#ef4444">*</span>
            </label>
            <textarea id="contactar-mensaje" maxlength="1000" rows="5"
                      placeholder="Describe tu consulta o problema con detalle..."
                      style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;
                             border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;
                             outline:none;color:#0f172a;resize:vertical;box-sizing:border-box;
                             transition:border-color .2s"
                      onfocus="this.style.borderColor='#2563eb'"
                      onblur="this.style.borderColor='#e2e8f0'"
                      oninput="document.getElementById('contactar-count').textContent=this.value.length"></textarea>
            <div style="text-align:right;font-size:11px;color:#94a3b8;margin-top:3px">
                <span id="contactar-count">0</span>/1000
            </div>
        </div>

        {{-- Botones --}}
        <div style="display:flex;gap:10px;justify-content:flex-end">
            <button onclick="cerrarContactarAdmin()"
                    style="padding:10px 20px;border-radius:10px;border:1.5px solid #e2e8f0;
                           background:#fff;font-size:13px;font-weight:600;color:#64748b;
                           cursor:pointer;font-family:'DM Sans',sans-serif">
                Cancelar
            </button>
            <button id="btn-contactar-enviar" onclick="contactarAdminEnviar()"
                    style="padding:10px 22px;border-radius:10px;border:none;
                           background:linear-gradient(135deg,#2563eb,#1d4ed8);
                           color:#fff;font-size:13px;font-weight:700;cursor:pointer;
                           font-family:'DM Sans',sans-serif;
                           box-shadow:0 4px 14px rgba(37,99,235,0.3);
                           display:inline-flex;align-items:center;gap:8px">
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
                Enviar mensaje
            </button>
        </div>
    </div>
</div>

<script>
    function abrirContactarAdmin(e) {
        e.preventDefault();
        document.getElementById('contactar-asunto').value  = '';
        document.getElementById('contactar-mensaje').value = '';
        document.getElementById('contactar-count').textContent = '0';
        document.getElementById('contactar-success').style.display = 'none';
        document.getElementById('contactar-error').style.display   = 'none';
        document.getElementById('modal-contactar-admin').style.display = 'flex';
    }

    function cerrarContactarAdmin() {
        document.getElementById('modal-contactar-admin').style.display = 'none';
    }

    // Cerrar al hacer clic en el fondo oscuro
    document.getElementById('modal-contactar-admin').addEventListener('click', function(e) {
        if (e.target === this) cerrarContactarAdmin();
    });

    async function contactarAdminEnviar() {
        const asunto  = document.getElementById('contactar-asunto').value.trim();
        const mensaje = document.getElementById('contactar-mensaje').value.trim();
        const errBox  = document.getElementById('contactar-error');

        errBox.style.display = 'none';

        if (!asunto || !mensaje) {
            errBox.textContent = 'Por favor completa el asunto y el mensaje.';
            errBox.style.display = 'block';
            return;
        }

        // Feedback visual en botón
        const btn = document.getElementById('btn-contactar-enviar');
        const textoOriginal = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;
                 stroke-width:2;stroke-linecap:round;animation:spin 1s linear infinite">
                <circle cx="12" cy="12" r="10" stroke-opacity="0.3"/>
                <path d="M12 2a10 10 0 0 1 10 10"/>
            </svg>
            Enviando...`;

        try {
            const res = await fetch('/contactar-admin', {
                method:  'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                },
                body: JSON.stringify({ titulo: asunto, mensaje }),
            });

            const json = await res.json().catch(() => ({}));

            if (res.ok) {
                document.getElementById('contactar-success').style.display = 'block';
                document.getElementById('contactar-asunto').value  = '';
                document.getElementById('contactar-mensaje').value = '';
                document.getElementById('contactar-count').textContent = '0';
                // Cerrar el modal después de 2 segundos
                setTimeout(cerrarContactarAdmin, 2000);
            } else {
                errBox.textContent = json.error || 'Ocurrió un error. Intenta de nuevo.';
                errBox.style.display = 'block';
            }
        } catch (e) {
            errBox.textContent = 'Error de conexión. Revisa tu internet e intenta de nuevo.';
            errBox.style.display = 'block';
        } finally {
            btn.disabled = false;
            btn.innerHTML = textoOriginal;
        }
    }
</script>