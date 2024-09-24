<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Listas_inspeccion;

class ListasInspeccionController extends Controller
{
    public function seleccion($id)
    {
        // Puedes obtener más información según tu lógica de negocio
        $id_servicio = $id;
        return view("armonia.servicios.anexo_30.listas.seleccion", compact('id_servicio'));
    }

    public  function store(Request $request){

        $data=[
            'lista'=>[
                'seccion1'=>[
                    'respaldo'=>$request->input('respaldo'),
                    'observaciones_respaldo'=>$request->input('observaciones_respaldo'),
                    'entorno_visual'=>$request->input('entorno_visual'),
                    'observaciones_entorno_visual'=>$request->input('observaciones_entorno_visual') ?? '',
                    'control_acceso'=>$request->input('control_acceso'),
                    'observaciones_control_acceso'=>$request->input('observaciones_control_acceso') ?? ''
                ],         
            ],
        ];
        return Listas_inspeccion::create($data);
    }


    public function edit(Request $request, $id ){
           $lista_inspeccion=Listas_inspeccion::findOrFail($id);
           $lista=$lista_inspeccion->lista;
            return view ('armonia.servicios.anexo_30.listas.edit',compact('lista'));
    }
    
    public function loadForm($type)
    {
        switch ($type) {
            case 'estacion':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.index')
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
                return view('armonia.servicios.anexo_30.listas.transporte');
            case 'almacenamiento':
                return view('armonia.servicios.anexo_30.listas.almacenamiento');
            default:
                abort(404); // Maneja el error si el tipo no es válido
        }
    }
}
