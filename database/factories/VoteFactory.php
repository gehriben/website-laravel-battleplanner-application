<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Vote;
use App\Models\User;
use App\Models\Battleplan;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $bp = factory(Battleplan::class)->create();
    return [
        'user_id' => $user->id,
        'value' => 1,
        'battleplan_id' => $bp->id
    ];
});
