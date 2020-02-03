<?php

namespace App\Events\Battleplan;
use App\Models\OperatorSlot;
use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChangeOperatorSlot implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;
    public $identifier;
    public $operatorSlot;
    public $operator;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conn_string, $operatorSlotId)
    {
        $this->room = Room::Connection($conn_string);
        $this->identifier = $conn_string;
        $this->operatorSlot = OperatorSlot::findOrFail($operatorSlotId);
        $this->operator = $this->operatorSlot->operator;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['ChangeOperatorSlot'];
    }
}
