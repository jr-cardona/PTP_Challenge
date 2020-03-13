<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Client;
use App\TypeDocument;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'document' => $faker->unique()->numberBetween(10000000, 9999999999),
        'type_document_id' => TypeDocument::whereIn('name', ['CC', 'NIT', 'PPN', 'TI', 'CE'])
                ->inRandomOrder()->first()->id ?? factory(TypeDocument::class),
        'user_id' => factory(User::class)->create(['password' => bcrypt('secret')])
            ->assignRole(Role::where('name', 'Client')->get()),
        'phone' => $faker->numberBetween(1000000, 9999999),
        'cellphone' => "3".$faker->numberBetween(100000000, 999999999),
        'address' => $faker->address,
    ];
});
