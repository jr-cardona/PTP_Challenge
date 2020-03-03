<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use App\User;
use App\Invoice;
use App\Product;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_delete_invoice_products()
    {
        $data = $this->data();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data);

        $this->delete(route('invoices.products.destroy', [$invoice, $product]))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function logged_in_user_cannot_delete_details_for_paid_invoices_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_cannot_delete_details_for_annulled_invoices_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_can_delete_invoice_products()
    {
        $user = factory(User::class)->create();
        $data = $this->data();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data);

        $response = $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]));
        $response->assertRedirect();
    }

    /** @test */
    public function when_deleted_a_product_should_redirect_to_invoice_show_view()
    {
        $user = factory(User::class)->create();
        $data = $this->data();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data);

        $response = $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function a_product_can_be_deleted_from_database()
    {
        $user = factory(User::class)->create();
        $data = $this->data();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data);

        $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]));
        $this->assertDatabaseMissing('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
    }

    /**
     * An array with valid invoice_product data
     * @return array
     */
    public function data()
    {
        return [
            'quantity' => 1,
            'unit_price' => 1,
        ];
    }
}
