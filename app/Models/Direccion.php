<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $connection = 'segunda_db';  // Conexión a la segunda base de datos
    protected $table = 'direcciones';  // Nombre de la tabla

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'codigo_postal',
        'localidad',
        'municipio',
        'entidad_federativa',
        'tipo'  // 'fiscal' o 'servicio'
    ];

    /**
     * Relación con el modelo Estacion.
     * Una dirección puede estar asociada a varias estaciones (fiscal o de servicio).
     */
    public function estaciones()
    {
        return $this->hasMany(Estacion::class, 'domicilio_fiscal_id')
            ->orWhere('domicilio_servicio_id', 'id');
    }
}
