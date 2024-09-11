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
        $estaciones = $this->getEstacionesUsuario($usuario);

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
        $data = $this->validateEstacion($request);

        if ($this->estacionExists($data['numestacion'])) {
            return redirect()->route('estaciones.usuario')->with('error', 'Error, la estación ya existe (número de estación).');
        }

        try {
            $this->createEstacion($data);
            return redirect()->route('estaciones.usuario')->with('success', 'Estación agregada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al intentar guardar la estación.']);
        }
    }

    // Eliminar estación
    public function destroy($id)
    {
        try {
            $this->deleteEstacion($id);
            return redirect()->route('estaciones.usuario')->with('warning', 'Estación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('estaciones.usuario')->with('error', 'Error al eliminar la estación.');
        }
    }

    // Actualizar estación
    public function update(Request $request, $id)
    {
        $data = $this->validateEstacion($request);

        try {
            $this->updateEstacion($data, $id);
            return redirect()->route('estaciones.usuario')->with('success', 'Estación actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('estaciones.usuario')->with('error', 'Error al actualizar la estación.');
        }
    }

    // Método privado para obtener las estaciones del usuario
    private function getEstacionesUsuario($usuario)
    {
        if ($usuario->hasAnyRole(['Administrador', 'Auditor'])) {
            return Estacion::all();
        }

        $estacionesDirectas = Estacion::where('usuario_id', $usuario->id)->get();
        $estacionesRelacionadas = Estacion::whereIn('id', Usuario_Estacion::where('usuario_id', $usuario->id)->pluck('estacion_id'))->get();

        return $estacionesDirectas->merge($estacionesRelacionadas)->unique('id');
    }

    // Método privado para validar los datos de la estación
    private function validateEstacion(Request $request)
    {
        return $request->validate([
            'tipo_estacion' => 'required|string|max:255',
            'numestacion' => 'required|string|max:255',
            'razonsocial' => 'required|string|max:255',
            'rfc' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'correo' => 'nullable|email|max:255',
            'repre' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);
    }

    // Método privado para verificar si la estación ya existe
    private function estacionExists($numEstacion)
    {
        return DB::connection($this->connection)
            ->table('estacion')
            ->where('num_estacion', $numEstacion)
            ->exists();
    }

    // Método privado para crear una estación
    private function createEstacion(array $data)
    {
        Estacion::create([
            'tipo_estacion' => $data['tipo_estacion'],
            'num_estacion' => $data['numestacion'],
            'razon_social' => $data['razonsocial'],
            'rfc' => $data['rfc'],
            'telefono' => $data['telefono'],
            'correo_electronico' => $data['correo'],
            'nombre_representante_legal' => $data['repre'],
            'estado_republica' => $data['estado'],
            'usuario_id' => auth()->id(),
        ]);
    }

    // Método privado para eliminar una estación
    private function deleteEstacion($id)
    {
        $estacion = Estacion::findOrFail($id);
        $estacion->delete();
    }

    // Método privado para actualizar una estación
    private function updateEstacion(array $data, $id)
    {
        $estacion = Estacion::findOrFail($id);
        $estacion->update($data);
    }
}
