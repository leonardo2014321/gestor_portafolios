<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index()
    {
    return response()->view('auth.login')->withHeaders([
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
    }

    public function store(Request $request)

{
    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    $usuario = \App\Models\Usuario::where('email', $request->email)->first();

    if (! $usuario) {
        return back()->withErrors([
            'email' => 'Correo incorrecto.',
        ])->onlyInput('email');
    }

    if (! password_verify($request->password, $usuario->contrasena)) {
        return back()->withErrors([
            'password' => 'Contraseña incorrecta.',
        ])->onlyInput('email');
    }

    Auth::login($usuario, $request->boolean('remember'));
    $request->session()->regenerate();
    return redirect()->intended('/menu');
}

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/home');
    }
}