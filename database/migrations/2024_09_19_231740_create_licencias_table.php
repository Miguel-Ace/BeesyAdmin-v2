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
        Schema::create('licencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('software_id');
            $table->string('ruta')->nullable();
            $table->integer('cantidad')->nullable();
            $table->date('fechaInicio')->nullable();
            $table->date('fechaFinal')->nullable();
            $table->integer('cantidad_usuario')->nullable();
            $table->boolean('bee_commerce')->default(false);

            $table->string('intervalo')->nullable();
            $table->integer('countIntervalo')->nullable();
            $table->integer('monto')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('subscripcion_id')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('software_id')->references('id')->on('software');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencias');
    }
};
