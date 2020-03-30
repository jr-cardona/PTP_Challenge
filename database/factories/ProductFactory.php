<?php

/** @var Factory $factory */

use App\Entities\User;
use App\Entities\Product;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    $cost = $faker->numberBetween(0, 99999);
    $role = Role::where('name', 'Stock')->first() ?? Role::create(['name' => 'Stock']);
    $stock = User::Role($role)->inRandomOrder()->first();
    return [
        'name' => $faker->name,
        'description' => $faker->realText(30),
        'cost' => $cost,
        'price' => $cost * 1.10,
        'created_by' => $stock->id ?? factory(User::class),
        'updated_by' => $stock->id ?? factory(User::class),
    ];
});
