<?php

namespace Tests\Feature\Admin\Clients;

use App\User;
use App\Client;
use App\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_delete_clients()
    {
        $client = factory(Client::class)->create();

        $this->delete(route('clients.destroy', $client))->assertRedirect(route('login'));

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
        ]);
    }

    /** @test */
    public function logged_in_user_cannot_delete_clients_with_invoices_assigned()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();
        factory(Invoice::class)->create(["client_id" => $client->id]);

        $response = $this->actingAs($user)
            ->from(route('clients.show', $client))
            ->delete(route('clients.destroy', $client));
        $response->assertRedirect(route('clients.show', $client));

        $this->assertDatabaseHas('clients', [
            'id' => $client->id
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_clients_without_invoices_assigned()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)
            ->from(route('clients.show', $client))
            ->delete(route('clients.destroy', $client));
        $response->assertRedirect(route('clients.index'));

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id
        ]);
    }
}
