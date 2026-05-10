<div id="loginModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/20 px-4 py-8 backdrop-blur-sm">
    <div class="relative w-full max-w-[440px] rounded-[40px] bg-white p-8 shadow-[0_30px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 sm:p-10">
        <button type="button" onclick="toggleModal()" class="absolute right-5 top-5 flex h-8 w-8 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>

        @if(session('cuenta_desactivada'))

            {{-- ===== PANTALLA DE REACTIVACIÓN ===== --}}
            <div class="flex flex-col items-center text-center">
                <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-[28px] bg-amber-50">
                    <svg width="40" height="40" fill="none" stroke="#d97706" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Cuenta desactivada</h2>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                    @if(session('motivo_desactivacion') === 'normas_inactividad')
                        Tu cuenta fue desactivada por no cumplir con las normas de la plataforma o por inactividad prolongada.<br>Si crees que esto es un error, contacta con soporte.
                    @else
                        Tu cuenta fue desactivada por ti mismo.<br>¿Deseas reactivarla y volver a entrar?
                    @endif
                </p>

                <form method="POST" action="{{ route('reactivar') }}" class="mt-7 w-full space-y-3">
                    @csrf
                    <button type="submit" class="w-full rounded-[28px] bg-gradient-to-r from-emerald-500 to-teal-500 px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition hover:opacity-95">
                        Sí, reactivar mi cuenta
                    </button>
                </form>

                <button type="button" onclick="toggleModal()" class="mt-3 text-sm text-slate-400 hover:text-slate-600 transition">
                    Cancelar
                </button>
            </div>

        @else

            {{-- ===== FORMULARIO NORMAL ===== --}}
            <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-[28px] bg-slate-100 shadow-sm">
                <img src="/images/logo.png" alt="Logo" class="h-12 w-12 object-contain" />
            </div>

            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Bienvenido de nuevo</h2>
                <p class="mt-3 text-sm text-slate-500">Inicia sesión para gestionar tu portafolio profesional digital.</p>
            </div>

            @php
                $emailInputClasses = 'rounded-[28px] border-2 border-slate-200 bg-white px-4 py-3 focus-within:border-sky-500';
                if ($errors->has('email')) {
                    $emailInputClasses = 'rounded-[28px] border-2 border-rose-500 bg-rose-50 px-4 py-3 focus-within:border-rose-500';
                } elseif (old('email')) {
                    $emailInputClasses = 'rounded-[28px] border-2 border-emerald-400 bg-emerald-50 px-4 py-3 focus-within:border-emerald-500';
                }

                $passwordInputClasses = 'rounded-[28px] border-2 border-slate-200 bg-white px-4 py-3 focus-within:border-sky-500';
                if ($errors->has('password')) {
                    $passwordInputClasses = 'rounded-[28px] border-2 border-rose-500 bg-rose-50 px-4 py-3 focus-within:border-rose-500';
                }
            @endphp

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label class="mb-3 block text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Correo electrónico</label>
                    <div class="{{ $emailInputClasses }}">
                        <input
                            id="input-email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="ejemplo@gmail.com"
                            class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400"
                            autocomplete="email"
                            required autofocus
                        />
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-3 block text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Contraseña</label>
                    <div class="{{ $passwordInputClasses }}">
                        <input
                            id="input-password"
                            type="password"
                            name="password"
                            placeholder="••••••••••••"
                            class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400"
                            autocomplete="current-password"
                            required
                        />
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm text-slate-500">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500" />
                        Recordar sesión
                    </label>
                    <a href="javascript:void(0)" onclick="abrirModalRecuperar()">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="w-full rounded-[28px] bg-gradient-to-r from-sky-600 to-blue-500 px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition hover:opacity-95">Entrar al sistema</button>

                <div class="flex items-center gap-3 text-xs text-slate-400">
                    <span class="h-px flex-1 bg-slate-200"></span>
                    <span>o</span>
                    <span class="h-px flex-1 bg-slate-200"></span>
                </div>

                <a href="{{ route('google.redirect') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-[28px] border border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Continuar con Google
                </a>

                <p class="text-center text-sm text-slate-500">¿No tienes cuenta?
                    <button type="button" onclick="toggleModal(); toggleRegister();" class="font-semibold text-slate-900 hover:text-sky-600 cursor-pointer">
                        Regístrate
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

    // Limpiar cada vez que el modal se hace visible (se quita la clase 'hidden')
    new MutationObserver(function (muts) {
        muts.forEach(function (m) {
            if (m.attributeName === 'class' && !modal.classList.contains('hidden')) {
                setTimeout(vaciarCampos, 0);
                setTimeout(vaciarCampos, 100);
                setTimeout(vaciarCampos, 300);
            }
        });
    }).observe(modal, { attributes: true });
})();
</script>
