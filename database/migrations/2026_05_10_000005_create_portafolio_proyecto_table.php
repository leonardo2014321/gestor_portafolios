<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portafolio_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portafolio_id')->constrained('portafolios')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->string('repositorio_url', 500)->nullable();
            $table->string('estado', 20)->default('borrador');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portafolio_proyecto');
    }
};
