<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\User;
use App\Entities\Client;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;
use App\Entities\TypeDocument;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'document' => $faker->unique()->numberBetween(10000000, 9999999999),
        'type_document_id' => TypeDocument::whereIn('name', ['CC', 'NIT', 'PPN', 'TI', 'CE'])
                ->inRandomOrder()->first()->id ?? factory(TypeDocument::class),
        'user_id' => factory(User::class)->create()->assignRole('Client'),
        'phone' => $faker->numberBetween(1000000, 9999999),
        'cellphone' => "3".$faker->numberBetween(100000000, 999999999),
        'address' => $faker->address,
    ];
});
