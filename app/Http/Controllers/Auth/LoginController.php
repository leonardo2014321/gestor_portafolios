<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
{
    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    $usuario = \App\Models\Usuario::where('email', $request->email)->first();

    if ($usuario && password_verify($request->password, $usuario->contrasena)) {
        Auth::login($usuario, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Las credenciales no son correctas.',
    ])->onlyInput('email');
}

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}