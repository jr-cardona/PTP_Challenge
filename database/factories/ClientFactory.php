<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'document' => $faker->unique()->numberBetween(10000000, 9999999999),
        'type_document_id' => $faker->numberBetween(1,4),
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'phone_number' => $faker->numberBetween(1000000,9999999),
        'cell_phone_number' => "3".$faker->numberBetween(100000000,999999999),
        'address' => $faker->address,
        'email' => $faker->unique()->safeEmail
    ];
});
