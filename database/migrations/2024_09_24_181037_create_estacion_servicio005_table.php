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
        Schema::connection('segunda_db')->create('estacion_servicio_nom_005', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estacion');
            $table->unsignedBigInteger('id_servicio_005');
            $table->timestamps(); // Timestamps

            // Definir claves foráneas
            $table->foreign('id_estacion')
                ->references('id')->on('datos_armonia.estacion')
                ->onDelete('cascade');

            $table->foreign('id_servicio_005')
                ->references('id')->on('datos_armonia.servicio_nom_005')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estacion_servicio_nom_005');
    }
};
