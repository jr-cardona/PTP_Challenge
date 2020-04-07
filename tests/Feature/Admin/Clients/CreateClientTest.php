<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_create_clients_view()
    {
        $this->get(route('clients.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_create_clients_view()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get(route('clients.create'))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_create_clients_view()
    {
        $permission = Permission::create(['name' => 'clients.create']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('clients.create'));
        $response->assertOk();
        $response->assertViewIs("clients.create");
        $response->assertSee("Crear Cliente");
    }

    /** @test */
    public function create_clients_view_contains_fields_to_create_a_client()
    {
        $permission = Permission::create(['name' => 'clients.create']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('clients.create'));
        $response->assertSee("Nombre");
        $response->assertSee("Apellidos");
        $response->assertSee("Tipo de documento");
        $response->assertSee("Número de documento");
        $response->assertSee("Número telefónico");
        $response->assertSee("Número de celular");
        $response->assertSee("Dirección");
        $response->assertSee("Email");
        $response->assertSee(route('clients.store'));
    }
}
