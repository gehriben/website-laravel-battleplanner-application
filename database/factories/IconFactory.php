<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Icon;
use App\Models\Coordinate;
use Faker\Generator as Faker;

$factory->define(Icon::class, function (Faker $faker) {
    $coord = factory(Coordinate::class)->create();
    return [
        // Properties
        "source" => "https://via.placeholder.com/25",
        "size" => 1,

        // Fkeys
        "origin_id" => $coord->id
    ];
});
