<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioAnexo extends Model
{
    use HasFactory;

    protected $connection = 'segunda_db';
    protected $table = 'servicio_anexo_30';


    // Agrega 'nomenclatura' al arreglo fillable para permitir la asignación masiva
    protected $fillable = [
        'nomenclatura',
        'costo_total',
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
        return $this->belongsToMany(Estacion::class, 'estacion_servicio_anexo_30', 'id_servicio_anexo', 'id_estacion');
    }
}
