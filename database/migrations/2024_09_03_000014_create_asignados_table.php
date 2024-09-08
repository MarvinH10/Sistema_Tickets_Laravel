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
        Schema::create('asignados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tic_id')->constrained('tickets');
            $table->foreignId('use_id')->constrained('users');
            $table->boolean('es_asignado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignados');
    }
};
