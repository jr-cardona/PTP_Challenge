<?php

namespace Tests\Feature\Admin\Clients;

use App\Entities\User;
use App\Entities\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_clients_index()
    {
        $this->get(route('clients.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_clients_index()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertOk();
    }

    /** @test */
    public function the_clients_index_route_redirect_to_the_correct_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertViewIs("clients.index");
        $response->assertSee("Clientes");
    }

    /** @test */
    public function the_index_of_clients_has_clients()
    {
        factory(Client::class, 5)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertViewHas('clients');
    }

    /** @test */
    public function the_index_of_clients_has_client_paginated()
    {
        factory(Client::class, 5)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $response->original->gatherData()['clients']
        );
    }

    /** @test */
    public function display_message_to_the_user_when_no_clients_where_found()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));
        $response->assertSee(__('No se encontraron clientes'));
    }

    /** @test */
    public function clients_can_be_found_by_id()
    {
        $user = factory(User::class)->create();
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
        $user = factory(User::class)->create();
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
        $user = factory(User::class)->create();
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
    public function clients_can_be_found_by_email()
    {
        $user = factory(User::class)->create();
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
