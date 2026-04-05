<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    Mail::send('emails.verificar', ['link' => $link], function($message) use ($data) {
        $message->to($data['email'])->subject('Verifica tu cuenta');
    });


        return true;
    }
}