<?php

namespace Tests\Feature;

use App\User;
use App\Client;
use App\Seller;
use App\Product;
use App\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoicesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function guest_user_cannot_access_to_invoices_lists()
    {
        $this->get(route('invoices.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_invoices_lists()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.index'));

        $response->assertSuccessful();
        $response->assertViewHas('invoices');
        $response->assertViewIs("invoices.index");
        $response->assertSee("Facturas");
    }



    /** @test */
    public function invoices_can_be_found_by_issued_init_and_issued_final(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $invoice1 = factory(Invoice::class)->create(['issued_at' => Carbon::now()->subWeek()]);
        $invoice2 = factory(Invoice::class)->create(['issued_at' => Carbon::now()->addWeek()]);
        $invoice3 = factory(Invoice::class)->create(['issued_at' => Carbon::now()]);

        $response = $this->actingAs($user)->get(route('invoices.index'));
        $response->assertSeeText($invoice1->fullname);
        $response->assertSeeText($invoice2->fullname);
        $response->assertSeeText($invoice3->fullname);

        $response = $this->actingAs($user)->get(route('invoices.index', [
            'issued_init' => Carbon::now()->toDateString(),
            'issued_final' => Carbon::now()->toDateString(),
        ]));
        $response->assertDontSeeText($invoice1->fullname);
        $response->assertDontSeeText($invoice2->fullname);
        $response->assertSeeText($invoice3->fullname);
    }

    /** @test */
    public function guest_user_cannot_access_to_create_invoices_view()
    {
        $this->get(route('invoices.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_invoices_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.create'));

        $response->assertSuccessful();
        $response->assertViewIs("invoices.create");
        $response->assertSee("Crear Factura");
    }

    /** @test */
    public function guest_user_cannot_store_invoices()
    {
        $this->post(route('invoices.store'), $this->data())->assertRedirect(route('login'));

        $this->assertDatabaseMissing('invoices', $this->data());
    }

    /** @test */
    public function logged_in_user_can_store_invoices()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('invoices.store'), $data);
        $response->assertRedirect(route('invoices.show', Invoice::first()));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('invoices', $data);
    }

    }



    /** @test */
    public function guest_user_cannot_access_to_a_specific_invoice()
    {
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.show', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_invoice()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.show', $invoice));

        $response->assertSuccessful();
        $response->assertViewIs("invoices.show");
        $response->assertSee("Factura");
        $response->assertSeeText($invoice->number);
    }

    /** @test */
    public function guest_user_cannot_access_to_edit_invoices_view()
    {
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.edit', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_id_user_can_access_to_edit_invoices_view()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.edit', $invoice));
        $response->assertSuccessful();
        $response->assertViewIs("invoices.edit");
        $response->assertSee("Editar");
        $response->assertSeeText($invoice->name);
    }



    /** @test */
    public function guest_user_cannot_update_invoices()
    {
        $invoice = factory(Invoice::class)->create();

        $this->put(route('invoices.update', $invoice), $this->data())->assertRedirect('login');

        $this->assertDatabaseHas('invoices', [
            'client_id' => $invoice->client_id,
            'seller_id' => $invoice->seller_id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_update_invoices()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('invoices.update', $invoice), $data);
        $response->assertRedirect(route('invoices.show', $invoice->id));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('invoices', $data);
    }

    /** @test */
    public function guest_user_cannot_delete_invoices()
    {
        $invoice = factory(Invoice::class)->create();

        $this->delete(route('invoices.destroy', $invoice))->assertRedirect(route('login'));

        $this->assertDatabaseHas('invoices', [
            'client_id' => $invoice->client_id,
            'seller_id' => $invoice->seller_id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_invoices()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->delete(route('invoices.destroy', $invoice));
        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('invoices', [
            'client_id' => $invoice->client_id,
            'seller_id' => $invoice->seller_id,
        ]);
    }

    /** @test */
    public function not_pending_invoice_cannot_be_received_checked()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);

        $response = $this->actingAs($user)->get(route('invoices.receivedCheck', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));

        $this->assertDatabaseHas("invoices", [
           'received_at' => null
        ]);
    }

    /** @test */
    public function pending_invoice_can_be_received_checked()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.receivedCheck', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
        $this->assertDatabaseHas("invoices", [
            'received_at' => Carbon::now()
        ]);
    }

    /** @test */
    public function logged_in_user_can_store_invoice_details()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->post(route('invoices.details.store', $invoice), [
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 1,
        ]);
        $response->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('invoice_product', [
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 1,
        ]);

    private function data(){
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        return [
            'issued_at' => Carbon::now()->toDateString(),
            'client_id' => $client->id,
            'seller_id' => $seller->id,
        ];
    }
}
