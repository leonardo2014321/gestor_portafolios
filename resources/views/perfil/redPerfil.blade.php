<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-lg p-4" style="width: 500px; border-radius: 15px;">

        <h5 class="mb-4 fw-bold">Vincular Redes</h5>

        <!-- 🔔 MENSAJE -->
        <div id="mensajeRedes"></div>

        <!-- LinkedIn -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-linkedin fs-4"></i>
                    <span class="fw-semibold">LinkedIn</span>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted">VISIBLE</small>
                    <input type="checkbox" id="linkedin_visible" class="form-check-input">
                </div>
            </div>

            <input type="text"
                   id="linkedin_url"
                   class="form-control mt-2"
                   placeholder="https://linkedin.com/in/tuusuario">

            <!-- 🔗 LINK -->
            <a id="linkedin_link"
               target="_blank"
               class="d-block mt-2 small fw-semibold text-decoration-underline text-primary"
               style="cursor:pointer;">
            </a>
        </div>

        <!-- GitHub -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-github fs-4"></i>
                    <span class="fw-semibold">GitHub</span>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted">VISIBLE</small>
                    <input type="checkbox" id="github_visible" class="form-check-input">
                </div>
            </div>

            <input type="text"
                   id="github_url"
                   class="form-control mt-2"
                   placeholder="https://github.com/usuario">

            <!-- 🔗 LINK -->
            <a id="github_link"
               target="_blank"
               class="d-block mt-2 small fw-semibold text-decoration-underline text-primary"
               style="cursor:pointer;">
            </a>
        </div>

        <div class="alert alert-info small">
            Vincular cuentas te permite sincronizar tu historial profesional.
        </div>

        <button id="btnGuardar" class="btn btn-primary w-100 mt-2" onclick="guardarRedes()">
            Guardar Cambios
        </button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
   cargarRedes();
   activarPreviewTiempoReal();
});

function cargarRedes() {
    fetch('/perfil/redes')
        .then(res => res.json())
        .then(data => {

            data.forEach(red => {

                if (red.tipo === 'linkedin') {
                    document.getElementById('linkedin_url').value = red.url ?? '';
                    document.getElementById('linkedin_visible').checked = red.visible;

                    actualizarLink('linkedin_link', red.url);
                }

                if (red.tipo === 'github') {
                    document.getElementById('github_url').value = red.url ?? '';
                    document.getElementById('github_visible').checked = red.visible;

                    actualizarLink('github_link', red.url);
                }

            });

        })
        .catch(err => {
            console.error(err);
            mostrarMensaje('Error al cargar redes', 'danger');
        });
}

function guardarRedes() {

    const btn = document.getElementById('btnGuardar');
    btn.disabled = true;
    btn.innerText = 'Guardando...';

    const redes = [
        {
            tipo: 'linkedin',
            url: document.getElementById('linkedin_url').value,
            visible: document.getElementById('linkedin_visible').checked
        },
        {
            tipo: 'github',
            url: document.getElementById('github_url').value,
            visible: document.getElementById('github_visible').checked
        }
    ];

    fetch('/perfil/redes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ redes })
    })
    .then(res => res.json())
    .then(data => {
        mostrarMensaje(data.mensaje, 'success');
    })
    .catch(err => {
        console.error(err);
        mostrarMensaje('Error al guardar', 'danger');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerText = 'Guardar Cambios';
    });
}

/* 🔥 FIX REAL DEL CLICK */
function actualizarLink(id, url) {
    const link = document.getElementById(id);

    if (!url || url.trim() === '') {
        link.style.display = 'none';
        return;
    }

    if (!url.startsWith('http://') && !url.startsWith('https://')) {
        url = 'https://' + url;
    }

    link.href = url;
    link.innerText = "🔗 " + url;
    link.style.display = 'block';
}

/* ⚡ TIEMPO REAL */
function activarPreviewTiempoReal() {
    document.getElementById('linkedin_url').addEventListener('input', e => {
        actualizarLink('linkedin_link', e.target.value);
    });

    document.getElementById('github_url').addEventListener('input', e => {
        actualizarLink('github_link', e.target.value);
    });
}

/* 🔔 MENSAJE */
function mostrarMensaje(texto, tipo) {
    const contenedor = document.getElementById('mensajeRedes');

    contenedor.innerHTML = `
        <div class="alert alert-${tipo} alert-dismissible fade show">
            ${texto}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    setTimeout(() => {
        contenedor.innerHTML = '';
    }, 3000);
}
</script>
@endpush