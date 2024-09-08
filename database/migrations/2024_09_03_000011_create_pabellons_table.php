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
        Schema::create('pabellons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sed_id')->constrained('sedes');
            $table->string('pab_nombre');
            $table->boolean('pab_activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pabellons');
    }
};
