<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\ServicioAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentacionAnexo30Controller extends Controller
{
    public function menu(Request $request) 
    {
        // Capturar el id del request
        $id = $request->input('id');
        // Buscar el servicio por el ID
        $servicio = ServicioAnexo::findOrFail($id);
        // Pasar el servicio a la vista para que puedas acceder a la nomenclatura
        return view('armonia.servicios.anexo_30.documentos.menu', compact('servicio'));
    }

    // Documentación General
    public function documentosGenerales(Request $request)
    {
        return $this->documentacion($request, 'generales', 'documentos_generales');
    }

    // Documentación Informática
    public function documentosInformaticos(Request $request)
    {
        return $this->documentacion($request, 'informatica', 'documentos_informaticos');
    }

    // Documentación de Medición
    public function documentosMedicion(Request $request)
    {
        return $this->documentacion($request, 'medicion', 'documentos_medicion');
    }

    // Documentación de Inspección
    public function documentosInspeccion(Request $request)
    {
        return $this->documentacion($request, 'inspeccion', 'documentos_inspeccion');
    }

    // Método genérico para manejar la obtención de documentos
    private function documentacion(Request $request, $categoria, $vista)
    {
        try {
            if ($request->has('id')) {
                $id = $request->input('id');
                $servicio = ServicioAnexo::findOrFail($id);
                $anio = date('Y');
                $userId = Auth::id();
                $nomenclatura = str_replace([' ', '.'], '_', $servicio->nomenclatura);
                $customFolderPath = "Servicios/Anexo_30/{$anio}/{$userId}/{$nomenclatura}/documentos/{$categoria}";

                // Definir los documentos requeridos para cada categoría
                $requiredDocuments = $this->getRequiredDocuments($categoria);

                $documentos = [];
                if (Storage::disk('public')->exists($customFolderPath)) {
                    $archivos = Storage::disk('public')->files($customFolderPath);
                    foreach ($archivos as $archivo) {
                        $nombreArchivo = pathinfo($archivo, PATHINFO_FILENAME);
                        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                        $rutaArchivo = Storage::url($archivo);

                        $documentos[] = (object)[
                            'nombre' => $nombreArchivo,
                            'ruta' => $rutaArchivo,
                            'extension' => $extension
                        ];
                    }
                }

                return view("armonia.servicios.anexo_30.documentos.sub_documentos.{$vista}", compact('requiredDocuments', 'documentos', 'id', 'servicio'));
            } else {
                return redirect()->route('anexo.index')->with('error', 'No se proporcionó un ID de servicio.');
            }
        } catch (\Exception $e) {
            return redirect()->route('anexo.index')->with('error', 'Error al obtener la documentación: ' . $e->getMessage());
        }
    }

    // Obtener los documentos requeridos según la categoría
    private function getRequiredDocuments($categoria)
    {
        $documents = [
            'generales' => [
                ['descripcion' => 'Cedula de Identificación Fiscal de la Empresa (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Cedula de Identificación Fiscal del Representante Legal (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'INE del representante legal', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'Permiso de la Cre', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 4],
            ],
            'informatica' => [
                ['descripcion' => 'Inventario de Activos tecnológicos relacionados con el control Volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Manual de Usuario de control volumétrico, de preferencia si incluye apartado de cumplimiento anexos 30 y 31 RMF', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'Información técnica de la base de datos utilizada en el control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'Documentación técnica del programa informático utilizado como control volumétrico', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 4],
                ['descripcion' => 'Evidencia de realizar pruebas de seguridad anual y evidencia del seguimiento a los hallazgos encontrados durante las pruebas', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 5],
                ['descripcion' => 'Política y procedimientos de control de acceso al programa informático para el control volumétrico', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 6],
                ['descripcion' => 'Procedimientos de restricción, control de asignación y uso de privilegios de acceso al programa informático', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 7],
                ['descripcion' => 'Evidencia de depuración y revisión de usuarios cada 6 meses en el programa informático para el control volumétrico', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 8],
                ['descripcion' => 'Procedimiento de control de cambios', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 9],
                ['descripcion' => 'Contrato de Arrendamiento o pólizas de contratación del programa informático para el control volumétrico', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 10],
                ['descripcion' => 'Políticas y procedimientos para la generación de respaldos de la información', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 11],
                ['descripcion' => 'Organigrama, estructura y mapa de la red informática que interactúa con los sistemas de medición y los programas informáticos de control volumétrico', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 12],
                ['descripcion' => 'Políticas y procedimientos para la gestión de incidentes de seguridad relacionados con el programa informático para llevar controles volumétricos', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 13],
                ['descripcion' => 'Acuerdos de confidencialidad firmado con el personal de desarrollo e implementación del programa informático', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 14],
                ['descripcion' => 'Pólizas y contratos de Control volumétrico', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 15],
                // Agrega más documentos según sea necesario
            ],
            'medicion' => [
                ['descripcion' => 'Dictámenes de calibración de dispensarios (primero y segundo semestre del año a inspeccionar)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Orden de Servicio de la última actualización de dispensarios', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'Aprobación de modelo prototipo (dispensarios)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'DGN de certificado de producto de software de dispensarios', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 4],
                ['descripcion' => 'DGN de resolución favorable de actualización de dispensarios (si aplica)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 5],
                ['descripcion' => 'Modelo, marca y capacidad de tanques', 'codigo' => '', 'tipo' => 'Documental', 'id' => 6],
                ['descripcion' => 'Plano Arquitectónico de la Estación de servicio', 'codigo' => '', 'tipo' => 'Documental', 'id' => 7],
                ['descripcion' => 'Plano Mecánico de la Estación de servicio', 'codigo' => '', 'tipo' => 'Documental', 'id' => 8],
                ['descripcion' => 'Dictamen de inspección (NOM_005_SCFI_2017)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 9],
                ['descripcion' => 'Dictamen de inspección (NOM_185_SCFI_2017)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 10],
                ['descripcion' => 'Fichas técnicas y/o manuales de equipos de medición (sondas, dispensarios y consola de Telemedicion)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 11],
                ['descripcion' => 'Informes de calibración de sondas de medición en magnitudes: nivel y temperatura', 'codigo' => '', 'tipo' => 'Documental', 'id' => 12],
                ['descripcion' => 'Verificar que la consola cuente con contraseña', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 13],
                ['descripcion' => 'Certificado de calibración de tanques', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 14],
                ['descripcion' => 'Tablas de cubicación de tanques ', 'codigo' => '', 'tipo' => 'Fotos', 'id' => 15],
                ['descripcion' => 'Sistema de Gestión de Medición (SGM) digital: Manual, procedimientos y formatos', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 16],
                ['descripcion' => 'Constancia de capacitación al personal involucrado en las actividades del SGM', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 17],
                ['descripcion' => 'Certificados de calibración vigentes de equipos de medición manual para la correcta verificación de los equipos automáticos(Cinta petrolera con plomada, Termómetro electrónico portátil, Jarra patrón)', 'codigo' => '', 'tipo' => 'Fotos', 'id' => 18],
                ['descripcion' => 'Reportes de laboratorio de la calidad del petrolífero correspondientes al primero y segundo semestre del año', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 19],
                // Agrega más documentos según sea necesario
            ],
            'inspeccion' => [
                ['descripcion' => 'Una tirilla de inventario de la consola de monitoreo de tanques', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Impresión de la configuración de la consola de monitoreo de tanques', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'La factura de una compra con su soporte (Remisión, Carta porte, Tira de Inicio y Fin de Incremento)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'La factura de una venta ', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 4],
                // Agrega más documentos según sea necesario
            ],
        ];

        return $documents[$categoria] ?? [];
    }

    // Método para almacenar documentos
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'rutadoc_estacion' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx', // Ajusta los tipos de archivo y tamaño si es necesario
            'servicio_id' => 'required',
            'nombre' => 'required|string',
        ]);

        try {
            // Obtener los datos del formulario
            $servicioId = $request->input('servicio_id');
            $nombreDocumento = $request->input('nombre');
            $archivo = $request->file('rutadoc_estacion');

            // Buscar el servicio
            $servicio = ServicioAnexo::findOrFail($servicioId);
            $anio = date('Y');
            $userId = Auth::id();
            $nomenclatura = str_replace([' ', '.'], '_', $servicio->nomenclatura);

            // Ruta personalizada para la carpeta "documentos"
            $categoria = $request->input('categoria'); // Obtener la categoría del documento
            $customFolderPath = "Servicios/Anexo_30/{$anio}/{$userId}/{$nomenclatura}/documentos/{$categoria}";

            // Generar el nombre del archivo para almacenar con la fecha
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = str_replace(' ', '_', $nombreDocumento) . '-' . now()->format('Y-m-d') . '.' . $extension;

            // Subir el archivo a la carpeta correspondiente
            $rutaArchivo = $archivo->storeAs($customFolderPath, $nombreArchivo, 'public');

            return redirect()->back()->with('success', 'Documento subido exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al subir el documento: ' . $e->getMessage());
        }
    }
}
