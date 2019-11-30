<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'text'           => $faker->text(150),
        'article_id'     => $faker->numberBetween(1, 100),
        'event_photo_id' => $faker->numberBetween(1, 200),
        'user_id'        => $faker->numberBetween(1, 5),
        'event_id'       => $faker->numberBetween(1, 100)
    ];
});
