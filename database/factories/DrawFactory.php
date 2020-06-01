<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Draw;
use App\Models\Battleplan;
use App\Models\Line;
use App\Models\Square;
use App\Models\Icon;
use App\Models\Coordinate;

use Faker\Generator as Faker;

$factory->defineAs(Draw::class, Line::class, function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $drawable = factory(Line::class)->create();

    $drawable->points()->sync([
        factory(Coordinate::class)->create(),
        factory(Coordinate::class)->create(),
        factory(Coordinate::class)->create()
    ]);

    return [
        "battlefloor_id" => $battleplan->id, 
        "drawable_id" => $drawable->id, 
        "drawable_type" => get_class($drawable)
    ];
});

$factory->defineAs(Draw::class, Square::class, function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $drawable = factory(Square::class)->create();

    return [
        "battlefloor_id" => $battleplan->id, 
        "drawable_id" => $drawable->id, 
        "drawable_type" => get_class($drawable)
    ];
});

$factory->defineAs(Draw::class, Icon::class, function (Faker $faker) {
    $battleplan = factory(Battleplan::class)->create();
    $drawable = factory(Icon::class)->create();

    return [
        "battlefloor_id" => $battleplan->id, 
        "drawable_id" => $drawable->id, 
        "drawable_type" => get_class($drawable)
    ];
});
