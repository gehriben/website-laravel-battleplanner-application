<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Battleplan;
use App\Models\Map;
use App\Models\GameType;
use App\Models\User;

use Faker\Generator as Faker;

$factory->define(Battleplan::class, function (Faker $faker) {
    return [
        'name' => "test plan",
        'description' => 'test plan description',
        'owner_id' => User::first()->id,
        'gametype_id' => GameType::first()->id,
        'map_id' => Map::first()->id,
        'saved' => false,
        'notes' => 'no notes', 
        "public" => false
    ];
});
