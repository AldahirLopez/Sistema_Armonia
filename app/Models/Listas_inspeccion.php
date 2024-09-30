<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listas_inspeccion extends Model
{
    use HasFactory;

    protected $connection = 'segunda_db';

    protected $table = 'listas_inspeccion';

    protected $fillable = [
        'lista',
        'id_servicio'
    ];

    protected $casts = [
        'lista' => 'json',
        
    ];

    public function servicio_anexo()
    {
        return $this->belongsTo(ServicioAnexo::class, 'id_servicio');
    }
}
