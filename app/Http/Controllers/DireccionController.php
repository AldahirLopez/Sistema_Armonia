<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Estados\Municipios;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    protected $connection = 'segunda_db';

    // Ver direcciones asociadas a la estación
    public function verDirecciones($id)
    {
        $estacion = Estacion::findOrFail($id);
        $estados = Estados::where('id_country', 42)->get();
        $estado = $estacion->estado_republica;
        $estado_id = Estados::where('description', $estado)->first()->id ?? null;
        $municipios = $estado_id ? Municipios::where('id_state', $estado_id)->get() : collect();

        $direccionFiscal = Direccion::find($estacion->domicilio_fiscal_id);
        $direccionEstacion = Direccion::find($estacion->domicilio_servicio_id);

        return view('armonia.estacion.direcciones_estacion', compact('estacion', 'direccionFiscal', 'direccionEstacion', 'municipios', 'estados'));
    }

    // Guardar nueva dirección
    public function guardarDireccion(Request $request)
    {
        $request->validate([
            'direccionSelect' => 'required|in:fiscal,estacion',
            'estacion_id' => 'required|exists:segunda_db.estacion,id',
        ]);

        $tipoDireccion = $request->input('direccionSelect');
        $campos = [
            'fiscal' => [
                'calle_fiscal' => 'required|max:255',
                'numero_ext_fiscal' => 'required|max:10',
                'numero_int_fiscal' => 'nullable|max:10',
                'colonia_fiscal' => 'required|max:255',
                'codigo_postal_fiscal' => 'required',
                'municipio_id_fiscal' => 'required',
                'localidad_fiscal' => 'required',
                'entidad_federativa_fiscal' => 'required',
            ],
            'estacion' => [
                'calle_estacion' => 'required|max:255',
                'numero_ext_estacion' => 'required|max:10',
                'numero_int_estacion' => 'nullable|max:10',
                'colonia_estacion' => 'required|max:255',
                'codigo_postal_estacion' => 'required',
                'municipio_id_estacion' => 'required',
                'localidad_estacion' => 'required',
                'entidad_federativa_estacion' => 'required',
            ],
        ];

        $request->validate($campos[$tipoDireccion]);

        $direccion = new Direccion();
        $direccion->setConnection('segunda_db');
        $direccion->tipo = ucfirst($tipoDireccion);
        $direccion->calle = $request->input("calle_{$tipoDireccion}");
        $direccion->numero = $request->input("numero_ext_{$tipoDireccion}");
        $direccion->numero_interior = $request->input("numero_int_{$tipoDireccion}");
        $direccion->colonia = $request->input("colonia_{$tipoDireccion}");
        $direccion->codigo_postal =         $request->input("codigo_postal_{$tipoDireccion}");
        $direccion->localidad = $request->input("localidad_{$tipoDireccion}");
        $direccion->municipio = $request->input("municipio_id_{$tipoDireccion}");

        if ($tipoDireccion == 'fiscal') {
            // Obtener el nombre del estado para una dirección fiscal
            $estadoId = $request->input("entidad_federativa_fiscal");
            $estado = Estados::on('segunda_db')->findOrFail($estadoId);
            $direccion->entidad_federativa = $estado->description;
        } else {
            // Guardar directamente el estado para una dirección de servicio
            $direccion->entidad_federativa = $request->input("entidad_federativa_{$tipoDireccion}");
        }

        // Guardar la dirección en la base de datos
        $direccion->save();

        // Asignar la dirección a la estación correspondiente en la base de datos
        $estacion = Estacion::on('segunda_db')->findOrFail($request->input('estacion_id'));

        if ($tipoDireccion == 'fiscal') {
            $estacion->domicilio_fiscal_id = $direccion->id;
        } else {
            $estacion->domicilio_servicio_id = $direccion->id;
        }

        $estacion->save();

        return redirect()->back()->with('success', 'Dirección guardada exitosamente.');
    }

    // Obtener datos de una dirección para edición
    public function ObtenerDatosDireccion($id)
    {
        try {
            $direccion = Direccion::findOrFail($id);

            // Retornar los datos de la dirección en formato JSON
            return response()->json([
                'id' => $direccion->id,
                'calle' => $direccion->calle,
                'numero_ext' => $direccion->numero,
                'numero_int' => $direccion->numero_interior,
                'colonia' => $direccion->colonia,
                'codigo_postal' => $direccion->codigo_postal,
                'municipio' => $direccion->municipio,
                'localidad' => $direccion->localidad,
                'entidad_federativa' => $direccion->entidad_federativa
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo encontrar la dirección.'], 404);
        }
    }

    // Actualizar dirección
    public function updateDireccion(Request $request, $id)
    {
        try {
            $direccion = Direccion::findOrFail($id);

            if ($request->direccionSelect == 'fiscal') {
                $direccion->calle = $request->calle_fiscal;
                $direccion->numero = $request->numero_ext_fiscal;
                $direccion->numero_interior = $request->numero_int_fiscal;
                $direccion->colonia = $request->colonia_fiscal;
                $direccion->codigo_postal = $request->codigo_postal_fiscal;
                $direccion->localidad = $request->localidad_fiscal;
                $direccion->municipio = $request->municipio_id_fiscal;

                $estadoId = $request->entidad_federativa_fiscal;
                $estado = Estados::on('segunda_db')->findOrFail($estadoId);
                $direccion->entidad_federativa = $estado->description;
            } else {
                $direccion->calle = $request->calle_estacion;
                $direccion->numero = $request->numero_ext_estacion;
                $direccion->numero_interior = $request->numero_int_estacion;
                $direccion->colonia = $request->colonia_estacion;
                $direccion->codigo_postal = $request->codigo_postal_estacion;
                $direccion->localidad = $request->localidad_estacion;
                $direccion->municipio = $request->municipio_id_estacion;
                $direccion->entidad_federativa = $request->entidad_federativa_estacion;
            }

            $direccion->save();

            return redirect()->back()->with('success', 'Dirección actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la dirección.');
        }
    }

    // Obtener municipios basado en el estado seleccionado
    public function getMunicipios($estadoId)
    {
        $municipios = Municipios::where('id_state', $estadoId)->get();
        return response()->json($municipios);
    }
}
