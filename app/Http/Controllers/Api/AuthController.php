<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !password_verify($request->password, $usuario->contrasena)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        // Para API, puedes usar tokens. Si tienes Sanctum, usar createToken.
        // Como no tienes, devolver solo success y user data.
        // O instalar Sanctum.

        Auth::login($usuario);

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'user' => $usuario,
        ]);
    }
}