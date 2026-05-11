<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('colecciones_portafolio')) {
            Schema::create('colecciones_portafolio', function (Blueprint $table) {
                $table->id();
                $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
                $table->string('nombre', 150);
                $table->text('descripcion')->nullable();
                $table->string('banner_ruta')->nullable();
                $table->string('logo_ruta')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('colecciones_portafolio');
    }
};
