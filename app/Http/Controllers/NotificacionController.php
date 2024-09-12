<?php

namespace App\Http\Controllers;

use App\Models\ServicioAnexo;
use App\Models\User;
use App\Notifications\ServicioCreadoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

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
        // Obtener todos los usuarios con rol de administrador
        $administradores = User::role('Administrador')->get();

        if ($administradores->isEmpty()) {
            return redirect()->back()->with('error', 'No hay administradores disponibles para enviar la notificación.');
        }

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
}
