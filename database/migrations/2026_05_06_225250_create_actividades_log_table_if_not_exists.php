<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('actividades_log')) {
            Schema::create('actividades_log', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('usuario_id')->nullable();
                $table->string('accion');
                $table->json('detalles')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
                
                $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('set null');
            });
        } else {
            Schema::table('actividades_log', function (Blueprint $table) {
                if (!Schema::hasColumn('actividades_log', 'usuario_id')) {
                    $table->unsignedBigInteger('usuario_id')->nullable()->after('id');
                    $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('set null');
                }
                if (!Schema::hasColumn('actividades_log', 'accion')) {
                    $table->string('accion')->after('usuario_id');
                }
                if (!Schema::hasColumn('actividades_log', 'detalles')) {
                    $table->json('detalles')->nullable()->after('accion');
                }
                if (!Schema::hasColumn('actividades_log', 'ip_address')) {
                    $table->string('ip_address', 45)->nullable()->after('detalles');
                }
                if (!Schema::hasColumn('actividades_log', 'user_agent')) {
                    $table->text('user_agent')->nullable()->after('ip_address');
                }
                if (!Schema::hasColumn('actividades_log', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No borramos la tabla por seguridad si ya existía
    }
};
