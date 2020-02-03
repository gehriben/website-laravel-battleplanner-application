<?php

namespace App\Events\Draw;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateDraws implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $draws;
    public $creator;
    public $identifier;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($draws, $identifier, $creator)
    {
        $this->draws = $draws;
        $this->identifier = $identifier;
        $this->creator = $creator;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('test-channel');
        return ['BattlefloorDraw']; // TODO add room id!
    }
}
