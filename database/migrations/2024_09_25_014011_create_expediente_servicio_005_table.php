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
        Schema::connection('segunda_db')->create('expediente_servicio005', function (Blueprint $table) {
            $table->id();
            $table->string('rutadoc_estacion');
            $table->unsignedBigInteger('servicio_005_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            // Agregar la clave foránea
            $table->foreign('usuario_id')->references('id')->on('sistema_armonia.users');
            // Agrega la clave foránea correctamente
            $table->foreign('servicio_005_id')
                ->references('id')->on('datos_armonia.servicio005')
                ->onDelete('cascade'); // Eliminación en cascada para mantener la integridad referencial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expediente_servicio005');
    }
};
