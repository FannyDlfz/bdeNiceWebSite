<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name'        => $faker->domainName,
        'scheduled'   => $faker->boolean,
        'recurrence'  => $faker->dateTimeThisCentury,
        'price'       => $faker->numberBetween(0, 300),
        'description' => $faker->realText(200),
        'begin_at'    => $faker->date(),
        'end_at'      => $faker->date(),
        'user_id'     => $faker->numberBetween(1, 5),
        'selected'    => $faker->boolean(10)
    ];
});
