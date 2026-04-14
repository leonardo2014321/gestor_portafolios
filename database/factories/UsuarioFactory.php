<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nombre' => 'Test',
            'apellido' => 'User',
            'email' => $this->faker->unique()->safeEmail(),
            'contrasena' => bcrypt('12345678'),
            'email_verificado' => true,
        ];
    }
}