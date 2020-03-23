<?php

namespace Tests\Feature\Admin\PaymentAttempts;

use App\Entities\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorePaymentAttemptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_store_payment_attempts()
    {
        $invoice = factory(Invoice::class)->create();

        $this->post(route('invoices.payments.store', $invoice))->assertRedirect(route('login'));
        $this->assertDatabaseMissing('payment_attempts', ['invoice_id' => $invoice->id]);
    }
}
