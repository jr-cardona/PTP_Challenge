<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Seller;
use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    $issued_at = $faker->dateTime;
    $overdued_at = $faker->dateTimeBetween($issued_at, now());
    return [
        'issued_at' => $issued_at,
        'overdued_at' => $overdued_at,
        'description' => $faker->text,
        'vat' => $faker->numberBetween(0,100),
        'state_id' => $faker->numberBetween(1,3),
        'client_id' => factory(Client::class),
        'seller_id' => factory(Seller::class)
    ];
});
