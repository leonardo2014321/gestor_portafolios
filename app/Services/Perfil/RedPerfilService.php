<?php

namespace App\Services\Perfil;

use App\Models\RedPerfil;

class RedPerfilService
{
    public function guardar($usuarioId, array $redes)
    {
        // eliminar anteriores
        RedPerfil::where('usuario_id', $usuarioId)->delete();

        $guardadas = [];

        foreach ($redes as $red) {

            if (empty($red['url'])) continue;

            $guardadas[] = RedPerfil::create([
                'usuario_id' => $usuarioId,
                'tipo' => $red['tipo'],
                'url' => $red['url'],
                'visible' => $red['visible'] ?? false
            ]);
        }

        return $guardadas;
    }

    public function obtener($usuarioId)
    {
        return RedPerfil::where('usuario_id', $usuarioId)->get();
    }
}