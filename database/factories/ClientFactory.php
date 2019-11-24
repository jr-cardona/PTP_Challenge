<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'document' => $faker->unique()->randomNumber(),
        'type_document_id' => $faker->numberBetween(1,4),
        'name' => $faker->name,
        'phone_number' => $faker->numberBetween(1000000,9999999),
        'cell_phone_number' => $faker->numberBetween(1000000000,9999999999),
        'address' => $faker->address,
        'email' => $faker->unique()->safeEmail
    ];
});
