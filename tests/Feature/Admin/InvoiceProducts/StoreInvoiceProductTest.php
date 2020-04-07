<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use Carbon\Carbon;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Invoice;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreInvoiceProductTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\InvoiceProductTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guests_cannot_store_invoice_products()
    {
        $invoice = factory(Invoice::class)->create();
        $data = $this->data();

        $this->post(route('invoices.products.store', $invoice), $data)
            ->assertRedirect(route('login'));
        $this->assertDatabaseMissing('invoice_product', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_invoice_details()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $this->actingAs($user)->post(route('invoices.products.store', $invoice), $this->data())
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoice_product', [
            'invoice_id' => $invoice->id,
        ]);
    }

    /** @test */
    public function authorized_user_cannot_store_details_for_paid_invoices()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(['paid_at' => Carbon::now()]);

        $this->actingAs($user)->post(route('invoices.products.store', $invoice), $this->data())
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoice_product', [
            'invoice_id' => $invoice->id,
        ]);
    }

    /** @test */
    public function authorized_user_cannot_store_details_for_annulled_invoices()
    {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(['annulled_at' => Carbon::now()]);

        $this->actingAs($user)->post(route('invoices.products.store', $invoice), $this->data())
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoice_product', [
            'invoice_id' => $invoice->id,
        ]);
    }

    /** @test */
    public function authorized_user_can_store_invoice_products()
    {
        $data = $this->data();
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->post(route('invoices.products.store', $invoice), $data);
        $response->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('invoice_product', $data);
    }

    /**
     * Test that a invoice cannot be stored
     * due to some data was not passed the validation rules
     *
     * @param array $invoiceData
     * @param string $field field that has failed
     * @param string $message error message
     * @return       void
     * @test
     * @dataProvider storeTestDataProvider
     */
    public function an_invoice_product_cannot_be_stored_due_to_validation_errors(
        array $invoiceData,
        string $field,
        string $message
    ) {
        $permission = Permission::create(['name' => 'invoices.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();
        $product = factory(Product::class)->create();
        $invoice->products()->attach($product->id, [
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $response =  $this->actingAs($user)->post(route('invoices.products.store', $invoice), $invoiceData);
        $response->assertSessionHasErrors([$field => $message]);
    }

    /** @test */
    public function a_product_can_be_sold_on_many_invoices()
    {
        $product = factory(Product::class)->create();
        $invoices = factory(Invoice::class, 3)->create();
        foreach ($invoices as $invoice) {
            $product->invoices()->attach($invoice->id, ['quantity' => 1, 'unit_price' => 1]);
        }
        foreach ($product->invoices as $invoice) {
            $this->assertDatabaseHas('invoice_product', [
                'product_id' => $product->id,
                'invoice_id' => $invoice->id,
            ]);
        }
    }

    /**
     * An array with valid invoice_product data
     * @return array
     */
    public function data()
    {
        $product = factory(Product::class)->create();
        return [
            'product_id' => $product->id,
            'quantity' => 1,
        ];
    }
}
