<?php

namespace Tests\Feature\Admin\Invoices;

use App\User;
use App\Invoice;
use Carbon\Carbon;
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
    public function logged_in_user_cannot_access_to_edit_paid_invoices_view(){
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_cannot_access_to_edit_expired_invoices_view(){
        $invoice = factory(Invoice::class)->create(["issued_at" => Carbon::now()->subMonth()]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_can_access_to_edit_pending_invoices_view()
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
    public function the_invoice_edit_view_has_current_information_of_an_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertSee($invoice->client->fullname);
        $response->assertSee($invoice->seller->fullname);
    }
}
