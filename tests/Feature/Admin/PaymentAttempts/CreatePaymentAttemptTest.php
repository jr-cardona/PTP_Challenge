<?php

namespace Tests\Feature\Admin\PaymentAttempts;

use App\User;
use App\Invoice;
use App\Product;
use Carbon\Carbon;
use Tests\TestCase;
use App\PaymentAttempt;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePaymentAttemptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_create_payment_attempts_view()
    {
        $invoice = factory(Invoice::class)->create();
        $this->get(route('invoices.payments.create', $invoice))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_payment_attempts_view_for_a_valid_invoice()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();
        $product = factory(Product::class)->create();
        $invoice->products()->attach($product->id, ['quantity' => 1, 'unit_price' => 1]);

        $response = $this->actingAs($user)->get(route('invoices.payments.create', $invoice));
        $response->assertOk();
        $response->assertViewIs('invoices.payments.create');
        $response->assertSee('Estás a punto de pagar');
    }

    /** @test */
    public function user_cannot_access_to_create_payment_attempts_view_for_a_paid_invoice()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);

        $response = $this->actingAs($user)->get(route('invoices.payments.create', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function user_cannot_access_to_create_payment_attempts_view_for_a_expired_invoice()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create(["issued_at" => Carbon::now()->subMonth()]);

        $response = $this->actingAs($user)->get(route('invoices.payments.create', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
    }

    /** @test */
    public function user_cannot_access_to_create_payment_attempts_view_for_a_invoice_without_products()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.payments.create', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));
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
