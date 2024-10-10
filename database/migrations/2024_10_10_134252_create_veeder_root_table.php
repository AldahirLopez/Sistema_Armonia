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
        Schema::connection('segunda_db')->create('veeder_root', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->string('numero_serie');
            $table->foreignId('estacion_id'); // Relación con la estación
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('estacion_id')->references('id')->on('datos_armonia.estacion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veeder_root');
    }
};
