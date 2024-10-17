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
        Schema::create('soportes', function (Blueprint $table) {
            $table->id();
            // $table->string('ticker'); Remplazado por el id
            $table->unsignedBigInteger('colaborador_id'); // Se saca de la tabla users
            // $table->string('fechaCreacionTicke')->nullable(); Remplazado por created_at
            $table->timestamp('fechaInicioAsistencia')->nullable();
            $table->timestamp('fechaFinalAsistencia')->nullable();
            $table->timestamp('fecha_prevista_cumplimiento')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('software_id');
            $table->text('problema')->nullable();
            $table->text('solucion')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('prioridad_id');
            $table->unsignedBigInteger('estado_id');
            $table->string('correo_cliente');
            $table->string('archivo')->nullable();
            $table->unsignedBigInteger('tipo_id')->nullable();
            $table->unsignedBigInteger('user_cliente_id')->nullable();
            $table->boolean('interno')->default(false);
            $table->unsignedBigInteger('expediente_id')->nullable();

            $table->string('imagen')->nullable();
            $table->timestamps();

            $table->foreign('colaborador_id')->references('id')->on('users');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('software_id')->references('id')->on('software');
            $table->foreign('prioridad_id')->references('id')->on('priorities');
            $table->foreign('estado_id')->references('id')->on('states');
            $table->foreign('tipo_id')->references('id')->on('origen_asistencias');
            $table->foreign('user_cliente_id')->references('id')->on('user_clientes');
            $table->foreign('expediente_id')->references('id')->on('expedientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soportes');
    }
};
