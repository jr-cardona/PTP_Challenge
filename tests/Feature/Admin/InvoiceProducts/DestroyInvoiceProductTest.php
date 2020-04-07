<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use Carbon\Carbon;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_delete_invoice_products()
    {
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $this->data());

        $this->delete(route('invoices.products.destroy', [$invoice, $product]))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_delete_invoice_details()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, $this->data());

        $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]))
            ->assertStatus(403);

        $this->assertDatabaseHas('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function authorized_user_cannot_delete_details_for_paid_invoices_view()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(['paid_at' => Carbon::now()]);
        $invoice->products()->attach($product->id, $this->data());

        $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]))
            ->assertStatus(403);

        $this->assertDatabaseHas('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function authorized_user_cannot_delete_details_for_annulled_invoices_view()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(['annulled_at' => Carbon::now()]);
        $invoice->products()->attach($product->id, $this->data());

        $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]))
            ->assertStatus(403);

        $this->assertDatabaseHas('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function authorized_user_can_delete_invoice_products()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $data = $this->data();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data);

        $this->actingAs($user)->delete(route('invoices.products.destroy', [$invoice, $product]))
            ->assertRedirect(route('invoices.show', $invoice));

        $this->assertDatabaseMissing('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
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
