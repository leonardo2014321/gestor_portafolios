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
            // individual = un usuario, todos = todos, rol = solo admins
            $table->enum('tipo_envio', ['individual', 'todos', 'rol']);
            // solo se llena si tipo_envio = 'individual'
            $table->foreignId('destinatario_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');
            // quien creó la notificación (siempre un admin)
            $table->foreignId('creado_por')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->boolean('leida')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};