<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'titulo',
        'mensaje',
        'tipo_envio',
        'destinatario_id',
        'creado_por',
        'leida',
    ];

    public function creadoPor()
    {
        return $this->belongsTo(Usuario::class, 'creado_por', 'id');
    }

    public function destinatario()
    {
        return $this->belongsTo(Usuario::class, 'destinatario_id', 'id');
    }
}