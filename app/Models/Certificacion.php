<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificacion extends Model
{
    protected $table = 'certificaciones';

    protected $fillable = ['usuario_id', 'nombre', 'organizacion', 'fecha_obtencion', 'descripcion'];

    protected $casts = [
        'fecha_obtencion' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
