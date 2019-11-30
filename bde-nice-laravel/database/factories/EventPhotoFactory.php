<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EventPhoto;
use Faker\Generator as Faker;

$factory->define(EventPhoto::class, function (Faker $faker) {
    return
    [
        'name'        => $faker->imageUrl(),
        'description' => $faker->realText(150),
        'event_id'    => $faker->numberBetween(1, 100),
        'user_id'     => $faker->numberBetween(1, 5)
    ];
});
