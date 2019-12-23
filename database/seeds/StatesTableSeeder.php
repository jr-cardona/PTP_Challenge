<?php

use App\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'name' => 'Pendiente',
        ]);
        State::create([
            'name' => 'Pagada',
        ]);
        State::create([
            'name' => 'Vencida',
        ]);
    }
}
