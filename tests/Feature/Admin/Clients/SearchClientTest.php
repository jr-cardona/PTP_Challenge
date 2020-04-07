<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Client;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function clients_can_be_searched_by_name()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $clients = factory(User::class, 5)->create()->each(function ($u) {
            factory(Client::class)->create(['id' => $u->id]);
        });

        $response = $this->actingAs($user)->get(route('search.clients'));
        $response->assertSuccessful();

        foreach ($clients as $client) {
            $response->assertSeeText($client->name);
        }

        $response = $this->actingAs($user)->get(route('search.clients', [
            'name' => $clients->last()->name
        ]));
        $response->assertSuccessful();

        foreach ($clients as $client) {
            if ($client->name == $clients->last()->name) {
                $response->assertSeeText($client->name);
            } else {
                $response->assertDontSeeText($client->name);
            }
        }
    }
}
