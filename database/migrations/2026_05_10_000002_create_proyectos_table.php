<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('proyectos')) {
            Schema::create('proyectos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
                $table->foreignId('coleccion_id')->nullable()->constrained('colecciones_portafolio')->onDelete('set null');
                $table->string('nombre', 100);
                $table->text('descripcion');
                $table->string('repositorio_url', 500)->nullable();
                $table->string('estado', 20)->default('borrador');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('proyecto_archivos')) {
            Schema::create('proyecto_archivos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
                $table->string('nombre_original');
                $table->string('ruta');
                $table->unsignedBigInteger('tamanio');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_archivos');
        Schema::dropIfExists('proyectos');
    }
};
