<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use Carbon\Carbon;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInvoiceProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_update_invoice_products()
    {
        $data1 = $this->data1();
        $data2 = $this->data2();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data1);

        $this->put(route('invoices.products.update', [$invoice, $product]), $data2)
            ->assertRedirect('login');
        $this->assertDatabaseMissing('invoice_product', $data2);
    }

    /** @test */
    public function unauthorized_user_cannot_update_invoice_details()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create();
        $data1 = $this->data1();
        $data2 = $this->data2();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data1);

        $this->actingAs($user)->put(route('invoices.products.update', [$invoice, $product]), $data2)
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoice_product', $data2);
    }

    /** @test */
    public function authorized_user_cannot_update_details_for_paid_invoices_view()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $data1 = $this->data1();
        $data2 = $this->data2();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, $data1);

        $this->actingAs($user)->put(route('invoices.products.update', [$invoice, $product]), $data2)
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoice_product', $data2);
    }

    /** @test */
    public function authorized_user_cannot_update_details_for_annulled_invoices_view()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $data1 = $this->data1();
        $data2 = $this->data2();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);
        $invoice->products()->attach($product->id, $data1);

        $this->actingAs($user)->put(route('invoices.products.update', [$invoice, $product]), $data2)
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoice_product', $data2);
    }

    /** @test */
    public function authorized_user_can_update_invoice_products()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $data1 = $this->data1();
        $data2 = $this->data2();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach($product->id, $data1);

        $response = $this->actingAs($user)->put(route('invoices.products.update', [$invoice, $product]), $data2);
        $response->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('invoice_product', $data2);
    }

    /**
     * An array with valid invoice_product data
     * @return array
     */
    public function data1()
    {
        return [
            'quantity' => 1,
            'unit_price' => 1,
        ];
    }

    /**
     * An array with valid invoice_product data
     * @return array
     */
    public function data2()
    {
        return [
            'quantity' => 100,
        ];
    }
}
