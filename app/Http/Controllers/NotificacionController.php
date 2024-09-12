<?php

namespace App\Http\Controllers;

use App\Models\ServicioAnexo;
use App\Models\User;
use App\Notifications\ServicioCreadoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotificacionController extends Controller
{
    // Obtener notificaciones no leídas (pendientes)
    public function obtenerNotificacionesPendientes()
    {
        $pendientes = Auth::user()->unreadNotifications;
        return view('partials.notificaciones', compact('pendientes'));
    }

    // Enviar notificaciones a los administradores cuando se crea un nuevo servicio
    public function notificarNuevoServicio(ServicioAnexo $servicio)
    {
        $administradores = User::role('Administrador')->get();

        if ($administradores->isEmpty()) {
            return redirect()->back()->with('error', 'No hay administradores disponibles para enviar la notificación.');
        }

        // Enviar notificación
        Notification::send($administradores, new ServicioCreadoNotification($servicio));
        return redirect()->back()->with('success', 'Notificación enviada a los administradores.');
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
            $tipo_servicio = "Anexo 30"; // Aquí puedes cambiar el tipo de servicio
            return view('notificaciones.show', compact('data', 'tipo_servicio', 'notification'));
        }
        return redirect()->route('notificaciones.show')->with('error', 'Notificación no encontrada.');
    }

    // Listar todas las notificaciones relacionadas con Anexo 30
    public function listarNotificacionesAnexo30()
    {
        $notificaciones = Auth::user()->notifications;
        return view('notificaciones.listar', compact('notificaciones'));
    }

    // Aprobación de los servicios por administrador
    public function AprobarServicioAnexo30($id, $notificationId)
    {
        $servicio = $this->buscarServicio($id);

        if ($servicio) {
            $servicio->pending_apro_servicio = true;
            $servicio->save();

            $this->eliminarNotificacion($notificationId);
            return redirect()->route('notificaciones.listar')->with('success', 'Servicio aprobado y notificación eliminada correctamente.');
        }

        return redirect()->route('notificaciones.listar')->with('error', 'Servicio no encontrado.');
    }

    // Eliminación del servicio y la notificación por administrador
    public function EliminarServicioAnexo30($id, $notificationId)
    {
        $servicio = $this->buscarServicio($id);

        if ($servicio) {
            $servicio->delete();
            $this->eliminarNotificacion($notificationId);
            return redirect()->route('notificaciones.listar')->with('warning', 'Servicio y notificación eliminados correctamente.');
        }

        return redirect()->route('notificaciones.listar')->with('error', 'Servicio no encontrado.');
    }

    // Métodos auxiliares

    // Buscar el servicio por su ID
    private function buscarServicio($id)
    {
        try {
            return ServicioAnexo::findOrFail($id);
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
