<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Client;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_edit_clients_view()
    {
        $client = factory(Client::class)->create();

        $this->get(route('clients.edit', $client))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_edit_clients_view()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $this->actingAs($user)->get(route('clients.edit', $client))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_edit_clients_view()
    {
        $permission = Permission::create(['name' => 'clients.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client));
        $response->assertOk();
        $response->assertViewIs("clients.edit");
        $response->assertSee("Editar Cliente");
    }

    /** @test */
    public function the_client_edit_view_has_current_information_of_a_client()
    {
        $permission = Permission::create(['name' => 'clients.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client));
        $response->assertSee($client->document);
        $response->assertSee($client->cellphone);
    }
}
