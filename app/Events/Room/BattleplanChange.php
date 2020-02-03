<?php

namespace App\Events\Room;
use App\Models\Battleplan;
use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BattleplanChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;
    public $identifier;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conn_string)
    {
        $this->room = Room::Connection($conn_string);
        $this->identifier = $conn_string;
        // $this->battleplan = Battleplan::findOrFail($battleplanId);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['BattleplanChange'];
    }
}
