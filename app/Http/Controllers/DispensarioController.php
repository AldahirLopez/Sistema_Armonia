<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispensario;
use App\Models\Estacion;

class DispensarioController extends Controller
{
    // Guardar un nuevo dispensario
    public function store(Request $request, $estacion_id)
    {
        $request->validate([
            'num_isla' => 'required|string',
            'marca' => 'required|string',
            'modelo' => 'nullable|string',
            'numero_serie' => 'nullable|string',
            'numero_aprobacion' => 'nullable|string',
        ]);

        Dispensario::create([
            'num_isla' => $request->input('num_isla'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'numero_serie' => $request->input('numero_serie'),
            'numero_aprobacion' => $request->input('numero_aprobacion'),
            'estacion_id' => $estacion_id,
        ]);

        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Dispensario agregado correctamente.');
    }

    // Actualizar un dispensario
    public function update(Request $request, $id)
    {
        $dispensario = Dispensario::findOrFail($id);

        $request->validate([
            'num_isla' => 'required|string',
            'marca' => 'required|string',
            'modelo' => 'nullable|string',
            'numero_serie' => 'nullable|string',
            'numero_aprobacion' => 'nullable|string',
        ]);

        $dispensario->update([
            'num_isla' => $request->input('num_isla'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'numero_serie' => $request->input('numero_serie'),
            'numero_aprobacion' => $request->input('numero_aprobacion'),
        ]);

        return redirect()->route('equipo.seleccion', $dispensario->estacion_id)->with('success', 'Dispensario actualizado correctamente.');
    }

    // Eliminar un dispensario
    public function destroy($estacion_id, $id)
    {
        // Buscar el dispensario que coincida con el estacion_id y el id
        $dispensario = Dispensario::where('id', $id)->where('estacion_id', $estacion_id)->firstOrFail();

        // Eliminar el dispensario
        $dispensario->delete();

        // Redirigir a la vista de equipo con un mensaje de éxito
        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Dispensario eliminado correctamente.');
    }
}
