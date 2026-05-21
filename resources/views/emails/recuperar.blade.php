<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('app.recuperar.titulo') }}</title>
</head>

<body style="margin:0; background:#f3f4f6; font-family:Arial,sans-serif;">

<div style="max-width:520px; margin:60px auto; background:#fff; padding:30px; border-radius:14px; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

    <div style="font-size:18px; font-weight:700; color:#1f2937;">
        {{ __('app.recuperar.nombre_sistema') }}
    </div>

    <h2 style="margin-top:20px; font-size:24px; color:#111827;">
        {{ __('app.recuperar.encabezado') }}
    </h2>

    <p style="color:#6b7280; line-height:1.5;">
        {{ __('app.recuperar.saludo', ['nombre' => $usuario->nombre]) }}<br><br>
        {{ __('app.recuperar.cuerpo') }}
    </p>

    <div style="text-align:center; margin:30px 0;">
        <a href="{{ $enlace }}"
           style="background:#2563eb; color:#fff; padding:12px 22px;
                  border-radius:10px; text-decoration:none; font-weight:600;">
            {{ __('app.recuperar.boton_restablecer') }}
        </a>
    </div>

    <p style="font-size:12px; color:#9ca3af;">
        {{ __('app.recuperar.expiracion') }}
    </p>

</div>

</body>
</html>
