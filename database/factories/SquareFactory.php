<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Square;
use Faker\Generator as Faker;

$factory->define(Square::class, function (Faker $faker) {
    $coord1 = factory(Coordinate::class)->create();
    $coord2 = factory(Coordinate::class)->create();
    return [
        // Properties
        "color" => "#ffffff",
        "size" => 1,
        'opacity' => 0.4,

        // Fkeys
        "origin_id" => $coord->id,
        "destination_id" => $coord2->id
    ];
});
