<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Draw;
use App\Models\Battleplan;
use App\Models\Line;
use App\Models\Square;
use App\Models\Icon;
use Faker\Generator as Faker;

$factory->defineAs(Draw::class, "Line", function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $user = factory(User::class)->create();
    $drawable = factory(Line::class)->create();

    return [
        "battlefloor_id" => $battleplan,
        "originX" => $faker->numberBetween(-100,100),
        "originY" =>  $faker->numberBetween(-100,100), 
        "destinationX" => $faker->numberBetween(-100,100),
        "destinationY" => $faker->numberBetween(-100,100), 
        "user_id" => $user->id, 
        "saved" => false,
        "drawable_id" => $drawable->id, 
        "drawable_type" => get_class($drawable), 
        "deleted" => false
    ];
});

$factory->defineAs(Draw::class, "Square", function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $user = factory(User::class)->create();
    $drawable = factory(Square::class)->create();

    return [
        "battlefloor_id" => $battleplan,
        "originX" => $faker->numberBetween(-100,100),
        "originY" =>  $faker->numberBetween(-100,100), 
        "destinationX" => $faker->numberBetween(-100,100),
        "destinationY" => $faker->numberBetween(-100,100), 
        "user_id" => $user->id, 
        "saved" => false,
        "drawable_id" => $drawable->id, 
        "drawable_type" => get_class($drawable), 
        "deleted" => false
    ];
});

$factory->defineAs(Draw::class, "Icon", function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $user = factory(User::class)->create();
    $drawable = factory(Icon::class)->create();

    return [
        "battlefloor_id" => $battleplan,
        "originX" => $faker->numberBetween(-100,100),
        "originY" =>  $faker->numberBetween(-100,100), 
        "destinationX" => $faker->numberBetween(-100,100),
        "destinationY" => $faker->numberBetween(-100,100), 
        "user_id" => $user->id, 
        "saved" => false,
        "drawable_id" => $drawable->id, 
        "drawable_type" => get_class($drawable), 
        "deleted" => false
    ];
});
