<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListasInspeccionController extends Controller
{
    public function seleccion($id)
    {
        // Puedes obtener más información según tu lógica de negocio
        $id_servicio = $id;
        return view("armonia.servicios.anexo_30.listas.seleccion", compact('id_servicio'));
    }

    public function loadForm($type)
    {
        switch ($type) {
            case 'estacion':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.index')
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.seccion04')->render());
            case 'transporte':
                return view('armonia.servicios.anexo_30.listas.transporte');
            case 'almacenamiento':
                return view('armonia.servicios.anexo_30.listas.almacenamiento');
            default:
                abort(404); // Maneja el error si el tipo no es válido
        }
    }
}
