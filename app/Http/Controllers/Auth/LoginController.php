<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActividadService;


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

    if (! $usuario->activo) {
        session(['reactivar_uid' => $usuario->id]);
        return back()->with('cuenta_desactivada', true);
    }

    Auth::login($usuario, $request->boolean('remember'));
    $request->session()->regenerate();

    ActividadService::log($usuario->id, 'login', ['email' => $usuario->email]);

    // Redirigir al panel de administrador si corresponde
    if ($usuario->es_admin) {
        return redirect('/admin');
    }

    return redirect()->intended('/menu');
}

    public function reactivar(Request $request)
    {
        $uid = session('reactivar_uid');
        if (! $uid) return redirect('/home');

        $usuario = \App\Models\Usuario::find($uid);
        if (! $usuario) return redirect('/home');

        $usuario->update(['activo' => true]);
        session()->forget('reactivar_uid');

        Auth::login($usuario);
        $request->session()->regenerate();

        ActividadService::log($usuario->id, 'reactivacion_cuenta');

        return redirect('/menu');
    }

    public function destroy(Request $request)
    {
        $usuarioId = Auth::id();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($usuarioId) {
            ActividadService::log($usuarioId, 'logout');
        }

        return redirect('/home');
    }
}