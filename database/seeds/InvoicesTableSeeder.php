<?php

use App\User;
use App\Client;
use App\Invoice;
use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    protected $total_clients;
    protected $total_owners;
    protected $total_invoices;
    protected $total_details;

    public function __construct()
    {
        $this->total_clients = Client::all()->count();
        $this->total_owners = User::whereIn('name', ['Admin', 'Seller'])->count();
        $this->total_invoices = 100;
        $this->total_details = 10;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= $this->total_invoices; $i++) {
            $clientId = $this->getId($this->total_clients, $i);
            $ownerId = $this->getId($this->total_owners, $i);

            $invoice = new Invoice();
            $invoice->client_id = $clientId;
            $invoice->creator_id = $ownerId;

            if ($i > ($this->total_invoices / 2)) {
                $invoice->issued_at = Carbon::now();
                $invoice->paid_at = Carbon::now();
            } else {
                $invoice->issued_at = Carbon::now()->subMonth();
            }

            $invoice->save();
            $this->assignProducts($invoice);
        }
    }

    public function getId($total, $i){
        return $i % $total == 0 ? $total : ($i % $total);
    }

    public function assignProducts($invoice){
        factory(Product::class, $this->total_details)->create()->each(
            function($product) use ($invoice){
                $invoice->products()->attach($product->id, [
                    'quantity' => rand(1, 9),
                    'unit_price' => $product->price,
                ]);
            });
    }
}
