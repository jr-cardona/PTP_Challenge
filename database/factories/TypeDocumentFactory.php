<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use App\Entities\TypeDocument;
use Illuminate\Database\Eloquent\Factory;

$factory->define(TypeDocument::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'fullname' => $faker->name
    ];
});
