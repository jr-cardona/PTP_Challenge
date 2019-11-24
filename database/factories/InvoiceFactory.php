<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'issued_at' => $faker->dateTime,
        'overdued_at' => $faker->dateTime,
        'received_at' => $faker->dateTime,
        'vat' => $faker->numberBetween(0,100),
        'state_id' => $faker->numberBetween(1,3),
        'client_id' => factory(Client::class)
    ];
});
