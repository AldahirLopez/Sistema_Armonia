<?php

namespace App\Http\Controllers;

use App\Models\ServicioAnexo;
use App\Models\User;
use App\Notifications\ServicioCreadoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{

    //Creando Notificaciones
    public function notificarNuevoServicio(ServicioAnexo $servicio)
    {
        // Obtener los administradores
        $administradores = User::role('Administrador')->get();

        // Verificar si hay administradores
        if ($administradores->isEmpty()) {
            return redirect()->back()->with('error', 'No hay administradores disponibles para enviar la notificación.');
        }

        // Verificar que cada administrador tenga un correo válido
        foreach ($administradores as $admin) {
            if (empty($admin->email)) {
                return redirect()->back()->with('error', 'Uno o más administradores no tienen un correo válido.');
            }
        }

        // Enviar la notificación a todos los administradores
        Notification::send($administradores, new ServicioCreadoNotification($servicio));

        return redirect()->back()->with('success', 'Notificación enviada al administrador.');
    }





    // Marcar notificación como leída
    public function marcarLeida($id)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener la notificación por ID usando la relación notifications sin paréntesis
        $notification = $user->notifications->where('id', $id)->first();

        // Verificar si la notificación existe
        if ($notification) {
            $notification->markAsRead(); // Marcar la notificación como leída
        }

        return redirect()->back();
    }


    // Ver todas las notificaciones
    public function todas()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        // Acceder a las notificaciones sin paréntesis
        $notifications = $user->notifications;

        return view('notificaciones.todas', compact('notifications'));
    }
}
