<?php

namespace Tests\Feature\Admin\InvoiceProducts;

use App\User;
use App\Product;
use App\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreInvoiceProductTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\InvoiceProductTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guest_user_cannot_store_invoice_products()
    {
        $invoice = factory(Invoice::class)->create();
        $data = $this->data();

        $this->post(route('invoices.products.store', $invoice), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('invoice_product', $data);
    }

    /** @test */
    public function logged_in_user_can_store_invoice_products()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('invoices.products.store', $invoice), $data);
        $response->assertRedirect();
    }

    /** @test */
    public function when_stored_a_invoice_product_should_redirect_to_invoice_show_view_without_errors(){
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('invoices.products.store', $invoice), $data);
        $response->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function an_invoice_product_can_be_stored_in_database(){
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->post(route('invoices.products.store', $invoice), $data);
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
        array $invoiceData, string $field, string $message
    ) {
        factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->products()->attach(Product::first()->id, [
                'quantity' => 10,
                'unit_price' => 45000,
            ]);
        $user = factory(User::class)->create();
        $response =  $this->actingAs($user)->post(route('invoices.products.store', $invoice), $invoiceData);

        $response->assertSessionHasErrors([$field => $message]);
    }

    /** @test */
    public function a_product_can_be_sold_on_many_invoices(){
        $product = factory(Product::class)->create();
        $invoices = factory(Invoice::class, 3)->create();
        foreach($invoices as $invoice){
            $product->invoices()->attach($invoice->id, ['quantity' => 1, 'unit_price' => 1]);
        }
        foreach($product->invoices as $invoice){
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
    public function data(){
        $product = factory(Product::class)->create();
        return [
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 1,
        ];
    }
}
