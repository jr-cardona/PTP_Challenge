<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    $start_date = Carbon::now()->subWeek();
    $final_date = Carbon::now();
    return [
        'issued_at' => $faker->dateTimeBetween($start_date, $final_date),
        'description' => $faker->realText(30),
        'client_id' => factory(Client::class),
        'creator_id' => User::first()->id,
    ];
});
