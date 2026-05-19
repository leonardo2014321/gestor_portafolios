<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new Client(['verify' => base_path('cacert.pem')]))
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            return redirect('/')->withErrors(['google' => 'No se pudo autenticar con Google. Intenta de nuevo.']);
        }

        $nombre = $googleUser->getName() ?? $googleUser->getNickname() ?? 'Usuario';

        $user = Usuario::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'nombre'           => $nombre,
                'contrasena'       => bcrypt(uniqid()),
                'email_verificado' => true,
                'activo'           => true,
            ]
        );

        Auth::login($user);

        return redirect('/menu');
    }
}