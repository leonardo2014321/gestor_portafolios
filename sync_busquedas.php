<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Busqueda;
use App\Models\Usuario;
use App\Models\Habilidad;
use App\Models\Experiencia;
use App\Models\Certificacion;
use Illuminate\Support\Facades\DB;

try {
    DB::beginTransaction();

    echo "Limpiando tabla de búsquedas...\n";
    Busqueda::truncate();

    // 1. Usuarios -> Perfiles
    echo "Sincronizando Usuarios...\n";
    $usuarios = Usuario::all();
    foreach ($usuarios as $u) {
        Busqueda::create([
            'origen_id' => $u->id,
            'tipo' => 'perfil',
            'titulo' => $u->nombre . ' ' . $u->apellido,
            'descripcion' => 'Perfil profesional en SansiFolios.',
            'tags' => ['#USER', '#PROFILE'],
            'avatar_letter' => strtoupper(substr($u->nombre, 0, 1)),
            'avatar_class' => 'av-blue',
            'has_users' => true
        ]);
    }

    // 2. Habilidades
    echo "Sincronizando Habilidades...\n";
    $habilidades = Habilidad::all();
    foreach ($habilidades as $h) {
        Busqueda::create([
            'origen_id' => $h->id,
            'tipo' => 'habilidad',
            'titulo' => $h->nombre,
            'descripcion' => 'Nivel: ' . $h->nivel,
            'tags' => ['#SKILL', '#' . strtoupper($h->nivel)],
            'avatar_letter' => 'H',
            'avatar_class' => 'av-orange',
            'has_users' => false
        ]);
    }

    // 3. Experiencias -> Proyectos
    echo "Sincronizando Experiencias...\n";
    $experiencias = Experiencia::all();
    foreach ($experiencias as $e) {
        Busqueda::create([
            'origen_id' => $e->id,
            'tipo' => 'proyecto',
            'titulo' => $e->cargo . ' en ' . $e->empresa,
            'descripcion' => $e->descripcion ?? 'Experiencia laboral registrada.',
            'tags' => ['#EXPERIENCE', '#WORK'],
            'avatar_letter' => 'E',
            'avatar_class' => 'av-green',
            'has_users' => false
        ]);
    }

    // 4. Certificaciones -> Documentos
    echo "Sincronizando Certificaciones...\n";
    $certificaciones = Certificacion::all();
    foreach ($certificaciones as $c) {
        Busqueda::create([
            'origen_id' => $c->id,
            'tipo' => 'documento',
            'titulo' => $c->nombre,
            'descripcion' => ($c->organizacion ?? 'N/A') . ' - ' . ($c->fecha_obtencion ?? 'Sin fecha'),
            'tags' => ['#CERTIFICATE', '#DOC'],
            'avatar_letter' => 'C',
            'avatar_class' => 'av-teal',
            'has_users' => false
        ]);
    }

    DB::commit();
    echo "Sincronización completada con éxito.\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "Error durante la sincronización: " . $e->getMessage() . "\n";
}
