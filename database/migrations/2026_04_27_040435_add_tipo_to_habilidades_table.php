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
        Schema::table('habilidades', function (Blueprint $table) {
            $table->string('tipo', 20)->default('fuerte')->after('nivel');
        });
    }

    public function down(): void
    {
        Schema::table('habilidades', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
