<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use App\Models\ServicioAnexo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Listas_inspeccion;

class ListasInspeccionMedicionController extends Controller
{


    public function seleccion($id)
    {
        $tipo_general_lista='Sistemas de medicion';

        // Puedes obtener más información según tu lógica de negocio
        $id_servicio = $id;
        $listas_inspeccion = Listas_inspeccion::where('id_servicio', $id)
            ->whereJsonContains('lista->tipo_general',$tipo_general_lista)
            ->first();
        
        return view("armonia.servicios.anexo_30.listas.listas_medicion.seleccion", compact('id_servicio','listas_inspeccion'));
    }


    
    public function loadForm($type,$id_servicio)
    {
        switch ($type) {
            case 'estacion':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion16')->render());
            case 'transporte':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion16')->render());
            case 'almacenamiento':
                //Almacenamiento
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion16')->render());
            default:
                abort(404); // Maneja el error si el tipo no es válido
        }
    }






    
}
