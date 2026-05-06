<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades_log';

    protected $fillable = [
        'usuario_id',
        'accion',
        'detalles',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'detalles' => 'array'
    ];

    /**
     * Relación con el usuario que realizó la acción.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
