<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Coordinate;
use Faker\Generator as Faker;

$factory->define(Coordinate::class, function (Faker $faker) {
    return [
        // Properties
        'x' => rand(0,1000), 
        'y' => rand(0,1000)
    ];
});
