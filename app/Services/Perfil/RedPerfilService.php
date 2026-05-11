<?php

namespace App\Services\Perfil;

use App\Models\RedPerfil;

class RedPerfilService
{
    public function guardar($usuarioId, array $redes)
    {
        $guardadas = [];

        foreach ($redes as $red) {
            $tipo = $red['tipo'];
            $url  = $red['url'] ?? null;

            if (empty($url)) {
                // Si no tiene URL, eliminar esa red si existía
                RedPerfil::where('usuario_id', $usuarioId)
                         ->where('tipo', $tipo)
                         ->delete();
                continue;
            }

            // Busca por usuario+tipo y actualiza, o crea si no existe
            $guardadas[] = RedPerfil::updateOrCreate(
                [
                    'usuario_id' => $usuarioId,
                    'tipo'       => $tipo,
                ],
                [
                    'url'     => $url,
                    'visible' => $red['visible'] ?? false,
                ]
            );
        }

        return $guardadas;
    }

    public function obtener($usuarioId)
    {
        return RedPerfil::where('usuario_id', $usuarioId)->get();
    }
}