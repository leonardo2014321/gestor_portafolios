<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $timestamps = false;
    protected $table = 'categorias';
    
    // Agregar nombre_en y nombre_fr al fillable
    protected $fillable = ['slug', 'nombre', 'nombre_en', 'nombre_fr', 'activa', 'orden'];

    public function portafolios()
    {
        return $this->hasMany(Portafolio::class);
    }

    // Agregar el accessor
    public function getNombreTraducidoAttribute(): string
    {
        $locale = app()->getLocale();
        $col    = 'nombre_' . $locale;

        return ($locale !== 'es' && !empty($this->$col))
            ? $this->$col
            : $this->nombre;
    }
}