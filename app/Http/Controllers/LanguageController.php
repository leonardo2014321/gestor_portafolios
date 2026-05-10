<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $lang)
    {
        $allowed = ['es', 'en', 'fr'];

        if (in_array($lang, $allowed)) {
            session(['locale' => $lang]);
        }

        // Redirige a la página anterior, si no hay anterior va al home
        $previous = url()->previous();
        $current  = url()->current();

        // Evita loop infinito si la página anterior es la misma ruta de lang
        if ($previous === $current || str_contains($previous, '/lang/')) {
            return redirect('/');
        }

        return redirect($previous);
    }
}