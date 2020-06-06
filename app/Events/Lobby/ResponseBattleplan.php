<?php

namespace App\Events\Lobby;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

// Models
use App\Models\OperatorSlot;
use App\Models\Lobby;

class ResponseBattleplan implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lobby;
    public $appJson;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($connection_string,$appJson)
    {
        $this->lobby = Lobby::byConnection($connection_string)->first();
        $this->appJson = $appJson;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['ResponseBattleplan'];
    }
}
