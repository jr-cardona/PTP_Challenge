<?php

/** @var Factory $factory */

use Carbon\Carbon;
use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Invoice::class, function (Faker $faker) {
    $start_date = Carbon::now()->subWeek();
    $final_date = Carbon::now();
    $role = Role::where('name', 'Seller')->first() ?? Role::create(['name' => 'Seller']);
    $seller = User::Role($role)->inRandomOrder()->first();
    return [
        'issued_at' => $faker->dateTimeBetween($start_date, $final_date),
        'description' => $faker->realText(30),
        'client_id' => factory(Client::class),
        'created_by' => $seller->id ?? factory(User::class),
        'updated_by' => $seller->id ?? factory(User::class),
    ];
});
