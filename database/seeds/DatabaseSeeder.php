<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            TypeDocumentsTableSeeder::class,
            StatesTableSeeder::class,
            InvoicesTableSeed::class,
            ProductsTableSeed::class
        ]);
    }
}
