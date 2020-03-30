<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_create_invoice_products_view()
    {
        $invoice = factory(Invoice::class)->create();
        $this->get(route('invoices.products.create', $invoice))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_create_invoice_products_view()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('invoices.products.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_create_details_for_paid_invoices_view()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);

        $this->actingAs($user)->get(route('invoices.products.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_create_details_for_annulled_invoices_view()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);

        $this->actingAs($user)->get(route('invoices.products.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_create_invoice_products_view()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.create', $invoice));
        $response->assertOk();
        $response->assertViewIs("invoices.products.create");
        $response->assertSee("Agregar producto");
    }

    /** @test */
    public function create_invoice_products_view_contains_fields_to_create_an_invoice_detail()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.products.create', $invoice));
        $response->assertSee("Producto");
        $response->assertSee("Precio unitario");
        $response->assertSee("Cantidad");
        $response->assertSee(route('invoices.products.store', $invoice));
    }
}
