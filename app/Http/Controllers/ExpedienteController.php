<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Estados\Estados;
use App\Models\Expediente_Servicio_Anexo_30;
use App\Models\ProveedorInformatico;
use App\Models\ServicioAnexo;
use App\Models\Estacion;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class ExpedienteController extends Controller
{
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
            $data = $this->prepareExpedienteData($validatedData, $estacion, $direccionFiscal, $direccionServicio);

            // Definir la carpeta de destino y procesar las plantillas
            $subFolderPath = $this->defineFolderPath($validatedData);
            $this->processTemplate($data, $subFolderPath, 'FORMATO DE DETECCIÓN DE RIESGOS A LA IMPARCIALIDAD.docx');
            $this->processTemplate($data, $subFolderPath, 'FORMATO PARA CONTRATO DE PRESTACIÓN DE SERVICIOS DE INSPECCIÓN DE LOS ANEXOS 30 Y 31 RESOLUCIÓN MISCELÁNEA FISCAL PARA 2024.docx');
            $this->processTemplate($data, $subFolderPath, 'ORDEN DE TRABAJO.docx');
            $this->processTemplate($data, $subFolderPath, 'PLAN DE INSPECCIÓN DE LOS SISTEMAS DE MEDICION.docx');
            $this->processTemplate($data, $subFolderPath, 'PLAN DE INSPECCIÓN DE PROGRAMAS INFORMATICOS.docx');
            // Guardar los datos de expediente
            $this->saveExpedienteData($data, $validatedData, $estacion);

            return redirect()->route('expediente.index', ['id' => $validatedData['id_servicio']])
                ->with('success', 'Expediente generado y guardado correctamente.');
        } catch (\Exception $e) {
            \Log::error("Error al generar el expediente: " . $e->getMessage());
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
            \Log::error("Error al generar documentos: " . $e->getMessage());
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
            \Log::error("Error al generar documentos: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al procesar la solicitud.'], 500);
        }
    }



    // Métodos auxiliares

    // Método para obtener los datos del servicio y archivos existentes
    private function getServiceData($id)
    {
        $servicioAnexo = ServicioAnexo::findOrFail($id);
        $estaciones = $servicioAnexo->estaciones()->get();

        if ($estaciones->isEmpty()) {
            throw new \Exception('No se encontraron estaciones relacionadas.');
        }

        $estacion = $estaciones->first();
        $estados = Estados::all();

        $anio = now()->year;
        $folderPath = "Servicios/Anexo_30/{$anio}/{$servicioAnexo->id_usuario}/{$servicioAnexo->nomenclatura}/expediente";

        $existingFiles = $this->getExistingFiles($folderPath);

        return compact('servicioAnexo', 'estacion', 'estados', 'existingFiles');
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

    // Método para preparar los datos que se usarán en las plantillas
    private function prepareExpedienteData($validatedData, $estacion, $direccionFiscal, $direccionServicio)
    {
        $totalData = $this->calculateTotal($validatedData['cantidad']); // Obtener total, mitad, y restante

        return array_merge($validatedData, [
            'numestacion' => $estacion->num_estacion,
            'razonsocial' => $estacion->razon_social,
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

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = implode(", ", $value); // Convertir arrays a texto si es necesario
            }

            $templateProcessor->setValue($key, (string) $value);
        }

        $fileName = pathinfo($templateName, PATHINFO_FILENAME) . "_{$data['nomenclatura']}.docx";
        $templateProcessor->saveAs(storage_path("app/public/{$subFolderPath}/{$fileName}"));
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
            ['date_recepcion_at' => $validatedData['fecha_recepcion'], 'date_inspeccion_at' => $validatedData['fecha_inspeccion']]
        );

        Expediente_Servicio_Anexo_30::updateOrCreate(
            ['servicio_anexo_id' => $servicio->id],
            ['rutadoc_estacion' => $this->defineFolderPath($validatedData), 'usuario_id' => $validatedData['id_usuario']]
        );
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
            'detalleOpinion1' => 'required',
            'recomendaciones1' => 'required',
            'detalleOpinion2' => 'required',
            'recomendaciones2' => 'required',
            'detalleOpinion3' => 'required',
            'recomendaciones3' => 'required',
            'detalleOpinion4' => 'required',
            'recomendaciones4' => 'required',
            'detalleOpinion5' => 'required',
            'recomendaciones5' => 'required',
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
            'detalleOpinion1' => 'required',
            'recomendaciones1' => 'required',
            'detalleOpinion2' => 'required',
            'recomendaciones2' => 'required',
            'detalleOpinion3' => 'required',
            'recomendaciones3' => 'required',
            'detalleOpinion4' => 'required',
            'recomendaciones4' => 'required',
        ];
    }
}
