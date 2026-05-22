<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Services\Auth\RecuperacionService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Services\ActividadService;

class RecuperacionController extends Controller
{
    protected $service;

    public function __construct(RecuperacionService $service)
    {
        $this->service = $service;
    }

    /**
     *  Enviar correo
     */
    public function solicitarRecuperacion(Request $request)
    {
        try {
            Log::info(" Inicio recuperación", ['email' => $request->email]);

            $usuario = Usuario::where('email', $request->email)->first();

            if (!$usuario) {

                Log::warning(" Usuario no encontrado", ['email' => $request->email]);

                ActividadService::log(null, 'RECUPERACION_EMAIL_NO_EXISTE', [
                    'email' => $request->email
                ]);

                return response()->json([
                    'mensaje' => 'Correo no encontrado en el sistema'
                ], 404);
            }

            Log::info(" Usuario encontrado", ['id' => $usuario->id]);

            $token = $this->service->generarToken($usuario);

            Log::info(" Token generado", ['token' => $token]);

            $enlace = url('/?token=' . $token);

            Log::info(" Enlace generado", ['enlace' => $enlace]);

         /*   Mail::send('Emails.recuperar', [
                'usuario' => $usuario,
                'enlace' => $enlace
            ], function ($message) use ($usuario) {
                $message->to($usuario->email)
                        ->subject('Recuperar contraseña');
            });*/

            $html = view('Emails.recuperar', [
                'usuario' => $usuario,
                'enlace' => $enlace
            ])->render();

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => ['name' => 'Tu App', 'email' => env('MAIL_FROM_ADDRESS')],
                'to' => [['email' => $usuario->email]],
                'subject' => 'Recuperar contraseña',
                'htmlContent' => $html,
            ]);

            if (!$response->successful()) {
                throw new \Exception('Brevo error: ' . $response->body());
            }

            Log::info(" Mail::send ejecutado");
            
            ActividadService::log($usuario->id, 'SOLICITAR_RECUPERACION', [
                'email' => $usuario->email
            ]);

            return response()->json([
                'mensaje' => 'Correo enviado correctamente'
            ]);

        } catch (\Exception $e) {

            Log::error(" Error enviando correo", [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile()
            ]);

            ActividadService::log(null, 'ERROR_RECUPERACION', [
                'mensaje' => $e->getMessage()
            ]);

            return response()->json([
                'mensaje' => 'Error al enviar correo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     *  Cambiar contraseña
     */
    public function cambiarContrasena(Request $request)
    {
        $ok = $this->service->actualizarContrasena(
            $request->token,
            $request->contrasena
        );

        if (!$ok) {
            return response()->json([
                'mensaje' => 'Token inválido o expirado'
            ], 400);
        }

        return response()->json([
            'mensaje' => 'Contraseña actualizada correctamente'
        ]);
    }
}