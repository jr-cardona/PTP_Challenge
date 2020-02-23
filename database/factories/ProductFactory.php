<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $cost = $faker->numberBetween(0, 99999);
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'cost' => $cost,
        'price' => $cost * 1.10,
    ];
});
