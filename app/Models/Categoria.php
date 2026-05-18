<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false;

    protected $fillable = ['slug', 'nombre', 'icono', 'activa', 'orden'];

    public function portafolios()
    {
        return $this->hasMany(Portafolio::class, 'categoria_id');
    }
}
