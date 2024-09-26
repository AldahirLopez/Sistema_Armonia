<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanquesTable extends Migration
{
    public function up()
    {
        Schema::connection('segunda_db')->create('tanques', function (Blueprint $table) {
            $table->id(); // Identificador del tanque
            $table->string('folio'); // Folio único del tanque
            $table->string('marca'); // Marca del tanque
            $table->string('producto'); // Tipo de producto almacenado en el tanque
            $table->integer('capacidad'); // Capacidad del tanque en litros
            $table->string('numero_serie')->nullable(); // Número de serie del tanque
            $table->foreignId('estacion_id'); // Relación con la estación
            $table->timestamps(); // Campos para created_at y updated_at

            // Definir la clave foránea con la tabla estaciones
            $table->foreign('estacion_id')->references('id')->on('datos_armonia.estacion')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection('segunda_db')->dropIfExists('tanques');
    }
}
