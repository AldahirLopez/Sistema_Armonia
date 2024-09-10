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

use Illuminate\Support\Facades\Auth; // Importa la clase Auth

class ServicioAnexo30Controller extends Controller
{

    public function index(Request $request)
    {
        // Inicializar colecciones
        $usuarios = collect();
        $servicios = collect();
        $estaciones = collect();

        // Obtener el rol "Verificador Anexo 30" y los usuarios con ese rol
        $rolVerificador = Role::on('mysql')->where('name', 'Verificador Anexo 30')->first();
        if ($rolVerificador) {
            $usuariosConRol = $rolVerificador->users()->pluck('id');
            $usuarios = User::on('mysql')->whereIn('id', $usuariosConRol)->get();
        }

        // Obtener el usuario autenticado
        $usuario = Auth::user();

        if ($usuario) {
            // Si se seleccionó un usuario en el request, obtener los servicios de ese usuario
            $usuarioSeleccionado = $request->input('usuario_id');

            // Verificar si el usuario es Administrador o Auditor
            $isAdminOrAuditor = $usuario->hasAnyRole(['Administrador', 'Auditor']);

            // Obtener los servicios, aplicando filtro por usuario seleccionado o por roles
            $servicios = ServicioAnexo::when($usuarioSeleccionado, function ($query, $usuarioSeleccionado) {
                return $query->where('usuario_id', $usuarioSeleccionado);
            }, function ($query) use ($usuario, $isAdminOrAuditor) {
                // Si es Administrador o Auditor, obtener todos los servicios
                if ($isAdminOrAuditor) {
                    return $query;
                }
                // Si no es Administrador, obtener solo los servicios del usuario autenticado
                return $query->where('usuario_id', $usuario->id);
            })->paginate(10); // Cambiamos get() por paginate() para obtener resultados paginados

            // Obtener las estaciones asociadas
            if ($isAdminOrAuditor) {
                $estaciones = Estacion::all(); // Obtener todas las estaciones si es Administrador o Auditor
            } else {
                $estacionesDirectas = Estacion::where('usuario_id', $usuario->id)->get();

                // Obtener estaciones relacionadas
                $estacionesRelacionadas = Estacion::whereIn('id', Usuario_Estacion::where('usuario_id', $usuario->id)->pluck('estacion_id'))->get();

                // Combinar estaciones directas y relacionadas, eliminando duplicados
                $estaciones = $estacionesDirectas->merge($estacionesRelacionadas)->unique('id');
            }
        }

        // Retornar la vista con los datos paginados
        return view('armonia.servicios.anexo_30.index', compact('servicios', 'usuarios', 'estaciones'));
    }

    public function store(Request $request)
    {
        $estacionId = $request->input('estacion');

        $usuario = Auth::user(); // O el método que uses para obtener el usuario
        $nomenclatura = $this->generarNomenclatura($usuario);

        // Crear instancia de ServicioAnexo y guardar datos
        $servicio = new ServicioAnexo();
        $servicio->nomenclatura = $nomenclatura;
        $servicio->pending_apro_servicio = false;
        $servicio->pending_deletion_servicio = false;
        $servicio->id_usuario = $usuario->id;
        // Asigna otros campos al servicio según sea necesario
        $servicio->save();

        // Obtener el ID del servicio anexo creado
        $servicio_anexo_id = $servicio->id;

        // Crear instancia de Estacion_Servicio y guardar la relación
        $estacionServicio = new Estacion_Servicio();
        $estacionServicio->id_servicio_anexo = $servicio_anexo_id;
        $estacionServicio->id_estacion = $estacionId;
        // Asigna otros campos a Estacion_Servicio si es necesario
        $estacionServicio->save();

        // Definir el año actual
        $anio = now()->year;

        // Definir la carpeta de destino para cada servicio en función del año, usuario y nomenclatura
        $customFolderPath = "Servicios/Anexo_30/{$anio}/{$usuario->id}/{$nomenclatura}";

        // Crear la carpeta si no existe
        Storage::disk('public')->makeDirectory($customFolderPath);

        return redirect()->route('anexo.index')->with('success', 'Servicio creado exitosamente');
    }

    public function destroy(string $id)
    {
        // Obtener el servicio por su ID
        $servicio = ServicioAnexo::findOrFail($id);

        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Verificar si el usuario autenticado es un administrador
        if ($usuario->hasRole('Administrador')) {
            // Si es administrador, eliminar el servicio directamente
            $servicio->delete();

            // Redireccionar con un mensaje de éxito
            return redirect()->route('servicio_inspector_anexo_30.index')->with('success', 'El servicio ha sido eliminado exitosamente.');
        } else {
            // Si no es administrador, marcar como pendiente de eliminación
            $servicio->pending_deletion_servicio = true;

            // Obtener la fecha y hora actuales y formatearla
            $fechaHoraActual = Carbon::now()->format('Y-m-d H:i:s');
            $servicio->date_eliminated_at = $fechaHoraActual;

            // Guardar los cambios
            $servicio->save();

            // Simular notificación al administrador
            // Aquí puedes agregar código para enviar notificaciones (por ejemplo, por correo o a través del sistema de notificaciones de Laravel)
            //$admin = User::role('Administrador')->first(); // Obtener al primer administrador como ejemplo
            //if ($admin) {
            // Suponiendo que existe una función de notificación (puede ser un correo o sistema de notificaciones)
            //    $admin->notify(new SolicitudEliminacionServicio($servicio, $usuario)); // Notificar al administrador
            // }

            // Redireccionar con un mensaje de notificación
            return redirect()->route('anexo.index')->with('info', 'La solicitud de eliminación ha sido enviada y está pendiente de aprobación.');
        }
    }


    public function generarNomenclatura($usuario)
    {
        $iniciales = $this->obtenerIniciales($usuario);
        $anio = date('Y');
        $nomenclatura = '';
        $numero = 1;

        do {
            $nomenclatura = "A-$iniciales-$numero-$anio";
            $existe = ServicioAnexo::where('nomenclatura', $nomenclatura)->exists();

            if ($existe) {
                $numero++;
            } else {
                break;
            }
        } while (true);

        return $nomenclatura;
    }

    private function obtenerIniciales($usuario)
    {
        $nombres = explode(' ', $usuario->name); // Suponiendo que el campo de nombres es 'name'
        $iniciales = '';
        $contador = 0;

        foreach ($nombres as $nombre) {
            if ($contador < 3) {
                $iniciales .= substr($nombre, 0, 1);
                $contador++;
            } else {
                break;
            }
        }

        return strtoupper($iniciales);
    }
}
