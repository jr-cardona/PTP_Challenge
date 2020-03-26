<?php

namespace Tests\Feature\Admin\Invoices;

use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_update_invoices()
    {
        $invoice = factory(Invoice::class)->create();
        $data = $this->data();

        $this->put(route('invoices.update', $invoice), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('invoices', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_update_invoices()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();
        $data = $this->data();

        $this->actingAs($user)->put(route('invoices.update', $invoice), $data)
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoices', $data);
    }

    /** @test */
    public function authorized_user_cannot_update_paid_invoices()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["paid_at" => Carbon::now()]);
        $data = $this->data();

        $this->actingAs($user)->put(route('invoices.update', $invoice), $data)
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoices', $data);
    }

    /** @test */
    public function authorized_user_cannot_update_annulled_invoices()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create(["annulled_at" => Carbon::now()]);
        $data = $this->data();

        $this->actingAs($user)->put(route('invoices.update', $invoice), $data)
            ->assertStatus(403);
        $this->assertDatabaseMissing('invoices', $data);
    }

    /** @test */
    public function authorized_user_can_update_invoices()
    {
        $permission = Permission::create(['name' => 'Edit all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $invoice = factory(Invoice::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('invoices.update', $invoice), $data);
        $response->assertRedirect(route('invoices.show', $invoice));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('invoices', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_check_invoices_as_received()
    {
        $user = factory(User::class)->create();
        $invoice = factory(Invoice::class)->create();

        $this->actingAs($user)->get(route('invoices.receivedCheck', $invoice))
            ->assertStatus(403);
        $this->assertDatabaseHas("invoices", ['received_at' => null]);
    }

    /** @test */
    public function authorized_user_can_check_invoices_as_received()
    {
        $permission = Permission::create(['name' => 'Receive invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create(['id' => $user->id]);
        $invoice = factory(Invoice::class)->create(['client_id' => $client->id]);

        $this->actingAs($user)->get(route('invoices.receivedCheck', $invoice))
            ->assertRedirect(route('invoices.show', $invoice));
        $this->assertDatabaseMissing('invoices', ['received_at' => null]);
    }

    /**
     * An array with valid invoice data
     * @return array
     */
    public function data()
    {
        $client = factory(Client::class)->create();
        return [
            'issued_at' => Carbon::now()->toDateString(),
            'client_id' => $client->id,
        ];
    }
}
