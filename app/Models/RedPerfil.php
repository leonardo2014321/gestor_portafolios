<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedPerfil extends Model
{
    // ── Nombre real de la tabla en PostgreSQL ──
    protected $table = 'redes_perfil';

    // La tabla no tiene updated_at, solo created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'usuario_id',
        'tipo',
        'url',
        'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}