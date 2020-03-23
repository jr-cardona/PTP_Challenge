<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entities\TypeDocument;

$factory->define(TypeDocument::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'fullname' => $faker->name
    ];
});
