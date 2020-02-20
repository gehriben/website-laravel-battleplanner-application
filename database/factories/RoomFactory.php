<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Room;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'owner' => factory(User::class)->create()->id,
        'connection_string' => Room::generateConnectionString(),
        'battleplan_id' => null
    ];
});
