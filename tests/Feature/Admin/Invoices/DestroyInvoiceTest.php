<?php

namespace Tests\Feature\Admin\Invoices;

use Carbon\Carbon;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_annul_invoices()
    {
        $invoice = factory(Invoice::class)->create();

        $this->delete(route('invoices.destroy', $invoice))->assertRedirect(route('login'));

        $this->assertDatabaseHas('invoices', [
            'annulled_at' => null,
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_annul_invoices()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $this->actingAs($user)->delete(route('invoices.destroy', $invoice))
            ->assertStatus(403);

        $this->assertDatabaseHas("invoices", [
            'annulled_at' => null,
        ]);
    }

    /** @test */
    public function authorized_user_can_annul_invoices()
    {
        $permission = Permission::create(['name' => 'Annul all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();

        $response = $this->actingAs($user)
            ->from(route('invoices.show', $invoice))
            ->delete(route('invoices.destroy', $invoice), [
            'annulment_reason' => 'Annulment Test'
        ]);
        $response->assertRedirect(route('invoices.show', $invoice));

        $this->assertDatabaseHas("invoices", [
            'annulled_at' => Carbon::now(),
        ]);
    }
}
