<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo que representa a los usuarios del sistema.
 * Gestiona la información de acceso y autenticación.
 */
class Usuario extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'contrasena',
        'email_verificado',
        'google_id',
        'profesion',
        'biografia',
        'foto_perfil',
    ];

    public $timestamps = true;

    public function getRememberTokenName()
    {
        return null;
    }

    public function redes()
    {
        return $this->hasMany(\App\Models\RedPerfil::class, 'usuario_id');
    }
}
