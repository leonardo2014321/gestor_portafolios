<div id="loginModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/20 px-4 py-8 backdrop-blur-sm">
    <div class="w-full max-w-[440px] rounded-[40px] bg-white p-8 shadow-[0_30px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 sm:p-10">
        <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-[28px] bg-slate-100 shadow-sm">
            <img src="/images/logo.png" alt="Logo" class="h-12 w-12 object-contain" />
        </div>

        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Bienvenido de nuevo</h2>
            <p class="mt-3 text-sm text-slate-500">Inicia sesión para gestionar tu portafolio profesional digital.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
            @csrf

            <div>
                <label class="mb-3 block text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Correo electrónico</label>
                <div class="rounded-[28px] border-2 border-emerald-400/70 bg-emerald-50 px-4 py-3 focus-within:border-emerald-500">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="ejemplo@gmail.com"
                        class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400"
                        required autofocus
                    />
                </div>
                @error('email')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-3 block text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Contraseña</label>
                <div class="rounded-[28px] border-2 border-emerald-400/70 bg-emerald-50 px-4 py-3 focus-within:border-emerald-500">
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••••••"
                        class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400"
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
                <a href="/recuperar-password" class="font-semibold text-slate-700 hover:text-sky-600">¿Olvidaste tu contraseña?</a>
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
    </div>
</div>
