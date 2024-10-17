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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('colaborador_pertenece_id')->nullable(); // El usuario dueño del expediente
            $table->unsignedBigInteger('colaborador_soluciona_id')->nullable(); // El usuario que realiza el expediente
            $table->unsignedBigInteger('tipo_id')->nullable(); // Laboratorio,Especialización,Mejora
            $table->bigInteger('num_expediente')->nullable(); // Numero del expediente
            $table->string('expediente')->nullable(); // Ejemplo: Edwin_Torres-150-L
            $table->string('archivo')->nullable(); // Aqui suben un archivo rar, word ó pdf
            $table->unsignedBigInteger('prioridad_id')->nullable(); // Leve, Media y Alta
            $table->unsignedBigInteger('estado_id')->nullable(); // Enviado, En proceso, En revisión y Completado
            $table->date('fecha_entrada')->nullable(); // Cuando se crea el lab
            $table->date('fecha_programada')->nullable(); // Cuando se estima que esté listo el lab
            $table->date('fecha_salida')->nullable(); // Cuando realmente se entrega el lab
            $table->date('fecha_revision')->nullable(); // Cuando soporte finaliza o completa la revisión
            $table->unsignedBigInteger('cliente_id')->nullable(); // Obtener datos de la tabla cliente
            $table->unsignedBigInteger('software_id')->nullable(); // Obtener datos de la tabla software
            $table->timestamps();

            $table->foreign('colaborador_pertenece_id')->references('id')->on('users');
            $table->foreign('colaborador_soluciona_id')->references('id')->on('users');
            $table->foreign('tipo_id')->references('id')->on('origen_asistencias');
            $table->foreign('prioridad_id')->references('id')->on('priorities');
            $table->foreign('estado_id')->references('id')->on('states');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('software_id')->references('id')->on('software');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
