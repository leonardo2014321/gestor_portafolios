<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial; text-align:center; padding:20px;">

    <h2>{{ __('app.verificar.titulo') }}</h2>

    <p>{{ __('app.verificar.instruccion') }}</p>

    <a href="{{ $link }}"
       style="background:#2563eb;color:white;padding:12px 20px;
       text-decoration:none;border-radius:6px;display:inline-block;">
        {{ __('app.verificar.boton_verificar') }}
    </a>

    <p style="margin-top:20px;font-size:12px;color:gray;">
        {{ __('app.verificar.expiracion') }}
    </p>

</body>
</html>