<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServicioCreadoNotification extends Notification
{
    use Queueable;

    protected $servicio;

    // El constructor ahora acepta un objeto genérico
    public function __construct($servicio)
    {
        $this->servicio = $servicio;
    }

    // Define los canales por los cuales se enviará la notificación
    public function via($notifiable)
    {
        return ['database'];
    }

    // Define el contenido del correo
    public function toMail($notifiable)
    {
        $subject = '';
        $view = '';

        // Validar el tipo de servicio
        if ($this->servicio instanceof \App\Models\ServicioAnexo) {
            if ($this->servicio->pending_deletion_servicio) {
                $subject = 'Servicio Anexo 30 Pendiente de Eliminación';
                $view = 'emails.servicio_anexo_eliminado'; // Vista personalizada para servicio Anexo pendiente de eliminación
            } else {
                $subject = 'Nuevo Servicio Anexo 30 Creado';
                $view = 'emails.servicio_anexo_creado'; // Vista para la creación de servicio Anexo
            }
        } elseif ($this->servicio instanceof \App\Models\Servicio_005) {
            if ($this->servicio->pending_deletion_servicio) {
                $subject = 'Servicio 005 Pendiente de Eliminación';
                $view = 'emails.servicio_005_eliminado'; // Vista personalizada para servicio 005 pendiente de eliminación
            } else {
                $subject = 'Nuevo Servicio 005 Creado';
                $view = 'emails.servicio_005_creado'; // Vista para la creación de servicio 005
            }
        }

        return (new MailMessage)
            ->subject($subject)
            ->view($view, ['servicio' => $this->servicio]);
    }

    public function toArray($notifiable)
    {
        $tipoServicio = $this->servicio instanceof \App\Models\ServicioAnexo ? 'Anexo 30' : '005';

        // Genera el mensaje dependiendo del estado del servicio
        if ($this->servicio->pending_deletion_servicio) {
            $mensaje = 'El servicio ' . $tipoServicio . ' con la nomenclatura ' . $this->servicio->nomenclatura . ' está pendiente de eliminación.';
        } else {
            $mensaje = 'Se ha creado un nuevo servicio ' . $tipoServicio . ' con la nomenclatura ' . $this->servicio->nomenclatura;
        }

        $usuarioNombre = $this->servicio->usuario->name ?? 'Usuario no definido';

        return [
            'servicio_id' => $this->servicio->id,
            'nomenclatura' => $this->servicio->nomenclatura,
            'mensaje' => $mensaje,
            'usuario_id' => $this->servicio->id_usuario,
            'usuario' => $usuarioNombre,
            'tipo_servicio' => $tipoServicio, // Agregar el tipo de servicio
            'pending_deletion_servicio' => $this->servicio->pending_deletion_servicio,
            'pending_apro_servicio' => $this->servicio->pending_apro_servicio,
        ];
    }
}
