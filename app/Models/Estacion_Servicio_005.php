<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion_Servicio_005 extends Model
{
    use HasFactory;

    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';

    // Especificar la tabla asociada al modelo
    protected $table = 'estacion_servicio_nom_005';

    // Agrega 'id_servicio_005' y otros campos al arreglo fillable para permitir la asignación masiva
    protected $fillable = [
        'id_servicio_005',
        'id_estacion',
        // Añade aquí cualquier otro campo que deba ser asignado de manera masiva
    ];

    public function servicio005()
    {
        return $this->belongsTo(Servicio_005::class, 'id_servicio_005', 'id');
    }
}
