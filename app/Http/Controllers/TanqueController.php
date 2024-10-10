<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tanque;
use App\Models\Estacion;

class TanqueController extends Controller
{
    // Guardar un nuevo tanque
    public function store(Request $request, $estacion_id)
    {
        $request->validate([
            'folio' => 'required|string',
            'marca' => 'required|string',
            'producto' => 'required|string',
            'capacidad' => 'required|integer',
            'numero_serie' => 'nullable|string',
        ]);

        Tanque::create([
            'folio' => $request->input('folio'),
            'marca' => $request->input('marca'),
            'producto' => $request->input('producto'),
            'capacidad' => $request->input('capacidad'),
            'numero_serie' => $request->input('numero_serie'),
            'estacion_id' => $estacion_id,
        ]);

        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Tanque agregado correctamente.');
    }



    // Actualizar un tanque
    public function update(Request $request, $id)
    {
        $tanque = Tanque::findOrFail($id);

        $request->validate([
            'folio' => 'required|string|unique:tanques,folio,' . $id,
            'marca' => 'required|string',
            'producto' => 'required|string',
            'capacidad' => 'required|integer',
        ]);

        $tanque->update([
            'folio' => $request->input('folio'),
            'marca' => $request->input('marca'),
            'producto' => $request->input('producto'),
            'capacidad' => $request->input('capacidad'),
            'numero_serie' => $request->input('numero_serie'),
        ]);

        return redirect()->route('equipo.seleccion', $tanque->estacion_id)->with('success', 'Tanque actualizado correctamente.');
    }

    // Eliminar un tanque
    public function destroy($estacion_id, $id)
    {
        // Encuentra el tanque por su ID
        $tanque = Tanque::findOrFail($id);

        // Elimina el tanque
        $tanque->delete();

        // Redirecciona de vuelta a la página de selección de equipo
        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Tanque eliminado correctamente.');
    }
}
