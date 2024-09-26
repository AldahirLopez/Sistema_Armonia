<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos_Servicio_005 extends Model
{
    use HasFactory;

    protected $connection = 'segunda_db';  // Conexión a la segunda base de datos
    protected $table = 'documentos_servicio_nom_005';  // Nombre de la tabla

    // Permitir la asignación masiva en los siguientes campos
    protected $fillable = [
        'nombre',
        'ruta',
        'servicio_id',
        'categoria',
        'usuario_id',
    ];
}
