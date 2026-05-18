<div id="loginModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/20 px-4 py-8 backdrop-blur-sm">
    <div class="relative w-full max-w-[440px] rounded-[40px] bg-white p-8 shadow-[0_30px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 sm:p-10 font-[Poppins]">

        {{-- Botón cerrar --}}
        <button type="button" onclick="toggleModal()" class="absolute right-5 top-5 flex h-8 w-8 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>

        @if(session('success_reactivacion'))
            {{-- ===== PANTALLA DE ÉXITO REACTIVACIÓN ===== --}}
            <div class="flex flex-col items-center text-center">
                <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-[28px] bg-emerald-50">
                    <svg width="40" height="40" fill="none" stroke="#10b981" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('app.login.reactivacion_titulo') }}</h2>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                   {{ __('app.login.reactivacion_desc') }}
                </p>
                <button type="button" onclick="toggleModal()" class="mt-7 w-full rounded-[28px] bg-blue-600 hover:bg-blue-700 px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition">
                    {{ __('app.login.reactivacion_btn') }}
                </button>
            </div>

        @elseif(session('cuenta_desactivada'))
            {{-- ===== PANTALLA DE REACTIVACIÓN ===== --}}
            <div class="flex flex-col items-center text-center">
                <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-[28px] bg-amber-50">
                    <svg width="40" height="40" fill="none" stroke="#d97706" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('app.login.cuenta_desactivada') }}</h2>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                    @if(session('motivo_desactivacion') === 'normas_inactividad')
                        {!! __('app.login.desactivada_normas') !!}
                    @else
                        {!! __('app.login.desactivada_desc') !!}
                    @endif
                </p>
                <form method="POST" action="{{ route('reactivar') }}" class="mt-7 w-full space-y-3">
                    @csrf
                    <button type="submit" class="w-full rounded-[28px] bg-emerald-500 hover:bg-emerald-600 px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition">
                        {{ __('app.login.btn_solicitar_reactivacion') }}
                    </button>
                </form>
                <button type="button" onclick="toggleModal()" class="mt-3 text-sm text-slate-400 hover:text-slate-600 transition">
                    {{ __('app.login.cancelar') }}
                </button>
            </div>

        @else
            {{-- ===== FORMULARIO NORMAL ===== --}}

            {{-- Icono + encabezado --}}
            <div class="mb-7 flex flex-col items-center text-center">
                <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-[22px] bg-blue-50 shadow-sm ring-1 ring-blue-100">
                    <img src="/images/logo.png" alt="Logo" class="h-10 w-10 object-contain" />
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('app.login.bienvenido') }}</h2>
                <p class="mt-1.5 text-sm text-slate-500">{{ __('app.login.subtitulo') }}</p>
            </div>

            @php
                $emailWrapBase   = 'rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all';
                $emailWrapClass  = $errors->has('email')
                    ? 'rounded-2xl border border-rose-400 bg-rose-50 px-4 py-3 ring-3 ring-rose-100'
                    : (old('email') ? 'rounded-2xl border border-emerald-400 bg-emerald-50 px-4 py-3 ring-3 ring-emerald-100' : $emailWrapBase);

                $passWrapBase   = 'rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 flex items-center gap-2 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all';
                $passWrapClass  = $errors->has('password')
                    ? 'rounded-2xl border border-rose-400 bg-rose-50 px-4 py-3 flex items-center gap-2 ring-3 ring-rose-100'
                    : $passWrapBase;
            @endphp

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="mb-2 flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 7 10-7"/></svg>
                        {{ __('app.login.correo') }}
                    </label>
                    <div id="login-email-wrap" class="{{ $emailWrapClass }}">
                        <input
                            id="input-email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('app.login.tu_correo') }}"
                            class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400"
                            autocomplete="email"
                            required autofocus
                        />
                    </div>
                    @error('email')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-500">
                            <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-9.25a.75.75 0 011.5 0v3a.75.75 0 01-1.5 0v-3zm.75 6.5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p id="login-email-feedback" class="mt-1.5 text-xs hidden"></p>
                </div>

                {{-- Contraseña --}}
                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            {{ __('app.login.password') }}
                        </label>
                        <a href="javascript:void(0)" onclick="abrirModalRecuperar()" class="text-xs font-medium text-blue-600 hover:text-blue-700 transition">
                            {{ __('app.login.olvidaste') }}
                        </a>
                    </div>
                    <div class="{{ $passWrapClass }}">
                        <input
                            id="input-password"
                            type="password"
                            name="password"
                            placeholder="{{ __('app.login.placeholder_password') }}"
                            class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400"
                            autocomplete="current-password"
                            required
                        />
                        <button type="button" onclick="toggleLoginPassword()" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition" tabindex="-1">
                            <svg id="login-eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-500">
                            <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-9.25a.75.75 0 011.5 0v3a.75.75 0 01-1.5 0v-3zm.75 6.5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Recordarme --}}
                <div class="flex items-center gap-2 pt-0.5">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 accent-blue-600" />
                    <label for="remember" class="text-sm text-slate-500 cursor-pointer select-none">{{ __('app.login.recordar') }}</label>
                </div>

                <div id="loginMensaje"></div>

                {{-- Botón principal --}}
                <button id="btnLogin" type="submit" class="relative w-full rounded-2xl bg-blue-600 hover:bg-blue-700 px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-blue-500/25 transition-all active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed">
                    <span id="btnLoginText">{{ __('app.login.btn_entrar') }}</span>
                    <span id="btnLoginLoading" class="hidden absolute inset-0 flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        {{ __('app.login.iniciando_sesion') }}
                    </span>
                </button>

                {{-- Divisor --}}
                <div class="flex items-center gap-3 text-xs text-slate-400">
                    <span class="h-px flex-1 bg-slate-200"></span>
                    <span>{{ __('app.login.o_continua_con') }}</span>
                    <span class="h-px flex-1 bg-slate-200"></span>
                </div>

                {{-- Google --}}
                <a href="{{ route('google.redirect') }}" class="inline-flex w-full items-center justify-center gap-2.5 rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 hover:border-slate-300 active:scale-[0.98]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    {{ __('app.login.google') }}
                </a>

                <p class="text-center text-sm text-slate-500">
                    {{ __('app.login.sin_cuenta') }}
                    <button type="button" onclick="toggleModal(); toggleRegister();" class="font-semibold text-blue-600 hover:text-blue-700 cursor-pointer transition">
                        {{ __('app.login.registrate') }}
                    </button>
                </p>
            </form>
        @endif

    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('loginModal');
    if (!modal) return;

    function vaciarCampos() {
        var e = document.getElementById('input-email');
        var p = document.getElementById('input-password');
        if (e) e.value = '';
        if (p) p.value = '';
    }

    new MutationObserver(function (muts) {
        muts.forEach(function (m) {
            if (m.attributeName === 'class' && !modal.classList.contains('hidden')) {
                setTimeout(vaciarCampos, 0);
                setTimeout(vaciarCampos, 100);
                setTimeout(vaciarCampos, 300);
            }
        });
    }).observe(modal, { attributes: true });

    /* ── Ojito contraseña ── */
    window.toggleLoginPassword = function () {
        var input = document.getElementById('input-password');
        var icon  = document.getElementById('login-eye-icon');
        if (!input) return;
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.innerHTML = show
            ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
            : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
    };

    /* ── Validación en vivo del email ── */
    var emailInput    = document.getElementById('input-email');
    var emailWrap     = document.getElementById('login-email-wrap');
    var emailFeedback = document.getElementById('login-email-feedback');
    var baseWrap      = 'rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-3 focus-within:ring-blue-100 transition-all';
    if (emailInput && emailWrap && emailFeedback) {
        emailInput.addEventListener('input', function () {
            var val    = this.value.trim();
            var valido = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[A-Za-z]{2,})+$/.test(val);
            if (val === '') {
                emailWrap.className = baseWrap;
                emailFeedback.classList.add('hidden');
                return;
            }
            if (valido) {
                emailWrap.className = 'rounded-2xl border border-emerald-400 bg-emerald-50 px-4 py-3 ring-3 ring-emerald-100 transition-all';
                emailFeedback.innerHTML = '<span class="flex items-center gap-1 text-emerald-600 font-semibold"><svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Correo válido</span>';
                emailFeedback.classList.remove('hidden');
            } else {
                emailWrap.className = 'rounded-2xl border border-rose-400 bg-rose-50 px-4 py-3 ring-3 ring-rose-100 transition-all';
                emailFeedback.innerHTML = '<span class="flex items-center gap-1 text-rose-500 font-semibold"><svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>Formato inválido</span>';
                emailFeedback.classList.remove('hidden');
            }
        });
    }

    /* ── Loading al hacer submit ── */
    var loginForm = document.querySelector('#loginModal form[action]');
    if (loginForm) {
        loginForm.addEventListener('submit', function () {
            var btn    = document.getElementById('btnLogin');
            var txtEl  = document.getElementById('btnLoginText');
            var loadEl = document.getElementById('btnLoginLoading');
            if (!btn || !txtEl || !loadEl) return;
            btn.disabled = true;
            txtEl.classList.add('invisible');
            loadEl.classList.remove('hidden');
        });
    }
})();
</script>