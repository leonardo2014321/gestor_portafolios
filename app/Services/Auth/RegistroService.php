<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificarEmailMail;

class RegistroService
{
    /**
     * Registrar usuario temporalmente y enviar correo de verificación
     */
    public function registrar($data)
    {
        // 1. Generar token único
        $token = Str::random(60);

        // 2. Guardar datos en cache por 24 horas
        Cache::put('registro_temp_'.$token, [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ], now()->addHours(24));

        // 3. Enviar correo de verificación
        $link = url("/verificar-email?token=$token");

        try {
            Log::info('Intentando enviar correo de verificación a ' . $data['email']);
            Mail::to($data['email'])->send(new VerificarEmailMail($link));
            Log::info('Correo de verificación enviado exitosamente a ' . $data['email']);
            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de verificación: ' . $e->getMessage(), [
                'email'   => $data['email'],
                'linea'   => $e->getLine(),
                'archivo' => $e->getFile(),
            ]);
            return false;
        }
    }
}
