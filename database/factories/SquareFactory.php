<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Square;
use Faker\Generator as Faker;

$factory->define(Square::class, function (Faker $faker) {
    return [
        "color" => '#ffffff',
        "lineSize" => 5
    ];
});
