<?php

use App\Entities\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! User::where('email', 'admin@example.com')->first()) {
            factory(User::class)->create([
                'name' => 'Admin',
                'surname' => 'Admin',
                'email' => 'admin@example.com',
            ])->assignRole('Admin');
        }

        if (! User::where('email', 'seller1@example.com')->first()) {
            factory(User::class)->create([
                'name' => 'Seller',
                'surname' => '1',
                'email' => 'seller1@example.com',
            ])->assignRole('Seller');
        }

        if (! User::where('email', 'seller2@example.com')->first()) {
            factory(User::class)->create([
                'name' => 'Seller',
                'surname' => '2',
                'email' => 'seller2@example.com',
            ])->assignRole('Seller');
        }

        if (! User::where('email', 'accountant1@example.com')->first()) {
            factory(User::class)->create([
                'name' => 'Accountant',
                'surname' => '1',
                'email' => 'accountant1@example.com',
            ])->assignRole('Accountant');
        }

        if (! User::where('email', 'stock1@example.com')->first()) {
            factory(User::class)->create([
                'name' => 'Stock',
                'surname' => '1',
                'email' => 'stock1@example.com',
            ])->assignRole('Stock');
        }

        if (! User::where('email', 'superadmin@example.com')->first()) {
            factory(User::class)->create([
                'name' => 'Super',
                'surname' => 'Admin',
                'email' => 'superadmin@example.com',
            ])->assignRole('SuperAdmin');
        }
    }
}
