<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\RegistroService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use App\Models\Usuario;
use App\Services\ActividadService;

class RegistroController extends Controller
{
    protected $service;

    public function __construct(RegistroService $service)
    {
        $this->service = $service;
    }

    // Mostrar formulario
    public function show()
    {
        return view('auth.registro');
    }

    // Procesar registro
    public function register(Request $request)
    {
        try {

            $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'nullable|string|max:100',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|min:8|confirmed'
            ], [
                'email.unique' => 'Este correo ya está registrado',
                'email.required' => 'El correo es obligatorio'
            ]);

            // 🔍 Validar dominio
            $email = $request->email;
            $domain = explode('@', $email)[1] ?? null;

            if (!$domain || !checkdnsrr($domain, 'MX')) {

                // 👇 SI ES FETCH (AJAX)
                if ($request->expectsJson()) {
                    return response()->json([
                        'errors' => [
                            'email' => ['El dominio del correo no existe']
                        ]
                    ], 422);
                }

                return back()->withErrors([
                    'email' => 'El dominio del correo no existe'
                ]);
            }

            // ✅ Registrar
            $enviado = $this->service->registrar(
                $request->only('nombre', 'apellido', 'email', 'password')
            );

            if (!$enviado) {
                return response()->json([
                    'errors' => [
                        'email' => ['No se pudo enviar el correo de verificación']
                    ]
                ], 422);
            }

            ActividadService::log(null, 'SOLICITUD_REGISTRO', ['email' => $request->email]);

            // 👇 RESPUESTA PARA FETCH
            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Registro exitoso'
                ]);
            }

            return redirect()->back()->with('success', 'Revisa tu correo para verificar tu cuenta.');

        } catch (ValidationException $e) {

            // 👇 IMPORTANTE PARA FETCH
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => $e->errors()
                ], 422);
            }

            throw $e;
        }
    }

        public function verificarEmail(Request $request)
        {
            $token = $request->token;

            $data = Cache::get('registro_temp_'.$token);

            if (!$data) {
                return view('auth.verificacion_error');
            }

            if (Usuario::where('email', $data['email'])->exists()) {
                Cache::forget('registro_temp_'.$token);
                return view('auth.verificacion_exitosa');
            }

            Usuario::create([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'email' => $data['email'],
                'contrasena' => $data['password'],
                'email_verificado' => true
            ]);

            Cache::forget('registro_temp_'.$token);

            return view('auth.verificacion_ok');
        }

}