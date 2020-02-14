<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use App\PaymentAttempt;
use Faker\Generator as Faker;

$factory->define(PaymentAttempt::class, function (Faker $faker) {
    return [
        'invoice_id' => factory(Invoice::class),
        'status' => $faker->state,
        'amount' => $faker->randomNumber(),
        'requestID' => $faker->randomNumber(),
        'processUrl' => $faker->url
    ];
});
