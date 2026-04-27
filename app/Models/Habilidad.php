<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    protected $table = 'habilidades';

    protected $fillable = ['usuario_id', 'nombre', 'nivel', 'tipo'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
