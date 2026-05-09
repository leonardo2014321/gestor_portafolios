<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $fillable = [
        'titulo',
        'mensaje',
        'tipo_envio',
        'destinatario_id',
        'creado_por',
        'leida',
    ];

    // Quién la creó (admin)
    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Destinatario individual (nullable)
    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }
}