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
            $client = app()->environment('production') 
                ? new Client() 
                : new Client(['verify' => base_path('cacert.pem')]);

            $googleUser = Socialite::driver('google')
                ->setHttpClient($client)
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
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