<?php

namespace Tests\Feature\Admin\Invoices;

use App\User;
use App\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_delete_invoices()
    {
        $invoice = factory(Invoice::class)->create();

        $this->delete(route('invoices.destroy', $invoice))->assertRedirect(route('login'));

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_invoices()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->delete(route('invoices.destroy', $invoice));
        $response->assertRedirect();
    }

    /** @test */
    public function when_deleted_an_invoice_should_redirect_to_invoices_index_view(){
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->delete(route('invoices.destroy', $invoice));
        $response->assertRedirect(route('invoices.index'));
    }

    /** @test */
    public function an_invoice_can_be_deleted_from_database(){
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $this->actingAs($user)->delete(route('invoices.destroy', $invoice));
        $this->assertDatabaseMissing('invoices', [
            'id' => $invoice->id
        ]);
    }
}
