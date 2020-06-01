<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OperatorSlot;
use App\Models\Battleplan;
use Faker\Generator as Faker;

$factory->define(OperatorSlot::class, function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $operator = factory(Operator::class)->create();
    
    return [
        // Fkeys
        'operator_id' => $operator->id,
        'battleplan_id' => $battleplan->id
    ];
});
