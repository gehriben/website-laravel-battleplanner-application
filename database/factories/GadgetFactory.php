<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gadget;
use App\Models\Media;
use Faker\Generator as Faker;

$factory->define(Gadget::class, function (Faker $faker) {
    $media = factory(Media::class)->create();
    return [
        // Properties
        'name' => $faker->name,
    
        // Fkeys
        'icon_id' => $media->id,
    ];
});
