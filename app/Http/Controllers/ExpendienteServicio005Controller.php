<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio_005;
use App\Models\Estados\Estados;
use App\Models\Verificador;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Estacion;
use App\Models\Expediente_Servicio_005;
use App\Models\Direccion;
class ExpendienteServicio005Controller extends Controller
{
    public function index($id)
    {
        // Obtener datos para la vista
        $data = $this->getServiceData($id);

        return view('armonia.servicios.005.expediente.generarExpediente', $data);
    }


    public function generarExpediente(Request $request)
    {
        try {
          
            // Validar los datos del formulario
            $validatedData = $this->validateExpedienteRequest($request);
          
            // Obtener datos relacionados desde la base de datos
            $estacion = $this->getEstacionData($validatedData['idestacion']);
            $usuario = $this->getUsuarioData($validatedData['id_usuario']);
            $direccionFiscal = $this->getDireccion($validatedData['domicilio_fiscal_id']);
            $direccionServicio = $this->getDireccion($validatedData['domicilio_servicio_id']);
          
            // Preparar los datos a usar en las plantillas
            $data = $this->prepareExpedienteData($validatedData, $estacion, $direccionFiscal, $direccionServicio);
           
            // Definir la carpeta de destino y procesar las plantillas
            $subFolderPath = $this->defineFolderPath($validatedData);
         
            $this->processTemplate($data, $subFolderPath, 'DETEC.docx');
            $this->processTemplate($data, $subFolderPath, 'CONTRATO.docx');
            $this->processTemplate($data, $subFolderPath, 'ORDEN DE TRABAJO.docx');

         
            // Guardar los datos de expediente
            $this->saveExpedienteData($data, $validatedData, $estacion);

            return redirect()->route('expediente_servicio_005.index', ['id' => $validatedData['id_servicio']])
                ->with('success', 'Expediente generado y guardado correctamente.');
            } catch (\Exception $e) {
                \Log::error("Error al generar el expediente: " . $e->getMessage());
                return response()->json(['error' => 'Ocurrió un error al generar el expediente.'], 500);
            }
    }


    public function generarReporteFotografico(Request $request)
    {

    
            // Validar los datos del formulario
            $validatedData = $this->validateReporteFotografico($request);
          
            // Obtener datos relacionados desde la base de datos
            $estacion = $this->getEstacionData($validatedData['idestacion']);
            $usuario = $this->getUsuarioData($validatedData['id_usuario']);
            $direccionServicio = $this->getDireccion($validatedData['domicilio_servicio_id']);
          
            // Preparar los datos a usar en las plantillas
            $data = $this->prepareReporteFotograficoData($validatedData, $estacion, $direccionServicio);
           
            // Definir la carpeta de destino y procesar las plantillas
            $subFolderPath = $this->defineFolderPath($validatedData);
         
            $this->processTemplate($data, $subFolderPath, 'REPORTE FOTOGRAFICO.docx');
         
            // Guardar los datos de expediente
            $this->saveReporteFotograficoData($data, $validatedData, $estacion);

            return redirect()->route('expediente_servicio_005.index', ['id' => $validatedData['id_servicio']])
                ->with('success', 'Expediente generado y guardado correctamente.');
            
    }


     // Método para definir la carpeta de destino
     private function defineFolderPath($validatedData)
     {
         $anio = now()->year;
         return "Servicios/005/{$anio}/{$validatedData['id_usuario']}/{$validatedData['nomenclatura']}/expediente";
     }

