<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Los archivos pertenecen al proyecto, no al portafolio
        Schema::dropIfExists('portafolio_archivos');

        Schema::create('portafolio_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('portafolio_proyecto')->onDelete('cascade');
            $table->string('nombre_original');
            $table->string('ruta');
            $table->unsignedBigInteger('tamanio');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portafolio_archivos');

        Schema::create('portafolio_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portafolio_id')->constrained('portafolios')->onDelete('cascade');
            $table->string('nombre_original');
            $table->string('ruta');
            $table->unsignedBigInteger('tamanio');
            $table->timestamps();
        });
    }
};
