<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'name' => implode($faker->words(3)) . ".png",
        'path' => $faker->url
    ];
});
