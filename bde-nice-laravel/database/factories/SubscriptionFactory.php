<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subscription;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    return
    [
        'user_id'  => $faker->numberBetween(1, 5),
        'event_id' => $faker->numberBetween(1, 100)
    ];
});
