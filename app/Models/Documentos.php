<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    protected $connection = 'segunda_db';  // Conexión a la segunda base de datos
    protected $table = 'documentos_anexos';  // Nombre de la tabla

    // Permitir la asignación masiva en los siguientes campos
    protected $fillable = [
        'nombre',
        'ruta',
        'servicio_id',
        'categoria',
        'usuario_id',
    ];
}
