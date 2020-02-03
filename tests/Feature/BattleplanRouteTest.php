<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

// Models 
use App\Models\User;
use App\Models\Map;
use App\Models\Battleplan;

class BattleplanRouteTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    private $user;
    private $battleplan;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->user = factory(User::class)->create();
        $this->battleplan = factory(Battleplan::class)->create([
            "public" => true,
            'owner_id' => $this->user->id
        ]);

        Passport::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBattleplanCreate()
    {   
        $data = [
            'name' => 'my battleplan',
            'map_id' => Map::first()->id,
            'description' => "my desc",
            'notes' => "my Notes"
        ];

        $response = $this->postJson('/api/v1/battleplan', $data);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'slots',
                        'map',
                        'battlefloors',
                    ]
                ]
            );
    }

    public function testBattleplanRead()
    {   
        $response = $this->get("/api/v1/battleplan/{$this->battleplan->id}");
        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'slots',
                        'map',
                        'battlefloors',
                    ]
                ]
            );
    }

    public function testBattleplanUpdate()
    {   
        $data = [
            'name' => 'my battleplan',
            'description' => "my desc",
            'notes' => "my Notes",
            'public' => true
        ];

        $response = $this->postJson("/api/v1/battleplan/{$this->battleplan->id}",$data);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'slots',
                        'map',
                        'battlefloors',
                    ]
                ]
            );
    }

    public function testBattleplanDelete()
    {   
        $response = $this->delete("/api/v1/battleplan/{$this->battleplan->id}");
        $response->assertStatus(200);
        $this->assertNull($this->battleplan->fresh());
    }
}
