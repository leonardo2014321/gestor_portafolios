<?php

namespace Tests\Unit\Perfil;

use Tests\TestCase;
use App\Services\Perfil\RedPerfilService;
use App\Models\RedPerfil;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedPerfilServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RedPerfilService();
    }

    public function test_guarda_redes_correctamente()
    {
        $usuarioId = 1;

        $redes = [
            [
                'tipo' => 'linkedin',
                'url' => 'https://linkedin.com/test',
                'visible' => true
            ],
            [
                'tipo' => 'github',
                'url' => 'https://github.com/test',
                'visible' => false
            ]
        ];

        $this->service->guardar($usuarioId, $redes);

        $this->assertDatabaseCount('redes_perfil', 2);

        $this->assertDatabaseHas('redes_perfil', [
            'tipo' => 'linkedin'
        ]);
    }

    public function test_no_guarda_urls_vacias()
    {
        $usuarioId = 1;

        $redes = [
            [
                'tipo' => 'linkedin',
                'url' => '',
                'visible' => true
            ]
        ];

        $this->service->guardar($usuarioId, $redes);

        $this->assertDatabaseCount('redes_perfil', 0);
    }
}