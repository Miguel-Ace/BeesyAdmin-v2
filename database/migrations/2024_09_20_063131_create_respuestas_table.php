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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregunta_id');
            $table->integer('num_respuesta')->nullable();
            $table->string('cedula_cliente')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('pais')->nullable();
            $table->string('usuario')->nullable();
            $table->timestamp('fecha_hora')->nullable();
            $table->integer('intento')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('pregunta_id')->references('id')->on('preguntas');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
