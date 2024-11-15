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
        Schema::create('subscription_statuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pv_po_id');
            $table->text('po_id');
            $table->boolean('status');
            $table->decimal('amount');
            $table->text('pv_checksum');
            $table->boolean('renovacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_statuses');
    }
};
