<?php

namespace Tests\Feature\Admin\Clients;

use App\User;
use App\Client;
use Tests\TestCase;
use App\TypeDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_update_clients()
    {
        $client = factory(Client::class)->create();
        $data = $this->data();

        $this->put(route('clients.update', $client), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('clients', $this->data());
    }

    /** @test */
    public function logged_in_user_can_update_clients()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('clients.update', $client), $data);
        $response->assertRedirect(route('clients.show', $client));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function data_client_can_be_updated_in_database()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->put(route('clients.update', $client), $data);
        $this->assertDatabaseHas('clients', $data);
    }

    /**
     * An array with valid client data
     * @return array
     */
    public function data()
    {
        $type_document = factory(TypeDocument::class)->create();
        return [
            'document' => '0000000000',
            'type_document_id' => $type_document->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '3000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com',
        ];
    }
}
