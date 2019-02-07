<?php

use Faker\Generator as Faker;

$factory->define(App\Result::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'grades' => $faker->numberBetween(0,4),
        'total_time' => $faker->numberBetween(2,200),
    ];
});
