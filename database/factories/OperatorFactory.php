<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Operator;
use App\Models\Media;
use Faker\Generator as Faker;

$factory->define(Operator::class, function (Faker $faker) {
    $media = factory(Media::class)->create();
    return [
        // Properties
        'name' => $faker->name,
        'colour' => '#ffffff',
        'attacker' => rand(0,1) == 1,
    
        // Fkey
        'icon_id' => $media->id
    ];
});
