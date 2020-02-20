<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

// Models 
use App\Models\User;
use App\Models\Battleplan;
use App\Models\Room;

class RoomRouteTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    private $user;
    private $battleplan;
    private $room;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->user = factory(User::class)->create();
        $this->battleplan = factory(Battleplan::class)->create([
            "public" => true,
            'owner_id' => $this->user->id
        ]);

        $this->room = factory(Room::class)->create([
            'battleplan_id' => $this->battleplan->id,
        ]);
        // We need battlefloors initialized to work with draws
        $this->battleplan->init();
        Passport::actingAs($this->user);
    }

    public function testCreateRoom(){
        $response = $this->postJson('api/v1/room');
        $response->assertStatus(200);
    }

    public function testUpdateRoom(){
        // unst current loaded battleplan
        $this->room->update([
            'battleplan_id' => null
        ]);

        $data = [
            "battleplan_id" => $this->battleplan->id,
        ];
        $response = $this->postJson("api/v1/room/{$this->room->id}", $data);
        $this->assertEquals($this->room->fresh()->battleplan_id, $this->battleplan->id);
        $response->assertStatus(200);
    }

}
