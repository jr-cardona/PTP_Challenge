<?php

namespace Tests\Feature\Admin\Invoices;

use App\User;
use App\Client;
use App\Seller;
use App\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreInvoiceTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\InvoiceTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guest_user_cannot_store_invoices()
    {
        $data = $this->data();

        $this->post(route('invoices.store'), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('invoices', $data);
    }

    /** @test */
    public function logged_in_user_can_store_invoices()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('invoices.store'), $data);
        $response->assertRedirect();
    }

    /** @test */
    public function when_stored_an_invoice_should_redirect_to_his_show_view_without_errors()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('invoices.store'), $data);
        $response->assertRedirect(route('invoices.show', Invoice::first()));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function an_invoice_can_be_stored_in_database()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->post(route('invoices.store'), $data);
        $this->assertDatabaseHas('invoices', $data);
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
    public function an_invoice_cannot_be_stored_due_to_validation_errors(
        array $invoiceData,
        string $field,
        string $message
    ) {
        $user = factory(User::class)->create();
        $response =  $this->actingAs($user)->post(route('invoices.store'), $invoiceData);

        $response->assertSessionHasErrors([$field => $message]);
    }

    /**
     * An array with valid invoice data
     * @return array
     */
    public function data()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        return [
            'issued_at' => Carbon::now()->toDateString(),
            'client_id' => $client->id,
            'seller_id' => $seller->id,
        ];
    }
}
