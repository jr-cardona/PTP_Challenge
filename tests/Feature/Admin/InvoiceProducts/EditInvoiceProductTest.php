<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use Carbon\Carbon;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Invoice;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_edit_invoice_products_view()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $this->data());
        $this->get(route('invoices.products.edit', [$invoice, $product]))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_edit_invoice_products_view()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $this->data());

        $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_edit_details_for_paid_invoices_view()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, $this->data());

        $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_edit_details_for_annulled_invoices_view()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, $this->data());

        $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_edit_invoice_products_view()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $this->data());

        $response = $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]));
        $response->assertOk();
        $response->assertViewIs("invoices.products.edit");
        $response->assertSee("Editar detalle");
    }

    /** @test */
    public function create_invoice_products_view_contains_fields_to_edit_an_invoice_product()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $this->data());

        $response = $this->actingAs($user)->get(route('invoices.products.edit', [$invoice, $product]));
        $response->assertSee("Producto");
        $response->assertSee("Precio unitario");
        $response->assertSee("Cantidad");
        $response->assertSee(route('invoices.products.update', [$invoice, $product]));
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
