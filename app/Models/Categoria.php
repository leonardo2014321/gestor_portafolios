<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false;

    protected $fillable = ['slug', 'nombre', 'nombre_en', 'nombre_fr', 'icono', 'activa', 'orden'];

    public function portafolios()
    {
        return $this->hasMany(Portafolio::class, 'categoria_id');
    }

    public function getNombreTraducidoAttribute(): string
    {
        $locale = app()->getLocale();
        $col    = 'nombre_' . $locale;

        return ($locale !== 'es' && !empty($this->$col))
            ? $this->$col
            : $this->nombre;
    }
}
