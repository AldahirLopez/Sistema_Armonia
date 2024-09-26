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

        $municipios = $this->getMunicipiosFromEstado($estacion->estado_republica);

        $direccionFiscal = Direccion::find($estacion->domicilio_fiscal_id);
        $direccionEstacion = Direccion::find($estacion->domicilio_servicio_id);

        return view('armonia.direcciones.index', compact('estacion', 'direccionFiscal', 'direccionEstacion', 'municipios', 'estados'));
    }

    // Guardar nueva dirección
    public function guardarDireccion(Request $request)
    {
        $this->validate($request, [
            'direccionSelect' => 'required|in:fiscal,estacion',
            'estacion_id' => 'required|exists:segunda_db.estacion,id',
        ]);

        $tipoDireccion = $request->input('direccionSelect');
        $this->validateDireccion($request, $tipoDireccion);

        $direccion = $this->createDireccion($request, $tipoDireccion);

        $this->updateEstacionWithDireccion($request->input('estacion_id'), $direccion->id, $tipoDireccion);

        return redirect()->back()->with('success', 'Dirección guardada exitosamente.');
    }

    // Obtener datos de una dirección para edición
    public function obtenerDatosDireccion($id)
    {
        try {
            $direccion = Direccion::findOrFail($id);

            return response()->json($direccion);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No se pudo encontrar la dirección.'], 404);
        }
    }

    // Actualizar dirección
    public function updateDireccion(Request $request, $id)
    {
        try {
            $direccion = Direccion::findOrFail($id);
            $tipoDireccion = $request->input('direccionSelect');

            $this->validateDireccion($request, $tipoDireccion);

            $this->updateFields($direccion, $request, $tipoDireccion);

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

    // Eliminar dirección
    public function destroy($id)
    {
        try {
            $direccion = Direccion::findOrFail($id);
            $this->removeDireccionFromEstacion($direccion->id);

            $direccion->delete();

            return redirect()->back()->with('warning', 'Dirección eliminada exitosamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'La dirección no se pudo encontrar.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar la dirección.');
        }
    }

    // Métodos auxiliares

    private function getMunicipiosFromEstado($estadoDescription)
    {
        $estado = Estados::where('description', $estadoDescription)->first();
        return $estado ? Municipios::where('id_state', $estado->id)->get() : collect();
    }

    private function validateDireccion(Request $request, $tipo)
    {
        $campos = [
            'fiscal' => [
                'entre_calles_fiscal' => 'nullable|max:255',
                'calle_fiscal' => 'nullable|max:255',
                'numero_exterior_fiscal' => 'nullable|max:255',
                'numero_interior_fiscal' => 'nullable|max:255',
                'colonia_fiscal' => 'nullable|max:255',
                'codigo_postal_fiscal' => 'nullable',
                'municipio_fiscal' => 'required',
                'localidad_fiscal' => 'nullable|max:255',
                'entidad_federativa_fiscal' => 'required',
            ], 
            'estacion' => [
                'entre_calles_estacion' => 'nullable|max:255',
                'calle_estacion' => 'nullable|max:255',
                'numero_exterior_estacion' => 'nullable|max:255',
                'numero_interior_estacion' => 'nullable|max:255',
                'colonia_estacion' => 'nullable|max:255',
                'codigo_postal_estacion' => 'nullable',
                'municipio_estacion' => 'required',
                'localidad_estacion' => 'nullable|max:255',
                'entidad_federativa_estacion' => 'required',
            ],
        ];

        $this->validate($request, $campos[$tipo]);
    }

    private function createDireccion(Request $request, $tipoDireccion)
    {
        $direccion = new Direccion();
        $direccion->setConnection('segunda_db');
        $direccion->tipo = ucfirst($tipoDireccion);

        $this->updateFields($direccion, $request, $tipoDireccion);

        if ($tipoDireccion == 'fiscal') {
            $estado = Estados::on('segunda_db')->findOrFail($request->input("entidad_federativa_fiscal"));
            $direccion->entidad_federativa = $estado->description;
        } else {
            $direccion->entidad_federativa = $request->input("entidad_federativa_estacion");
        }

        $direccion->save();

        return $direccion;
    }

    private function updateEstacionWithDireccion($estacionId, $direccionId, $tipoDireccion)
    {
        $estacion = Estacion::on('segunda_db')->findOrFail($estacionId);

        if ($tipoDireccion == 'fiscal') {
            $estacion->domicilio_fiscal_id = $direccionId;
        } else {
            $estacion->domicilio_servicio_id = $direccionId;
        }

        $estacion->save();
    }

    private function updateFields(Direccion $direccion, Request $request, $tipo)
    {
        foreach (['entre_calles', 'calle', 'numero_exterior', 'numero_interior', 'colonia', 'codigo_postal', 'municipio', 'localidad'] as $field) {
            $direccion->$field = $request->input("{$field}_{$tipo}");
        }
    }

    private function removeDireccionFromEstacion($direccionId)
    {
        $estacionFiscal = Estacion::on('segunda_db')->where('domicilio_fiscal_id', $direccionId)->first();
        $estacionServicio = Estacion::on('segunda_db')->where('domicilio_servicio_id', $direccionId)->first();

        if ($estacionFiscal) {
            $estacionFiscal->domicilio_fiscal_id = null;
            $estacionFiscal->save();
        }

        if ($estacionServicio) {
            $estacionServicio->domicilio_servicio_id = null;
            $estacionServicio->save();
        }
    }
}
