<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use App\User;
use App\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_create_invoice_products_view()
    {
        $invoice = factory(Invoice::class)->create();
        $this->get(route('invoices.products.create', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_cannot_access_to_create_details_for_paid_invoices_view()
    {
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.create', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_cannot_access_to_create_details_for_annulled_invoices_view()
    {
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.create', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_invoice_products_view()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.create', $invoice));
        $response->assertOk();
    }

    /** @test */
    public function the_invoice_products_create_route_redirect_to_the_correct_view()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.create', $invoice));
        $response->assertViewIs("invoices.products.create", $invoice);
        $response->assertSee("Agregar producto");
    }

    /** @test */
    public function create_invoice_products_view_contains_fields_to_create_an_invoice_product()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.create', $invoice));
        $response->assertSee("Producto");
        $response->assertSee("Precio unitario");
        $response->assertSee("Cantidad");
        $response->assertSee(route('invoices.products.store', $invoice));
    }
}
