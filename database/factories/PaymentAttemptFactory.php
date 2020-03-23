<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\User;
use App\Entities\Invoice;
use Faker\Generator as Faker;
use App\Entities\PaymentAttempt;

$factory->define(PaymentAttempt::class, function (Faker $faker) {
    return [
        'invoice_id' => factory(Invoice::class),
        'status' => $faker->state,
        'amount' => $faker->randomNumber(),
        'requestID' => $faker->randomNumber(),
        'processUrl' => $faker->url
    ];
});
