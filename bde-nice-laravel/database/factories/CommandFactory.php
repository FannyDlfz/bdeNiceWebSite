<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Command;
use Faker\Generator as Faker;

$factory->define(Command::class, function (Faker $faker) {
    return
    [
        'submit'  =>$faker->boolean,
        'user_id' => $faker->numberBetween(1, 5)
    ];
});
