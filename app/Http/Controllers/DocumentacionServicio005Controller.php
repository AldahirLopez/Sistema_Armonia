<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio_005;
use App\Models\Documentos_servicio_005;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class DocumentacionServicio005Controller extends Controller
{

    public function menu(Request $request)
    {
        // Capturar el id del request
        $id = $request->input('id');
        // Buscar el servicio por el ID
        $servicio = Servicio_005::findOrFail($id);
        // Pasar el servicio a la vista para que puedas acceder a la nomenclatura
        return view('armonia.servicios.005.documentos.menu', compact('servicio'));
    }

    // Documentación General
    public function documentosGenerales(Request $request)
    {
        return $this->documentacion($request, 'generales', 'documentos_generales');
    }

    // Documentación General
    public function documentosExpedidosTerceros(Request $request)
    {
        return $this->documentacion($request, 'terceros', 'documentos_terceros');
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
             $servicio = Servicio_005::findOrFail($servicioId);
             $anio = date('Y');
             $userId = $servicio->id_usuario;
             $userIdstore = Auth::id();
             $nomenclatura = str_replace([' ', '.'], '_', $servicio->nomenclatura);
 
             // Ruta personalizada para la carpeta "documentos"
             $categoria = $request->input('categoria'); // Obtener la categoría del documento
             $customFolderPath = "Servicios/005/{$anio}/{$userId}/{$nomenclatura}/documentos/{$categoria}";
 
             // Generar el nombre del archivo para almacenar con la fecha
             $extension = $archivo->getClientOriginalExtension();
             $nombreArchivo = str_replace(' ', '_', $nombreDocumento) . '-' . now()->format('Y-m-d') . '.' . $extension;
 
             // Verificar si el documento ya existe
             $documento = Documentos_Servicio_005::where('servicio_id', $servicioId)
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
                 Documentos_Servicio_005::create([
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
            $documento = Documentos_Servicio_005::findOrFail($id);

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





    // Método genérico para manejar la obtención de documentos
    private function documentacion(Request $request, $categoria, $vista)
    {
        try {
            if ($request->has('id')) {
                $id = $request->input('id');
                $servicio = Servicio_005::findOrFail($id);

                // Obtener los documentos de la base de datos relacionados con el servicio y la categoría
                $documentos = Documentos_servicio_005::where('servicio_id', $id)
                    ->where('categoria', $categoria)
                    ->get();

                // Definir los documentos requeridos para cada categoría
                $requiredDocuments = $this->getRequiredDocuments($categoria);

                return view("armonia.servicios.005.documentos.sub_documentos.{$vista}", compact('requiredDocuments', 'documentos', 'id', 'servicio'));
            } else {
                return redirect()->route('servicio_005.index')->with('error', 'No se proporcionó un ID de servicio.');
            }
        } catch (\Exception $e) {
            return redirect()->route('servicio_005.index')->with('error', 'Error al obtener la documentación: ' . $e->getMessage());
        }
    }



    private function getRequiredDocuments($categoria)
    {
        $documents = [
            'generales' => [
                ['descripcion' => 'Cédula de Identificación Fiscal de la Empresa (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                ['descripcion' => 'Cédula de Identificación Fiscal del Representante Legal (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                ['descripcion' => 'INE del representante legal', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                ['descripcion' => 'Permiso de la CRE', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 4],
            ],
           
            'terceros' => [
                ['descripcion' => 'Análisis de riesgo del sector hidrocarburos', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 1],
                ['descripcion' => 'Pruebas de hermeticidad', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 2],
                ['descripcion' => 'Carta responsiva y/o factura del mantenimiento de extintores', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 3],
                ['descripcion' => 'Dictamen de instalaciones eléctricas', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 4],
                ['descripcion' => 'Estudio de tierras físicas', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 5],
                ['descripcion' => 'Certificado de limpieza ecológica', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 6],
                ['descripcion' => 'Permiso de la CRE', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 7],
                ['descripcion' => 'Tirilla del reporte de inventarios', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 8],
                ['descripcion' => 'Tirilla de las pruebas de sensores', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 9],
                ['descripcion' => 'Identificación oficial de la persona que atendió la inspección y testigos', 'codigo' => '', 'tipo' => 'Documental y Copia', 'id' => 10],
            ],

            'inspeccion' => [
                ['descripcion' => 'Bitacora Recepcion Y Descarga De Producto', 'codigo' => '', 'tipo' => 'Revision', 'id' => 1],
                ['descripcion' => 'Bitacora De Limpiezas Programadas', 'codigo' => '', 'tipo' => 'Revision', 'id' => 2],
                ['descripcion' => 'Bitacora De Desviaciones En El Balance Prod.', 'codigo' => '', 'tipo' => 'Revision', 'id' => 3],
                ['descripcion' => 'Bitacora Incidentes E Inspeciones De Operación', 'codigo' => '', 'tipo' => 'Revision', 'id' => 4],
                ['descripcion' => 'Bitacora De Mantenimiento', 'codigo' => '', 'tipo' => 'Revision', 'id' => 5],
                ['descripcion' => 'Procedimiento Preparacion Y Respuesta Emergencia', 'codigo' => '', 'tipo' => 'Revision', 'id' => 6],
                ['descripcion' => 'Procedimiento Investigacion De Accidente E Incidentes', 'codigo' => '', 'tipo' => 'Revision', 'id' => 7],
                ['descripcion' => 'Procedimiento Etiquetado, Bloqueo Y Candadeo De Lineas Electricas', 'codigo' => '', 'tipo' => 'Revision', 'id' => 8],
                ['descripcion' => 'Procedimiento Etiquetado, Bloqueo Y Candadeo De Lineas De Producto', 'codigo' => '', 'tipo' => 'Revision', 'id' => 9],
                ['descripcion' => 'Procedimiento Para Trabajos Peligrosos Con Fuentes Que Generan Ignicion', 'codigo' => '', 'tipo' => 'Revision', 'id' => 10],
                ['descripcion' => 'Procedimiento Trabajos En Alturas', 'codigo' => '', 'tipo' => 'Revision', 'id' => 11],
                ['descripcion' => 'Procedimiento Trabajos En Areas Confinadas', 'codigo' => '', 'tipo' => 'Revision', 'id' => 12],
                ['descripcion' => 'Procedimiento Despacho Al Publico', 'codigo' => '', 'tipo' => 'Revision', 'id' => 13],
                ['descripcion' => 'Procedimiento Recepcion Y Descarga De Productos', 'codigo' => '', 'tipo' => 'Revision', 'id' => 14],],
        
            
        ];
        return $documents[$categoria] ?? [];
    }

    public function generarPDF()
    {
        try {
            // Obtener todas las categorías y sus documentos
            $categorias = ['inspeccion', 'terceros'];
            $allDocuments = [];

            // Obtener los documentos de cada categoría
            foreach ($categorias as $categoria) {
                $allDocuments[$categoria] = $this->getRequiredDocuments($categoria);
            }

            // Generar el PDF usando la plantilla que guardaste
            $pdf = Pdf::loadView('armonia.servicios.005.documentos.componentes.requisitos_pdf', compact('allDocuments'));

            // Descargar el PDF con todos los requisitos
            return $pdf->download('lista_completa_requisitos_anexo_30_31.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }


}
