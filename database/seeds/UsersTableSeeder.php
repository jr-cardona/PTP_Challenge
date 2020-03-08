<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'email' => 'admin@example.com',
        ]);

        factory(User::class)->create([
            'name' => 'Juan Ricardo',
            'email' => 'jrrricardo11@gmail.com',
        ]);
    }
}
