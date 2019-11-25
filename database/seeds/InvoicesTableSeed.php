<?php

use App\Invoice;
use Illuminate\Database\Seeder;

class InvoicesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Invoice::class, 100)->create();
    }
}
