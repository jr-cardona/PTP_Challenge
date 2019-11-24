<?php

use App\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        State::create([
            'name' => 'Abierta',
        ]);
        State::create([
            'name' => 'Borrador',
        ]);
        State::create([
            'name' => 'Pagada',
        ]);
    }
}
