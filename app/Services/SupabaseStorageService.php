<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    private string $url;
    private string $key;
    private string $bucket;

    public function __construct()
    {
        $this->url    = rtrim(config('services.supabase.url'), '/');
        $this->key    = config('services.supabase.key');
        $this->bucket = config('services.supabase.bucket');
    }

    /**
     * Sube un archivo al bucket/carpeta indicada.
     * Devuelve la ruta relativa dentro del bucket (ej: "perfil/uuid.jpg")
     * o lanza una excepción si falla.
     */
    public function upload(string $folder, \Illuminate\Http\UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename  = Str::uuid() . '.' . $extension;
        $path      = trim($folder, '/') . '/' . $filename;  // ej: perfil/uuid.jpg

        $response = Http::withOptions(['verify' => !app()->environment('local')])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->key,
                'apikey'        => $this->key,
                'Content-Type'  => $file->getMimeType(),
                'x-upsert'      => 'true',
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getMimeType()
            )->post($this->storageUrl($path));

        if ($response->failed()) {
            throw new \RuntimeException(
                'Supabase upload error: ' . $response->status() . ' — ' . $response->body()
            );
        }

        return $path;   // solo la ruta relativa, esta se guarda en DB
    }

    /**
     * Elimina un archivo del bucket dado su path relativo (ej: "perfil/uuid.jpg").
     * Silencia errores de "no encontrado" (el archivo ya no existe, no importa).
     */
    public function delete(string $path): void
    {
        $response = Http::withOptions(['verify' => !app()->environment('local')])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->key,
                'apikey'        => $this->key,
                'Content-Type'  => 'application/json',
            ])->delete($this->storageUrl($path));

        // 404 = ya no existía, lo ignoramos
        if ($response->failed() && $response->status() !== 404) {
            \Log::warning('Supabase delete warning: ' . $response->status() . ' — ' . $response->body());
        }
    }

    /**
     * Devuelve la URL pública de un archivo dado su path relativo.
     * Requiere que el bucket tenga visibilidad "Public" en Supabase.
     */
    public function publicUrl(string $path): string
    {
        return $this->url . '/storage/v1/object/public/' . $this->bucket . '/' . ltrim($path, '/');
    }

    // ---- interno ----

    private function storageUrl(string $path): string
    {
        return $this->url . '/storage/v1/object/' . $this->bucket . '/' . ltrim($path, '/');
    }
}