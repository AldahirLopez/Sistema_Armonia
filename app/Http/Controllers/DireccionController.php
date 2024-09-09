<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Estados\Municipios;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DireccionController extends Controller
{
    protected $connection = 'segunda_db';

    // Ver direcciones asociadas a la estación
    public function verDirecciones($id)
    {
        $estacion = Estacion::findOrFail($id);
        $estados = Estados::where('id_country', 42)->get();

        $estado_id = Estados::where('description', $estacion->estado_republica)->first()->id ?? null;
        $municipios = $estado_id ? Municipios::where('id_state', $estado_id)->get() : collect();

        $direccionFiscal = Direccion::find($estacion->domicilio_fiscal_id);
        $direccionEstacion = Direccion::find($estacion->domicilio_servicio_id);

        return view('armonia.direcciones.index', compact('estacion', 'direccionFiscal', 'direccionEstacion', 'municipios', 'estados'));
    }

    // Guardar nueva dirección
    public function guardarDireccion(Request $request)
    {
        // Registrar las variables enviadas al controlador en el archivo de logs
        //\Log::info('Datos recibidos:', $request->all());
        // Validación inicial en la segunda base de datos
        $request->validate([
            'direccionSelect' => 'required|in:fiscal,estacion',
            'estacion_id' => 'required|exists:segunda_db.estacion,id',  // Validación en la segunda base de datos
        ]);

        // Determina el tipo de dirección y realiza la validación correspondiente
        $tipoDireccion = $request->input('direccionSelect');
        $camposValidacion = [
            'fiscal' => [
                'entre_calles_fiscal' => 'required|max:255',
                'calle_fiscal' => 'required|max:255',
                'numero_ext_fiscal' => 'required|max:10',
                'numero_int_fiscal' => 'nullable|max:10',
                'colonia_fiscal' => 'required|max:255',
                'codigo_postal_fiscal' => 'required',
                'municipio_id_fiscal' => 'required',
                'localidad_fiscal' => 'required|max:255',
                'entidad_federativa_fiscal' => 'required',
            ],
            'estacion' => [
                'entre_calles_estacion' => 'required|max:255',
                'calle_estacion' => 'required|max:255',
                'numero_ext_estacion' => 'required|max:10',
                'numero_int_estacion' => 'nullable|max:10',
                'colonia_estacion' => 'required|max:255',
                'codigo_postal_estacion' => 'required',
                'municipio_id_estacion' => 'required',
                'localidad_estacion' => 'required|max:255',
                'entidad_federativa_estacion' => 'required',
            ],
        ];

        // Validación específica para el tipo de dirección
        $request->validate($camposValidacion[$tipoDireccion]);

        // Capitaliza el tipo de dirección
        $tipoDireccionCapitalizado = ucfirst($tipoDireccion);
 
        // Crear una nueva dirección en la segunda base de datos
        $direccion = new Direccion();
        $direccion->setConnection('segunda_db');  // Usar la conexión a la segunda base de datos
        $direccion->tipo = $tipoDireccionCapitalizado;
        $direccion->entre_calles = $request->input("entre_calles_{$tipoDireccion}");
        $direccion->calle = $request->input("calle_{$tipoDireccion}");
        $direccion->numero_exterior = $request->input("numero_ext_{$tipoDireccion}");
        $direccion->numero_interior = $request->input("numero_int_{$tipoDireccion}");
        $direccion->colonia = $request->input("colonia_{$tipoDireccion}");
        $direccion->codigo_postal = $request->input("codigo_postal_{$tipoDireccion}");
        $direccion->localidad = $request->input("localidad_{$tipoDireccion}");
        $direccion->municipio = $request->input("municipio_id_{$tipoDireccion}");

        // Asignar el valor del estado según el tipo de dirección
        if ($tipoDireccion == 'fiscal') {
            $estadoId = $request->input("entidad_federativa_{$tipoDireccion}");
            $estado = Estados::on('segunda_db')->findOrFail($estadoId);
            $direccion->entidad_federativa = $estado->description;
        } else {
            $direccion->entidad_federativa = $request->input("entidad_federativa_{$tipoDireccion}");
        }

        // Guardar la dirección
        $direccion->save();

        // Actualizar la referencia de la dirección en la estación correspondiente en la segunda base de datos
        $estacion = Estacion::on('segunda_db')->findOrFail($request->input('estacion_id'));  // Cambia la conexión a la segunda base de datos
        if ($tipoDireccion == 'fiscal') {
            $estacion->domicilio_fiscal_id = $direccion->id;
        } else {
            $estacion->domicilio_servicio_id = $direccion->id;
        }
        $estacion->save();

        return redirect()->back()->with('success', 'Dirección guardada exitosamente.');
    }



    // Obtener datos de una dirección para edición
    public function obtenerDatosDireccion($id)
    {
        try {
            $direccion = Direccion::findOrFail($id);

            return response()->json([
                'id' => $direccion->id,
                'calle' => $direccion->calle,
                'numero_exterior' => $direccion->numero,
                'numero_interior' => $direccion->numero_interior,
                'colonia' => $direccion->colonia,
                'codigo_postal' => $direccion->codigo_postal,
                'municipio' => $direccion->municipio,
                'localidad' => $direccion->localidad,
                'entidad_federativa' => $direccion->entidad_federativa
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No se pudo encontrar la dirección.'], 404);
        }
    }

    // Actualizar dirección
    public function updateDireccion(Request $request, $id)
    {
        try {
            $direccion = Direccion::findOrFail($id);

            $this->validateDireccion($request, $request->direccionSelect);

            if ($request->direccionSelect == 'fiscal') {
                $this->updateFields($direccion, $request, 'fiscal');
                $estado = Estados::on('segunda_db')->findOrFail($request->entidad_federativa_fiscal);
                $direccion->entidad_federativa = $estado->description;
            } else {
                $this->updateFields($direccion, $request, 'estacion');
                $direccion->entidad_federativa = $request->entidad_federativa_estacion;
            }

            $direccion->save();

            return redirect()->back()->with('success', 'Dirección actualizada exitosamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Error al actualizar la dirección.');
        }
    }

    // Obtener municipios basado en el estado seleccionado
    public function getMunicipios($estadoId)
    {
        return response()->json(Municipios::where('id_state', $estadoId)->get());
    }

    // Helper methods to validate and update address fields
    private function validateDireccion(Request $request, $tipo)
    {
        $request->validate([
            "calle_{$tipo}" => 'required|max:255',
            "numero_ext_{$tipo}" => 'required|max:10',
            "numero_int_{$tipo}" => 'nullable|max:10',
            "colonia_{$tipo}" => 'required|max:255',
            "codigo_postal_{$tipo}" => 'required',
            "municipio_id_{$tipo}" => 'required',
            "localidad_{$tipo}" => 'required',
            "entidad_federativa_{$tipo}" => 'required',
        ]);
    }

    private function updateFields(Direccion $direccion, Request $request, $tipo)
    {
        foreach (['calle', 'numero_ext', 'numero_int', 'colonia', 'codigo_postal', 'municipio', 'localidad'] as $field) {
            $direccion->$field = $request->input("{$field}_{$tipo}");
        }
    }
}
