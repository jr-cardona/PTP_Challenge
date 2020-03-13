<?php

use App\Client;
use App\User;
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
        factory(User::class)->create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'email' => 'admin@example.com',
        ])
            ->assignRole(Role::where('name', 'Admin')->get());

        factory(User::class)->create([
            'name' => 'Seller',
            'surname' => '1',
            'email' => 'seller1@example.com',
        ])
            ->assignRole(Role::where('name', 'Seller')->get());

        $user = factory(User::class)->create([
            'name' => 'Client',
            'surname' => '1',
            'email' => 'client1@example.com',
        ])
            ->assignRole(Role::where('name', 'Client')->get());
        factory(Client::class)->create(['user_id' => $user->id]);

        factory(User::class)->create([
            'name' => 'Accountant',
            'surname' => '1',
            'email' => 'accountant@example.com',
        ])
            ->assignRole(Role::where('name', 'Accountant')->get());

        factory(User::class)->create([
            'name' => 'Stock',
            'surname' => '1',
            'email' => 'stock1@example.com',
        ])
            ->assignRole(Role::where('name', 'Stock')->get());
    }
}
