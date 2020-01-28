<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Seller;
use App\Invoice;
use App\State;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'issued_at' => $faker->dateTime,
        'description' => $faker->text,
        'vat' => $faker->numberBetween(0,100),
        'state_id' => factory(State::class),
        'client_id' => factory(Client::class),
        'seller_id' => factory(Seller::class)
    ];
});
