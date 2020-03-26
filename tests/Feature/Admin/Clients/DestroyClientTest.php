<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_delete_clients()
    {
        $client = factory(Client::class)->create();

        $this->delete(route('clients.destroy', $client))->assertRedirect(route('login'));

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_delete_clients()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->delete(route('clients.destroy', $client));
        $response->assertStatus(403);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id
        ]);
    }

    /** @test */
    public function authorized_user_cannot_delete_clients_with_invoices_assigned()
    {
        $permission = Permission::create(['name' => 'Delete all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create();
        factory(Invoice::class)->create(["client_id" => $client->id]);

        $response = $this->actingAs($user)->delete(route('clients.destroy', $client));
        $response->assertStatus(403);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id
        ]);
    }

    /** @test */
    public function authorized_user_can_delete_clients_without_invoices_assigned()
    {
        $permission = Permission::create(['name' => 'Delete all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client = factory(Client::class)->create();

        $this->actingAs($user)->delete(route('clients.destroy', $client))
            ->assertRedirect(route('clients.index'));

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id
        ]);
    }
}
