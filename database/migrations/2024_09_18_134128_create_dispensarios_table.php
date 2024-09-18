<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispensariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('segunda_db')->create('dispensarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('isla_id'); // Relación con la tabla islas
            $table->string('marca'); // Número de dispensario
            $table->string('modelo');// Número de dispensario
            $table->string('numero_serie'); // Número de dispensario
            $table->string('numero_aprobacion')->nullable(); // Número de dispensario
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('isla_id')->references('id')->on('datos_armonia.islas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispensarios');
    }
}
