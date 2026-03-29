<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa los tokens de recuperación de contraseña.
 * Permite almacenar y validar enlaces de restablecimiento de acceso.
 */
class TokenRecuperacion extends Model
{
    protected $table = 'tokens_recuperacion';

    protected $fillable = [
        'usuario_id',
        'token',
        'expira_en',
        'usado'
    ];

    public $timestamps = false;
}