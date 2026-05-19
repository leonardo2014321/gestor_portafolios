<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portafolio extends Model
{
    protected $table = 'portafolios';

    protected $fillable = ['nombre', 'descripcion', 'repositorio_url', 'estado', 'usuario_id', 'banner_ruta', 'logo_ruta', 'categoria_id'];

    protected $appends = ['banner_url', 'logo_url'];

    public function getBannerUrlAttribute(): ?string
    {
        if (!$this->banner_ruta) return null;
        $base   = rtrim(config('services.supabase.url'), '/');
        $bucket = config('services.supabase.bucket', 'usuarios');
        return $base . '/storage/v1/object/public/' . $bucket . '/' . ltrim($this->banner_ruta, '/');
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo_ruta) return null;
        $base   = rtrim(config('services.supabase.url'), '/');
        $bucket = config('services.supabase.bucket', 'usuarios');
        return $base . '/storage/v1/object/public/' . $bucket . '/' . ltrim($this->logo_ruta, '/');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function proyectos()
    {
        return $this->hasMany(PortafolioProyecto::class, 'portafolio_id');
    }
}