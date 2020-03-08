<?php

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
        $adminRole = Role::create(['name' => 'Admin']);
        $sellerRole = Role::create(['name' => 'Seller']);
        $clientRole = Role::create(['name' => 'Client']);

        $admin = factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole($adminRole);

        $seller = factory(User::class)->create([
            'name' => 'Seller1',
            'email' => 'seller1@example.com',
        ]);
        $seller->assignRole($sellerRole);

        $client = factory(User::class)->create([
            'name' => 'Client1',
            'email' => 'client1@example.com',
        ]);
        $client->assignRole($clientRole);
    }
}
