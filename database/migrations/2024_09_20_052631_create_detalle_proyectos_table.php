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
        Schema::create('detalle_proyectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            // $table->string('num_actividad')->nullable(); Lo remplaza el id
            $table->string('nombre_actividad')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('horas_propuestas');
            $table->integer('meta_hrs_optimas')->nullable();
            $table->integer('horas_reales')->nullable();
            $table->unsignedBigInteger('colaborador_id')->nullable();
            $table->string('ejecutor_cliente')->nullable();
            $table->unsignedBigInteger('tipo_id')->nullable(); // Laboratorio,Especialización,Mejora
            $table->string('rendimiento')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->unsignedBigInteger('etapa_id')->nullable();
            $table->string('notas')->nullable();
            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('colaborador_id')->references('id')->on('users');
            $table->foreign('estado_id')->references('id')->on('states');
            $table->foreign('etapa_id')->references('id')->on('etapas');
            $table->foreign('tipo_id')->references('id')->on('origen_asistencias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_proyectos');
    }
};
