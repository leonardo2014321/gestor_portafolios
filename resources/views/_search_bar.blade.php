{{-- ============================================================
     _search_bar.blade.php
     Uso: @include('_search_bar', [
              'placeholder' => 'Buscar portafolios...',
              'searchRoute'  => 'portafolios.index',   // opcional
              'inputName'    => 'q',                   // opcional
              'liveSearch'   => true,                  // busca en DOM sin reload
          ])
     ============================================================ --}}

@php
    $placeholder = $placeholder ?? __('app.menu.buscar_placeholder');
    $inputName   = $inputName   ?? 'q';
    $searchRoute = $searchRoute ?? null;
    $liveSearch  = $liveSearch  ?? true;   // true = filtra el DOM local; false = hace submit al servidor
    $searchId    = 'porta-search-' . uniqid();  // permite múltiples instancias en la misma página
@endphp
 
<div class="psearch-wrap" id="{{ $searchId }}-wrap">
 
    @if(!$liveSearch && $searchRoute)
        <form action="{{ route($searchRoute) }}" method="GET" role="search" class="psearch-form">
    @else
        <div class="psearch-form">
    @endif
 
        {{-- Icono lupa --}}
        <span class="psearch-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.3"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </span>
 
        <input
            id="{{ $searchId }}"
            type="search"
            name="{{ $inputName }}"
            value="{{ request($inputName) }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            class="psearch-input"
            aria-label="{{ $placeholder }}"
            @if($liveSearch) data-live-search="true" data-target="porta-grid" @endif
        >
 
        {{-- Spinner (visible solo mientras debounce está activo en live search) --}}
        @if($liveSearch)
            <span class="psearch-spinner" id="{{ $searchId }}-spinner" aria-hidden="true"></span>
            <button type="button" class="psearch-clear" id="{{ $searchId }}-clear"
                    aria-label="Limpiar búsqueda" style="display:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        @else
            <button type="submit" class="psearch-submit" aria-label="Buscar">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </button>
        @endif
 
    @if(!$liveSearch && $searchRoute)
        </form>
    @else
        </div>
    @endif
 
    {{-- Mensaje "sin resultados" solo en modo live --}}
    @if($liveSearch)
        <p class="psearch-no-results" id="{{ $searchId }}-noresults" style="display:none;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                <line x1="8" y1="11" x2="14" y2="11"/>
            </svg>
            Sin resultados para "<strong id="{{ $searchId }}-query"></strong>"
        </p>
    @endif
</div>
 
<style>
.psearch-wrap {
    margin-bottom: 1.2rem;
}
 
.psearch-form {
    position: relative;
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 1px 6px rgba(0,0,0,.05);
    transition: border-color .2s, box-shadow .2s;
    overflow: hidden;
}
.psearch-form:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,.12), 0 2px 10px rgba(0,0,0,.06);
}
 
.psearch-icon {
    display: flex;
    align-items: center;
    padding: 0 12px 0 16px;
    color: #94a3b8;
    flex-shrink: 0;
    transition: color .2s;
}
.psearch-form:focus-within .psearch-icon {
    color: #3b82f6;
}
 
.psearch-input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 13.5px;
    font-family: 'DM Sans', sans-serif;
    color: #1e293b;
    padding: 11px 0;
    min-width: 0;
}
.psearch-input::placeholder {
    color: #cbd5e1;
}
/* Quitar el botón nativo de limpiado en Safari/Chrome */
.psearch-input::-webkit-search-cancel-button { display: none; }
 
/* Botón limpiar (×) */
.psearch-clear {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #f1f5f9;
    border: none;
    cursor: pointer;
    color: #64748b;
    margin-right: 6px;
    flex-shrink: 0;
    transition: background .15s, color .15s;
}
.psearch-clear:hover {
    background: #e2e8f0;
    color: #1e293b;
}
 
/* Botón submit (modo servidor) */
.psearch-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 16px;
    height: 100%;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border: none;
    color: #fff;
    cursor: pointer;
    border-radius: 0 14px 14px 0;
    transition: background .2s;
}
.psearch-submit:hover {
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
}
 
/* Spinner */
.psearch-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid #e2e8f0;
    border-top-color: #3b82f6;
    border-radius: 50%;
    animation: psearch-spin .6s linear infinite;
    margin-right: 10px;
    flex-shrink: 0;
    display: none;
}
@keyframes psearch-spin {
    to { transform: rotate(360deg); }
}
 
/* Sin resultados */
.psearch-no-results {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12.5px;
    color: #94a3b8;
    margin-top: 10px;
    font-family: 'DM Sans', sans-serif;
}
.psearch-no-results svg { flex-shrink: 0; }
.psearch-no-results strong { color: #475569; }
</style>
 
@if($liveSearch)
<script>
(function () {
    const searchId  = '{{ $searchId }}';
    const input     = document.getElementById(searchId);
    const clearBtn  = document.getElementById(searchId + '-clear');
    const spinner   = document.getElementById(searchId + '-spinner');
    const noResults = document.getElementById(searchId + '-noresults');
    const querySpan = document.getElementById(searchId + '-query');
 
    if (!input) return;
 
    let debounceTimer;
 
    function applySearch(query) {
        // Escribe en el estado compartido con el filtro de categorías
        if (window.portaGridState) {
            window.portaGridState.searchQuery = query;
        }
 
        // Delega el render a la función central si existe, si no filtra solo
        let visible = 0;
        if (typeof window.portaApplyFilters === 'function') {
            visible = window.portaApplyFilters();
        } else {
            // Fallback: el buscador actúa solo (sin filtro de categorías activo)
            const targetId = input.dataset.target ?? 'porta-grid';
            const grid = document.getElementById(targetId);
            if (!grid) return;
            const q = query.trim().toLowerCase();
            grid.querySelectorAll('.porta-card').forEach(card => {
                const match = !q || card.textContent.toLowerCase().includes(q);
                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });
        }
 
        // Feedback sin resultados
        if (noResults && querySpan) {
            const q = query.trim();
            if (q && visible === 0) {
                querySpan.textContent = q;
                noResults.style.display = 'flex';
            } else {
                noResults.style.display = 'none';
            }
        }
    }
 
    input.addEventListener('input', function () {
        const val = this.value;
 
        if (clearBtn) clearBtn.style.display = val ? 'flex' : 'none';
        if (spinner)  spinner.style.display  = val ? 'block' : 'none';
 
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            if (spinner) spinner.style.display = 'none';
            applySearch(val);
        }, 280);
    });
 
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            input.value = '';
            this.style.display = 'none';
            if (spinner)  spinner.style.display  = 'none';
            if (noResults) noResults.style.display = 'none';
            applySearch('');
            input.focus();
        });
    }
 
    // Si llega con ?q= pre-rellenado, aplicar al cargar
    if (input.value) {
        applySearch(input.value);
        if (clearBtn) clearBtn.style.display = 'flex';
    }
})();
</script>
@endif
 