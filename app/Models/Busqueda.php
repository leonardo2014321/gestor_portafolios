<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Busqueda extends Model
{
    protected $table = 'busquedas';

    protected $fillable = [
        'origen_id',
        'tipo',
        'titulo',
        'descripcion',
        'tags',
        'url',
        'avatar_class',
        'avatar_letter',
        'has_users'
    ];

    protected $casts = [
        'tags' => 'array',
        'has_users' => 'boolean'
    ];
}
