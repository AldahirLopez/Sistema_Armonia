<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('armonia.calendario.index');
    }

    public function fetchEvents(Request $request)
    {
        try {
            $start = $request->start; // Fecha de inicio (start)
            $end = $request->end;     // Fecha de fin (end)

            // Filtrar eventos en el rango de fechas
            $events = Evento::whereBetween('start_time', [$start, $end])->get();

            $formattedEvents = $events->map(function ($event) {
                $start_time = $event->start_time instanceof \Carbon\Carbon ? $event->start_time : \Carbon\Carbon::parse($event->start_time);

                // Ajustamos la fecha de fin basada en la duración proporcionada
                $end_time = $start_time->copy()->addDays($event->duration_days); // La duración incluye el primer día

                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $start_time->format('Y-m-d\TH:i:s'), // Formato ISO 8601
                    'end' => $end_time->format('Y-m-d\TH:i:s'),
                    'className' => $event->category,
                    'duration_days' => $event->duration_days,
                ];
            });

            return response()->json($formattedEvents);
        } catch (\Exception $e) {
            \Log::error('Error al obtener eventos: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener eventos'], 500);
        }
    }



    // Almacenar un nuevo evento
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'start_time' => 'required|date',
            'duration_days' => 'required|integer|min:1',
        ]);

        Evento::create([
            'title' => $request->title,
            'category' => $request->category,
            'start_time' => $request->start_time,
            'duration_days' => $request->duration_days,
            'user_id' => Auth::id(), // El usuario autenticado crea el evento
        ]);

        return response()->json(['message' => 'Evento creado con éxito']);
    }

    // Actualizar un evento
    public function update(Request $request, $id)
    {
        $event = Evento::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'duration_days' => 'required|integer|min:1',
        ]);

        $event->update($request->all());

        return response()->json(['message' => 'Evento actualizado con éxito']);
    }

    // Eliminar un evento
    public function destroy($id)
    {
        $event = Evento::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Evento eliminado con éxito']);
    }
}