     // Método para preparar los datos que se usarán en las plantillas
     private function prepareExpedienteData($validatedData, $estacion, $direccionFiscal, $direccionServicio)
     {
        $totalData = $this->calculateTotal($validatedData['cantidad']); // Obtener total, mitad, y restante
         return array_merge($validatedData, [

             'numestacion' => $estacion->num_estacion,
             'razonsocial' => $estacion->razon_social,
             'id_usuario' => $validatedData['id_usuario'],
             'nomenclatura'=>$validatedData['nomenclatura'],
             'rfc' => $estacion->rfc,
             'fecha_actual' => now()->format('d/m/Y'),
             'domicilio_fiscal' => $this->formatAddress($direccionFiscal),
             'domicilio_estacion' => $this->formatAddress($direccionServicio),
             'cre' => $validatedData['num_cre'] ?? $estacion->num_cre,
             'constancia' => $validatedData['num_constancia'] ?? $estacion->num_constancia,
             'contacto' => $validatedData['contacto'] ?? $estacion->contacto,
             'nom_repre' => $validatedData['nombre_representante_legal'] ?? $estacion->nombre_representante_legal,
             'telefono' => $estacion->telefono,
             'correo' => $estacion->correo_electronico,
             'iva' => $this->calculateIva($validatedData['cantidad']),
             'total' => $totalData['total'],
             'total_mitad' => $totalData['total_mitad'],
             'total_restante' => $totalData['total_restante'],
             'fecha_inspeccion' => Carbon::parse($validatedData['fecha_inspeccion'])->format('d-m-Y'),
             'fecha_recepcion' => Carbon::parse($validatedData['fecha_recepcion'])->format('d-m-Y'),
             'fecha_inspeccion_modificada' => Carbon::parse($validatedData['fecha_inspeccion'])->addYear()->format('d-m-Y'),
             'cantidad' => $validatedData['cantidad'],
         ]);
     }
        // Método para preparar los datos que se usarán en las plantillas del reporte fotografico
        private function prepareReporteFotograficoData($validatedData, $estacion, $direccionServicio)
        {
            $anio = now()->year;
            $carpetaImages="Servicios/005/{$anio}/{$validatedData['id_usuario']}/{$validatedData['nomenclatura']}/expediente/imagenes_reporte_fotografico";
            //Creamos la carpteta donde iran las imagenes del reporte fotografico
            if (!Storage::disk('public')->exists($carpetaImages)) {
                Storage::disk('public')->makeDirectory($carpetaImages);
            }

            //Obtener las imagenes
             $imageNumber = 1;
           
             $imagePaths=[];
             foreach ( $validatedData['imagenes'] as $image) {
                 // Generar el nombre de la imagen
                 $imageName = 'img_' . $imageNumber . '.' . $image->extension();
                 
             
                 // Mover la imagen a la carpeta de destino, reemplazando si existe
                 $image->storeAs($carpetaImages, $imageName, 'public');
                
                 // Obtener la ruta completa de la imagen
                 $imagePath = Storage::disk('public')->path("$carpetaImages/$imageName") ?? null;
                  // Almacenar la ruta de la imagen en el array
                  $imagePaths[] = [
                     'name' => 'img_' . $imageNumber ,
                     'path' => $imagePath,
                 ];
                 $imageNumber++;
                  
             }

            return array_merge($validatedData, [
                'imagePaths'=>$imagePaths,
                'numestacion' => $estacion->num_estacion,
                'razonsocial' => $estacion->razon_social,
                'id_usuario' => $validatedData['id_usuario'],
                'nomenclatura'=>$validatedData['nomenclatura'],
                'domicilio_estacion' => $this->formatAddress($direccionServicio),
                'fecha_inspeccion' => Carbon::parse($validatedData['fecha_inspeccion'])->format('d-m-Y'),           
            ]);
        }


     // Método para formatear las direcciones
    private function formatAddress($direccion)
    {
        if (!$direccion) {
            return 'N/A';
        }

        return "Calle: {$direccion->calle}, Número Exterior: {$direccion->numero_exterior}, Colonia: {$direccion->colonia}, Localidad: {$direccion->localidad}, Municipio: {$direccion->municipio}, Entidad Federativa: {$direccion->entidad_federativa}";
    }


    private function saveReporteFotograficoData($data, $validatedData, $estacion){
       

        Expediente_Servicio_005::updateOrCreate(
            ['servicio_005_id' => $validatedData['id_servicio']],
            ['rutadoc_estacion' => $this->defineFolderPath($validatedData), 'usuario_id' => $validatedData['id_usuario']]
        );

    }

     // Guardar los datos en la base de datos
     private function saveExpedienteData($data, $validatedData, $estacion)
     {
         // Guardar datos de la estación
         $estacion->update([
             'num_cre' => $data['cre'],
             'num_constancia' => $data['constancia'],
             'contacto' => $data['contacto'],
             'nombre_representante_legal' => $data['nom_repre'],
         ]);
 
         // Guardar servicio y expediente
         $servicio = Servicio_005::updateOrCreate(
             ['id' => $validatedData['id_servicio']],
             ['date_recepcion_at' => $validatedData['fecha_recepcion'], 'date_inspeccion_at' => $validatedData['fecha_inspeccion']]
         );
 
         Expediente_Servicio_005::updateOrCreate(
             ['servicio_005_id' => $servicio->id],
             ['rutadoc_estacion' => $this->defineFolderPath($validatedData), 'usuario_id' => $validatedData['id_usuario']]
         );
     }

    // Método para procesar la plantilla
    private function processTemplate($data, $subFolderPath, $templateName)
    {
        $templateProcessor = new TemplateProcessor(storage_path("app/templates/servicio_005/Expediente/{$templateName}"));
        // Si el template es "REPORTE FOTOGRAFICO.docx", manejamos las imágenes
        if ($templateName == "REPORTE FOTOGRAFICO.docx") {
            if (isset($data['imagePaths']) && is_array($data['imagePaths'])) {
                foreach ($data['imagePaths'] as $image) {
                    if (isset($image['name']) && isset($image['path'])) {
                        // Agregamos la imagen al documento
                        $templateProcessor->setImageValue($image['name'], [
                            'path' => $image['path'],
                            'width' => 310,
                            'height' => 285,
                            'ratio' => false
                        ]);
                    }
                }
            }
        }
        
        // Reemplazamos los valores en el template
        foreach ($data as $key => $value) {
            // Ignoramos claves especiales que no deben ser procesadas como texto
            if ($key == 'imagePaths' || $key == 'imagenes') {
                continue; // Saltar estas claves
            }
            // Si el valor es un array, verificamos cómo manejarlo
            if (is_array($value)) {
                // Verificamos si es un array simple (no asociativo)
                if ($this->isAssociativeArray($value)) {
                    continue;
                } else {
                    // Si es un array numérico, lo convertimos a una cadena
                    $value = implode(", ", $value);
                }
            }

            // Reemplazamos el valor en el template
            $templateProcessor->setValue($key, (string) $value);
        }

        // Guardamos el archivo con un nombre único basado en la nomenclatura
        $fileName = pathinfo($templateName, PATHINFO_FILENAME) . "_{$data['nomenclatura']}.docx";
        $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
    }



