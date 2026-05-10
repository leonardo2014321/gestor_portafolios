<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portafolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portafolios', 'estado'))
                $table->string('estado', 20)->default('borrador')->after('usuario_id');
            if (!Schema::hasColumn('portafolios', 'repositorio_url'))
                $table->string('repositorio_url')->nullable()->after('descripcion');
        });

        if (!Schema::hasTable('portafolio_archivos')) {
            Schema::create('portafolio_archivos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portafolio_id')->constrained('portafolios')->onDelete('cascade');
                $table->string('nombre_original');
                $table->string('ruta');
                $table->unsignedBigInteger('tamanio');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('portafolio_archivos');
        Schema::table('portafolios', function (Blueprint $table) {
            $table->dropColumn(['estado', 'repositorio_url']);
        });
    }
};
