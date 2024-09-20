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
                return view('armonia.servicios.anexo_30.listas.estacion');
            case 'transporte':
                return view('armonia.servicios.anexo_30.listas.transporte');
            case 'almacenamiento':
                return view('armonia.servicios.anexo_30.listas.almacenamiento');
            default:
                abort(404); // Maneja el error si el tipo no es válido
        }
    }
}
