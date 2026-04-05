<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Recuperar contraseña</title>
</head>

<body style="margin:0; background:#f3f4f6; font-family:Arial,sans-serif;">

<!--
    Plantilla de correo para recuperación de contraseña.
    Envía un enlace seguro al usuario para restablecer su acceso al sistema.
-->

<div style="max-width:520px; margin:60px auto; background:#fff; padding:30px; border-radius:14px; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

    <!-- Nombre del sistema -->
    <div style="font-size:18px; font-weight:700; color:#1f2937;">
        SansiFolios
    </div>

    <!-- Título del correo -->
    <h2 style="margin-top:20px; font-size:24px; color:#111827;">
        Recupera tu acceso
    </h2>

    <!-- Mensaje al usuario -->
    <p style="color:#6b7280; line-height:1.5;">
        Hola {{ $usuario->nombre }},<br><br>
        Te enviamos un enlace para restablecer tu contraseña.
    </p>

    <!-- Botón de recuperación -->
    <div style="text-align:center; margin:30px 0;">
        <a href="{{ $enlace }}"
           style="background:#2563eb; color:#fff; padding:12px 22px;
                  border-radius:10px; text-decoration:none; font-weight:600;">
            Restablecer contraseña →
        </a>
    </div>

    <!-- Información de expiración -->
    <p style="font-size:12px; color:#9ca3af;">
        Este enlace expira en 2 horas.
    </p>

</div>

</body>
</html>