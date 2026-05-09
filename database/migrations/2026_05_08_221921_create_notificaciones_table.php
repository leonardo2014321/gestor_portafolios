<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('mensaje');
            $table->enum('tipo_envio', ['individual', 'todos', 'rol']);
            $table->unsignedBigInteger('destinatario_id')->nullable();
            $table->unsignedBigInteger('creado_por');
            $table->boolean('leida')->default(false);
            $table->timestamps();

            $table->foreign('destinatario_id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');

            $table->foreign('creado_por')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};