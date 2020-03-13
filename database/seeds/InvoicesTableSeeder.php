<?php

use App\User;
use App\Client;
use App\Invoice;
use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all()->count();
        $users = User::whereIn('name', ['Admin', 'Seller'])->count();
        $invoices = 100;
        for ($j = 1; $j <= $invoices; $j++){
            $clientId = $j % $clients == 0 ? $clients : ($j % $clients);
            $userId = $j % $users == 0 ? $users : ($j % $users);
            if ($j > ($invoices / 2)){
                $invoice = factory(Invoice::class)->create([
                    'client_id' => $clientId,
                    'owner_id' => $userId,
                    'paid_at' => Carbon::now(),
                ]);
            }else{
                $invoice = factory(Invoice::class)->create([
                    'client_id' => $clientId,
                    'owner_id' => $userId,
                    'issued_at' => Carbon::now()->subMonth(),
                ]);
            }
            for($i = 0; $i < 10; $i++){
                $product = factory(Product::class)->create();
                $invoice->products()->attach($product->id, [
                    'quantity' => rand(1, 9),
                    'unit_price' => $product->price,
                ]);
            }
        }
    }
}
