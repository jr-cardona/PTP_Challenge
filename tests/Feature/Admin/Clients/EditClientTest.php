<?php

namespace Tests\Feature\Admin\Clients;

use App\Entities\User;
use App\Entities\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_edit_clients_view()
    {
        $client = factory(Client::class)->create();

        $this->get(route('clients.edit', $client))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_edit_clients_view()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client));
        $response->assertOk();
    }

    /** @test */
    public function the_clients_edit_route_redirect_to_the_correct_view()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client));
        $response->assertViewIs("clients.edit");
        $response->assertSee("Editar Cliente");
    }

    /** @test */
    public function the_client_edit_view_has_current_information_of_a_client()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client));
        $response->assertSee($client->name);
        $response->assertSee($client->surname);
        $response->assertSee($client->document);
    }
}
