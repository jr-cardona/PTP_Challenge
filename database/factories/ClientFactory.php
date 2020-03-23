<?php

/** @var Factory $factory */

use App\Entities\User;
use App\Entities\Client;
use Faker\Generator as Faker;
use App\Entities\TypeDocument;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'id' => factory(User::class)->create()->assignRole('Client'),
        'document' => $faker->unique()->randomNumber(9),
        'type_document_id' => TypeDocument::whereIn('name', ['CC', 'NIT', 'PPN', 'TI', 'CE'])
                ->inRandomOrder()->first()->id ?? factory(TypeDocument::class),
        'phone' => $faker->randomNumber(7),
        'cellphone' => "3" . $faker->randomNumber(9),
        'address' => $faker->address,
    ];
});
