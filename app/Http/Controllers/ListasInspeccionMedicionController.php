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
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
class ListasInspeccionMedicionController extends Controller
{


    public function seleccion($id)
    {
        $tipo_general_lista='Sistemas de medicion';

        // Puedes obtener más información según tu lógica de negocio
        $id_servicio = $id;
        $listas_inspeccion = Listas_inspeccion::where('id_servicio', $id)
            ->whereJsonContains('lista->tipo_general_lista',$tipo_general_lista)
            ->first();
        
        return view("armonia.servicios.anexo_30.listas.listas_medicion.seleccion", compact('id_servicio','listas_inspeccion'));
    }



    public function store(Request $request){
        
        $tipo_general_lista="Sistemas de medicion";
       
        $data = $request->except('_token', 'id_servicio');
        
        $data['tipo_general_lista'] = $tipo_general_lista;

        //Data final 
        $data2 = [
            'lista' => $data,
            'id_servicio' => $request->input('id_servicio'),
        ];

        $servicio_anexo=ServicioAnexo::findOrFail($request->input('id_servicio'));

        $lista_inspeccion = Listas_inspeccion::where('id_servicio', $servicio_anexo->id)
            ->whereJsonContains('lista->tipo_general_lista',$tipo_general_lista)
            ->first();


    
        if (!$lista_inspeccion) {
                $data_word= array_merge($data, $this->processListaOptions($data));
                Listas_inspeccion::create($data2);
                $this->processListaTemplates($data_word,$servicio_anexo);
        } else {

            $tipo_actual = $lista_inspeccion->lista['tipo_lista'];
            $lista_actualizada = $data2['lista'];
            // Si ya hay un tipo existente, lo mantenemos para no sobrescribirlo
            $lista_actualizada['tipo_lista'] = $tipo_actual;                   
            $lista_inspeccion->lista = $lista_actualizada;           
            $lista_inspeccion->save();

            $data_word= array_merge($data, $this->processListaOptions($data));
            $this->processListaTemplates($data_word,$servicio_anexo);

            return redirect()->route('listas_medicion.seleccion', ['id' => $request->input('id_servicio')])->with('info', 'Lista actualizada exitosamente');   
        }

        return redirect()->route('listas_medicion.seleccion', ['id' => $request->input('id_servicio')])->with('success', 'Lista creada exitosamente');     

       
    }


    private function processListaOptions($data)
    {

        $numero_max_requisitos=143;
        $processedData = [];

        for ($i = 1; $i <= $numero_max_requisitos; $i++) {
            $opcion = $data["opcion{$i}"] ?? null;

            // Procesar la opción seleccionada y asignar los valores correspondientes en la plantilla
            switch ($opcion) {
                case 'si':
                    $processedData["si{$i}"] = 'X';
                    $processedData["no{$i}"] = ' ';
                    $processedData["noaplica{$i}"] = ' ';
                    break;
                case 'no':
                    $processedData["si{$i}"] = ' ';
                    $processedData["no{$i}"] = 'X';
                    $processedData["noaplica{$i}"] = ' ';
                    break;
                case 'no_aplica':
                    $processedData["si{$i}"] = ' ';
                    $processedData["no{$i}"] = ' ';
                    $processedData["noaplica{$i}"] = 'X';
                    break;
                default:
                    $processedData["si{$i}"] = ' ';
                    $processedData["no{$i}"] = ' ';
                    $processedData["noaplica{$i}"] = ' ';
                    break;
            }
        }

        return $processedData;
    }

