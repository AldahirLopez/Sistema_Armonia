<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;

    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';

    // Especificar la tabla asociada al modelo
    protected $table = 'estacion';

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'num_estacion',
        'razon_social',
        'rfc',
        'estado_republica',
        'num_cre',
        'num_constancia',
        'telefono',
        'correo_electronico',
        'contacto',
        'nombre_representante_legal',
        'usuario_id',
        'domicilio_fiscal_id',
        'domicilio_servicio_id',
    ];

    /**
     * Relación con el modelo User (usuario).
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    /**
     * Relación con el modelo Direccion para el domicilio fiscal.
     */
    public function domicilioFiscal()
    {
        return $this->belongsTo(Direccion::class, 'domicilio_fiscal_id', 'id');
    }

    /**
     * Relación con el modelo Direccion para el domicilio de servicio.
     */
    public function domicilioServicio()
    {
        return $this->belongsTo(Direccion::class, 'domicilio_servicio_id', 'id');
    }
}
