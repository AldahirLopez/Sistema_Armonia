<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veeder_Root extends Model
{
    use HasFactory;

    // Definir la conexión con la base de datos secundaria
    protected $connection = 'segunda_db';

    // Definir la tabla asociada
    protected $table = 'veeder_root';

    // Definir los campos que se pueden asignar en masa
    protected $fillable = [
        'marca',
        'modelo',
        'numero_serie',
        'estacion_id',
    ];

    // Definir la relación con la estación
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estacion_id');
    }
}