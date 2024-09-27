<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sonda;
use App\Models\Estacion;
use App\Models\Sondas;

class SondaController extends Controller
{
    // Guardar una nueva sonda
    public function store(Request $request, $estacion_id)
    {
        $request->validate([
            'folio' => 'required|string',
            'numero_serie' => 'nullable|string',
            'producto' => 'required|string',
            'marca' => 'required|string',
        ]);

        Sondas::create([
            'folio' => $request->input('folio'),
            'numero_serie' => $request->input('numero_serie'),
            'producto' => $request->input('producto'),
            'marca' => $request->input('marca'),
            'estacion_id' => $estacion_id,
        ]);

        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Sonda agregada correctamente.');
    }

    // Actualizar una sonda
    public function update(Request $request, $id)
    {
        $sonda = Sondas::findOrFail($id);

        $request->validate([
            'folio' => 'required|string|unique:sondas,folio,' . $id,
            'numero_serie' => 'nullable|string',
            'producto' => 'required|string',
            'marca' => 'required|string',
        ]);

        $sonda->update([
            'folio' => $request->input('folio'),
            'numero_serie' => $request->input('numero_serie'),
            'producto' => $request->input('producto'),
            'marca' => $request->input('marca'),
        ]);

        return redirect()->route('equipo.seleccion', $sonda->estacion_id)->with('success', 'Sonda actualizada correctamente.');
    }

    // Eliminar una sonda
    public function destroy($id)
    {
        $sonda = Sondas::findOrFail($id);
        $estacion_id = $sonda->estacion_id;
        $sonda->delete();

        return redirect()->route('equipo.seleccion', $estacion_id)->with('success', 'Sonda eliminada correctamente.');
    }
}
