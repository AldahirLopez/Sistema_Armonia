<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIslasTable extends Migration
{
    public function up()
    {
        Schema::connection('segunda_db')->create('islas', function (Blueprint $table) {
            $table->id(); // Identificador de la isla
            $table->string('numero_isla'); // Número o nombre identificador de la isla
            $table->foreignId('estacion_id'); // Relación con estaciones
            $table->timestamps(); // Campos para created_at y updated_at
            // Foreign key con la tabla de usuarios
            $table->foreign('estacion_id')->references('id')->on('datos_armonia.estacion')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('islas');
    }
}
