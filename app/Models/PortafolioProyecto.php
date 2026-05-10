<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortafolioProyecto extends Model
{
    protected $table = 'portafolio_proyecto';

    protected $fillable = [
        'portafolio_id',
        'usuario_id',
        'nombre',
        'descripcion',
        'repositorio_url',
        'estado',
    ];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'portafolio_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
