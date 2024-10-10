<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estacion;
use App\Models\Veeder_Root;

class VeederRootController extends Controller
{
    // Guardar un nuevo Veeder-Root
    public function store(Request $request, $estacion_id)
    {
        $request->validate([
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'numero_serie' => 'nullable|string',
        ]);

        Veeder_Root::create([
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'numero_serie' => $request->input('numero_serie'),
            'estacion_id' => $estacion_id,
        ]);

        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Veeder-Root agregado correctamente.');
    }

    // Actualizar un Veeder-Root
    public function update(Request $request, $id)
    {
        $veederRoot = Veeder_Root::findOrFail($id);

        $request->validate([
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'numero_serie' => 'nullable|string',
        ]);

        $veederRoot->update([
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'numero_serie' => $request->input('numero_serie'),
        ]);

        return redirect()->route('equipo.seleccion', $veederRoot->estacion_id)->with('success', 'Veeder-Root actualizado correctamente.');
    }

    // Eliminar un Veeder-Root
    public function destroy($estacion_id, $id)
    {
        // Encuentra el registro de Veeder-Root por su ID
        $veederRoot = Veeder_Root::findOrFail($id); // Asegúrate de que estás utilizando el nombre correcto del modelo

        // Elimina el registro
        $veederRoot->delete();

        // Redirecciona de vuelta a la página de selección de equipo
        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Veeder-Root eliminado correctamente.');
    }
}
