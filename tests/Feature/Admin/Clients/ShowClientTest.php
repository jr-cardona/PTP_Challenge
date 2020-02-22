<?php

namespace Tests\Feature\Admin\Clients;

use App\Client;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_a_specific_client()
    {
        $client = factory(Client::class)->create();

        $this->get(route('clients.show', $client))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_client()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.show', $client));
        $response->assertOk();
    }

    /** @test */
    public function the_clients_show_route_redirect_to_the_correct_view()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.show', $client));
        $response->assertViewIs("clients.show");
        $response->assertSee("Clientes");
    }

    /** @test */
    public function the_client_show_view_has_a_client()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSeeText($client->fullname);
        $response->assertSeeText($client->document);
    }
}
