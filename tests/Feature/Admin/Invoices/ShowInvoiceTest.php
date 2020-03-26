<?php

namespace Tests\Feature\Admin\Invoices;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_a_specific_invoice()
    {
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.show', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_a_specific_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('invoices.show', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_a_specific_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $permission = Permission::create(['name' => 'View all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('invoices.show', $invoice));
        $response->assertOk();
        $response->assertViewIs("invoices.show");
        $response->assertSee("Facturas");
    }

    /** @test */
    public function the_invoice_show_view_has_information_of_an_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $permission = Permission::create(['name' => 'View all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('invoices.index'));
        $response->assertSeeText($invoice->fullname);
        $response->assertSeeText($invoice->client->fullname);
        $response->assertSeeText($invoice->seller->fullname);
    }
}
