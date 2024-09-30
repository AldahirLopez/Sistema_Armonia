<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicioAnexo;
use App\Models\Servicio_005;
use App\Models\Estacion;
use App\Models\User; // Asegúrate de incluir el modelo User
use Carbon\Carbon;

class RutasController extends Controller
{
    /**
     * Muestra la vista del listado de rutas de los inspectores.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener las rutas de los servicios Anexo 30 y ordenarlas por fecha de recepción
        $rutasAnexo30 = ServicioAnexo::with(['estaciones', 'usuario'])
            ->orderBy('date_recepcion_at') // Ordenar por fecha de recepción
            ->get()
            ->map(function ($servicio) {
                $estacion = $servicio->estaciones->first(); // Obtener la primera estación relacionada
                return [
                    'title' => 'Anexo 30: ' . $servicio->nomenclatura,
                    'start' => $servicio->date_recepcion_at,
                    'end' => $servicio->date_inspeccion_at,
                    'estacion' => $estacion ? $estacion->razon_social : 'N/A',
                    'inspector' => $servicio->usuario ? $servicio->usuario->name : 'N/A',
                    'estado' => $estacion->estado_republica ?? 'N/A',
                    'color' => 'red', // Color para Anexo 30
                ];
            });

        // Obtener las rutas de los servicios 005 y ordenarlas por fecha de recepción
        $rutas005 = Servicio_005::with(['estaciones', 'usuario'])
            ->orderBy('date_recepcion_at') // Ordenar por fecha de recepción
            ->get()
            ->map(function ($servicio) {
                $estacion = $servicio->estaciones->first(); // Obtener la primera estación relacionada
                return [
                    'title' => '005: ' . $servicio->nomenclatura,
                    'start' => $servicio->date_recepcion_at,
                    'end' => $servicio->date_inspeccion_at,
                    'estacion' => $estacion ? $estacion->razon_social : 'N/A',
                    'inspector' => $servicio->usuario ? $servicio->usuario->name : 'N/A',
                    'estado' => $estacion->estado_republica ?? 'N/A',
                    'color' => 'yellow', // Color para 005
                ];
            });

        // Combinar las rutas en un solo arreglo
        $rutas = $rutasAnexo30->merge($rutas005);

        // Ordenar todas las rutas combinadas por fecha de inicio ('start')
        $rutas = $rutas->sortBy('start');

        // Agrupar las rutas por inspector
        $rutasPorInspector = $rutas->groupBy('inspector');

        // Pasar las rutas agrupadas y ordenadas a la vista
        return view('armonia.rutas.index', compact('rutasPorInspector'));
    }
}
