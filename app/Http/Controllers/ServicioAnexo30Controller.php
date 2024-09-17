<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estacion_Servicio;
use App\Models\ServicioAnexo;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuario_Estacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ServicioAnexo30Controller extends Controller
{
    public function index(Request $request)
    {
        $usuarios = $this->getUsuariosConRol('Verificador Anexo 30');
        $usuario = Auth::user();

        if ($usuario) {
            $usuarioSeleccionado = $request->input('usuario_id');
            $isAdminOrAuditor = $usuario->hasAnyRole(['Administrador', 'Auditor']);

            $estaciones = $this->getEstacionesSinServicio($usuario, $isAdminOrAuditor);

            $servicios = ServicioAnexo::when($usuarioSeleccionado, function ($query, $usuarioSeleccionado) {
                return $query->where('id_usuario', $usuarioSeleccionado);
            }, function ($query) use ($usuario, $isAdminOrAuditor) {
                return $isAdminOrAuditor ? $query : $query->where('id_usuario', $usuario->id);
            })->paginate(10);

            return view('armonia.servicios.anexo_30.index', compact('servicios', 'usuarios', 'estaciones'));
        }

        return redirect()->route('anexo.index')->with('error', 'No se ha autenticado el usuario.');
    }

    public function store(Request $request)
    {
        $estacionId = $request->input('estacion');
        $usuario = Auth::user();
        $nomenclatura = $this->generarNomenclatura($usuario);

        // Crear el nuevo servicio anexo
        $servicio = ServicioAnexo::create([
            'nomenclatura' => $nomenclatura,
            'pending_apro_servicio' => false,
            'pending_deletion_servicio' => false,
            'id_usuario' => $usuario->id,
        ]);

        // Crear la relación con la estación
        Estacion_Servicio::create([
            'id_servicio_anexo' => $servicio->id,
            'id_estacion' => $estacionId,
        ]);

        // Crear la carpeta para el servicio
        $this->createServiceDirectory($usuario->id, $nomenclatura);

        // Enviar notificación a los administradores
        app('App\Http\Controllers\NotificacionController')->notificarNuevoServicio($servicio);

        // Redirigir con mensaje de éxito
        return redirect()->route('anexo.index')->with('success', 'Servicio creado exitosamente y notificación enviada al administrador.');
    }


    public function destroy(string $id)
    {
        $servicio = ServicioAnexo::findOrFail($id);
        $usuario = Auth::user();

        // Ruta personalizada para la carpeta del servicio
        $anio = now()->year;
        $customFolderPath = "Servicios/Anexo_30/{$anio}/{$usuario->id}/{$servicio->nomenclatura}";

        // Verificar si el usuario es administrador
        if ($usuario->hasRole('Administrador')) {

            // Verificar si la carpeta existe y eliminarla
            if (Storage::disk('public')->exists($customFolderPath)) {
                Storage::disk('public')->deleteDirectory($customFolderPath);
            } else {
                return redirect()->route('anexo.index')->with('error', 'La carpeta no existe o ya fue eliminada.');
            }

            // Eliminar el servicio de la base de datos
            $servicio->delete();

            return redirect()->route('anexo.index')->with('warning', 'El servicio y su carpeta han sido eliminados exitosamente.');
        }

        // Si no es administrador, marcar el servicio como pendiente de eliminación
        $servicio->update([
            'pending_deletion_servicio' => true,
            'date_eliminated_at' => now(),
        ]);

        // Aquí puedes añadir el código de notificación al administrador

        return redirect()->route('anexo.index')->with('info', 'La solicitud de eliminación está pendiente de aprobación.');
    }


    private function getUsuariosConRol(string $roleName)
    {
        $rol = Role::on('mysql')->where('name', $roleName)->first();
        return $rol ? User::on('mysql')->whereIn('id', $rol->users()->pluck('id'))->get() : collect();
    }

    private function getEstacionesSinServicio($usuario, $isAdminOrAuditor)
    {
        return Estacion::when(!$isAdminOrAuditor, function ($query) use ($usuario) {
            return $query->where('usuario_id', $usuario->id)
                ->orWhereIn('id', Usuario_Estacion::where('usuario_id', $usuario->id)->pluck('estacion_id'));
        })
            ->whereDoesntHave('estacionServicio')
            ->get();
    }

    private function createServiceDirectory($userId, $nomenclatura)
    {
        $anio = now()->year;
        $baseFolderPath = "Servicios/Anexo_30/{$anio}/{$userId}/{$nomenclatura}";

        // Carpetas base: documentos, expediente, pagos, facturas
        $mainFolders = [
            'documentos',
            'expediente',
            'pagos',
            'facturas',
        ];

        // Crear las carpetas base
        foreach ($mainFolders as $folder) {
            Storage::disk('public')->makeDirectory("{$baseFolderPath}/{$folder}");
        }

        // Subcarpetas dentro de "documentos"
        $subfolders = [
            'generales',
            'medicion',
            'informatica',
            'inspeccion',
        ];

        // Crear las subcarpetas dentro de "documentos"
        foreach ($subfolders as $subfolder) {
            Storage::disk('public')->makeDirectory("{$baseFolderPath}/documentos/{$subfolder}");
        }
    }


    public function generarNomenclatura($usuario)
    {
        $iniciales = $this->obtenerIniciales($usuario);
        $anio = now()->year;
        $numero = 1;

        do {
            $nomenclatura = "A-$iniciales-$numero-$anio";
            $existe = ServicioAnexo::where('nomenclatura', $nomenclatura)->exists();
            $numero++;
        } while ($existe);

        return $nomenclatura;
    }

    private function obtenerIniciales($usuario)
    {
        $nombres = explode(' ', $usuario->name);
        $iniciales = collect($nombres)->take(3)->map(function ($nombre) {
            return strtoupper(substr($nombre, 0, 1));
        })->implode('');

        return $iniciales;
    }
}
