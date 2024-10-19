<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Estacion extends Model
{
    use HasFactory;

    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';

    // Especificar la tabla asociada al modelo
    protected $table = 'usuario_estacion';

    // Definir los campos que se pueden asignar en masa
    protected $fillable = [
        'usuario_id',
        'estacion_id',
    ];
}
