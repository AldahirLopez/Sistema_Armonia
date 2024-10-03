<?php

namespace App\Http\Controllers;

use App\Models\Documentos;
use App\Models\Estacion;
use App\Models\ServicioAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

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

                // Obtener los documentos de la base de datos relacionados con el servicio y la categoría
                $documentos = Documentos::where('servicio_id', $id)
                    ->where('categoria', $categoria)
                    ->get();

                // Definir los documentos requeridos para cada categoría
                $requiredDocuments = $this->getRequiredDocuments($categoria);

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
                ['descripcion' => 'Cédula de Identificación Fiscal de la Empresa (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Cédula de Identificación Fiscal del Representante Legal (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'INE del representante legal', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'Permiso de la CRE', 'codigo' => '', 'tipo' => 'Documental', 'id' => 4],
            ],
            'informatica' => [
                ['descripcion' => 'Inventario de activos tecnológicos relacionados con el control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Manual de usuario de control volumétrico, de preferencia si incluye apartado de cumplimiento anexos 30 y 31 RMF', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'Información técnica de la base de datos utilizada en el control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'Documentación técnica del programa informático utilizado como control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 4],
                ['descripcion' => 'Evidencia de realizar pruebas de seguridad anual y evidencia del seguimiento a los hallazgos encontrados durante las pruebas', 'codigo' => '', 'tipo' => 'Documental', 'id' => 5],
                ['descripcion' => 'Política y procedimientos de control de acceso al programa informático para el control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 6],
                ['descripcion' => 'Procedimientos de restricción, control de asignación y uso de privilegios de acceso al programa informático', 'codigo' => '', 'tipo' => 'Documental', 'id' => 7],
                ['descripcion' => 'Evidencia de depuración y revisión de usuarios cada 6 meses en el programa informático para el control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 8],
                ['descripcion' => 'Procedimiento de control de cambios', 'codigo' => '', 'tipo' => 'Documental', 'id' => 9],
                ['descripcion' => 'Contrato de arrendamiento o pólizas de contratación del programa informático para el control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 10],
                ['descripcion' => 'Políticas y procedimientos para la generación de respaldos de la información', 'codigo' => '', 'tipo' => 'Documental', 'id' => 11],
                ['descripcion' => 'Organigrama, estructura y mapa de la red informática que interactúa con los sistemas de medición y los programas informáticos de control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 12],
                ['descripcion' => 'Políticas y procedimientos para la gestión de incidentes de seguridad relacionados con el programa informático para llevar controles volumétricos', 'codigo' => '', 'tipo' => 'Documental', 'id' => 13],
                ['descripcion' => 'Acuerdos de confidencialidad firmados con el personal de desarrollo e implementación del programa informático', 'codigo' => '', 'tipo' => 'Documental', 'id' => 14],
                ['descripcion' => 'Pólizas y contratos de control volumétrico', 'codigo' => '', 'tipo' => 'Documental', 'id' => 15],
            ],
            'medicion' => [
                ['descripcion' => 'Dictámenes de calibración de dispensarios (primero y segundo semestre del año a inspeccionar)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Orden de servicio de la última actualización de dispensarios', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'Aprobación de modelo prototipo (dispensarios)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'DGN de certificado de producto de software de dispensarios', 'codigo' => '', 'tipo' => 'Documental', 'id' => 4],
                ['descripcion' => 'DGN de resolución favorable de actualización de dispensarios (si aplica)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 5],
                ['descripcion' => 'Modelo, marca y capacidad de tanques', 'codigo' => '', 'tipo' => 'Documental', 'id' => 6],
                ['descripcion' => 'Plano arquitectónico de la estación de servicio', 'codigo' => '', 'tipo' => 'Documental', 'id' => 7],
                ['descripcion' => 'Plano mecánico de la estación de servicio', 'codigo' => '', 'tipo' => 'Documental', 'id' => 8],
                ['descripcion' => 'Fichas técnicas y/o manuales de equipos de medición (sondas, dispensarios y consola de telemedición)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 9],
                ['descripcion' => 'Informes de calibración de sondas de medición en magnitudes: nivel y temperatura', 'codigo' => '', 'tipo' => 'Documental', 'id' => 10],
                ['descripcion' => 'Verificar que la consola cuente con contraseña', 'codigo' => '', 'tipo' => 'Documental', 'id' => 11],
                ['descripcion' => 'Certificado de calibración de tanques', 'codigo' => '', 'tipo' => 'Documental', 'id' => 12],
                ['descripcion' => 'Tablas de cubicación de tanques', 'codigo' => '', 'tipo' => 'Documental', 'id' => 13],
                ['descripcion' => 'Sistema de gestión de medición (SGM) digital: manual, procedimientos y formatos', 'codigo' => '', 'tipo' => 'Documental', 'id' => 14],
                ['descripcion' => 'Constancia de capacitación al personal involucrado en las actividades del SGM', 'codigo' => '', 'tipo' => 'Documental', 'id' => 15],
                ['descripcion' => 'Certificados de calibración vigentes de equipos de medición manual para la correcta verificación de los equipos automáticos (Cinta petrolera con plomada, Termómetro electrónico portátil, Jarra patrón)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 16],
                ['descripcion' => 'Reportes de laboratorio de la calidad del petrolífero correspondientes al primero y segundo semestre del año', 'codigo' => '', 'tipo' => 'Documental', 'id' => 17],
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
            'rutadoc_estacion' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx', // Ajustar tipos de archivo y tamaño si es necesario
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
            $userId = $servicio->id_usuario;
            $userIdstore = Auth::id();
            $nomenclatura = str_replace([' ', '.'], '_', $servicio->nomenclatura);

            // Ruta personalizada para la carpeta "documentos"
            $categoria = $request->input('categoria'); // Obtener la categoría del documento
            $customFolderPath = "Servicios/Anexo_30/{$anio}/{$userId}/{$nomenclatura}/documentos/{$categoria}";

            // Generar el nombre del archivo para almacenar con la fecha
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = str_replace(' ', '_', $nombreDocumento) . '-' . now()->format('Y-m-d') . '.' . $extension;

            // Verificar si el documento ya existe
            $documento = Documentos::where('servicio_id', $servicioId)
                ->where('categoria', $categoria)
                ->where('nombre', $nombreDocumento)
                ->first();

            // Si el documento existe, actualiza el archivo y la ruta, de lo contrario crea uno nuevo
            if ($documento) {
                // Eliminar el archivo antiguo si existe
                if (Storage::exists($documento->ruta)) {
                    Storage::delete($documento->ruta);
                }

                // Subir el nuevo archivo y actualizar la ruta en la base de datos
                $rutaArchivo = $archivo->storeAs($customFolderPath, $nombreArchivo, 'public');
                $documento->ruta = $rutaArchivo;
                $documento->save();

                return redirect()->back()->with('success', 'Documento actualizado exitosamente.');
            } else {
                // Subir el archivo a la carpeta correspondiente y crear un nuevo registro
                $rutaArchivo = $archivo->storeAs($customFolderPath, $nombreArchivo, 'public');
                Documentos::create([
                    'nombre' => $nombreDocumento,
                    'ruta' => $rutaArchivo,
                    'servicio_id' => $servicioId,
                    'categoria' => $categoria,
                    'usuario_id' => $userIdstore,
                ]);

                return redirect()->back()->with('success', 'Documento subido exitosamente.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al subir el documento: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            // Buscar el documento por su ID
            $documento = Documentos::findOrFail($id);

            // Obtener la ruta relativa eliminando el prefijo de Storage::url()
            $rutaArchivo = str_replace('/storage/', '', $documento->ruta);

            // Eliminar el archivo físico si existe
            if (Storage::disk('public')->exists($rutaArchivo)) {
                Storage::disk('public')->delete($rutaArchivo);
            }

            // Eliminar el registro en la base de datos
            $documento->delete();

            return redirect()->back()->with('warning', 'Documento eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el documento: ' . $e->getMessage());
        }
    }

    public function generarPDF()
    {
        try {
            // Obtener todas las categorías y sus documentos
            $categorias = ['generales', 'informatica', 'medicion'];
            $allDocuments = [];

            // Obtener los documentos de cada categoría
            foreach ($categorias as $categoria) {
                $allDocuments[$categoria] = $this->getRequiredDocuments($categoria);
            }

            // Generar el PDF usando la plantilla que guardaste
            $pdf = Pdf::loadView('armonia.servicios.anexo_30.documentos.componentes.requisitos_pdf', compact('allDocuments'));

            // Descargar el PDF con todos los requisitos
            return $pdf->download('lista_completa_requisitos_anexo_30_31.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