    // Método para procesar las plantillas del dictamen informático
    private function processListaTemplates($data,ServicioAnexo $servicio)
    {
        $templatePaths = [
            'LISTA DE INSPECCIÓN VERIFICACION DE LOS SISTEMAS DE MEDICIÓN.docx',
        ];

        // Definir la carpeta de destino usando el método defineFolderPath
        $subFolderPath = $this->defineFolderPath($servicio);

        // Crear la carpeta personalizada si no existe
        if (!Storage::disk('public')->exists($subFolderPath)) {
            Storage::disk('public')->makeDirectory($subFolderPath);
        }

        // Reemplazar marcadores en las plantillas
        foreach ($templatePaths as $templatePath) {
            $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Listas/{$templatePath}"));

            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }

            $fileName = pathinfo($templatePath, PATHINFO_FILENAME) . "_{$servicio->nomenclatura}.docx";
            $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
        }
    }

     // Método para definir la carpeta de destino
     private function defineFolderPath(ServicioAnexo $servicio)
     {
         $anio = now()->year;
         return "Servicios/Anexo_30/{$anio}/{$servicio->id_usuario}/{$servicio->nomenclatura}/Listas";
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




    public function edit(Request $request, $id)
    {
        $lista_inspeccion = Listas_inspeccion::findOrFail($id);
  
        $lista = $lista_inspeccion->lista;
        $id_servicio=$lista_inspeccion->id_servicio;
        

        switch ($lista_inspeccion->lista['tipo_lista']){

            case 'estacion':
                return view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.index', compact('lista'))
                    ->with('id_servicio', $id_servicio) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion16')->render())
                    ->with('seccion17', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion17')->render())
                    ->with('seccion18', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion18')->render())
                    ->with('seccion19', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion19')->render())
                    ->with('seccion20', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion20')->render())
                    ->with('seccion21', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion21')->render())
                    ->with('seccion22', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion22')->render())
                    ->with('seccion23', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion23')->render())
                    ->with('seccion24', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion24')->render())
                    ->with('seccion25', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion25')->render())
                    ->with('seccion26', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion26')->render())
                    ->with('seccion27', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.estacion.seccion27')->render());
                
            case 'transporte':

                return view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion16')->render())
                ->with('seccion17', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion17')->render())
                ->with('seccion18', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion18')->render())
                ->with('seccion19', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion19')->render())
                ->with('seccion20', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion20')->render())
                ->with('seccion21', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion21')->render())
                ->with('seccion22', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion22')->render())
                ->with('seccion23', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion23')->render())
                ->with('seccion24', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion24')->render())
                ->with('seccion25', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion25')->render())
                ->with('seccion26', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion26')->render())
                ->with('seccion27', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.transporte.seccion27')->render());

            case 'almacenamiento':

                return view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion16')->render())
                ->with('seccion17', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion17')->render())
                ->with('seccion18', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion18')->render())
                ->with('seccion19', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion19')->render())
                ->with('seccion20', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion20')->render())
                ->with('seccion21', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion21')->render())
                ->with('seccion22', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion22')->render())
                ->with('seccion23', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion23')->render())
                ->with('seccion24', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion24')->render())
                ->with('seccion25', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion25')->render())
                ->with('seccion26', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion26')->render())
                ->with('seccion27', view('armonia.servicios.anexo_30.listas.listas_medicion.edit.almacenamiento.seccion27')->render());

            default:
                abort(404); // Maneja el error si el tipo no es válido
        }

           
    }

     public function destroy($id){
        $lista_inspeccion=Listas_inspeccion::findOrFail($id);
        $servicio=$lista_inspeccion->servicio_anexo;
        $anio = now()->year;

        $templatePaths = [
            'LISTA DE INSPECCIÓN VERIFICACION DE LOS SISTEMAS DE MEDICIÓN.docx',
        ];


        foreach ($templatePaths as $templatePath) {
            
            $fileName = pathinfo($templatePath, PATHINFO_FILENAME) . "_{$servicio->nomenclatura}.docx";
            $customFolderPath = "Servicios/Anexo_30/{$anio}/{$servicio->id_usuario}/{$servicio->nomenclatura}/Listas/${fileName}"; 

        }
      

       
        if (Storage::disk('public')->exists($customFolderPath)) {
            Storage::disk('public')->delete($customFolderPath);
        } 

        $id_servicio =$lista_inspeccion->id_servicio;
        $lista_inspeccion->delete();
        
        return redirect()->route('listas_medicion.seleccion', ['id' => $id_servicio]);

    }



    public function descargar_pdf($id_lista){

        $lista_inspeccion=Listas_inspeccion::findOrFail($id_lista);
        $servicio=$lista_inspeccion->servicio_anexo;
        $anio = now()->year;

        $templatePaths = [
            'LISTA DE INSPECCIÓN VERIFICACION DE LOS SISTEMAS DE MEDICIÓN.docx',
        ];

       foreach ($templatePaths as $templatePath) {

           $fileName = pathinfo($templatePath, PATHINFO_FILENAME) . "_{$servicio->nomenclatura}.docx";
           $customFolderPath = "Servicios/Anexo_30/{$anio}/{$servicio->id_usuario}/{$servicio->nomenclatura}/Listas/${fileName}"; 

       }

        // Inicializar CloudConvert con tu API Key
        $cloudconvert = new CloudConvert(['api_key' => env('CLOUDCONVERT_API_KEY')]);

        // Ruta completa del archivo .docx
        $fullPath = storage_path('app/public/' . $customFolderPath);

        // Extraer el nombre del archivo sin la extensión
        $fileNameWithoutExtension = pathinfo($customFolderPath, PATHINFO_FILENAME);

        // Crear una tarea de CloudConvert
        $job = (new Job())
            ->addTask(
                (new Task('import/upload', 'upload-my-file'))
            )
            ->addTask(
                (new Task('convert', 'convert-my-file'))
                    ->set('input', 'upload-my-file')
                    ->set('output_format', 'pdf')
            )
            ->addTask(
                (new Task('export/url', 'export-my-file'))
                    ->set('input', 'convert-my-file')
            );

        // Crear el trabajo en CloudConvert y obtener el resultado
        $jobResult = $cloudconvert->jobs()->create($job);

        // Subir el archivo a CloudConvert
        $uploadTask = $jobResult->getTasks()->whereName('upload-my-file')[0];
        $cloudconvert->tasks()->upload($uploadTask, fopen($fullPath, 'r'));

        // Esperar a que el trabajo finalice y obtener el resultado
        $job = $cloudconvert->jobs()->wait($jobResult);

        // Obtener la tarea de exportación
        $exportTask = $job->getTasks()->whereName('export-my-file')[0];

        // Obtener la URL del archivo convertido
        $exportedFileUrl = $exportTask->getResult()->files[0]->url;

        // Descargar el archivo convertido en PDF usando el nombre original
        return response()->streamDownload(function () use ($exportedFileUrl) {
            echo file_get_contents($exportedFileUrl);
        }, $fileNameWithoutExtension . '.pdf');  // Aquí se usa el nombre original con extensión .pdf


    }


    public function descargar_word($id_lista){
        
        $lista_inspeccion=Listas_inspeccion::findOrFail($id_lista);
        $servicio=$lista_inspeccion->servicio_anexo;
        $anio = now()->year;

        $templatePaths = [
            'LISTA DE INSPECCIÓN VERIFICACION DE LOS SISTEMAS DE MEDICIÓN.docx',
        ];

       foreach ($templatePaths as $templatePath) {

           $fileName = pathinfo($templatePath, PATHINFO_FILENAME) . "_{$servicio->nomenclatura}.docx";
           $customFolderPath = "Servicios/Anexo_30/{$anio}/{$servicio->id_usuario}/{$servicio->nomenclatura}/Listas/${fileName}"; 

       }



        $file = Storage::disk('public')->path($customFolderPath);
        
        if (Storage::disk('public')->exists($customFolderPath)) {
            return response()->download($file);
        } else {
            return redirect()->back()->with('error', 'Archivo no encontrado.');
        }

    }


    
}
