<?php

use Carbon\Carbon;
use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use App\Entities\Product;
use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    protected $total_invoices;
    protected $total_details;
    protected $clients;
    protected $sellers;
    protected $total_clients;
    protected $total_sellers;

    public function __construct()
    {
        $this->total_invoices = 100;
        $this->total_details = 10;
        $this->clients = Client::select('id')->without('user')->orderBy('id')->get();
        $this->sellers = User::select('id')->Role('Seller')->orderBy('id')->get();
        $this->total_clients = count($this->clients);
        $this->total_sellers = count($this->sellers);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < $this->total_invoices; $i++) {
            $invoice = new Invoice();
            $invoice->issued_at = Carbon::now();
            $invoice->client_id = $this->getClientId($i);
            $invoice->created_by = $this->getSellerId($i);

            /** One half paid and other half expired. */
            if ($this->onHalf($i)) {
                $invoice->paid_at = Carbon::now();
            } else {
                $invoice->issued_at->subMonth();
            }

            $invoice->save();
            $this->assignProducts($invoice);
        }
    }

    public function getClientId($i){
        $index = $i % $this->total_clients;
        return $this->clients[$index]->id;
    }

    public function getSellerId($i){
        $index = $i % $this->total_sellers;
        return $this->sellers[$index]->id;
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

    public function onHalf($i){
        return $i > ($this->total_invoices / 2);
    }
}
