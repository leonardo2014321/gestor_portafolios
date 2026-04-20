<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    protected $table = 'formaciones';

    protected $fillable = ['usuario_id', 'institucion', 'titulo', 'fecha_inicio', 'fecha_fin'];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
