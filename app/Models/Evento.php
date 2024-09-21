<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    // Especificar la conexión a la base de datos secundaria
    protected $connection = 'segunda_db';
    protected $fillable = ['title', 'category', 'start_time', 'duration_days', 'user_id'];

    protected $dates = ['start_time'];
    // Asegúrate de que 'start_time' se convierta en un objeto de Carbon automáticamente
    protected $casts = [
        'start_time' => 'datetime',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
