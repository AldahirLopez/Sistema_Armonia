<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSondasTable extends Migration
{
    public function up()
    {
        Schema::connection('segunda_db')->create('sondas', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->string('folio'); // Folio único
            $table->string('numero_serie')->nullable(); // Número de serie
            $table->string('producto')->nullable(); ; // Producto
            $table->string('marca')->nullable(); ; // Marca
            $table->foreignId('estacion_id'); // Relación con la estación
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('estacion_id')->references('id')->on('datos_armonia.estacion')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection('segunda_db')->dropIfExists('sondas');
    }
}
