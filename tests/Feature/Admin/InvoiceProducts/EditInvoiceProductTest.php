<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use App\Entities\User;
use App\Entities\Product;
use App\Entities\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_edit_invoice_products_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $this->get(route('invoices.products.edit', [$invoice, $product]))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_cannot_access_to_edit_details_for_paid_invoices_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_cannot_access_to_edit_details_for_annulled_invoices_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_can_access_to_edit_invoice_products_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]));
        $response->assertOk();
    }

    /** @test */
    public function the_invoice_products_edit_route_redirect_to_the_correct_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]));
        $response->assertViewIs("invoices.products.edit", [$invoice, $product]);
        $response->assertSee("Editar detalle");
    }

    /** @test */
    public function create_invoice_products_view_contains_fields_to_edit_an_invoice_product()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]));
        $response->assertSee("Producto");
        $response->assertSee("Precio unitario");
        $response->assertSee("Cantidad");
        $response->assertSee(route('invoices.products.update', [$invoice, $product]));
    }
}
