<?php

namespace Tests\Feature\Perfil;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Usuario;

class RedPerfilControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guardar_redes_endpoint()
    {
        $user = Usuario::factory()->create();

        $response = $this->actingAs($user)->postJson('/perfil/redes', [
            'redes' => [
                [
                    'tipo' => 'github',
                    'url' => 'https://github.com/test',
                    'visible' => true
                ]
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('redes_perfil', [
            'usuario_id' => $user->id,
            'tipo' => 'github'
        ]);
    }
}