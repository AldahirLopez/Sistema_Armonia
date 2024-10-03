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



    public function store(Request $request){
        $tipo_general_lista="Sistemas de medicion";
       

    
    }


    
    public function loadForm($type,$id_servicio)
    {
        switch ($type) {
            case 'estacion':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion16')->render())
                    ->with('seccion17', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion17')->render())
                    ->with('seccion18', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion18')->render())
                    ->with('seccion19', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion19')->render())
                    ->with('seccion20', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion20')->render())
                    ->with('seccion21', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion21')->render())
                    ->with('seccion22', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion22')->render())
                    ->with('seccion23', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion23')->render())
                    ->with('seccion24', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion24')->render())
                    ->with('seccion25', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion25')->render())
                    ->with('seccion26', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion26')->render())
                    ->with('seccion27', view('armonia.servicios.anexo_30.listas.listas_medicion.estacion.seccion27')->render());
            case 'transporte':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion16')->render())
                    ->with('seccion17', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion17')->render())
                    ->with('seccion18', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion18')->render())
                    ->with('seccion19', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion19')->render())
                    ->with('seccion20', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion20')->render())
                    ->with('seccion21', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion21')->render())
                    ->with('seccion22', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion22')->render())
                    ->with('seccion23', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion23')->render())
                    ->with('seccion24', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion24')->render())
                    ->with('seccion25', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion25')->render())
                    ->with('seccion26', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion26')->render())
                    ->with('seccion27', view('armonia.servicios.anexo_30.listas.listas_medicion.transporte.seccion27')->render());
            case 'almacenamiento':
                //Almacenamiento
                return view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion16')->render())
                    ->with('seccion17', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion17')->render())
                    ->with('seccion18', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion18')->render())
                    ->with('seccion19', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion19')->render())
                    ->with('seccion20', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion20')->render())
                    ->with('seccion21', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion21')->render())
                    ->with('seccion22', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion22')->render())
                    ->with('seccion23', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion23')->render())
                    ->with('seccion24', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion24')->render())
                    ->with('seccion25', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion25')->render())
                    ->with('seccion26', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion26')->render())
                    ->with('seccion27', view('armonia.servicios.anexo_30.listas.listas_medicion.almacenamiento.seccion27')->render());
            default:
                abort(404); // Maneja el error si el tipo no es válido
        }
    }






    
}
