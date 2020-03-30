<?php

namespace Tests\Feature\Admin\PaymentAttempts;

use Carbon\Carbon;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use App\Entities\Product;
use App\Entities\PaymentAttempt;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePaymentAttemptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_create_payment_attempts_view()
    {
        $invoice = factory(Invoice::class)->create();
        $this->get(route('invoices.payments.create', $invoice))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_create_payment_attempts_view()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();
        $product = factory(Product::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);

        $this->actingAs($user)->get(route('invoices.payments.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_create_payment_attempts_view_for_a_paid_invoice()
    {
        $permission = Permission::create(['name' => 'Pay invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);

        $this->actingAs($user)->get(route('invoices.payments.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_create_payment_attempts_view_for_a_annulled_invoice()
    {
        $permission = Permission::create(['name' => 'Pay invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);

        $this->actingAs($user)->get(route('invoices.payments.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_create_payment_attempts_view_for_a_invoice_without_products()
    {
        $permission = Permission::create(['name' => 'Pay invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();

        $this->actingAs($user)->get(route('invoices.payments.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_cannot_access_to_create_payment_attempts_view_for_a_unassociated_invoice()
    {
        $permission = Permission::create(['name' => 'Pay invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();
        $product = factory(Product::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);

        $this->actingAs($user)->get(route('invoices.payments.create', $invoice))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_create_payment_attempts_view_for_a_valid_invoice()
    {
        $permission = Permission::create(['name' => 'Pay invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create(['id' => $user->id]);
        $invoice = factory(Invoice::class)->create(['client_id' => $client->id]);
        $product = factory(Product::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);

        $response = $this->actingAs($user)->get(route('invoices.payments.create', $invoice));
        $response->assertOk();
        $response->assertViewIs('invoices.payments.create');
        $response->assertSee('Estás a punto de pagar');
    }

    /** @test */
    public function a_payment_attempt_can_belongs_to_a_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $payment_attempt = factory(PaymentAttempt::class)->create(["invoice_id" => $invoice->id]);
        $this->assertDatabaseHas('payment_attempts', [
            'invoice_id' => $payment_attempt->invoice->id
        ]);
    }
}
