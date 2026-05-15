<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActividadService;
use App\Models\SesionUsuario;


class LoginController extends Controller
{
    public function index()
    {
        return response()->view('auth.login')->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
            'Expires'       => '0',
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
            return back()->with([
                'cuenta_desactivada'   => true,
                'motivo_desactivacion' => $usuario->motivo_desactivacion,
            ]);
        }

        Auth::login($usuario, $request->boolean('remember'));
        $request->session()->regenerate();

        // ── Registrar sesión activa ──
        SesionUsuario::create([
            'usuario_id'   => $usuario->id,
            'token'        => session()->getId(),
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'expiracion'   => now()->addHours(2),
            'last_seen_at' => now(),
        ]);

        ActividadService::log($usuario->id, 'login', ['email' => $usuario->email]);

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

        ActividadService::log($usuario->id, 'SOLICITUD_REACTIVACION', ['email' => $usuario->email]);

        session()->forget('reactivar_uid');

        return redirect('/login')->with('success_reactivacion', true);
    }

    public function destroy(Request $request)
    {
        $usuarioId = Auth::id();
        $sessionId = session()->getId();

        // ── Eliminar la sesión activa de la tabla ──
        if ($usuarioId) {
            SesionUsuario::where('usuario_id', $usuarioId)
                ->where('token', $sessionId)
                ->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($usuarioId) {
            ActividadService::log($usuarioId, 'logout');
        }

        return redirect('/home');
    }
}