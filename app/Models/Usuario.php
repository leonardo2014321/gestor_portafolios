<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa a los usuarios del sistema.
 * Gestiona la información de acceso y autenticación.
 */
class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'email',
        'contrasena',
        'email_verificado',
        'google_id'
    ];

    public $timestamps = true;
}