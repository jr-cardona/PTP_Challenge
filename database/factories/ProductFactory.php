<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\User;
use App\Entities\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $cost = $faker->numberBetween(0, 99999);
    return [
        'name' => $faker->name,
        'description' => $faker->realText(30),
        'cost' => $cost,
        'price' => $cost * 1.10,
        'creator_id' => User::where('name', 'Stock')->first()->id,
    ];
});
