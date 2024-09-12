<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estacion_Servicio;
use App\Models\ServicioAnexo;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuario_Estacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
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


    // Documentos Generales
    public function documentosGenerales(Request $request)
    {
        try {
            if ($request->has('id')) {
                $id = $request->input('id');
                $servicio = ServicioAnexo::findOrFail($id);
                $anio = date('Y');
                $userId = Auth::id();
                $nomenclatura = str_replace([' ', '.'], '_', $servicio->nomenclatura);
                $customFolderPath = "Servicios/Anexo_30/{$anio}/{$userId}/{$nomenclatura}/documentacion/generales";

                $requiredDocuments = [
                    ['descripcion' => 'Cedula de Identificación Fiscal de la Empresa (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 1],
                    ['descripcion' => 'Cedula de Identificación Fiscal del Representante Legal (CIF, ALTA SAT)', 'codigo' => '', 'tipo' => 'Documental', 'id' => 2],
                    ['descripcion' => 'INE del representante legal', 'codigo' => '', 'tipo' => 'Documental', 'id' => 3],
                    ['descripcion' => 'Permiso de la Cre', 'codigo' => '', 'tipo' => 'Documental y Fotos', 'id' => 4],
                ];

                $documentos = [];
                if (Storage::disk('public')->exists($customFolderPath)) {
                    $archivos = Storage::disk('public')->files($customFolderPath);
                    foreach ($archivos as $archivo) {
                        $nombreArchivo = pathinfo($archivo, PATHINFO_FILENAME);
                        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                        $rutaArchivo = Storage::url($archivo);

                        $partes = explode('-', $nombreArchivo, 3);
                        $referencia = $partes[0] ?? '';
                        $nombre = $partes[0] ?? '';

                        $documentos[] = (object) [
                            'nombre' => $nombre,
                            'ruta' => $rutaArchivo,
                            'extension' => $extension
                        ];
                    }
                }

                return view('armonia.servicios.anexo_30.documentos.documentos_generales', compact('requiredDocuments', 'documentos', 'id', 'servicio'));
            } else {
                return redirect()->route('armonia.servicio_anexo_30.datos_servicio_anexo.documentacion_general')->with('error', 'No se proporcionó un ID de servicio.');
            }
        } catch (\Exception $e) {
            return redirect()->route('servicio_inspector_anexo_30.index')->with('error', 'Error al obtener la documentación: ' . $e->getMessage());
        }
    }
}
