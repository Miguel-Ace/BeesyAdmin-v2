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
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('licencia_id')->nullable();
            $table->string('serial')->nullable();
            $table->string('nombre_equipo')->nullable();
            $table->string('ultimo_acceso')->nullable();
            $table->boolean('estado')->default(false);
            $table->timestamps();

            $table->foreign('licencia_id')->references('id')->on('licencias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminals');
    }
};
