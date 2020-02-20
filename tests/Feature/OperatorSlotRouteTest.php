<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

// Models 
use App\Models\User;
use App\Models\Battleplan;
use App\Models\Operator;
use App\Models\Room;

class OperatorSlotRouteTest extends TestCase
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

        // We need battlefloors initialized to work with draws
        $this->battleplan->init();

        $this->room = factory(Room::class)->create([
            'battleplan_id' => $this->battleplan->id
        ]);

        Passport::actingAs($this->user);
    }

    public function testOperatorSlotUpdate(){
        $data = [
            'operator_id' => Operator::first()->id,
            'connection_string' => $this->room->connection_string
        ];
        $slot = $this->battleplan->operatorSlots[0];
        $response = $this->postJson("api/v1/operator-slot/{$slot->id}", $data);
        $response->assertStatus(200);
    }
}
