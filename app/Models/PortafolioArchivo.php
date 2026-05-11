<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortafolioArchivo extends Model
{
    protected $table = 'portafolio_archivos';

    protected $fillable = ['proyecto_id', 'nombre_original', 'ruta', 'tamanio'];

    public function proyecto()
    {
        return $this->belongsTo(PortafolioProyecto::class, 'proyecto_id');
    }
}
