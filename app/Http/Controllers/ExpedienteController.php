<?php

namespace App\Http\Controllers;

use App\Models\Certificado_Anexo30;
use App\Models\Direccion;
use App\Models\Dispensario;
use App\Models\Estados\Estados;
use App\Models\Expediente_Servicio_Anexo_30;
use App\Models\ProveedorInformatico;
use App\Models\ServicioAnexo;
use App\Models\Estacion;
use App\Models\Medidor_Flujo;
use App\Models\Servicio_005;
use App\Models\Sondas;
use App\Models\Tanque;
use App\Models\User;
use App\Models\Veeder_Root;
use App\Models\Verificador;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;

class ExpedienteController extends Controller
{

    public function convertirDocxAPdf($filePath)
    {
        // Inicializar CloudConvert con tu API Key
        $cloudconvert = new CloudConvert(['api_key' => env('CLOUDCONVERT_API_KEY')]);

        // Ruta completa del archivo .docx
        $fullPath = storage_path('app/public/' . $filePath);

        // Extraer el nombre del archivo sin la extensión
        $fileNameWithoutExtension = pathinfo($filePath, PATHINFO_FILENAME);

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

    public function index($id)
    {
        // Obtener datos para la vista
        $data = $this->getServiceData($id);

        return view('armonia.servicios.anexo_30.expediente.generarExpediente', $data);
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
            $data = $this->prepareExpedienteData($validatedData, $estacion, $direccionFiscal, $direccionServicio, $usuario);
            $data2 = $this->prepareExpedienteDataCalibracion($validatedData, $estacion, $direccionFiscal, $direccionServicio, $usuario);

            // Definir la carpeta de destino y procesar las plantillas
            $subFolderPath = $this->defineFolderPath($validatedData);
            //$subFolderPath2 = $this->defineFolderPathCalibraciones($validatedData);
            $this->processTemplate($data, $subFolderPath, 'FORMATO DE DETECCIÓN DE RIESGOS A LA IMPARCIALIDAD.docx');
            $this->processTemplate($data, $subFolderPath, 'FORMATO PARA CONTRATO DE PRESTACIÓN DE SERVICIOS DE INSPECCIÓN DE LOS ANEXOS 30 Y 31 RESOLUCIÓN MISCELÁNEA FISCAL PARA 2024.docx');
            $this->processTemplate($data, $subFolderPath, 'ORDEN DE TRABAJO.docx');
            $this->processTemplate($data, $subFolderPath, 'PLAN DE INSPECCIÓN DE LOS SISTEMAS DE MEDICION.docx');
            $this->processTemplate($data, $subFolderPath, 'PLAN DE INSPECCIÓN DE PROGRAMAS INFORMATICOS.docx');
            $this->processTemplateCalibraciones($data2, $subFolderPath, 'CALIBRACION SONDAS.docx');
            // Guardar los datos de expediente
            $this->saveExpedienteData($data, $validatedData, $estacion);

            return redirect()->route('expediente.index', ['id' => $validatedData['id_servicio']])
                ->with('success', 'Expediente generado y guardado correctamente.');
        } catch (\Exception $e) {
            //\Log::error("Error al generar el expediente: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al generar el expediente.'], 500);
        }
    }

