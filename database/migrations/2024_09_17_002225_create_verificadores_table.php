<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificadoresTable extends Migration
{
    public function up()
    {
        Schema::connection('segunda_db')->create('verificadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // Relación con el usuario
            $table->string('rfc')->unique();
            $table->timestamps();

            // Foreign key con la tabla de usuarios
            $table->foreign('usuario_id')->references('id')->on('sistema_armonia.users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('verificadores');
    }
}
