<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio_005 extends Model
{
    use HasFactory;

    protected $connection = 'segunda_db';
    protected $table = 'servicio_nom_005';


    // Agrega 'nomenclatura' al arreglo fillable para permitir la asignación masiva
    protected $fillable = [
        'nomenclatura',
        'pending_apro_servicio',
        'date_recepcion_at',
        'date_inspeccion_at',
        'pending_deletion_servicio',
        'id_usuario',
        // Añade aquí cualquier otro campo que deba ser asignado de manera masiva
    ];

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación de muchos a muchos con Estacion
    public function estaciones()
    {
        return $this->belongsToMany(Estacion::class, 'estacion_servicio_nom_005', 'id_servicio_005', 'id_estacion');
    }
}
