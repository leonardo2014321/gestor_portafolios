<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Evitar duplicados si ya existe
        if (Usuario::where('email', 'admin@gmail.com')->exists()) {
            $this->command->info('⚠️  La cuenta admin ya existe, se omite la creación.');
            return;
        }

        Usuario::create([
            'nombre'           => 'Administrador',
            'apellido'         => 'Sistema',
            'email'            => 'admin@gmail.com',
            'contrasena'       => password_hash('infinitycode1', PASSWORD_BCRYPT),
            'email_verificado' => true,
            'activo'           => true,
            'es_admin'         => true,
        ]);

        $this->command->info('✅ Cuenta admin creada: admin@sansifulios.com / infinitycode1');
    }
}
