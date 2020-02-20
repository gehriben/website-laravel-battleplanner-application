<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

// Models 
use App\Models\User;
use App\Models\Battleplan;
use App\Models\Draw;

class DrawRouteTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    private $user;
    private $battleplan;
    private $line;
    private $square;
    private $icon;

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

        $this->line = factory(Draw::class, "Line")->create([
            'battlefloor_id' => $this->battleplan->battlefloors[0]->id
        ]);

        $this->square = factory(Draw::class, "Square")->create([
            'battlefloor_id' => $this->battleplan->battlefloors[0]->id
        ]);

        $this->icon = factory(Draw::class, "Icon")->create([
            'battlefloor_id' => $this->battleplan->battlefloors[0]->id
        ]);
        
        Passport::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDrawCreate()
    {
        $data = [
            "battlefloor_id" => $this->battleplan->fresh()->battlefloors[0]->id,
            "originX" => $this->faker->numberBetween(-100,100),
            "originY" => $this->faker->numberBetween(-100,100),
            "destinationX" => $this->faker->numberBetween(-100,100),
            "destinationY" =>$this->faker->numberBetween(-100,100),
            'drawable_type' => 'Line',
            "color" => "#ffffff",
            "lineSize" => 5
        ];
        $response = $this->postJson('api/v1/draw', $data);
        $response->assertStatus(200);
    }

    public function testDrawBatchCreate()
    {
        // We need battlefloors initialized to work with draws
        $this->battleplan->init();
        $data = [
            [
                "battlefloor_id" => $this->battleplan->fresh()->battlefloors[0]->id,
                "originX" => $this->faker->numberBetween(-100,100),
                "originY" => $this->faker->numberBetween(-100,100),
                "destinationX" => $this->faker->numberBetween(-100,100),
                "destinationY" =>$this->faker->numberBetween(-100,100),
                'drawable_type' => 'Line',
                "color" => "#ffffff",
                "lineSize" => 5
            ]
        ];

        $response = $this->postJson('/api/v1/draw', $data);
        $response->assertStatus(200);
    }

    public function testDrawDelete()
    {
        $response = $this->delete("/api/v1/draw/{$this->line->id}");
        $response->assertStatus(200);
        
        $response = $this->delete("/api/v1/draw/{$this->square->id}");
        $response->assertStatus(200);
        
        $response = $this->delete("/api/v1/draw/{$this->icon->id}");
        $response->assertStatus(200);
    }

    public function testDrawBatchDelete()
    {
        $data = [
            'ids' => [
                $this->icon->id,
                $this->square->id,
                $this->icon->id
            ]
        ];
        $response = $this->delete("/api/v1/draw",$data);
        $response->assertStatus(200);
    }
}
