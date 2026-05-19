<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $timestamps = false;
    protected $table = 'categorias';
    protected $fillable = ['slug', 'nombre', 'activa', 'orden'];

    public function portafolios()
    {
        return $this->hasMany(Portafolio::class);
    }
}