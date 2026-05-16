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
        'deploy_url',
        'banner_ruta',
        'estado',
    ];

    protected $appends = ['banner_url'];

    public function getBannerUrlAttribute(): ?string
    {
        if (!$this->banner_ruta) return null;
        $base   = rtrim(config('services.supabase.url'), '/');
        $bucket = config('services.supabase.bucket', 'usuarios');
        return $base . '/storage/v1/object/public/' . $bucket . '/' . ltrim($this->banner_ruta, '/');
    }

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'portafolio_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function archivos()
    {
        return $this->hasMany(PortafolioArchivo::class, 'proyecto_id');
    }
}
