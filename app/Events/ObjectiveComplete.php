<?php

namespace App\Events;

// use App\Events\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ObjectiveComplete implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
     public function __construct($message, $user)
     {
         $this->message = $message;
         $this->user = $user;
     }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
     public function broadcastOn()

    {
        /*
        * Use the incoming skill name and the user that follows the currently logged in user
        */
        return new Channel("chat-room.".$this->message['skill_name'].".".$this->message['followed_id']);
    }
}
