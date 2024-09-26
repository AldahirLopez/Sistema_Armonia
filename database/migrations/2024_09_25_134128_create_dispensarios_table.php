<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispensariosTable extends Migration
{
    public function up()
    {
        Schema::connection('segunda_db')->create('dispensarios', function (Blueprint $table) {
            $table->id();
            $table->string('num_isla'); // Número de la isla a la que pertenece el dispensario
            $table->string('marca'); // Marca del dispensario
            $table->string('modelo')->nullable(); // Modelo del dispensario
            $table->string('numero_serie')->nullable(); // Número de serie del dispensario
            $table->string('numero_aprobacion')->nullable(); // Número de aprobación
            $table->foreignId('estacion_id'); // Relación con la estación
            $table->timestamps();

            // Definir la clave foránea con la tabla estaciones
            $table->foreign('estacion_id')->references('id')->on('datos_armonia.estacion')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection('segunda_db')->dropIfExists('dispensarios');
    }
}
