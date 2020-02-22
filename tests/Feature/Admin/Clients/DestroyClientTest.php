<?php

namespace Tests\Feature\Admin\Clients;

use App\User;
use App\Client;
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
    public function logged_in_user_can_delete_clients()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->delete(route('clients.destroy', $client));
        $response->assertRedirect();
    }

    /** @test */
    public function when_deleted_a_client_should_redirect_to_clients_index_view()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->delete(route('clients.destroy', $client));
        $response->assertRedirect(route('clients.index'));
    }

    /** @test */
    public function a_client_can_be_deleted_from_database()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $this->actingAs($user)->delete(route('clients.destroy', $client));
        $this->assertDatabaseMissing('clients', [
            'id' => $client->id
        ]);
    }
}
