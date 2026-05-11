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
        Schema::table('portafolio_proyecto', function (Blueprint $table) {
            $table->string('deploy_url', 500)->nullable()->after('repositorio_url');
        });
    }

    public function down(): void
    {
        Schema::table('portafolio_proyecto', function (Blueprint $table) {
            $table->dropColumn('deploy_url');
        });
    }
};