    // Función auxiliar para verificar si un array es asociativo
    private function isAssociativeArray(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    // Método para obtener los datos del usuario
    private function getUsuarioData($idUsuario)
    {
        return User::on('mysql')->findOrFail($idUsuario);
    }

     // Método para obtener los datos de la estación
     private function getEstacionData($idestacion)
     {
         return Estacion::findOrFail($idestacion);
     }

     // Método para obtener los datos de la dirección
    private function getDireccion($idDireccion)
    {
        return Direccion::find($idDireccion);
    }

    // Validar los datos del formulario
    private function validateExpedienteRequest($request)
    {
        return $request->validate([
            'nomenclatura' => 'required|string',
            'idestacion' => 'required',
            'id_servicio' => 'required',
            'id_usuario' => 'required|exists:users,id',
            'numestacion' => 'required|string',
            'tipo_estacion' => 'required|string',
            'num_estacion' => 'required|string',
            'razon_social' => 'required|string',
            'rfc' => 'required|string',
            'estado_republica' => 'required|string',
            'num_cre' => 'nullable|string',
            'num_constancia' => 'nullable|string',
            'fecha_recepcion' => 'required|date',
            'telefono' => 'nullable|string',
            'correo_electronico' => 'nullable|email',
            'contacto' => 'nullable|string',
            'nombre_representante_legal' => 'nullable|string',
            'domicilio_fiscal_id' => 'nullable|integer',
            'domicilio_servicio_id' => 'nullable|integer',
            'fecha_inspeccion' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);
    }

    private function validateReporteFotografico($request){
        return $request->validate([
            'idestacion' => 'required',
            'id_servicio' => 'required',
            'nomenclatura' => 'required|string',
            'id_usuario' => 'required|exists:users,id',
            'domicilio_servicio_id' => 'nullable|integer',
            'fecha_inspeccion' => 'required|date',
            'imagenes' => 'required|array|min:4',
            'imagenes.*'=>' |image|mimes:jpeg,png,jpg,gif',
        ]);
    }

    private function getServiceData($id)
    {
        $servicio = Servicio_005::findOrFail($id);
        $estacion = $servicio->estaciones()->first();

        if (!$estacion) {
            throw new \Exception('No se encontraron estaciones relacionadas.');
        }

        // Obtener las direcciones usando las relaciones
        $direccionFiscal = $estacion->domicilioFiscal;  // Relación definida en el modelo
        $direccionEstacion = $estacion->domicilioServicio;  // Relación definida en el modelo

        // Obtener los estados
        $estados = Estados::all();

        // Inicializar variables de verificadores y verificador
        $verificadores = [];
        $verificador = null;
        $usuarios = [];

        // Si el usuario es administrador
        if (auth()->user()->hasRole('Administrador')) {
            $verificadores = Verificador::all();

            // Si no hay verificadores, obtener los usuarios
            if ($verificadores->isEmpty()) {
                $usuarios = User::all(); // Obtener todos los usuarios para asignar un RFC
            }
        } else {
            // Si no es administrador, busca el verificador del usuario logueado
            $verificador = Verificador::where('usuario_id', auth()->user()->id)->first();

            // Si no está registrado como verificador, el verificador será null
            if (!$verificador) {
                $verificador = null;
            }
        }

        // Ruta para los archivos
        $anio = now()->year;
        $folderPath = "Servicios/005/{$anio}/{$servicio->id_usuario}/{$servicio->nomenclatura}/expediente";
        $existingFiles = $this->getExistingFiles($folderPath);

        // Pasar datos a la vista
        return compact('servicio', 'estacion', 'estados', 'existingFiles', 'direccionEstacion', 'direccionFiscal', 'verificadores', 'verificador', 'usuarios');
    }

    // Método para obtener archivos existentes en la carpeta
    private function getExistingFiles($folderPath)
    {
        $existingFiles = [];

        if (Storage::disk('public')->exists($folderPath)) {
            $files = Storage::disk('public')->files($folderPath);

            foreach ($files as $file) {
                $existingFiles[] = [
                    'name' => $file,
                    'url' => Storage::url($file)
                ];
            }
        }

        return $existingFiles;
    }

    // Método para calcular IVA y totales
    private function calculateIva($cantidad)
    {
        return number_format($cantidad * 0.16, 2, '.', ',');
    }

    private function calculateTotal($cantidad)
    {
        $iva = $cantidad * 0.16;
        $total = $cantidad + $iva;

        return [
            'total' => number_format($total, 2, '.', ','),
            'total_mitad' => number_format($total * 0.50, 2, '.', ','),
            'total_restante' => number_format($total - ($total * 0.50), 2, '.', ','),
        ];
    }

}
