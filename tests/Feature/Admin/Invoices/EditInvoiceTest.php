<?php

namespace Tests\Feature\Admin\Invoices;

use Carbon\Carbon;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_edit_invoices_view()
    {
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.edit', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_edit_invoices_view()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $this->actingAs($user)->get(route('invoices.edit', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_edit_paid_invoices_view()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);

        $this->actingAs($user)->get(route('invoices.edit', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_edit_annulled_invoices_view()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);

        $this->actingAs($user)->get(route('invoices.edit', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function user_can_access_to_edit_invoices_view()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertOk();
        $response->assertViewIs("invoices.edit");
        $response->assertSee("Editar Factura");
    }

    /** @test */
    public function the_invoice_edit_view_has_current_information_of_an_invoice()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertSee($invoice->client->fullname);
        $response->assertSee($invoice->seller->fullname);
    }
}
