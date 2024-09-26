<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispensario extends Model
{
    use HasFactory;

    // Definir la conexión con la base de datos secundaria
    protected $connection = 'segunda_db';

    // Definir la tabla asociada
    protected $table = 'dispensarios';

    // Definir los campos que se pueden asignar en masa
    protected $fillable = [
        'num_isla',
        'marca',
        'modelo',
        'numero_serie',
        'numero_aprobacion',
        'estacion_id',
    ];

    // Definir la relación con la estación
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estacion_id');
    }
}
