<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Icon;
use Faker\Generator as Faker;

$factory->define(Icon::class, function (Faker $faker) {
    return [
        "src" => "https://via.placeholder.com/25"
    ];
});
