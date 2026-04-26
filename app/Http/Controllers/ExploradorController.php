<?php

namespace App\Http\Controllers;

use App\Models\Busqueda;
use Illuminate\Http\Request;

class ExploradorController extends Controller
{
    /**
     * Muestra la vista del explorador con los datos de la base de datos.
     */
    public function index()
    {
        // Obtenemos todos los registros de la tabla busquedas
        // Si la tabla está vacía en este momento, enviará un array vacío
        $busquedas = Busqueda::all();

        return view('Auth.explorador', compact('busquedas'));
    }
}
