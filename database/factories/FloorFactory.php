<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Floor;
use App\Models\Map;
use App\Models\Media;
use Faker\Generator as Faker;

$factory->define(Floor::class, function (Faker $faker) {
    $map = factory(Map::class)->create();
    $media = factory(Media::class)->create();

    return [
        // Properties
        'name'=> $faker->name,
        'order' => 0,
    
        // Fkeys
        'map_id' => $map->id,
        'source_id' => $media->id
    ];
});
