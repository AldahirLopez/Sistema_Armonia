<?php

namespace App\Http\Controllers;

use App\Models\Servicio_005;
use App\Models\ServicioAnexo;
use App\Models\User;
use App\Notifications\ServicioCreadoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{
    // Obtener notificaciones no leídas (pendientes)
    public function obtenerNotificacionesPendientes()
    {
        $pendientes = Auth::user()->unreadNotifications;
        return view('partials.notificaciones', compact('pendientes'));
    }

    // Enviar notificaciones a los administradores cuando se crea un nuevo servicio
    public function notificarNuevoServicio($servicio)
    {
        $administradores = User::role('Administrador')->get();

        if ($administradores->isEmpty()) {
            return redirect()->back()->with('error', 'No hay administradores disponibles para enviar la notificación.');
        }

        // Enviar notificación dependiendo del tipo de servicio
        if ($servicio instanceof ServicioAnexo || $servicio instanceof Servicio_005) {
            Notification::send($administradores, new ServicioCreadoNotification($servicio));
        } else {
            return redirect()->back()->with('error', 'Tipo de servicio no soportado para notificación.');
        }
    }

    // Marcar notificación como leída
    public function marcarLeida($id)
    {
        $notification = Auth::user()->notifications->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

    // Ver todas las notificaciones
    public function todas()
    {
        $notifications = Auth::user()->notifications;
        return view('notificaciones.todas', compact('notifications'));
    }

    // Mostrar notificación específica
    public function mostrarNotificacion($id)
    {
        $notification = Auth::user()->notifications->find($id);
        if ($notification) {
            $data = $notification->data;
            $tipo_servicio = $data['tipo_servicio'] ?? 'Desconocido';
            return view('notificaciones.show', compact('data', 'tipo_servicio', 'notification'));
        }
        return redirect()->route('notificaciones.show')->with('error', 'Notificación no encontrada.');
    }

    // Listar todas las notificaciones relacionadas
    public function listarNotificaciones()
    {
        $notificaciones = Auth::user()->notifications;
        return view('notificaciones.listar', compact('notificaciones'));
    }

    // Aprobación de los servicios por administrador
    public function AprobarServicio($nomenclatura, $notificationId)
    {
        $servicio = $this->buscarServicio($nomenclatura);

        if ($servicio) {
            $servicio->pending_apro_servicio = true;
            $servicio->save();

            $this->eliminarNotificacion($notificationId);
            return redirect()->route('notificaciones.listar')->with('success', 'Servicio aprobado y notificación eliminada correctamente.');
        }

        return redirect()->route('notificaciones.listar')->with('error', 'Servicio no encontrado.');
    }

    public function CancelarServicio($nomenclatura, $notificationId)
    {
        $servicio = $this->buscarServicio($nomenclatura);
        if (!$servicio) {
            return redirect()->route('notificaciones.listar')->with('error', 'Servicio no encontrado.');
        }

        $usuarioId = $servicio->id_usuario;
        $anio = now()->year;
        $customFolderPath = '';

        // Determinar la ruta de la carpeta según el tipo de servicio
        if ($servicio instanceof ServicioAnexo) {
            $customFolderPath = "Servicios/Anexo_30/{$anio}/{$usuarioId}/{$nomenclatura}";
        } elseif ($servicio instanceof Servicio_005) {
            $customFolderPath = "Servicios/005/{$anio}/{$usuarioId}/{$nomenclatura}";
        }

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Verificar si la carpeta existe y eliminarla
            if ($customFolderPath && Storage::disk('public')->exists($customFolderPath)) {
                if (!Storage::disk('public')->deleteDirectory($customFolderPath)) {
                    throw new \Exception('Error al eliminar la carpeta del servicio.');
                }
            } else {
                throw new \Exception('La carpeta no existe.');
            }

            // Eliminar el servicio de la base de datos
            $servicio->delete();

            // Eliminar la notificación
            $notification = Auth::user()->notifications->find($notificationId);
            if ($notification) {
                $notification->delete();
            }

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('notificaciones.listar')->with('warning', 'Servicio, carpeta y notificación eliminados correctamente.');
        } catch (\Exception $e) {
            // Revertir la transacción si ocurre algún error
            DB::rollBack();

            return redirect()->route('notificaciones.listar')->with('error', 'Error al eliminar el servicio, la carpeta o la notificación: ' . $e->getMessage());
        }
    }


    public function EliminarServicio($nomenclatura, $notificationId)
    {
        $servicio = $this->buscarServicio($nomenclatura);
        if (!$servicio) {
            return redirect()->route('notificaciones.listar')->with('error', 'Servicio no encontrado.');
        }

        $usuario = Auth::user();
        $anio = now()->year;
        $customFolderPath = "";

        if ($servicio instanceof ServicioAnexo) {
            $customFolderPath = "Servicios/Anexo_30/{$anio}/{$servicio->id_usuario}/{$servicio->nomenclatura}";
        } elseif ($servicio instanceof Servicio_005) {
            $customFolderPath = "Servicios/005/{$anio}/{$servicio->id_usuario}/{$servicio->nomenclatura}";
        }

        // Verificar si el usuario es administrador
        if ($usuario->hasRole('Administrador')) {
            // Verificar si la carpeta existe y eliminarla
            if (Storage::disk('public')->exists($customFolderPath)) {
                Storage::disk('public')->deleteDirectory($customFolderPath);
            } else {
                return redirect()->route('notificaciones.listar')->with('error', 'La carpeta no existe o ya fue eliminada.');
            }

            // Eliminar el servicio de la base de datos
            $servicio->delete();

            // Eliminar la notificación relacionada
            \DB::table('notifications')->where('id', $notificationId)->delete();

            return redirect()->route('notificaciones.listar')->with('info', 'El servicio y su notificación han sido eliminados exitosamente.');
        }
    }

    // Métodos auxiliares

    // Buscar el servicio por su nomenclatura
    private function buscarServicio($nomenclatura)
    {
        try {
            // Intentar encontrar el servicio en ambos modelos usando la nomenclatura
            return ServicioAnexo::where('nomenclatura', $nomenclatura)->first()
                ?? Servicio_005::where('nomenclatura', $nomenclatura)->first();
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    // Eliminar notificación por ID
    private function eliminarNotificacion($notificationId)
    {
        $notification = Auth::user()->notifications->find($notificationId);
        if ($notification) {
            $notification->delete();
        }
    }
}
