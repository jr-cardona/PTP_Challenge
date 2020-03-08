<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Seller;
use App\TypeDocument;
use Faker\Generator as Faker;

$factory->define(Seller::class, function (Faker $faker) {
    return [
        'document' => $faker->unique()->numberBetween(10000000, 9999999999),
        'type_document_id' => TypeDocument::whereIn('name', ['CC', 'NIT', 'PPN', 'TI', 'CE'])
                ->inRandomOrder()->first()->id ?? factory(TypeDocument::class),
        'name' => $faker->firstName,
        'surname' => $faker->firstName,
        'phone' => $faker->numberBetween(1000000, 9999999),
        'cellphone' => "3".$faker->numberBetween(100000000, 999999999),
        'address' => $faker->address,
        'email' => $faker->unique()->safeEmail
    ];
});
