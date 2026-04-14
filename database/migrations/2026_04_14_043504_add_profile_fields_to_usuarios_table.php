<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('profesion', 150)->nullable()->after('apellido');
            $table->text('biografia')->nullable()->after('profesion');
            $table->string('foto_perfil')->nullable()->after('biografia');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['profesion', 'biografia', 'foto_perfil']);
        });
    }
};
