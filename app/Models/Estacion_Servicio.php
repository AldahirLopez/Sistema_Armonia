<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion_Servicio extends Model
{
    use HasFactory;

    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';

    // Especificar la tabla asociada al modelo
    protected $table = 'estacion_servicio_anexo_30';

    // Agrega 'id_servicio_anexo' y otros campos al arreglo fillable para permitir la asignación masiva
    protected $fillable = [
        'id_servicio_anexo',
        'id_estacion',
        // Añade aquí cualquier otro campo que deba ser asignado de manera masiva
    ];

    public function servicioAnexo()
    {
        return $this->belongsTo(ServicioAnexo::class, 'id_servicio_anexo', 'id');
    }
}
