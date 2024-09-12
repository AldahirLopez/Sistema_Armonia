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
        return (new MailMessage)
            ->subject('Nuevo Servicio Anexo 30 Creado')
            ->view('emails.servicio_creado', ['servicio' => $this->servicio]);  // Usa la vista personalizada
    }


    // Define los datos que se guardarán en la base de datos
    public function toArray($notifiable)
    {
        return [
            'servicio_id' => $this->servicio->id,
            'nomenclatura' => $this->servicio->nomenclatura,
            'mensaje' => 'Se ha creado un nuevo servicio con la nomenclatura ' . $this->servicio->nomenclatura,
            'usuario' => $this->servicio->usuario->name ?? 'Usuario no definido', // Acceder a la relación 'usuario' directamente
        ];
    }
}
