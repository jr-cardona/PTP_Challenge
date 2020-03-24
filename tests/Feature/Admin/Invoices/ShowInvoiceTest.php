<?php

namespace Tests\Feature\Admin\Invoices;

use App\Entities\User;
use App\Entities\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_a_specific_invoice()
    {
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.show', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.show', $invoice));
        $response->assertOk();
    }

    /** @test */
    public function the_invoices_show_route_redirect_to_the_correct_view()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.show', $invoice));
        $response->assertViewIs("invoices.show");
        $response->assertSee("Facturas");
    }

    /** @test */
    public function the_invoice_show_view_has_an_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.index'));
        $response->assertSeeText($invoice->fullname);
        $response->assertSeeText($invoice->client->fullname);
        $response->assertSeeText($invoice->seller->fullname);
    }
}
