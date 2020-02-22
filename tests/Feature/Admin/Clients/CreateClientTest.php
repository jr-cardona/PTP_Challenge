<?php

namespace Tests\Feature\Admin\Clients;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_create_clients_view()
    {
        $this->get(route('clients.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_clients_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.create'));
        $response->assertOk();
    }

    /** @test */
    public function the_clients_create_route_redirect_to_the_correct_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.create'));
        $response->assertViewIs("clients.create");
        $response->assertSee("Crear Cliente");
    }

    /** @test */
    public function create_clients_view_contains_fields_to_create_a_client()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.create'));
        $response->assertSee("Nombre");
        $response->assertSee("Apellido");
        $response->assertSee("Tipo de documento");
        $response->assertSee("Número de documento");
        $response->assertSee("Número telefónico");
        $response->assertSee("Número de celular");
        $response->assertSee("Dirección");
        $response->assertSee("Email");
        $response->assertSee(route('clients.store'));
    }
}
