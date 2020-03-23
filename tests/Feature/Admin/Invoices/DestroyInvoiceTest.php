<?php

namespace Tests\Feature\Admin\Invoices;

use App\Entities\User;
use App\Entities\Invoice;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_annul_invoices()
    {
        $invoice = factory(Invoice::class)->create();

        $this->delete(route('invoices.destroy', $invoice))->assertRedirect(route('login'));

        $this->assertDatabaseHas('invoices', [
            'annulled_at' => null,
        ]);
    }

    /** @test */
    public function logged_in_user_can_annul_invoices()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)
            ->from(route('invoices.show', $invoice))
            ->delete(route('invoices.destroy', $invoice));
        $response->assertRedirect(route('invoices.show', $invoice));

        $this->assertDatabaseHas("invoices", [
            'annulled_at' => Carbon::now(),
        ]);
    }
}
