<?php

/** @var Factory $factory */

use App\Entities\User;
use App\Entities\Invoice;
use Faker\Generator as Faker;
use App\Entities\PaymentAttempt;
use Illuminate\Database\Eloquent\Factory;

$factory->define(PaymentAttempt::class, function (Faker $faker) {
    return [
        'invoice_id' => factory(Invoice::class),
        'status' => $faker->state,
        'amount' => $faker->randomNumber(),
        'requestID' => $faker->randomNumber(),
        'processUrl' => $faker->url,
        'created_by' => User::first()->id,
        'updated_by' => User::first()->id,
    ];
});
