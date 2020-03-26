<?php

namespace Tests\Feature\Admin\Clients;

use App\Entities\Client;
use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_a_specific_client()
    {
        $client = factory(Client::class)->create();

        $this->get(route('clients.show', $client))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_a_specific_client()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $this->actingAs($user)->get(route('clients.show', $client))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_a_specific_client()
    {
        $permission = Permission::create(['name' => 'View all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.show', $client));
        $response->assertOk();
        $response->assertViewIs("clients.show");
        $response->assertSee("Clientes");
    }

    /** @test */
    public function the_client_show_view_has_a_client()
    {
        $permission = Permission::create(['name' => 'View all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSeeText($client->fullname);
        $response->assertSeeText($client->document);
        $response->assertSeeText($client->email);
    }
}
