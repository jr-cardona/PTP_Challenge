<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Client;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_clients_index()
    {
        $this->get(route('clients.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_clients_index()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('clients.index'))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_clients_index()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertOk();
        $response->assertViewIs("clients.index");
        $response->assertSee("Clientes");
    }

    /** @test */
    public function the_index_of_clients_has_clients()
    {
        factory(Client::class, 5)->create();
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $this->actingAs($user)->get(route('clients.index'))->assertViewHas('clients');
    }

    /** @test */
    public function the_index_of_clients_has_client_paginated()
    {
        factory(Client::class, 5)->create();
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('clients.index'));
        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $response->original->gatherData()['clients']
        );
    }

    /** @test */
    public function display_message_to_the_user_when_no_clients_where_found()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $this->actingAs($user)->get(route('clients.index'))
            ->assertSee(__('No se encontraron clientes'));
    }

    /** @test */
    public function clients_can_be_found_by_id()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client1 = factory(Client::class)->create();
        $client2 = factory(Client::class)->create();
        $client3 = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSeeText($client1->fullname);
        $response->assertSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);

        $response = $this->actingAs($user)->get(route('clients.index', ['id' => $client3->id]));
        $response->assertDontSeeText($client1->fullname);
        $response->assertDontSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);
    }

    /** @test */
    public function clients_can_be_found_by_type_document()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client1 = factory(Client::class)->create();
        $client2 = factory(Client::class)->create();
        $client3 = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSeeText($client1->fullname);
        $response->assertSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);

        $response = $this->actingAs($user)->get(route('clients.index', ['type_document_id' => $client3->type_document_id]));
        $response->assertDontSeeText($client1->fullname);
        $response->assertDontSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);
    }

    /** @test */
    public function clients_can_be_found_by_document()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client1 = factory(Client::class)->create();
        $client2 = factory(Client::class)->create();
        $client3 = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSeeText($client1->fullname);
        $response->assertSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);

        $response = $this->actingAs($user)->get(route('clients.index', ['document' => $client3->document]));
        $response->assertDontSeeText($client1->fullname);
        $response->assertDontSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);
    }

    /** @test */
    public function clients_can_be_found_by_cellphone()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client1 = factory(Client::class)->create();
        $client2 = factory(Client::class)->create();
        $client3 = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSeeText($client1->fullname);
        $response->assertSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);

        $response = $this->actingAs($user)->get(route('clients.index', ['cellphone' => $client3->cellphone]));
        $response->assertDontSeeText($client1->fullname);
        $response->assertDontSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);
    }

    /** @test */
    public function clients_can_be_found_by_email()
    {
        $permission = Permission::create(['name' => 'clients.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $client1 = factory(Client::class)->create();
        $client2 = factory(Client::class)->create();
        $client3 = factory(Client::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSeeText($client1->fullname);
        $response->assertSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);

        $response = $this->actingAs($user)->get(route('clients.index', ['email' => $client3->email]));
        $response->assertDontSeeText($client1->fullname);
        $response->assertDontSeeText($client2->fullname);
        $response->assertSeeText($client3->fullname);
    }
}
