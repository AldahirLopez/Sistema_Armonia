<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';

    protected $table = 'eventos';

    // Definir los campos que se pueden llenar masivamente
    protected $fillable = [
        'title',
        'category',
        'start_date',
        'start_time',
        'end_date',
        'duration_days',
        'user_id',
    ];

    // Indicar que los campos de fecha deben ser instancias de Carbon
    protected $dates = ['start_date', 'start_time', 'end_date'];
}
