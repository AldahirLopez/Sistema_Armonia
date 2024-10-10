<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estacion;
use App\Models\Medidor_Flujo;

class MedidorFlujoController extends Controller
{
    // Guardar un nuevo Medidor de Flujo
    public function store(Request $request, $estacion_id)
    {
        $request->validate([
            'marca' => 'required|string',
            'numero_serie' => 'nullable|string',
        ]);

        Medidor_Flujo::create([
            'marca' => $request->input('marca'),
            'numero_serie' => $request->input('numero_serie'),
            'estacion_id' => $estacion_id,
        ]);

        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Medidor de Flujo agregado correctamente.');
    }

    // Actualizar un Medidor de Flujo existente
    public function update(Request $request, $id)
    {
        $medidorFlujo = Medidor_Flujo::findOrFail($id);

        $request->validate([
            'marca' => 'required|string',
            'numero_serie' => 'nullable|string',
        ]);

        $medidorFlujo->update([
            'marca' => $request->input('marca'),
            'numero_serie' => $request->input('numero_serie'),
        ]);

        return redirect()->route('equipo.seleccion', $medidorFlujo->estacion_id)->with('success', 'Medidor de Flujo actualizado correctamente.');
    }

    // Eliminar un Medidor de Flujo
    public function destroy($estacion_id, $id)
    {
        $medidorFlujo = Medidor_Flujo::findOrFail($id);
        $medidorFlujo->delete();

        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Medidor de Flujo eliminado correctamente.');
    }
}
