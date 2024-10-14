<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medidor_Flujo extends Model
{
    use HasFactory;

    // Definir la conexión con la base de datos secundaria
    protected $connection = 'segunda_db';

    // Definir la tabla asociada
    protected $table = 'medidor_flujo';

    // Definir los campos que se pueden asignar en masa
    protected $fillable = [
        'marca',
        'numero_serie',
        'estacion_id',
        'dispensario_id',
    ];

    // Definir la relación con la estación
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estacion_id');
    }

    // Relación con Dispensario
    public function dispensario()
    {
        return $this->belongsTo(Dispensario::class, 'dispensario_id');
    }
}
