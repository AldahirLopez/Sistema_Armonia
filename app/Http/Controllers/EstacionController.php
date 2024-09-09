<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstacionController extends Controller
{
    protected $connection = 'segunda_db';

    // Vista de selección de estación
    public function index()
    {
        return view('armonia.estacion.seleccion');
    }



    // Obtener estaciones del usuario autenticado
    public function estacion_usuario()
    {
        $usuario = Auth::user();
        $estados = Estados::where('id_country', 42)->get();
        $estaciones = [];

        if ($usuario->hasAnyRole(['Administrador', 'Auditor'])) {
            $estaciones = Estacion::all();
        } else {
            $estacionesDirectas = Estacion::where('usuario_id', $usuario->id)->get();
            $estacionesRelacionadas = collect();

            if (!$usuario->hasAnyRole(['Administrador', 'Auditor'])) {
                $relaciones = Usuario_Estacion::where('usuario_id', $usuario->id)->get();
                foreach ($relaciones as $relacion) {
                    $estacionRelacionada = Estacion::find($relacion->estacion_id);
                    if ($estacionRelacionada) {
                        $estacionesRelacionadas->push($estacionRelacionada);
                    }
                }
            }
            $estaciones = $estacionesDirectas->merge($estacionesRelacionadas)->unique('id');
        }

        return view('armonia.estacion.estaciones_usuario', compact('usuario', 'estados', 'estaciones'));
    }

    // Mostrar todas las estaciones
    public function estacion_generales()
    {
        $estaciones = Estacion::all();
        return view('armonia.estacion.estaciones_generales', compact('estaciones'));
    }
 
    // Guardar estación
    public function store(Request $request)
    {
        try {
            // Validación de los datos recibidos del formulario
            $data = $request->validate([
                'numestacion' => 'required|string|max:255',
                'razonsocial' => 'required|string|max:255',
                'rfc' => 'required|string|max:255',
                'telefono' => 'nullable|string|max:255',
                'correo' => 'nullable|email|max:255',
                'repre' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
            ]);

            // Verificar si ya existe una estación con el mismo número
            $exists = DB::connection('segunda_db')->table('estacion')
                ->where('num_estacion', $data['numestacion'])
                ->exists();

            if ($exists) {
                return redirect()->route('estaciones.usuario')->with('error', 'Error, la estación ya existe (número de estación).');
            }

            // Crear la nueva instancia de Estacion y asignar los datos validados
            $estacionServicio = new Estacion();
            $estacionServicio->num_estacion = $data['numestacion'];
            $estacionServicio->razon_social = $data['razonsocial'];
            $estacionServicio->rfc = $data['rfc'];
            $estacionServicio->telefono = $data['telefono'];
            $estacionServicio->correo_electronico = $data['correo'];
            $estacionServicio->nombre_representante_legal = $data['repre'];
            $estacionServicio->estado_republica = $data['estado'];

            // Obtener el ID del usuario autenticado
            $estacionServicio->usuario_id = auth()->id(); // O también puedes usar Auth::id()

            // Guardar en la base de datos
            $estacionServicio->save();

            // Redireccionar con un mensaje de éxito
            return redirect()->route('estaciones.usuario')->with('success', 'Estación agregada exitosamente');
        } catch (\Exception $e) {
            // Capturar cualquier excepción y mostrar el mensaje de error
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al intentar guardar la estación.']);
        }
    }


    // Eliminar estación
    public function destroy($id)
    {
        try {
            $estacion = Estacion::findOrFail($id);
            $estacion->delete();

            return redirect()->route('estaciones.usuario')->with('success', 'Estación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('estaciones.usuario')->with('error', 'Error al eliminar la estación.');
        }
    }

    // Actualizar estación
    public function update(Request $request, $id)
    {
        // Validación de los datos recibidos del formulario
        $request->validate([
            'numestacion' => 'required|string|max:255',
            'razonsocial' => 'required|string|max:255',
            'rfc' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'correo' => 'required|email|max:255',
            'repre' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        try {
            // Buscar la estación por su ID
            $estacion = Estacion::findOrFail($id);

            // Actualizar los campos con los datos del formulario
            $estacion->num_estacion = $request->input('numestacion');
            $estacion->razon_social = $request->input('razonsocial');
            $estacion->rfc = $request->input('rfc');
            $estacion->telefono = $request->input('telefono');
            $estacion->correo_electronico = $request->input('correo');
            $estacion->nombre_representante_legal = $request->input('repre');
            $estacion->estado_republica = $request->input('estado');

            // Guardar los cambios
            $estacion->save();

            // Redirigir con mensaje de éxito
            return redirect()->route('estaciones.usuario')->with('success', 'Estación actualizada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de excepciones
            return redirect()->route('estaciones.usuario')->with('error', 'Error al actualizar la estación.');
        }
    }
}
