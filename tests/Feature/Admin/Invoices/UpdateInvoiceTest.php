<?php

namespace Tests\Feature\Admin\Invoices;

use App\Entities\User;
use App\Entities\Client;
use App\Seller;
use App\Entities\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_update_invoices()
    {
        $invoice = factory(Invoice::class)->create();
        $data = $this->data();

        $this->put(route('invoices.update', $invoice), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('invoices', $this->data());
    }

    /** @test */
    public function logged_in_user_cannot_update_paid_invoices()
    {
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('invoices.update', $invoice), $data);
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_cannot_update_annulled_invoices()
    {
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('invoices.update', $invoice), $data);
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function logged_in_user_can_update_invoices()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('invoices.update', $invoice), $data);
        $response->assertRedirect();
    }

    /** @test */
    public function when_updated_an_invoice_should_redirect_to_his_show_view_without_errors()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('invoices.update', $invoice), $data);
        $response->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function data_invoice_can_be_updated_in_database()
    {
        $invoice = factory(Invoice::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->put(route('invoices.update', $invoice), $data);
        $this->assertDatabaseHas('invoices', $data);
    }

    /** @test */
    public function not_pending_invoice_cannot_be_received_checked()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);

        $this->assertDatabaseHas("invoices", ['received_at' => null]);
        $response = $this->actingAs($user)->get(route('invoices.receivedCheck', $invoice));

        $response->assertRedirect(route('invoices.show', $invoice));
        $this->assertDatabaseHas("invoices", ['received_at' => null]);
    }

    /** @test */
    public function pending_invoice_can_be_received_checked()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $this->assertDatabaseHas("invoices", ['received_at' => null]);
        $response = $this->actingAs($user)->get(route('invoices.receivedCheck', $invoice));

        $response->assertRedirect(route('invoices.show', $invoice));
        $this->assertDatabaseMissing("invoices", ['received_at' => null]);
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
