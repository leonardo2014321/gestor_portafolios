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

        // Si viene del fetch del navbar → devuelve JSON y el JS recarga solo
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['ok' => true, 'locale' => $lang]);
        }

        // Navegación normal (link directo) → redirige a la página anterior
        $previous = url()->previous();
        $current  = url()->current();

        if ($previous === $current || str_contains($previous, '/lang/')) {
            return redirect('/');
        }

        return redirect($previous);
    }
}