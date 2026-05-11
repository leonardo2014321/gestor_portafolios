<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portafolios', function (Blueprint $table) {
            $table->string('banner_ruta', 500)->nullable()->after('descripcion');
            $table->string('logo_ruta', 500)->nullable()->after('banner_ruta');
        });
    }

    public function down(): void
    {
        Schema::table('portafolios', function (Blueprint $table) {
            $table->dropColumn(['banner_ruta', 'logo_ruta']);
        });
    }
};
