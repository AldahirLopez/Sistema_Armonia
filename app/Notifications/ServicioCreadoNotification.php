<?php

namespace App\Notifications;

use App\Models\ServicioAnexo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServicioCreadoNotification extends Notification
{
    use Queueable;

    protected $servicio;

    // El constructor recibe un objeto ServicioAnexo
    public function __construct(ServicioAnexo $servicio)
    {
        //dd($servicio); // Verifica si los datos del servicio son correctos
        $this->servicio = $servicio;
    }

    // Define los canales por los cuales se enviará la notificación
    public function via($notifiable)
    {
        return ['database'];
        //return ['mail', 'database'];
    }

    // Define el contenido del correo
    public function toMail($notifiable)
    {
        // Determina el estado del servicio y genera el asunto y vista correspondientes
        if ($this->servicio->pending_deletion_servicio) {
            $subject = 'Servicio Pendiente de Eliminación';
            $view = 'emails.servicio_eliminado'; // Vista personalizada para eliminación pendiente
        } else {
            $subject = 'Nuevo Servicio Anexo 30 Creado';
            $view = 'emails.servicio_creado'; // Vista para la creación de servicio
        }

        return (new MailMessage)
            ->subject($subject)
            ->view($view, ['servicio' => $this->servicio]);
    }

    public function toArray($notifiable)
    {
        // Genera el mensaje dependiendo del estado del servicio
        if ($this->servicio->pending_deletion_servicio) {
            $mensaje = 'El servicio con la nomenclatura ' . $this->servicio->nomenclatura . ' está pendiente de eliminación.';
        } else {
            $mensaje = 'Se ha creado un nuevo servicio con la nomenclatura ' . $this->servicio->nomenclatura;
        }

        return [
            'servicio_id' => $this->servicio->id,
            'nomenclatura' => $this->servicio->nomenclatura,
            'mensaje' => $mensaje,
            'usuario' => $this->servicio->usuario->name ?? 'Usuario no definido',
            'pending_deletion_servicio' => $this->servicio->pending_deletion_servicio, // Estado de eliminación
            'pending_apro_servicio' => $this->servicio->pending_apro_servicio, // Estado de aprobación
        ];
    }
}
