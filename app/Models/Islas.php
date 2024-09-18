<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Islas extends Model
{
    use HasFactory;

    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';

    // Especificar la tabla asociada al modelo
    protected $table = 'islas';

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'numero_isla',
        'estacion_id',
    ];
}
