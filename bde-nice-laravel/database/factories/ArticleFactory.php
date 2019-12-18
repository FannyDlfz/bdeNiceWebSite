<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {

    return [
        'name'        => $faker->name,
        'price'       => $faker->numberBetween(0,300),
        'description' => $faker->realText(200),
        'ordered'     => $faker->numberBetween(0,9),
        'selected'    => $faker->boolean(10)
    ];
});
