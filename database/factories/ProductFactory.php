<?php

/** @var Factory $factory */

use App\Entities\User;
use App\Entities\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    $cost = $faker->numberBetween(0, 99999);
    return [
        'name' => $faker->name,
        'description' => $faker->realText(30),
        'cost' => $cost,
        'price' => $cost * 1.10,
        'created_by' => User::Role('Stock')->inRandomOrder()->first()->id,
        'updated_by' => User::Role('Stock')->inRandomOrder()->first()->id,
    ];
});
