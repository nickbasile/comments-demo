<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    $user = factory(App\User::Class)->create();

    return [
        'user_id' => $user->id,
        'body' => $faker->sentence,
    ];
});
