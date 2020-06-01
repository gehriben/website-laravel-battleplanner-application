<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Battlefloor;
use App\Models\Battleplan;
use App\Models\Floor;
use Faker\Generator as Faker;

$factory->define(Battlefloor::class, function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $floor = factory(Floor::class)->create([
        'battleplan->id' => $battleplan->id
    ]);

    return [
        // Fkeys
        'battleplan_id' => $battleplan->id,
        'floor_id' => $floor->id
    ];
});
