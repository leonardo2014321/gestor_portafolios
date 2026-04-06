<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa a los usuarios del sistema.
 * Gestiona la información de acceso y autenticación.
 */
class Usuario extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'contrasena',
        'email_verificado',
        'google_id'
    ];

    public $timestamps = true;

    public function getRememberTokenName()
    {
        return null;
    }
}
