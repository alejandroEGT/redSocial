<?php

namespace App\Events;

use App\Solicitud;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificarSolicitudEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $solicitud;
     public $estado;
     
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Solicitud $solicitud, $estado)
    {
        $this->solicitud = $solicitud;
        $this->estado = $estado;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {   
        if($this->estado === "Seguir"){
            return [ 
                    new PrivateChannel('notificar_solicitud.'.$this->solicitud->user_acepta),
                    new PrivateChannel('notificar_solicitud_return.'.$this->solicitud->user_solicita)

                   ];
        }
        if ($this->estado == "Dejar de seguir") {
            return [
                new PrivateChannel('notificar_solicitud_cancel.'.$this->solicitud->user_acepta),
                new PrivateChannel('notificar_solicitud_cancel.'.$this->solicitud->user_solicita),
                new PrivateChannel('notificar_solicitud_return.'.$this->solicitud->user_solicita)
               ];
        }
        // if ($estado == "cancelar") {
        //     return new PrivateChannel('notificar_solicitud.'.$this->solicitud->user_acepta);
        // }

         
    }
}
