<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    /**
     * Muestra la vista del calendario
     */
    public function index()
    {
        return view('armonia.calendario.index'); // La vista del calendario
    }

    /**
     * Obtener los eventos registrados (para mostrarlos en el calendario)
     */
    public function fetchEvents(Request $request)
    {
        // Obtener eventos dentro del rango de fechas seleccionadas
        $start = $request->start;
        $end = $request->end;

        $events = Evento::whereBetween('start_date', [$start, $end])->get();

        // Formatear los eventos para que FullCalendar los entienda correctamente
        $formattedEvents = $events->map(function ($event) {
            $start_time = \Carbon\Carbon::parse($event->start_date . ' ' . $event->start_time);
            $end_time = \Carbon\Carbon::parse($event->end_date)->addDay(); // Incluimos el día final

            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $start_time->toIso8601String(),
                'end' => $end_time->toIso8601String(),
                'className' => $event->category,
            ];
        });

        return response()->json($formattedEvents);
    }


    /**
     * Guardar un nuevo evento
     */
    public function store(Request $request)
    {
        // Validar los datos del evento
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'duration_days' => 'required|integer|min:1',
        ]);

        // Calcular la fecha de término
        $start_date = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        $end_date = $start_date->copy()->addDays($request->duration_days - 1);

        // Guardar el evento
        Evento::create([
            'title' => $request->title,
            'category' => $request->category,
            'start_date' => $start_date->toDateString(),
            'start_time' => $start_date->toTimeString(),
            'end_date' => $end_date->toDateString(),
            'duration_days' => $request->duration_days,
            'user_id' => Auth::id(), // Usuario que creó el evento
        ]);

        return response()->json(['message' => 'Evento creado con éxito'], 200);
    }

    /**
     * Actualizar un evento existente
     */
    public function update(Request $request, $id)
    {
        $event = Evento::findOrFail($id);

        // Validar los datos actualizados
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'duration_days' => 'required|integer|min:1',
        ]);

        // Calcular la nueva fecha de fin
        $start_date = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        $end_date = $start_date->copy()->addDays($request->duration_days - 1);

        // Actualizar los datos del evento
        $event->update([
            'title' => $request->title,
            'category' => $request->category,
            'start_date' => $start_date->toDateString(),
            'start_time' => $start_date->toTimeString(),
            'end_date' => $end_date->toDateString(),
            'duration_days' => $request->duration_days,
        ]);

        return response()->json(['message' => 'Evento actualizado con éxito'], 200);
    }

    /**
     * Eliminar un evento
     */
    public function destroy($id)
    {
        $event = Evento::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Evento eliminado con éxito'], 200);
    }
}
