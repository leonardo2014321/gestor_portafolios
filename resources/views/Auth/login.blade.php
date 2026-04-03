<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { min-height: 100vh; display: flex; overflow: hidden; }

        /* Panel izquierdo */
        .panel-izquierdo {
            position: relative;
            width: 42%;
            overflow: hidden;
        }
        .panel-izquierdo img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .panel-izquierdo .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.45);
        }
        .panel-izquierdo .contenido {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2.5rem;
            color: white;
        }
        .panel-izquierdo .frase {
            font-size: 1.5rem;
            font-weight: 800;
            font-style: italic;
            line-height: 1.3;
            margin-bottom: 0.75rem;
        }
        .panel-izquierdo .sub {
            font-size: 0.85rem;
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Panel derecho */
        .panel-derecho {
            width: 58%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #ddeeff 0%, #c5dff8 40%, #b8d4f0 70%, #cce8f4 100%);
            padding: 2rem;
            position: relative;
        }

        /* Formas geométricas de fondo */
        .panel-derecho::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.15);
            transform: rotate(45deg);
            border-radius: 30px;
        }
        .panel-derecho::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 250px;
            height: 250px;
            background: rgba(255,255,255,0.1);
            transform: rotate(30deg);
            border-radius: 20px;
        }

        .card-login {
            background: white;
            border-radius: 20px;
            padding: 2rem 2.25rem;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        .logo-umss {
            width: 55px;
            height: 55px;
            display: block;
            margin: 0 auto 0.25rem;
            object-fit: contain;
        }

        .avatar {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background-color: #90a4ae;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0.5rem auto 1rem;
        }
        .avatar svg {
            width: 42px;
            height: 42px;
            fill: #546e7a;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 0.3rem;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0.55rem 1rem;
            font-size: 0.9rem;
            background: #f9f9f9;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
            border-color: #3498db;
            background: white;
        }

        .btn-login {
            background: linear-gradient(90deg, #2980b9, #3498db);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.7rem;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            letter-spacing: 0.5px;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.9; color: white; }

        .btn-google {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 0.6rem;
            background: white;
            color: #555;
            width: 100%;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s;
            cursor: pointer;
        }
        .btn-google:hover { background: #f5f5f5; }

        .separador {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0.6rem 0;
        }
        .separador hr { flex: 1; border-color: #ddd; margin: 0; }
        .separador span { font-size: 0.8rem; color: #aaa; }

        .link-azul {
            color: #2980b9;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .link-azul:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .panel-izquierdo { display: none; }
            .panel-derecho { width: 100%; }
        }
    </style>
</head>
<body>

    {{-- Panel izquierdo --}}
    <div class="panel-izquierdo">
        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800" alt="fondo">
        <div class="overlay"></div>
        <div class="contenido">
            <p class="frase">"Crea, gestiona y comparte tu portafolio profesional"</p>
            <p class="sub">Impulsa tu carrera mostrando tus proyectos al mundo</p>
        </div>
    </div>

    {{-- Panel derecho --}}
    <div class="panel-derecho">
        <div class="card-login">

            {{-- Logo UMSS --}}
            <img
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/47/Escudo_UMSS.svg/200px-Escudo_UMSS.svg.png"
                alt="UMSS"
                class="logo-umss"
            >

            <h4 class="text-center fw-bold mb-0 mt-1">Bienvenido</h4>
            <p class="text-center text-muted mb-2" style="font-size: 0.85rem;">Inicia sesión</p>

            {{-- Avatar --}}
            <div class="avatar">
                <svg viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>

            @if (session('status'))
                <div class="alert alert-success py-2 small">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="ejemplo@gmail.com"
                        class="form-control @error('email') is-invalid @enderror"
                        required autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-1">
                    <label class="form-label">Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••••••"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Olvidaste contraseña --}}
                    <div class="text-start mb-2">
                    <a href="/recuperar-password" class="link-azul">¿Olvidaste tu contraseña?</a>
                </div>

                {{-- Recordar sesión --}}
                <div class="mb-3">
                    <label class="d-flex align-items-center gap-2 small text-muted" style="cursor:pointer;">
                        <input type="checkbox" name="remember" class="form-check-input mt-0">
                        Recordar sesión
                    </label>
                </div>

                {{-- Botón login --}}
                <button type="submit" class="btn-login mb-2">Iniciar sesión</button>

                {{-- Separador --}}
                <div class="separador">
                    <hr><span>o</span><hr>
                </div>

                <a href="{{ route('google.redirect') }}" class="btn-google mb-3 text-decoration-none">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                Continuar con Google
                </a>

                {{-- Registro --}}
                <p class="text-center small text-muted mb-0">
                    ¿No tienes cuenta?
                    <a href="#" class="link-azul fw-semibold">Regístrate</a>
                </p>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>