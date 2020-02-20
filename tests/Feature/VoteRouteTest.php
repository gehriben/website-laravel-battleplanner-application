<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

// Models
use App\Models\Vote;
use App\Models\User;
use App\Models\Battleplan;

class VoteRouteTest extends TestCase
{
    
    use RefreshDatabase,WithFaker;

    public $vote;
    public $user;
    public $battleplan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->user = factory(User::class)->create();
        $this->battleplan = factory(Battleplan::class)->create([
            "public" => true,
            'owner_id' => $this->user->id
        ]);
        $this->vote = factory(Vote::class)->create([
            'user_id' => $this->user->id,
            'battleplan_id' => $this->battleplan->id
        ]);
        Passport::actingAs($this->user);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */    
    public function testCreateVote(){
        $data = [
            'battleplan_id' => $this->battleplan->id,
            'value' => 1
        ];
        $response = $this->postJson('api/v1/vote', $data);
        $response->assertStatus(200);
    }
    
    public function testUpdateVote(){
        $data = [
            'value' => $this->vote->value * -1
        ];
        $response = $this->postJson("api/v1/vote/{$this->vote->id}", $data);
        $response->assertStatus(200);
    }

    public function testDeleteVote(){
        $response = $this->delete("api/v1/vote/{$this->vote->id}");
        $response->assertStatus(200);
    }
}
