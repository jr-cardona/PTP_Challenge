<?php

namespace Tests\Feature\Admin\Invoices;

use App\User;
use App\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_edit_invoices_view()
    {
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.edit', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_id_user_can_access_to_edit_invoices_view()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertOk();
    }

    /** @test */
    public function the_invoices_edit_route_redirect_to_the_correct_view()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertViewIs("invoices.edit");
        $response->assertSee("Editar Factura");
    }

    /** @test */
    public function the_invoice_edit_view_has_current_information_of_a_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertSee($invoice->client->fullname);
        $response->assertSee($invoice->seller->fullname);
    }
}
