<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Line;
use Faker\Generator as Faker;

$factory->define(Line::class, function (Faker $faker) {
    return [
        "color" => '#ffffff',
        "lineSize" => 5
    ];
});
