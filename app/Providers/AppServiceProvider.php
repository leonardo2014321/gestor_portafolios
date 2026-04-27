<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Fix SSL en desarrollo local con Windows
        if (app()->environment('local')) {
            $caPath = base_path('cacert.pem');
            if (file_exists($caPath)) {
                putenv("CURL_CA_BUNDLE=$caPath");
                putenv("SSL_CERT_FILE=$caPath");
            }
        }
    }
}
