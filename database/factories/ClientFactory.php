<?php

/** @var Factory $factory */

use App\Entities\User;
use App\Entities\Client;
use Faker\Generator as Faker;
use App\Entities\TypeDocument;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Client::class, function (Faker $faker) {
    $role = Role::where('name', 'Client')->first() ?? Role::create(['name' => 'Client']);
    $user = factory(User::class)->create()->assignRole($role);
    return [
        'id' => $user->id,
        'document' => $faker->unique()->randomNumber(9),
        'type_document_id' => TypeDocument::whereIn('name', ['CC', 'NIT', 'PPN', 'TI', 'CE'])
                ->inRandomOrder()->first()->id ?? factory(TypeDocument::class),
        'phone' => $faker->randomNumber(7),
        'cellphone' => "3" . $faker->randomNumber(9),
        'address' => $faker->address,
        'created_by' => $user->created_by,
        'updated_by' => $user->created_by,
    ];
});
