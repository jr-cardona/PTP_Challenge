<?php

use Carbon\Carbon;
use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use App\Entities\Product;
use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param null $data
     * @return void
     */
    public function run($data = null)
    {
        $clients = $data["clients"] ?? factory(Client::class, 10)->create();
        $totalClients = $clients->count();
        $sellers = User::select('id')->Role('Seller')->orderBy('id')->get();
        $totalSellers = $sellers->count();
        $totalInvoices = $data["totalInvoices"] ?? 20;
        $productsPerInvoice = $data["productsPerInvoice"] ?? 5;

        for ($i = 0; $i < $totalInvoices; $i++) {
            $invoice = new Invoice();
            $invoice->issued_at = Carbon::now();
            $invoice->client_id = $this->getId($i, $clients, $totalClients);
            $invoice->created_by = $this->getId($i, $sellers, $totalSellers);

            /** One half paid and other half expired. */
            if ($i >= ($totalInvoices / 2)) {
                $invoice->paid_at = Carbon::now();
            } else {
                $invoice->issued_at = $invoice->issued_at->subMonth();
            }

            $invoice->save();
            if ($productsPerInvoice > 0) {
                $this->assignProducts($invoice, $productsPerInvoice);
            }
        }
    }

    public function getId($i, $model, $total)
    {
        $index = $i % $total;
        return $model[$index]->id;
    }

    public function assignProducts($invoice, $total)
    {
        factory(Product::class, $total)->create()->each(
            function ($product) use ($invoice) {
                $invoice->products()->attach($product->id, [
                    'quantity' => rand(1, 9),
                    'unit_price' => $product->price,
                ]);
            }
        );
    }
}
