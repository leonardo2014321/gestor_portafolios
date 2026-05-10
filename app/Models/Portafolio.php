<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portafolio extends Model
{
    protected $table = 'portafolios';

    protected $fillable = ['nombre', 'descripcion', 'repositorio_url', 'estado', 'usuario_id', 'banner_ruta', 'logo_ruta'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function archivos()
    {
        return $this->hasMany(PortafolioArchivo::class, 'portafolio_id');
    }
}
