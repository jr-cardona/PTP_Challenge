<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Seller;
use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    $issued_at = $faker->dateTime;
    return [
        'issued_at' => $issued_at,
        'description' => $faker->text,
        'vat' => $faker->numberBetween(0,100),
        'state_id' => "1",
        'client_id' => factory(Client::class),
        'seller_id' => factory(Seller::class)
    ];
});
