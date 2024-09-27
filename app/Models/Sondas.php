<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sondas extends Model
{
    use HasFactory;

    // Specify the connection to the secondary database
    protected $connection = 'segunda_db';

    // Specify the table associated with the model
    protected $table = 'sondas';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'folio',
        'numero_serie',
        'producto',
        'marca',
        'estacion_id',
    ];

    /**
     * Define the relationship with the Estacion model
     */
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estacion_id');
    }
}
