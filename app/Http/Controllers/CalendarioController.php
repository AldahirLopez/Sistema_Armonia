<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
        // Obtener las fechas de inicio y fin del rango seleccionado
        $start = $request->start;
        $end = $request->end;

        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Si el usuario es administrador, puede ver todos los eventos, de lo contrario, solo verá los suyos
        if ($usuario->hasRole('Administrador')) {
            // Si es administrador, obtener todos los eventos dentro del rango de fechas
            $events = Evento::whereBetween('start_date', [$start, $end])->get();
        } else {
            // Si no es administrador, solo obtener los eventos creados por el usuario autenticado
            $events = Evento::where('user_id', $usuario->id)
                ->whereBetween('start_date', [$start, $end])
                ->get();
        }

        // Formatear los eventos para que FullCalendar los entienda correctamente
        $formattedEvents = $events->map(function ($event) {
            $start_time = \Carbon\Carbon::parse($event->start_date . ' ' . $event->start_time);
            $end_time = \Carbon\Carbon::parse($event->end_date); // Incluimos el día final

            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $start_time->toIso8601String(),
                'end' => $end_time->toIso8601String(),
                'className' => $event->category,
                'duration_days' => $event->duration_days // Enviamos la duración al cliente
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

        // Calcular la fecha de término (sin restar días)
        $start_date = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        $end_date = $start_date->copy()->addDays((int)$request->duration_days); // No restamos días

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

        // Calcular la nueva fecha de fin (sin restar días)
        $start_date = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        $end_date = $start_date->copy()->addDays((int)$request->duration_days); // No restamos días

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

    public function eventosDelMes()
    {
        $mesActual = Carbon::now()->month; // Obtiene el mes actual
        $anioActual = Carbon::now()->year; // Obtiene el año actual

        // Filtra los eventos del mes y año actual y los ordena correctamente
        $eventos = Evento::whereYear('start_date', $anioActual)
            ->whereMonth('start_date', $mesActual)
            ->orderByRaw('STR_TO_DATE(start_date, "%Y-%m-%d") ASC') // Convierte a fecha y ordena
            ->orderBy('start_time', 'asc') // Ordena por hora de inicio
            ->get();

        return view('index', compact('eventos')); // Asegúrate de que 'index' sea la vista correcta.
    }
}
