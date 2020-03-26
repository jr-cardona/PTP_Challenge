<?php

/** @var Factory $factory */

use App\Entities\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'surname' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => 'secret',
        'remember_token' => Str::random(10),
        'created_by' => User::first()->id ?? null,
        'updated_by' => User::first()->id ?? null,
    ];
});
