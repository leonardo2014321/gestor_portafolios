<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortafolioArchivo extends Model
{
    protected $table = 'portafolio_archivos';

    protected $fillable = ['portafolio_id', 'nombre_original', 'ruta', 'tamanio'];

    public function portafolio()
    {
        return $this->belongsTo(Portafolio::class, 'portafolio_id');
    }
}
