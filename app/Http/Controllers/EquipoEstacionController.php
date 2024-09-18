<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EquipoEstacionController extends Controller
{

    public function seleccion($id)
    {
        
        $estacion = Estacion::findOrFail($id);
        return view('armonia.equipo_estacion.seleccion', compact('estacion'));
    }
}
