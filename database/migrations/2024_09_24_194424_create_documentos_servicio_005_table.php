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
        Schema::connection('segunda_db')->create('documentos_servicio_005', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');  // Nombre del documento
            $table->string('ruta');    // Ruta de almacenamiento del archivo
            $table->foreignId('servicio_id'); // Relaciona con la tabla de servicios
            $table->enum('categoria', ['generales', 'terceros']); // Categoría de documento
            $table->foreignId('usuario_id'); // Usuario que subió el documento
            $table->timestamps(); // Timestamps para control
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_servicio_005');
    }
};
