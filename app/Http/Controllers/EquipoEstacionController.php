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
        // Buscar la estación por su ID
        $estacion = Estacion::findOrFail($id);

        // Obtener los tanques y dispensarios asociados con la estación
        $tanques = $estacion->tanques;
        $dispensarios = $estacion->dispensarios;

        // Pasar los datos a la vista
        return view('armonia.equipo_estacion.seleccion', compact('estacion', 'tanques', 'dispensarios'));
    }
}
 