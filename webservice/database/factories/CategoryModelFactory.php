<?php

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(6, true),
    ];
});
