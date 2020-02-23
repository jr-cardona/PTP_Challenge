<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use App\User;
use App\Invoice;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_update_invoice_products()
    {
        $data = $this->data();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);

        $this->put(route('invoices.products.update', [$invoice, $product]), $data)
            ->assertRedirect('login');
        $this->assertDatabaseMissing('invoice_product', $data);
    }

    /** @test */
    public function logged_in_user_can_update_invoice_products()
    {
        $data = $this->data();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);

        $response = $this->actingAs($user)->put(route('invoices.products.update', [$invoice, $product]), $data)
            ->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function data_product_can_be_updated_in_database()
    {
        $data = $this->data();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, [
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $this->actingAs($user)->put(route('invoices.products.update', [$invoice, $product]), $data);
        $this->assertDatabaseHas('invoice_product', $data);
    }

    /**
     * An array with valid invoice_product data
     * @return array
     */
    public function data()
    {
        return [
            'quantity' => 100,
        ];
    }
}
