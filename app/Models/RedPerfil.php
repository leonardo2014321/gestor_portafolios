<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedPerfil extends Model
{
    protected $table = 'redes_perfil';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'tipo',
        'url',
        'visible'
    ];
}