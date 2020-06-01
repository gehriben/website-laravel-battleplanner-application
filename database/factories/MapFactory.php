<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Map;
use App\Models\Media;
use Faker\Generator as Faker;

$factory->define(Map::class, function (Faker $faker) {
    $media = factory(Media::class)->create();
    return [
        // Properties
        'name' => $faker->name,
        'competitive' => rand(0,1) == 1,
        
        // Fkeys
        'thumbnail_id' => $media->id,
    ];
});
