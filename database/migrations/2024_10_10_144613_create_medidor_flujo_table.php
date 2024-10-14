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
        Schema::connection('segunda_db')->create('medidor_flujo', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('numero_serie');
            $table->foreignId('estacion_id'); // Relación con la estación
            $table->foreignId('dispensario_id'); // Relación con la estación
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('dispensario_id')->references('id')->on('datos_armonia.dispensarios')->onDelete('cascade');
            $table->foreign('estacion_id')->references('id')->on('datos_armonia.estacion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medidor_flujo');
    }
};
