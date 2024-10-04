<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use App\Models\ServicioAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Listas_inspeccion;

class ListasInspeccionController extends Controller
{


    public function menu(Request $request)
    {
        // Capturar el id del request
        $id = $request->input('id');
        // Buscar el servicio por el ID
        $servicio = ServicioAnexo::findOrFail($id);
        // Pasar el servicio a la vista para que puedas acceder a la nomenclatura
        return view('armonia.servicios.anexo_30.listas.menu', compact('servicio'));
    }



    public function seleccion($id)
    {
        $tipo_general_lista = "Programas informaticos";

        // Puedes obtener más información según tu lógica de negocio
        $id_servicio = $id;
       
        $listas_inspeccion = Listas_inspeccion::where('id_servicio', $id)
            ->whereJsonContains('lista->tipo_general_lista',$tipo_general_lista)
            ->first();

        return view("armonia.servicios.anexo_30.listas.listas_informaticos.seleccion", compact('id_servicio','listas_inspeccion'));
    }

    public  function store(Request $request)
    {     
 
        $tipo_general_lista = "Programas informaticos";

        $data = $request->except('_token', 'id_servicio');
        
        $data['tipo_general_lista'] = $tipo_general_lista;

        //Data final 
        $data2 = [
            'lista' => $data,
            'id_servicio' => $request->input('id_servicio'),
        ];


        $lista_inspeccion = Listas_inspeccion::where('id_servicio', $request->input('id_servicio'))
            ->whereJsonContains('lista->tipo_general_lista',$tipo_general_lista)
            ->first();

        if (!$lista_inspeccion) {
                Listas_inspeccion::create($data2);
        } else {

            $tipo_actual = $lista_inspeccion->lista['tipo_lista'];
            $lista_actualizada = $data2['lista'];
            // Si ya hay un tipo existente, lo mantenemos para no sobrescribirlo
            $lista_actualizada['tipo_lista'] = $tipo_actual;                   
            $lista_inspeccion->lista = $lista_actualizada;
            $lista_inspeccion->save();
            return redirect()->route('listas.seleccion', ['id' => $request->input('id_servicio')])->with('info', 'Lista actualizada exitosamente'); 
        }

                

        return redirect()->route('listas.seleccion', ['id' => $request->input('id_servicio')])->with('success', 'Lista creada exitosamente');    
    }


    public function edit(Request $request, $id)
    {
        $lista_inspeccion = Listas_inspeccion::findOrFail($id);
        $lista = $lista_inspeccion->lista;
        $id_servicio=$lista_inspeccion->id_servicio;
        

        switch ($lista_inspeccion->lista['tipo_lista']){

            case 'estacion':
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('id_lista_inspeccion',$lista_inspeccion->id)
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion16')->render());
                
            case 'transporte':

                return view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion16')->render());

            case 'almacenamiento':

                return view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion16')->render());

            default:
                abort(404); // Maneja el error si el tipo no es válido
        }

           
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


    public function destroy($id){
        $lista_inspeccion=Listas_inspeccion::findOrFail($id);
        $id_servicio =$lista_inspeccion->id_servicio;
        $lista_inspeccion->delete();
        
        return redirect()->route('listas.seleccion', ['id' => $id_servicio]);

    }
}
