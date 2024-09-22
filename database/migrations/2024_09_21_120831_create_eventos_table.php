<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    public function up()
    {
        Schema::connection('segunda_db')->create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título del evento
            $table->string('category'); // Categoría del evento
            $table->date('start_date'); // Fecha de inicio
            $table->time('start_time'); // Hora de inicio
            $table->date('end_date'); // Fecha de término calculada
            $table->integer('duration_days')->default(1); // Duración en días
            $table->unsignedBigInteger('user_id'); // Usuario que crea el evento
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('sistema_armonia.users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection('segunda_db')->dropIfExists('eventos');
    }
}
