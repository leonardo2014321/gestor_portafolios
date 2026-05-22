<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Mail\VerificarEmailMail;

class RegistroService
{
    public function registrar($data)
    {
        $token = Str::random(60);

        Cache::put('registro_temp_'.$token, [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ], now()->addHours(24));

        $link = url("/verificar-email?token=$token");

        try {
            $html = (new VerificarEmailMail($link))->render();

            $response = Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => ['name' => 'Tu App', 'email' => env('MAIL_FROM_ADDRESS')],
                'to' => [['email' => $data['email']]],
                'subject' => 'Verifica tu correo',
                'htmlContent' => $html,
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            return false;
        }
    }
}