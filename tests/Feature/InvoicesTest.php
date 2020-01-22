<?php

namespace Tests\Feature;

use App\Client;
use App\Product;
use App\Seller;
use App\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Invoice;
use App\User;

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
        $response->assertViewIs("invoices.index");
        $response->assertSee("Facturas");
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
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $this->post(route('invoices.store'), [
            'issued_at' => '2000-01-01',
            'vat' => 1,
            'client_id' => $client->id,
            'seller_id' => $seller->id,
        ])
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('invoices', [
            'issued_at' => '2000-01-01',
            'vat' => 1,
            'client_id' => $client->id,
            'seller_id' => $seller->id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_store_invoices()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();

        $response = $this->actingAs($user)->post(route('invoices.store'), [
            'issued_at' => '2000-01-01',
            'vat' => 1,
            'client_id' => $client->id,
            'seller_id' => $seller->id,
        ]);

        $invoice = Invoice::first();
        $response->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('invoices', [
            'issued_at' => '2000-01-01 00:00:00',
            'vat' => 1,
            'client_id' => $client->id,
            'seller_id' => $seller->id,
        ]);
    }



    /** @test */
    public function guest_user_cannot_access_to_a_specific_invoice()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.show', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_invoice()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
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
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.edit', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_id_user_can_access_to_edit_invoices_view()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
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
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $this->put(route('invoices.update', $invoice), [
            'issued_at' => '2000-01-01',
            'vat' => 1,
            'state_id' => $invoice->state_id,
            'client_id' => $invoice->client_id,
            'seller_id' => $invoice->seller_id,
        ])
            ->assertRedirect('login');

        $this->assertDatabaseHas('invoices', [
            'issued_at' => $invoice->issued_at,
            'vat' => $invoice->vat,
            'state_id' => $invoice->state_id,
            'client_id' => $invoice->client_id,
            'seller_id' => $invoice->seller_id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_update_invoices()
    {
		//$this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->put(route('invoices.update', $invoice), [
            'issued_at' => '2000-01-01',
            'vat' => 1,
			'client_id' => $invoice->client_id,
			'seller_id' => $invoice->seller_id
        ]);
        $response->assertRedirect(route('invoices.show', Invoice::first()));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('invoices', [
            'issued_at' => '2000-01-01 00:00:00',
            'vat' => 1,
			'client_id' => $invoice->client_id,
			'seller_id' => $invoice->seller_id
        ]);
    }



    /** @test */
    public function guest_user_cannot_delete_invoices()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $this->delete(route('invoices.destroy', $invoice))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('invoices', [
            'issued_at' => $invoice->issued_at,
            'vat' => $invoice->vat,
            'state_id' => $invoice->state_id,
            'client_id' => $invoice->client_id,
            'seller_id' => $invoice->seller_id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_invoices()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->delete(route('invoices.destroy', $invoice));
        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('invoices', [
            'issued_at' => $invoice->issued_at,
            'vat' => $invoice->vat,
            'state_id' => $invoice->state_id,
            'client_id' => $invoice->client_id,
            'seller_id' => $invoice->seller_id,
        ]);
    }



    /** @test */
    public function guest_user_cannot_access_to_create_invoice_details_view()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $this->get(route('invoices.details.create', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_invoice_details_view()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.details.create', $invoice));

        $response->assertSuccessful();
        $response->assertViewIs("invoices.details.create");
        $response->assertSee("Agregar detalle");
    }



    /** @test */
    public function guest_user_cannot_store_invoice_details()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $this->seed("StatesTableSeeder");
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create();
        $this->post(route('invoices.details.store', $invoice), [
            'quantity' => 1,
            'unit_price' => 1,
        ])
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('invoice_product', [
            'quantity' => 1,
            'unit_price' => 1,
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
    }
}
