<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Battleplan;
use App\Models\Map;
use App\Models\User;

use Faker\Generator as Faker;

$factory->define(Battleplan::class, function (Faker $faker) {
    $user = Factory(User::class)->create();
    $map = Factory(Map::class)->create();
    return [
        // Properties
        'name'=> $faker->name,
        'description'=> $faker->name,
        'notes'=> $faker->name,
        'public' => rand(0,1) == 1,

        // Fkeys
        'owner_id' => $user->id,
        'map_id' => $map->id, 
    ];
});
