<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioAnexo extends Model
{
    use HasFactory;

    protected $connection = 'segunda_db';
    protected $table = 'servicio_anexo_30';
    
}