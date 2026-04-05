<?php

namespace App\Services\Auth;

use App\Models\TokenRecuperacion;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Services\ActividadService;

/**
 * Servicio encargado de la recuperación de contraseñas.
 * Gestiona generación de tokens, validación y actualización de acceso.
 */
class RecuperacionService
{
    /**
     * Generar token de recuperación para un usuario
     */
    public function generarToken(Usuario $usuario)
    {
        $token = Str::random(60);

        TokenRecuperacion::create([
            'usuario_id' => $usuario->id,
            'token' => $token,
            'expira_en' => Carbon::now()->addHours(2),
            'usado' => false
        ]);

        return $token;
    }

    /**
     * Validar token de recuperación
     */
    public function validarToken($token)
    {
        return TokenRecuperacion::where('token', $token)
            ->where('usado', false)
            ->where('expira_en', '>', now())
            ->first();
    }

    /**
     * Actualizar contraseña usando token válido
     */
    public function actualizarContrasena($token, $nuevaContrasena)
    {
        $registro = $this->validarToken($token);

        if (!$registro) {

            ActividadService::log(null, 'TOKEN_INVALIDO', [
                'token' => $token
            ]);

            return false;
        }

        $usuario = Usuario::find($registro->usuario_id);

        $usuario->contrasena = Hash::make($nuevaContrasena);
        $usuario->save();

        ActividadService::log($usuario->id, 'PASSWORD_ACTUALIZADO', [
            'metodo' => 'recuperacion'
        ]);

        $registro->usado = true;
        $registro->save();

        return true;
    }
}