    public function guardarDictamenesInformatico(Request $request)
    {
        try {
            // Obtener el ID de servicio, usuario y estación desde la solicitud
            $idServicio = $request->input('id_servicio');
            $idUsuario = $request->input('id_usuario');
            $idEstacion = $request->input('idestacion');

            // Buscar los datos necesarios
            $servicio = ServicioAnexo::findOrFail($idServicio);
            $usuario = User::findOrFail($idUsuario);
            $estacion = Estacion::findOrFail($idEstacion);

            // Definir las reglas de validación
            $rules = $this->getDictamenesRules();
            $data = $request->validate($rules);
            // Reemplazar campos vacíos con un guion
            $data = $this->reemplazarVacioPorGuion($data, [
                'detalleOpinion1',
                'recomendaciones1',
                'detalleOpinion2',
                'recomendaciones2',
                'detalleOpinion3',
                'recomendaciones3',
                'detalleOpinion4',
                'recomendaciones4',
                'detalleOpinion5',
                'recomendaciones5'
            ]);
            // Obtener y formatear fechas desde el servicio
            $fechaInspeccion = Carbon::parse($servicio->date_inspeccion_at)->format('d-m-Y');
            $fechaRecepcion = Carbon::parse($servicio->date_recepcion_at)->format('d-m-Y');
            $fechaInspeccionAumentada = Carbon::parse($servicio->date_inspeccion_at)->addYear()->format('d-m-Y');

            // Obtener las direcciones de la estación
            $direccionEstacion = Direccion::where('id', $estacion->domicilio_servicio_id)->first();

            // Procesar las opciones seleccionadas (opcion1, opcion2, etc.)
            $data = array_merge($data, [
                'fecha_inspeccion' => $fechaInspeccion,
                'fecha_recepcion' => $fechaRecepcion,
                'fecha_inspeccion_modificada' => $fechaInspeccionAumentada,
                'nom_verificador' => $usuario->name,
                'razonsocial' => $estacion->razon_social,
                'direccion_estacion' => $this->formatAddress($direccionEstacion),
                'telefono' => $estacion->telefono,
                'correo' => $estacion->correo_electronico,
            ]);

            // Procesar opciones (opcion1, opcion2, etc.) para plantillas
            $data = array_merge($data, $this->processDictamenOptions($data));

            // Guardar o crear registro del proveedor informático
            $this->saveProveedorInformatico($data, $idServicio);

            // Procesar las plantillas de Word
            $this->processDictamenesTemplates($data);

            return redirect()->route('expediente.index', ['id' => $data['id_servicio']])
                ->with('success', 'Dictamen Informático guardado correctamente.');
        } catch (\Exception $e) {
            //  \Log::error("Error al generar documentos: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al procesar la solicitud.'], 500);
        }
    }
    private function processDictamenOptions($data)
    {
        $processedData = [];

        for ($i = 0; $i <= 6; $i++) {
            $opcion = $data["opcion{$i}"] ?? null;

            // Procesar la opción seleccionada y asignar los valores correspondientes en la plantilla
            switch ($opcion) {
                case 'cumple':
                    $processedData["si{$i}"] = 'X';
                    $processedData["no{$i}"] = ' ';
                    $processedData["noaplica{$i}"] = ' ';
                    break;
                case 'no_cumple':
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

    public function guardarDictamenesMedicion(Request $request)
    {
        try {
            // Obtener el ID de servicio, usuario y estación desde la solicitud
            $idServicio = $request->input('id_servicio');
            $idUsuario = $request->input('id_usuario');
            $idEstacion = $request->input('idestacion');

            // Buscar los datos del servicio, usuario y estación
            $servicio = ServicioAnexo::findOrFail($idServicio);
            $usuario = User::findOrFail($idUsuario);
            $estacion = Estacion::findOrFail($idEstacion);

            // Buscar los datos del proveedor informático por el ID del servicio
            $proveedor = ProveedorInformatico::where('servicio_anexo_id', $idServicio)->first();

            // Validar los datos del formulario
            $rules = $this->getDictamenesMedicionRules();
            $data = $request->validate($rules);
            // Reemplazar campos vacíos con un guion
            $data = $this->reemplazarVacioPorGuion($data, [
                'detalleOpinion1',
                'recomendaciones1',
                'detalleOpinion2',
                'recomendaciones2',
                'detalleOpinion3',
                'recomendaciones3',
                'detalleOpinion4',
                'recomendaciones4',
                'detalleOpinion5',
                'recomendaciones5'
            ]);
            // Obtener y formatear fechas desde el servicio
            $fechaInspeccion = Carbon::parse($servicio->date_inspeccion_at)->format('d-m-Y');
            $fechaRecepcion = Carbon::parse($servicio->date_recepcion_at)->format('d-m-Y');
            $fechaInspeccionAumentada = Carbon::parse($servicio->date_inspeccion_at)->addYear()->format('d-m-Y');

            // Obtener las direcciones de la estación
            $direccionEstacion = Direccion::where('id', $estacion->domicilio_servicio_id)->first();

            // Completar los datos necesarios para el procesamiento
            $data = array_merge($data, [
                'fecha_inspeccion' => $fechaInspeccion,
                'fecha_recepcion' => $fechaRecepcion,
                'fecha_inspeccion_modificada' => $fechaInspeccionAumentada,
                'nom_verificador' => $usuario->name,
                'id_estacion' => $estacion->id,
                'razonsocial' => $estacion->razon_social,
                'direccion_estacion' => $this->formatAddress($direccionEstacion),
                'telefono' => $estacion->telefono,
                'correo' => $estacion->correo_electronico,
                // Añadir los datos del proveedor si están disponibles
                'proveedor' => $proveedor->nombre ?? 'N/A',
                'rfc_proveedor' => $proveedor->rfc ?? 'N/A',
                'software' => $proveedor->nombre_software ?? 'N/A',
                'version' => $proveedor->version ?? 'N/A',
            ]);

            // Procesar las opciones seleccionadas (opcion1, opcion2, etc.)
            $data = array_merge($data, $this->processDictamenOptions($data));

            // Procesar las plantillas de Word para medición
            $this->processDictamenesTemplatesMedicion($data);

            // Redirigir con éxito
            return redirect()->route('expediente.index', ['id' => $data['id_servicio']])
                ->with('success', 'Dictamen de Medición guardado correctamente.');
        } catch (\Exception $e) {
            //\Log::error("Error al generar documentos: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al procesar la solicitud.'], 500);
        }
    }



    // Métodos auxiliares

    // Método para obtener los datos del servicio y archivos existentes
    private function getServiceData($id)
    {
        $servicioAnexo = ServicioAnexo::findOrFail($id);
        $estacion = $servicioAnexo->estaciones()->first();
        $proveedorinfo = ProveedorInformatico::where('servicio_anexo_id', $id)->first();

        if (!$estacion) {
            throw new \Exception('No se encontraron estaciones relacionadas.');
        }

        // Obtener las direcciones usando las relaciones
        $direccionFiscal = $estacion->domicilioFiscal;
        $direccionEstacion = $estacion->domicilioServicio;

        // Obtener los estados
        $estados = Estados::all();

        // Inicializar variables de verificadores y verificador
        $verificadores = [];
        $verificador = null;
        $usuarios = [];

        if (auth()->user()->hasRole('Administrador')) {
            $verificadores = Verificador::all();
            if ($verificadores->isEmpty()) {
                $usuarios = User::all();
            }
        } else {
            $verificador = Verificador::where('usuario_id', auth()->user()->id)->first();
            if (!$verificador) {
                $verificador = null;
            }
        }

        // Obtener las fechas ocupadas de inspección y recepción de servicios Anexo 30 del mismo usuario
        $fechasOcupadasAnexo30 = ServicioAnexo::where('id_usuario', $servicioAnexo->id_usuario)
            ->where('id', '!=', $id) // Excluir el servicio actual
            ->get(['date_recepcion_at', 'date_inspeccion_at', 'nomenclatura'])
            ->flatMap(function ($servicio) {
                return [
                    ['fecha' => $servicio->date_recepcion_at, 'nomenclatura' => $servicio->nomenclatura],
                    ['fecha' => $servicio->date_inspeccion_at, 'nomenclatura' => $servicio->nomenclatura],
                ];
            })
            ->filter(function ($item) {
                return !empty($item['fecha']);
            })
            ->values()
            ->toArray();

        // Obtener las fechas ocupadas de inspección y recepción de los servicios 005 del mismo usuario
        $fechasOcupadas005 = Servicio_005::where('id_usuario', $servicioAnexo->id_usuario)
            ->get(['date_recepcion_at', 'date_inspeccion_at', 'nomenclatura'])
            ->flatMap(function ($servicio) {
                return [
                    ['fecha' => $servicio->date_recepcion_at, 'nomenclatura' => $servicio->nomenclatura],
                    ['fecha' => $servicio->date_inspeccion_at, 'nomenclatura' => $servicio->nomenclatura],
                ];
            })
            ->filter(function ($item) {
                return !empty($item['fecha']);
            })
            ->values()
            ->toArray();

        // Ruta para los archivos
        $anio = now()->year;
        $folderPath = "Servicios/Anexo_30/{$anio}/{$servicioAnexo->id_usuario}/{$servicioAnexo->nomenclatura}/expediente";
        $existingFiles = $this->getExistingFiles($folderPath);


        //Pasamos las categorias de las imagenes

        $categorias_imagen = [
            '005',
            'Anexo',
            'Anuncio luminario',
            'Bombas',
            'Generales',
            'Inspectores',
            'Tanques'
        ];

        // Pasar datos a la vista
        return compact('categorias_imagen', 'servicioAnexo', 'estacion', 'estados', 'existingFiles', 'direccionEstacion', 'direccionFiscal', 'verificadores', 'verificador', 'usuarios', 'proveedorinfo', 'fechasOcupadasAnexo30', 'fechasOcupadas005');
    }



    // Validar los datos del formulario
    private function validateExpedienteRequest($request)
    {
        return $request->validate([
            'nomenclatura' => 'required|string',
            'idestacion' => 'required',
            'id_servicio' => 'required',
            'id_usuario' => 'required',
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


    // Método para obtener los datos de la estación
    private function getEstacionData($idestacion)
    {
        return Estacion::findOrFail($idestacion);
    }

    // Método para obtener los datos del usuario
    private function getUsuarioData($idUsuario)
    {
        return User::on('mysql')->findOrFail($idUsuario);
    }

    // Método para obtener los datos de la dirección
    private function getDireccion($idDireccion)
    {
        return Direccion::find($idDireccion);
    }

    private function prepareExpedienteData($validatedData, $estacion, $direccionFiscal, $direccionServicio, $usuario)
    {
        // Redondear la cantidad sin IVA a 2 decimales
        $cantidadSinIva = round($validatedData['cantidad'] / 1.16, 2);
        $iva = round($this->calculateIva($validatedData['cantidad']), 2);
        $totalData = $this->calculateTotal($cantidadSinIva); // Obtener total, mitad, y restante

        // Redondear cada parte del total a 2 decimales
        $total = round($totalData['total'], 2);
        $totalMitad = round($totalData['total_mitad'], 2);
        $totalRestante = round($totalData['total_restante'], 2);

        // Convertir a letras después de redondear los números
        $cantidadEnLetras = $this->numeroALetras($cantidadSinIva);
        $ivaEnLetras = $this->numeroALetras($iva);
        $totalEnLetras = $this->numeroALetras($total);
        $mitadEnLetras = $this->numeroALetras($totalMitad);
        $restanteEnLetras = $this->numeroALetras($totalRestante);

        // Obtener la fecha actual desglosada
        $fechaActual = Carbon::now();
        $diaActual = $fechaActual->format('d');
        $mesActual = $fechaActual->translatedFormat('F'); // Mes en texto (en español)
        $anioActual = $fechaActual->format('Y');

        // Formato completo de la fecha
        $fechaCompleta = "{$diaActual} de {$mesActual} del {$anioActual}";

        return array_merge($validatedData, [
            'numestacion' => $estacion->num_estacion,
            'razonsocial' => $estacion->razon_social,
            'id_usuario' => $usuario->name,
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

            // Cantidades numéricas redondeadas y formateadas para mostrar
            'iva' => number_format($iva, 2, '.', ','),
            'cantidad' => number_format($cantidadSinIva, 2, '.', ','), // Cantidad sin IVA redondeada
            'total' => number_format($total, 2, '.', ','), // Total redondeado con IVA
            'total_mitad' => number_format($totalMitad, 2, '.', ','), // 50% del total redondeado
            'total_restante' => number_format($totalRestante, 2, '.', ','), // Resto del total redondeado

            // Fechas
            'fecha_inspeccion' => Carbon::parse($validatedData['fecha_inspeccion'])->format('d-m-Y'),
            'fecha_recepcion' => Carbon::parse($validatedData['fecha_recepcion'])->format('d-m-Y'),
            'fecha_inspeccion_modificada' => Carbon::parse($validatedData['fecha_inspeccion'])->addYear()->format('d-m-Y'),

            // Fecha actual desglosada y en texto completo
            'fecha_completa' => $fechaCompleta,

            // Cantidades en letras (con valores redondeados)
            'cantidad_letras' => $cantidadEnLetras,
            'iva_letras' => $ivaEnLetras,
            'total_letras' => $totalEnLetras,
            'total_mitad_letras' => $mitadEnLetras,
            'total_restante_letras' => $restanteEnLetras,
        ]);
    }
    // Método para convertir números a letras
    private function numeroALetras($numero)
    {
        // Redondear el número a 2 decimales y separar la parte entera y la parte decimal
        $entero = floor($numero); // Parte entera del número
        $decimales = round(($numero - $entero) * 100); // Parte decimal redondeada a dos decimales

        // Usar NumberFormatter para convertir la parte entera a letras
        $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
        $enteroEnLetras = ucfirst($formatter->format($entero));

        // Si hay decimales, los añadimos en letras con la palabra 'punto'
        if ($decimales > 0) {
            // Aquí el uso de 'punto' en vez de 'coma' para la separación decimal
            $decimalesEnLetras = $formatter->format($decimales);
            return "{$enteroEnLetras} punto {$decimalesEnLetras}";
        }

        // Si no hay decimales, solo devolvemos la parte entera en letras
        return $enteroEnLetras;
    }

    // Método para formatear las direcciones
    private function formatAddress($direccion)
    {
        if (!$direccion) {
            return 'N/A';
        }

        $components = [];

        if (!empty($direccion->calle)) {
            $components[] = "{$direccion->calle}";
        }
        if (!empty($direccion->numero_exterior)) {
            $components[] = "# {$direccion->numero_exterior}";
        }
        if (!empty($direccion->colonia)) {
            $components[] = "C. {$direccion->colonia}";
        }
        if (!empty($direccion->localidad)) {
            $components[] = "{$direccion->localidad}";
        }
        if (!empty($direccion->municipio)) {
            $components[] = "{$direccion->municipio}";
        }
        if (!empty($direccion->entidad_federativa)) {
            $components[] = "{$direccion->entidad_federativa}";
        }
        if (!empty($direccion->codigo_postal)) {
            $components[] = "C.P. {$direccion->codigo_postal}";
        }

        // Unir los componentes que no son nulos con una coma
        return !empty($components) ? implode(', ', $components) : 'N/A';
    }
    // Método para calcular IVA (debe retornar un número redondeado)
    private function calculateIva($cantidad)
    {
        return round(($cantidad / 1.16) * 0.16, 2); // Redondea a 2 decimales
    }

    // Método para calcular totales (debe retornar números redondeados)
    private function calculateTotal($cantidad)
    {
        $iva = round($cantidad * 0.16, 2); // Redondea a 2 decimales
        $total = round($cantidad + $iva, 2); // Redondea el total a 2 decimales

        return [
            'total' => $total, // Total redondeado
            'total_mitad' => round($total * 0.50, 2), // Mitad del total redondeada a 2 decimales
            'total_restante' => round($total - ($total * 0.50), 2), // Resto del total redondeado
        ];
    }

    // Método para definir la carpeta de destino
    private function defineFolderPath($validatedData)
    {
        $anio = now()->year;
        return "Servicios/Anexo_30/{$anio}/{$validatedData['id_usuario']}/{$validatedData['nomenclatura']}/expediente";
    }

    // Método para procesar la plantilla
    private function processTemplate($data, $subFolderPath, $templateName)
    {

        $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Expediente/{$templateName}"));
        if ($templateName == "REPORTE FOTOGRAFICO.docx") {
            if (isset($data['imagePaths'])) {
                $totalImages = count($data['imagePaths']);
                $maxImages = 8;

                foreach ($data['imagePaths'] as $image) {

                    $imageRelativePath = "Estaciones/{$data['numestacion']}/Imagenes/{$image['categoria']}/{$image['nombre_original']}";

                    $imagePath = Storage::disk('public')->path($imageRelativePath);
                    if (!empty($image['name'])) {
                        $templateProcessor->setImageValue($image['name'], [
                            'path' => $imagePath,
                            'width' => 310,
                            'height' => 285,
                            'ratio' => false
                        ]);
                    }
                }
                for ($i = $totalImages + 1; $i <= $maxImages; $i++) {

                    $templateProcessor->setValue("img_$i", '');
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
    private function isAssociativeArray(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    // Método para procesar las plantillas del dictamen informático
    private function processDictamenesTemplates($data)
    {
        $templatePaths = [
            'DICTAMEN TECNICO DE PROGRAMAS INFORMATICOS.docx',
        ];

        // Definir la carpeta de destino usando el método defineFolderPath
        $subFolderPath = $this->defineFolderPath($data);

        // Crear la carpeta personalizada si no existe
        if (!Storage::disk('public')->exists($subFolderPath)) {
            Storage::disk('public')->makeDirectory($subFolderPath);
        }

        // Reemplazar marcadores en las plantillas
        foreach ($templatePaths as $templatePath) {
            $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Dictamenes/{$templatePath}"));

            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }

            $fileName = pathinfo($templatePath, PATHINFO_FILENAME) . "_{$data['nomenclatura']}.docx";
            $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
        }
    }

    private function processDictamenesTemplatesMedicion($data)
    {
        $templatePaths = [
            'DICTAMEN TECNICO DE SISTEMAS DE MEDICION.docx',
        ];

        // Definir la carpeta de destino usando el método defineFolderPath
        $subFolderPath = $this->defineFolderPath($data);

        // Crear la carpeta personalizada si no existe
        if (!Storage::disk('public')->exists($subFolderPath)) {
            Storage::disk('public')->makeDirectory($subFolderPath);
        }

        // Obtener los datos de los equipos de medición (tanques, sondas, dispensarios)
        $equipos = $this->getEquiposMedicionData($data['id_estacion']);

        foreach ($templatePaths as $templatePath) {
            $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Dictamenes/{$templatePath}"));

            // Realizar reemplazos estáticos de datos
            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }

            // Agregar filas dinámicamente a la tabla
            $templateProcessor->cloneRow('EQUIPO', count($equipos));
            foreach ($equipos as $index => $equipo) {
                $templateProcessor->setValue('EQUIPO#' . ($index + 1), $equipo['EQUIPO']);
                $templateProcessor->setValue('IDENTIFICACION#' . ($index + 1), $equipo['IDENTIFICACION']);
                $templateProcessor->setValue('NORMA#' . ($index + 1), $equipo['NORMA']);
            }

            // Guardar el documento modificado
            $fileName = pathinfo($templatePath, PATHINFO_FILENAME) . "_{$data['nomenclatura']}.docx";
            $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
        }
    }

    // Método para obtener los datos de los equipos de medición
    // Método para obtener los datos de los equipos de medición
    private function getEquiposMedicionData($estacion_id)
    {
        // Obtener tanques, sondas, dispensarios y veeder-root de la estación
        $tanques = Tanque::where('estacion_id', $estacion_id)->get();
        $sondas = Sondas::where('estacion_id', $estacion_id)->get();
        $dispensarios = Dispensario::where('estacion_id', $estacion_id)->get();
        $veederRoots = Veeder_Root::where('estacion_id', $estacion_id)->get();

        $equipos = [];

        // Agregar tanques a la lista de equipos
        foreach ($tanques as $tanque) {
            $equipos[] = [
                'EQUIPO' => 'Tanque ' . $tanque->producto,
                'IDENTIFICACION' => $tanque->folio,
                'NORMA' => 'ANEXOS 30 Y 31 DE LA RESOLUCIÓN MISCELÁNEA FISCAL PARA 2023',
            ];
        }

        // Agregar sondas a la lista de equipos
        foreach ($sondas as $sonda) {
            $equipos[] = [
                'EQUIPO' => 'Sonda Flexible de Tanque',
                'IDENTIFICACION' => $sonda->numero_serie,
                'NORMA' => 'ANEXOS 30 Y 31 DE LA RESOLUCIÓN MISCELÁNEA FISCAL PARA 2023',
            ];
        }

        // Agregar dispensarios y sus medidores de flujo a la lista de equipos
        foreach ($dispensarios as $dispensario) {
            // Agregar el dispensario con formato: Dispensario {num_isla} - {marca} - {modelo}
            $equipos[] = [
                'EQUIPO' => 'Dispensario ' . $dispensario->num_isla . ' - ' . $dispensario->marca . ' - ' . $dispensario->modelo,
                'IDENTIFICACION' => $dispensario->numero_serie,
                'NORMA' => 'ANEXOS 30 Y 31 DE LA RESOLUCIÓN MISCELÁNEA FISCAL PARA 2023',
            ];

            // Obtener los medidores de flujo asociados a este dispensario
            $medidoresFlujo = Medidor_Flujo::where('dispensario_id', $dispensario->id)->get();

            // Agregar cada medidor de flujo asociado con el formato: Medidor de Flujo tipo Desplazamiento Positivo {numero_medidor} Dispensario {num_isla}
            $contador = 1; // Contador para numerar los medidores de flujo
            foreach ($medidoresFlujo as $medidorFlujo) {
                $equipos[] = [
                    'EQUIPO' => 'Medidor de Flujo tipo Desplazamiento Positivo ' . $contador . ' Dispensario ' . $dispensario->num_isla,
                    'IDENTIFICACION' => $medidorFlujo->numero_serie,
                    'NORMA' => 'ANEXOS 30 Y 31 DE LA RESOLUCIÓN MISCELÁNEA FISCAL PARA 2023',
                ];
                $contador++; // Incrementar el contador para el siguiente medidor
            }
        }

        // Agregar los Veeder-Root a la lista de equipos con el formato: Consola de Telemedición - VEEDER ROOT – {modelo}
        foreach ($veederRoots as $veederRoot) {
            $equipos[] = [
                'EQUIPO' => 'Consola de Telemedición - VEEDER ROOT – ' . $veederRoot->modelo,
                'IDENTIFICACION' => $veederRoot->numero_serie,
                'NORMA' => 'ANEXOS 30 Y 31 DE LA RESOLUCIÓN MISCELÁNEA FISCAL PARA 2023',
            ];
        }

        return $equipos;
    }

    // Método para guardar o actualizar los datos del proveedor informático
    private function saveProveedorInformatico($data, $idServicio)
    {
        ProveedorInformatico::updateOrCreate(
            ['servicio_anexo_id' => $idServicio],
            [
                'nombre' => $data['proveedor'],
                'rfc' => $data['rfc_proveedor'],
                'nombre_software' => $data['software'],
                'version' => $data['version'],
                'servicio_anexo_id' => $idServicio
            ]
        );
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
        $servicio = ServicioAnexo::updateOrCreate(
            ['id' => $validatedData['id_servicio']],
            ['date_recepcion_at' => $validatedData['fecha_recepcion'], 'date_inspeccion_at' => $validatedData['fecha_inspeccion'], 'costo_total' => $validatedData['cantidad']]
        );

        Expediente_Servicio_Anexo_30::updateOrCreate(
            ['servicio_anexo_id' => $servicio->id],
            ['rutadoc_estacion' => $this->defineFolderPath($validatedData), 'usuario_id' => $validatedData['id_usuario']]
        );
    }

    //Remplzar por guion campos vacios
    private function reemplazarVacioPorGuion($data, $campos)
    {
        foreach ($campos as $campo) {
            // Reemplazar por guion solo si el campo está estrictamente vacío o nulo
            if (!array_key_exists($campo, $data) || trim($data[$campo]) === '') {
                $data[$campo] = '-';
            }
        }
        return $data;
    }

    // Reglas para validar los datos del dictamen informático
    private function getDictamenesRules()
    {
        return [
            'nomenclatura' => 'required|string',
            'id_servicio' => 'required',
            'id_usuario' => 'required',
            'nom_repre' => 'required',
            'proveedor' => 'required',
            'rfc_proveedor' => 'required',
            'software' => 'required',
            'version' => 'required',
            'opcion1' => 'required',
            'opcion2' => 'required',
            'opcion3' => 'required',
            'opcion4' => 'required',
            'opcion5' => 'required',
            'opcion6' => 'required',
            'detalleOpinion1' => 'nullable|string',
            'recomendaciones1' => 'nullable|string',
            'detalleOpinion2' => 'nullable|string',
            'recomendaciones2' => 'nullable|string',
            'detalleOpinion3' => 'nullable|string',
            'recomendaciones3' => 'nullable|string',
            'detalleOpinion4' => 'nullable|string',
            'recomendaciones4' => 'nullable|string',
            'detalleOpinion5' => 'nullable|string',
            'recomendaciones5' => 'nullable|string',
        ];
    }

    private function getDictamenesMedicionRules()
    {
        return [
            'nomenclatura' => 'required|string',
            'id_servicio' => 'required',
            'id_usuario' => 'required',
            'nom_repre' => 'required',
            'opcion1' => 'required',
            'opcion2' => 'required',
            'opcion3' => 'required',
            'opcion4' => 'required',
            'opcion6' => 'required',
            'detalleOpinion1' => 'nullable|string',
            'recomendaciones1' => 'nullable|string',
            'detalleOpinion2' => 'nullable|string',
            'recomendaciones2' => 'nullable|string',
            'detalleOpinion3' => 'nullable|string',
            'recomendaciones3' => 'nullable|string',
            'detalleOpinion4' => 'nullable|string',
            'recomendaciones4' => 'nullable|string',
        ];
    }


    public function guardarCertificado(Request $request)
    {
        try {
            // Validar los datos del formulario
            $rules = [
                'nomenclatura' => 'required',
                'idestacion' => 'required',
                'id_servicio' => 'required',
                'id_usuario' => 'required',
                'RfcRepresentanteLegal' => 'required',
                'RfcPersonal' => 'required',
            ];

            // Validar los datos
            $data = $request->validate($rules);

            // Obtener la estación y servicio utilizando funciones auxiliares
            $estacion = $this->getEstacionData($data['idestacion']);
            $servicio = ServicioAnexo::findOrFail($data['id_servicio']);

            // Verificar el rol del usuario y manejar el RFC del Verificador
            if (auth()->user()->hasRole('Administrador')) {
                // Administrador: selecciona un usuario y su RFC
                if ($request->has('RfcPersonal') && !empty($request->input('RfcPersonal'))) {
                    // Si selecciona un RFC de la lista de verificadores o lo proporciona manualmente
                    $verificador = Verificador::where('rfc', $data['RfcPersonal'])->first();

                    // Si no existe el verificador, creamos uno nuevo
                    if (!$verificador) {
                        $usuarioSeleccionado = User::findOrFail($request->input('usuario_id_verificador'));
                        $verificador = Verificador::create([
                            'usuario_id' => $usuarioSeleccionado->id,
                            'rfc' => $data['RfcPersonal'],
                            'nombre_verificador' => $usuarioSeleccionado->name,
                        ]);
                    }
                } else {
                    // Si no selecciona un RFC, devolver un error
                    return back()->withErrors(['RfcPersonal' => 'Debe proporcionar un RFC válido para el verificador.']);
                }
            } else {
                // Si no es administrador, comprobar si ya tiene un verificador asociado
                $verificador = Verificador::where('usuario_id', auth()->user()->id)->first();

                // Si no existe un verificador, se crea uno con el RFC proporcionado
                if (!$verificador) {
                    if ($request->has('RfcPersonal') && !empty($request->input('RfcPersonal'))) {
                        $verificador = Verificador::create([
                            'usuario_id' => auth()->user()->id,
                            'rfc' => $data['RfcPersonal'],
                            'nombre_verificador' => auth()->user()->name,
                        ]);
                    } else {
                        // Si no se proporciona un RFC, devolver un error
                        return back()->withErrors(['RfcPersonal' => 'Debe proporcionar un RFC válido para el verificador.']);
                    }
                }
            }


            // Obtener la fecha de inspección y recepción formateadas
            $fechaInspeccion = Carbon::parse($servicio->date_inspeccion_at)->format('Y-m-d');
            $fechaRecepcion = Carbon::parse($servicio->date_recepcion_at)->format('Y-m-d');

            // Generar el número de folio y procesar el certificado
            $numeroFolioCertificado = $this->generateFolioNumber($data['nomenclatura']);
            $fisica = ($data['RfcRepresentanteLegal'] === $estacion->rfc);

            // Procesar la plantilla del certificado con el verificador
            $this->processCertificadoTemplate($data, $estacion, $verificador, $fechaInspeccion, $fechaRecepcion, $numeroFolioCertificado, $fisica, $this->defineFolderPath($data));

            // Generar archivo JSON y guardar en la base de datos
            $this->generateCertificadoJson($data, $estacion, $fechaInspeccion, $numeroFolioCertificado, $this->defineFolderPath($data));
            $this->saveCertificadoToDatabase($data, $this->defineFolderPath($data));

            return redirect()->route('expediente.index', ['id' => $data['id_servicio']])
                ->with('success', 'Certificado guardado correctamente.');
        } catch (\Exception $e) {
            // Manejo del error
            \Log::error("Error al generar el certificado: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al generar el certificado.'], 500);
        }
    }

    // Función auxiliar para procesar la plantilla de certificado
    private function processCertificadoTemplate($data, $estacion, $verificador, $fechaInspeccion, $fechaRecepcion, $numeroFolioCertificado, $fisica, $subFolderPath)
    {
        $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Certificado/CERTIFICADO.docx"));

        // Reemplazar marcadores en la plantilla
        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        // Reemplazar datos específicos
        $templateProcessor->setValue('${nombre_verificador}', $verificador->usuario->name);
        $templateProcessor->setValue('${fecha_inspeccion}', $fechaInspeccion);
        $templateProcessor->setValue('${fecha_recepcion}', $fechaRecepcion);
        $templateProcessor->setValue('${razon_social}', strtoupper($estacion->razon_social));
        $templateProcessor->setValue('${numeroFolioCertificado}', $numeroFolioCertificado);
        $templateProcessor->setValue('${F}', $fisica ? 'X' : ' ');
        $templateProcessor->setValue('${M}', $fisica ? ' ' : 'X');

        // Obtener la dirección desglosada
        $direccionEstacion = $estacion->domicilioServicio; // Relación definida en el modelo

        // Reemplazar los campos de la dirección en la plantilla
        $templateProcessor->setValue('${calle}', $direccionEstacion->calle ?? 'N/A');
        $templateProcessor->setValue('${numero}', $direccionEstacion->numero_exterior ?? 'N/A');
        $templateProcessor->setValue('${numero_interior}', $direccionEstacion->numero_interior ?? 'N/A');
        $templateProcessor->setValue('${colonia}', $direccionEstacion->colonia ?? 'N/A');
        $templateProcessor->setValue('${codigo_postal}', $direccionEstacion->codigo_postal ?? 'N/A');
        $templateProcessor->setValue('${localidad}', $direccionEstacion->localidad ?? 'N/A');
        $templateProcessor->setValue('${municipio}', $direccionEstacion->municipio ?? 'N/A');
        $templateProcessor->setValue('${entidad_federativa}', $direccionEstacion->entidad_federativa ?? 'N/A');

        // Colocar cada letra del RFC de la estación en su recuadro correspondiente (máximo 13 caracteres)
        for ($i = 0; $i < 13; $i++) {
            $char = isset($estacion->rfc[$i]) ? strtoupper($estacion->rfc[$i]) : ' ';

            // Si el carácter es '0', reemplazar por 'X'
            if ($char === '0') {
                $char = ' 0';
            }

            $templateProcessor->setValue('${c' . ($i + 1) . '}', $char);
        }

        // Colocar cada letra del RFC de la estación en su recuadro correspondiente (máximo 13 caracteres)
        for ($i = 0; $i < 13; $i++) {
            $char = isset($verificador->rfc[$i]) ? strtoupper($verificador->rfc[$i]) : ' ';

            // Si el carácter es '0', reemplazar por 'X'
            if ($char === '0') {
                $char = ' 0';
            }

            $templateProcessor->setValue('${v' . ($i + 1) . '}', $char);
        }

        // Buscar el proveedor de sistemas informáticos relacionado con el servicio anexo
        $proveedor = ProveedorInformatico::where('servicio_anexo_id', $data['id_servicio'])->first();

        // Colocar cada letra del RFC del proveedor en su recuadro correspondiente (máximo 13 caracteres)
        if ($proveedor && $proveedor->rfc) {
            for ($i = 0; $i < 13; $i++) {
                $char = isset($proveedor->rfc[$i]) ? strtoupper($proveedor->rfc[$i]) : ' ';

                // Si el carácter es '0', reemplazar por 'X'
                if ($char === '0') {
                    $char = ' 0';
                }

                $templateProcessor->setValue('${p' . ($i + 1) . '}', $char);
            }
        } else {
            // Si no hay proveedor o no tiene RFC, llenar con espacios en blanco
            for ($i = 0; $i < 13; $i++) {
                $templateProcessor->setValue('${p' . ($i + 1) . '}', ' ');
            }
        }

        // Reemplazar el nombre del proveedor informático
        $templateProcessor->setValue('${proveedor_informatico}', $proveedor->nombre ?? 'N/A');

        // Guardar el archivo procesado
        $fileName = "CE-{$estacion->rfc}_{$numeroFolioCertificado}.docx";
        $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
    }

    // Función auxiliar para generar el archivo JSON del certificado
    private function generateCertificadoJson($data, $estacion, $fechaInspeccion, $numeroFolioCertificado, $subFolderPath)
    {
        $jsonData = [
            'RfcContribuyente' => $estacion->rfc,
            'RfcRepresentanteLegal' => strtoupper($data['RfcRepresentanteLegal']),
            'RfcProveedorCertificado' => "ACA160422EA7",
            'RfcRepresentanteLegalProveedor' => "LOBJ711123NS5",
            'InformacionVerificacion' => [
                'FechaEmisionCertificado' => $fechaInspeccion,
                'NumeroFolioCertificado' => $numeroFolioCertificado,
                'ResultadoCertificado' => "ACREDITADO",
                'RfcPersonal' => strtoupper($data['RfcPersonal'])
            ]
        ];

        $jsonFileName = "CE-{$estacion->rfc}_{$numeroFolioCertificado}.json";
        Storage::disk('public')->put("{$subFolderPath}/{$jsonFileName}", json_encode($jsonData, JSON_PRETTY_PRINT));
    }

    // Función auxiliar para crear la carpeta de destino si no existe
    private function createFolderIfNotExists($folderPath)
    {
        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);
        }
    }

    // Función auxiliar para generar el número de folio
    private function generateFolioNumber($nomenclatura)
    {
        $parts = explode('-', $nomenclatura);
        $numeroNomenclatura = isset($parts[2]) ? $parts[2] : '0';
        $formattedNumeroNomenclatura = str_pad($numeroNomenclatura, 5, '0', STR_PAD_LEFT);
        $anoActual = date('Y');
        $numeroFolio = "ACA160422EA7";
        return "{$numeroFolio}{$formattedNumeroNomenclatura}{$anoActual}";
    }

    // Función auxiliar para guardar los detalles del certificado en la base de datos
    private function saveCertificadoToDatabase($data, $subFolderPath)
    {
        Certificado_Anexo30::updateOrCreate(
            ['servicio_anexo_id' => $data['id_servicio']],
            [
                'rutadoc' => $subFolderPath,
                'usuario_id' => $data['id_usuario'],
                'servicio_anexo_id' => $data['id_servicio'],
            ]
        );
    }


    //REPORTE FOTOGRAFICO

    public function generarReporteFotografico(Request $request)
    {

        // Validar los datos del formulario
        $validatedData = $this->validateReporteFotografico($request);

        // Obtener datos relacionados desde la base de datos
        $estacion = $this->getEstacionData($validatedData['idestacion']);
        $usuario = $this->getUsuarioData($validatedData['id_usuario']);
        $direccionServicio = $this->getDireccion($validatedData['domicilio_servicio_id']);

        // Preparar los datos a usar en las plantillas
        $data = $this->prepareReporteFotograficoData($usuario, $validatedData, $estacion, $direccionServicio);

        // Definir la carpeta de destino y procesar las plantillas
        $subFolderPath = $this->defineFolderPath($validatedData);

        $this->processTemplate($data, $subFolderPath, 'REPORTE FOTOGRAFICO.docx');

        // Guardar los datos de expediente
        $this->saveReporteFotograficoData($data, $validatedData, $estacion);

        return redirect()->route('expediente.index', ['id' => $validatedData['id_servicio']])
            ->with('success', 'Reporte fotografico guardado correctamente.');
    }

    private function validateReporteFotografico($request)
    {
        return $request->validate([
            'idestacion' => 'required',
            'id_servicio' => 'required',
            'nomenclatura' => 'required|string',
            'id_usuario' => 'required|exists:users,id',
            'domicilio_servicio_id' => 'nullable|integer',
            'fecha_inspeccion' => 'required|date',
            'selected_images' => 'required',
        ]);
    }

    private function prepareReporteFotograficoData($usuario, $validatedData, $estacion, $direccionServicio)
    {

        $imagenesSeleccionadas = $validatedData['selected_images'];

        $imageNumber = 1;
        $imagePaths = [];

        foreach ($imagenesSeleccionadas as $imageData) {
            $image = json_decode($imageData, true);

            $imagePaths[] = [
                'name' => 'img_' . $imageNumber,
                'nombre_original' => $image['nombre'],
                'categoria' => $image['categoria'],
                'path' => $image['url'],
            ];
            $imageNumber++;
        }

        // Retornar datos combinados con la información adicional
        return array_merge($validatedData, [
            'imagePaths' => $imagePaths,
            'numestacion' => $estacion->num_estacion,
            'razonsocial' => $estacion->razon_social,
            'id_usuario' => $usuario->name,
            'nomenclatura' => $validatedData['nomenclatura'],
            'domicilio_estacion' => $this->formatAddress($direccionServicio),
            'fecha_inspeccion' => Carbon::parse($validatedData['fecha_inspeccion'])->format('d-m-Y'),
        ]);
    }


    private function saveReporteFotograficoData($data, $validatedData, $estacion)
    {

        Expediente_Servicio_Anexo_30::updateOrCreate(
            ['servicio_anexo_id' => $validatedData['id_servicio']],
            ['rutadoc_estacion' => $this->defineFolderPath($validatedData), 'usuario_id' => $validatedData['id_usuario']]
        );
    }



    public function generarProcedimientoRevision(Request $request)
    {

        // Validar los datos del formulario
        $validatedData = $request->all();

        // Obtener datos relacionados desde la base de datos
        $estacion = $this->getEstacionData($validatedData['idestacion']);
        $usuario = $this->getUsuarioData($validatedData['id_usuario']);

        // Preparar los datos a usar en las plantillas
        $data = $this->prepareProcedimientoRevisionData($usuario, $validatedData, $estacion);

        // Definir la carpeta de destino y procesar las plantillas
        $subFolderPath = $this->defineFolderPath($validatedData);


        $this->processTemplateProcedimiento($data, $subFolderPath, 'PROCEDIMIENTO REVISION DEL EXPEDIENTE V2.docx');

        // Guardar los datos de expediente
        $this->saveProcedimientoRevisionData($data, $validatedData, $estacion);

        return redirect()->route('expediente.index', ['id' => $validatedData['id_servicio']])
            ->with('success', 'Procedimiento de revision de expediente guardado correctamente.');
    }


    private function prepareProcedimientoRevisionData($usuario, $validatedData, $estacion)
    {

        // Retornar datos combinados con la información adicional
        return array_merge($validatedData, [
            'numestacion' => $estacion->num_estacion,
            'razonsocial' => $estacion->razon_social,
            'id_usuario' => $usuario->name,
            'nomenclatura' => $validatedData['nomenclatura'],
        ]);
    }


    private function processTemplateProcedimiento($data, $subFolderPath, $templateName)
    {

        $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Expediente/{$templateName}"));

        // Reemplazamos los valores en el template
        foreach ($data as $key => $value) {

            $templateProcessor->setValue($key, $value);
            //PRIMERA PAGINA
            switch ($data['orden_trabajo']) {
                case 'si':
                    $templateProcessor->setValue('orden_si', 'X');
                    $templateProcessor->setValue('orden_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('orden_si', ' ');
                    $templateProcessor->setValue('orden_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['contrato_prestacion']) {
                case 'si':
                    $templateProcessor->setValue('contrato_si', 'X');
                    $templateProcessor->setValue('contrato_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('contrato_si', ' ');
                    $templateProcessor->setValue('contrato_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['formato_deteccion']) {
                case 'si':
                    $templateProcessor->setValue('formato_si', 'X');
                    $templateProcessor->setValue('formato_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('formato_si', ' ');
                    $templateProcessor->setValue('formato_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['plan_inspeccion_m']) {
                case 'si':
                    $templateProcessor->setValue('planM_si', 'X');
                    $templateProcessor->setValue('planM_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('planM_si', ' ');
                    $templateProcessor->setValue('planM_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['plan_inspeccion_i']) {
                case 'si':
                    $templateProcessor->setValue('planI_si', 'X');
                    $templateProcessor->setValue('planI_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('planI_si', ' ');
                    $templateProcessor->setValue('planI_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            //SEGUNDA PAGINA
            switch ($data['constancia_f']) {
                case 'si':
                    $templateProcessor->setValue('constancia_f_si', 'X');
                    $templateProcessor->setValue('constancia_f_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('constancia_f_si', ' ');
                    $templateProcessor->setValue('constancia_f_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['cree']) {
                case 'si':
                    $templateProcessor->setValue('cree_si', 'X');
                    $templateProcessor->setValue('cree_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('cree_si', ' ');
                    $templateProcessor->setValue('cree_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['representante_legal']) {
                case 'si':
                    $templateProcessor->setValue('identificacion_si', 'X');
                    $templateProcessor->setValue('identificacion_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('identificacion_si', ' ');
                    $templateProcessor->setValue('identificacion_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['constancia_l']) {
                case 'si':
                    $templateProcessor->setValue('constancia_l_si', 'X');
                    $templateProcessor->setValue('constancia_l_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('constancia_l_si', ' ');
                    $templateProcessor->setValue('constancia_l_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['manual']) {
                case 'si':
                    $templateProcessor->setValue('manual_si', 'X');
                    $templateProcessor->setValue('manual_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('manual_si', ' ');
                    $templateProcessor->setValue('manual_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['ficha']) {
                case 'si':
                    $templateProcessor->setValue('ficha_si', 'X');
                    $templateProcessor->setValue('ficha_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('ficha_si', ' ');
                    $templateProcessor->setValue('ficha_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['almacen']) {
                case 'si':
                    $templateProcessor->setValue('almacen_si', 'X');
                    $templateProcessor->setValue('almacen_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('almacen_si', ' ');
                    $templateProcessor->setValue('almacen_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['elementos']) {
                case 'si':
                    $templateProcessor->setValue('elementos_si', 'X');
                    $templateProcessor->setValue('elementos_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('elementos_si', ' ');
                    $templateProcessor->setValue('elementos_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['planos']) {
                case 'si':
                    $templateProcessor->setValue('planos_si', 'X');
                    $templateProcessor->setValue('planos_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('planos_si', ' ');
                    $templateProcessor->setValue('planos_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['politicas']) {
                case 'si':
                    $templateProcessor->setValue('politicas_si', 'X');
                    $templateProcessor->setValue('politicas_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('politicas_si', ' ');
                    $templateProcessor->setValue('politicas_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['inventario']) {
                case 'si':
                    $templateProcessor->setValue('inventario_si', 'X');
                    $templateProcessor->setValue('inventario_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('inventario_si', ' ');
                    $templateProcessor->setValue('inventario_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['acuerdos']) {
                case 'si':
                    $templateProcessor->setValue('acuerdos_si', 'X');
                    $templateProcessor->setValue('acuerdos_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('acuerdos_si', ' ');
                    $templateProcessor->setValue('acuerdos_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['registros']) {
                case 'si':
                    $templateProcessor->setValue('registros_si', 'X');
                    $templateProcessor->setValue('registros_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('registros_si', ' ');
                    $templateProcessor->setValue('registros_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }
            //TERCERA PAGINA
            switch ($data['dt']) {
                case 'si':
                    $templateProcessor->setValue('dt_si', 'X');
                    $templateProcessor->setValue('dt_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('dt_si', ' ');
                    $templateProcessor->setValue('dt_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['dm']) {
                case 'si':
                    $templateProcessor->setValue('dm_si', 'X');
                    $templateProcessor->setValue('dm_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('dm_si', ' ');
                    $templateProcessor->setValue('dm_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['rf']) {
                case 'si':
                    $templateProcessor->setValue('rf_si', 'X');
                    $templateProcessor->setValue('rf_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('rf_si', ' ');
                    $templateProcessor->setValue('rf_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['ct']) {
                case 'si':
                    $templateProcessor->setValue('ct_si', 'X');
                    $templateProcessor->setValue('ct_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('ct_si', ' ');
                    $templateProcessor->setValue('ct_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['pr']) {
                case 'si':
                    $templateProcessor->setValue('pr_si', 'X');
                    $templateProcessor->setValue('pr_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('pr_si', ' ');
                    $templateProcessor->setValue('pr_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            //CUARTA PAGINA
            switch ($data['cc']) {
                case 'si':
                    $templateProcessor->setValue('cc_si', 'X');
                    $templateProcessor->setValue('cc_no', ' ');
                    break;
                case 'no':
                    $templateProcessor->setValue('cc_si', ' ');
                    $templateProcessor->setValue('cc_no', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }
        }

        // Guardamos el archivo con un nombre único basado en la nomenclatura
        $fileName = pathinfo($templateName, PATHINFO_FILENAME) . "_{$data['nomenclatura']}.docx";
        $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
    }

    private function saveProcedimientoRevisionData($data, $validatedData, $estacion)
    {

        Expediente_Servicio_Anexo_30::updateOrCreate(
            ['servicio_anexo_id' => $validatedData['id_servicio']],
            ['rutadoc_estacion' => $this->defineFolderPath($validatedData), 'usuario_id' => $validatedData['id_usuario']]
        );
    }


    public function generarComprobanteTraslado(Request $request)
    {

        // Validar los datos del formulario
        $validatedData = $request->all();

        // Obtener datos relacionados desde la base de datos
        $estacion = $this->getEstacionData($validatedData['idestacion']);
        $usuario = $this->getUsuarioData($validatedData['id_usuario']);
        $direccionServicio = $this->getDireccion($estacion->domicilio_servicio_id);

        // Preparar los datos a usar en las plantillas
        $data = $this->prepareComprobanteTrasladoData($usuario, $validatedData, $estacion, $direccionServicio);

        // Definir la carpeta de destino y procesar las plantillas
        $subFolderPath = $this->defineFolderPath($validatedData);


        $this->processTemplateComprobanteTraslado($data, $subFolderPath, 'COMPROBANTE DE TRASLADO INDICE 4.docx');

        // Guardar los datos de expediente
        $this->saveComprobanteTrasladoData($data, $validatedData, $estacion);

        return redirect()->route('expediente.index', ['id' => $validatedData['id_servicio']])
            ->with('success', 'Comprobante Traslado guardado correctamente.');
    }

    private function prepareComprobanteTrasladoData($usuario, $validatedData, $estacion, $direccionServicio)
    {

        // Retornar datos combinados con la información adicional
        return array_merge($validatedData, [
            'domicilio_estacion' => $this->formatAddress($direccionServicio),
            'razonsocial' => $estacion->razon_social,
            'id_usuario' => $usuario->name,
            'nomenclatura' => $validatedData['nomenclatura'],
        ]);
    }

    private function processTemplateComprobanteTraslado($data, $subFolderPath, $templateName)
    {

        $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Expediente/{$templateName}"));

        // Reemplazamos los valores en el template
        foreach ($data as $key => $value) {

            $templateProcessor->setValue($key, $value);

            switch ($data['trasnporte']) {
                case 'avion':
                    $templateProcessor->setValue('av1', 'X');
                    $templateProcessor->setValue('au1', ' ');
                    $templateProcessor->setValue('ta1', ' ');
                    $templateProcessor->setValue('of1', ' ');
                    $templateProcessor->setValue('otro1', ' ');

                    break;
                case 'autobus':
                    $templateProcessor->setValue('av1', ' ');
                    $templateProcessor->setValue('au1', 'X');
                    $templateProcessor->setValue('ta1', ' ');
                    $templateProcessor->setValue('of1', ' ');
                    $templateProcessor->setValue('otro1', ' ');
                    break;
                case 'taxi':
                    $templateProcessor->setValue('av1', ' ');
                    $templateProcessor->setValue('au1', ' ');
                    $templateProcessor->setValue('ta1', 'X');
                    $templateProcessor->setValue('of1', ' ');
                    $templateProcessor->setValue('otro1', ' ');
                    break;
                case 'oficial':
                    $templateProcessor->setValue('av1', ' ');
                    $templateProcessor->setValue('au1', ' ');
                    $templateProcessor->setValue('ta1', ' ');
                    $templateProcessor->setValue('of1', 'X');
                    $templateProcessor->setValue('otro1', ' ');
                    break;
                case 'otro':
                    $templateProcessor->setValue('av1', ' ');
                    $templateProcessor->setValue('au1', ' ');
                    $templateProcessor->setValue('ta1', ' ');
                    $templateProcessor->setValue('of1', ' ');
                    $templateProcessor->setValue('otro1', 'X');
                    break;

                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }
            switch ($data['comprobante']) {
                case 'factura':
                    $templateProcessor->setValue('fa1', 'X');
                    $templateProcessor->setValue('bo1', ' ');
                    $templateProcessor->setValue('otro20', ' ');
                    break;
                case 'boleto':
                    $templateProcessor->setValue('fa1', ' ');
                    $templateProcessor->setValue('bo1', 'X');
                    $templateProcessor->setValue('otro20', ' ');
                    break;
                case 'otro':
                    $templateProcessor->setValue('fa1', ' ');
                    $templateProcessor->setValue('bo1', ' ');
                    $templateProcessor->setValue('otro20', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['concepto']) {
                case 'pasaje':
                    $templateProcessor->setValue('pa1', 'X');
                    $templateProcessor->setValue('ca1', ' ');
                    $templateProcessor->setValue('co1', ' ');
                    $templateProcessor->setValue('otro3', ' ');
                    break;
                case 'caseta':
                    $templateProcessor->setValue('pa1', ' ');
                    $templateProcessor->setValue('ca1', 'X');
                    $templateProcessor->setValue('co1', ' ');
                    $templateProcessor->setValue('otro3', ' ');
                    break;
                case 'combustible':
                    $templateProcessor->setValue('pa1', ' ');
                    $templateProcessor->setValue('ca1', ' ');
                    $templateProcessor->setValue('co1', 'X');
                    $templateProcessor->setValue('otro3', ' ');
                    break;
                case 'otro':
                    $templateProcessor->setValue('pa1', ' ');
                    $templateProcessor->setValue('ca1', ' ');
                    $templateProcessor->setValue('co1', ' ');
                    $templateProcessor->setValue('otro3', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }


            //SEGUNDA PARTE O ROW 2
            switch ($data['trasnporte2']) {
                case 'avion':
                    $templateProcessor->setValue('av2', 'X');
                    $templateProcessor->setValue('au2', ' ');
                    $templateProcessor->setValue('ta2', ' ');
                    $templateProcessor->setValue('of2', ' ');
                    $templateProcessor->setValue('otro4', ' ');

                    break;
                case 'autobus':
                    $templateProcessor->setValue('av2', ' ');
                    $templateProcessor->setValue('au2', 'X');
                    $templateProcessor->setValue('ta2', ' ');
                    $templateProcessor->setValue('of2', ' ');
                    $templateProcessor->setValue('otro4', ' ');
                    break;
                case 'taxi':
                    $templateProcessor->setValue('av2', ' ');
                    $templateProcessor->setValue('au2', ' ');
                    $templateProcessor->setValue('ta2', 'X');
                    $templateProcessor->setValue('of2', ' ');
                    $templateProcessor->setValue('otro4', ' ');
                    break;
                case 'oficial':
                    $templateProcessor->setValue('av2', ' ');
                    $templateProcessor->setValue('au2', ' ');
                    $templateProcessor->setValue('ta2', ' ');
                    $templateProcessor->setValue('of2', 'X');
                    $templateProcessor->setValue('otro4', ' ');
                    break;
                case 'otro':
                    $templateProcessor->setValue('av2', ' ');
                    $templateProcessor->setValue('au2', ' ');
                    $templateProcessor->setValue('ta2', ' ');
                    $templateProcessor->setValue('of2', ' ');
                    $templateProcessor->setValue('otro4', 'X');
                    break;

                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }
            switch ($data['comprobante2']) {
                case 'factura':
                    $templateProcessor->setValue('fa2', 'X');
                    $templateProcessor->setValue('bo2', ' ');
                    $templateProcessor->setValue('otro5', ' ');
                    break;
                case 'boleto':
                    $templateProcessor->setValue('fa2', ' ');
                    $templateProcessor->setValue('bo2', 'X');
                    $templateProcessor->setValue('otro5', ' ');
                    break;
                case 'otro':
                    $templateProcessor->setValue('fa2', ' ');
                    $templateProcessor->setValue('bo2', ' ');
                    $templateProcessor->setValue('otro5', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }

            switch ($data['concepto2']) {
                case 'pasaje':
                    $templateProcessor->setValue('pa2', 'X');
                    $templateProcessor->setValue('ca2', ' ');
                    $templateProcessor->setValue('co2', ' ');
                    $templateProcessor->setValue('otro6', ' ');
                    break;
                case 'caseta':
                    $templateProcessor->setValue('pa2', ' ');
                    $templateProcessor->setValue('ca2', 'X');
                    $templateProcessor->setValue('co2', ' ');
                    $templateProcessor->setValue('otro6', ' ');
                    break;
                case 'combustible':
                    $templateProcessor->setValue('pa2', ' ');
                    $templateProcessor->setValue('ca2', ' ');
                    $templateProcessor->setValue('co2', 'X');
                    $templateProcessor->setValue('otro6', ' ');
                    break;
                case 'otro':
                    $templateProcessor->setValue('pa2', ' ');
                    $templateProcessor->setValue('ca2', ' ');
                    $templateProcessor->setValue('co2', ' ');
                    $templateProcessor->setValue('otro6', 'X');
                    break;
                default:
                    // Manejar cualquier otro caso aquí si es necesario
                    break;
            }
        }


        // Guardamos el archivo con un nombre único basado en la nomenclatura
        $fileName = pathinfo($templateName, PATHINFO_FILENAME) . "_{$data['nomenclatura']}.docx";
        $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
    }

    private function saveComprobanteTrasladoData($data, $validatedData, $estacion)
    {

        Expediente_Servicio_Anexo_30::updateOrCreate(
            ['servicio_anexo_id' => $validatedData['id_servicio']],
            ['rutadoc_estacion' => $this->defineFolderPath($validatedData), 'usuario_id' => $validatedData['id_usuario']]
        );
    }

    private function defineFolderPathCalibraciones($validatedData)
    {
        $anio = now()->year;
        return "Servicios/Anexo_30/{$anio}/{$validatedData['id_usuario']}/{$validatedData['nomenclatura']}/calibraciones/";
    }

    // Método para procesar la plantilla
    private function processTemplateCalibraciones($data, $subFolderPath, $templateName)
    {

        $templateProcessor = new TemplateProcessor(storage_path("app/templates/Anexo30/Calibraciones/{$templateName}"));

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

    private function prepareExpedienteDataCalibracion($validatedData, $estacion, $direccionFiscal, $direccionServicio, $usuario)
    {

        // Obtener la fecha actual desglosada
        $fechaActual = Carbon::now();
        $diaActual = $fechaActual->format('d');
        $mesActual = $fechaActual->translatedFormat('F'); // Mes en texto (en español)
        $anioActual = $fechaActual->format('Y');

        // Formato completo de la fecha
        $fechaCompleta = "{$diaActual} de {$mesActual} del {$anioActual}";

        return array_merge($validatedData, [
            'numestacion' => $estacion->num_estacion,
            'razonsocial' => $estacion->razon_social,
            'id_usuario' => $usuario->name,
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


            // Fechas
            'fecha_inspeccion' => Carbon::parse($validatedData['fecha_inspeccion'])->format('d-m-Y'),
            'fecha_recepcion' => Carbon::parse($validatedData['fecha_recepcion'])->format('d-m-Y'),
            'fecha_inspeccion_modificada' => Carbon::parse($validatedData['fecha_inspeccion'])->addYear()->format('d-m-Y'),

            // Fecha actual desglosada y en texto completo
            'fecha_completa' => $fechaCompleta,
        ]);
    }
}
