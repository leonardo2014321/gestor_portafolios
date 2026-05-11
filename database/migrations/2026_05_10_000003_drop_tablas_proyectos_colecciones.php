<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('proyecto_archivos');
        Schema::dropIfExists('proyectos');
        Schema::dropIfExists('colecciones_portafolio');
    }

    public function down(): void
    {
        // no se restauran
    }
};
