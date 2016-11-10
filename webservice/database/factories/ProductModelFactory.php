<?php

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(6, true),
    ];
});
