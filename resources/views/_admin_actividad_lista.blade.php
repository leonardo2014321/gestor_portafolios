@forelse($actividades_recientes as $act)
    @php
        $titulo = __('app.admin.act_accion') . ': ' . $act->accion;
        $iconClass = "icon-purple";
        $svg = '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>';

        switch($act->accion) {
            case 'login':
                $titulo = __('app.admin.act_login');
                $iconClass = "icon-teal";
                $svg = '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>';
                break;
            case 'logout':
                $titulo = __('app.admin.act_logout');
                $iconClass = "icon-rose";
                $svg = '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>';
                break;
            case 'registro_usuario':
                $titulo = __('app.admin.act_registro_usuario');
                $iconClass = "icon-purple";
                $svg = '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>';
                break;
            case 'PASSWORD_ACTUALIZADO':
                $titulo = __('app.admin.act_password_actualizado');
                $iconClass = "icon-teal";
                $svg = '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>';
                break;
            case 'SOLICITAR_RECUPERACION':
                $titulo = __('app.admin.act_solicitar_recuperacion');
                $iconClass = "icon-blue";
                $svg = '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>';
                break;
            case 'reactivacion_cuenta':
                $titulo = __('app.admin.act_reactivacion_cuenta');
                $iconClass = "icon-teal";
                $svg = '<path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>';
                break;
            case 'SOLICITUD_REGISTRO':
                $titulo = __('app.admin.act_solicitud_registro');
                $iconClass = "icon-purple";
                $svg = '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>';
                break;
            case 'RECUPERACION_EMAIL_NO_EXISTE':
                $titulo = __('app.admin.act_email_no_existe');
                $iconClass = "icon-rose";
                $svg = '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>';
                break;
            case 'TOKEN_INVALIDO':
                $titulo = __('app.admin.act_token_invalido');
                $iconClass = "icon-rose";
                $svg = '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
                break;
            case 'ERROR_RECUPERACION':
                $titulo = __('app.admin.act_error_recuperacion');
                $iconClass = "icon-rose";
                $svg = '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>';
                break;
            case 'PERFIL_ACTUALIZADO':
                $titulo = __('app.admin.act_perfil_actualizado');
                $iconClass = "icon-blue";
                $svg = '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>';
                break;
            case 'CUENTA_DESACTIVADA':
                $titulo = __('app.admin.act_cuenta_desactivada');
                $iconClass = "icon-rose";
                $svg = '<path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/>';
                break;
        }
    @endphp
    <div class="act-item" style="padding: 1rem; gap: 10px;">
        <div class="act-icon {{ $iconClass }}" style="width: 32px; height: 32px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $svg !!}</svg>
        </div>
        <div class="act-content">
            <div class="act-title" style="font-size: 12px;">
                {{ $titulo }} <br>
                <span>{{ $act->usuario ? $act->usuario->nombre . ' ' . $act->usuario->apellido : __('app.admin.act_sistema_invitado') }}</span>
            </div>
            <div class="act-time" style="font-size: 10px;">{{ $act->created_at ? $act->created_at->diffForHumans() : __('app.admin.act_recientemente') }}</div>
        </div>
    </div>
@empty
    <div style="padding: 2rem; text-align: center; color: var(--muted); font-size: 13px;">
        {{ __('app.admin.empty_actividad') }}
    </div>
@endforelse

