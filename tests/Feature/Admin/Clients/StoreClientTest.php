<?php

namespace Tests\Feature\Admin\Clients;

use App\Client;
use App\TypeDocument;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreClientTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\ClientTestHasProviders;

    /** @test */
    public function guest_user_cannot_store_clients()
    {
        $data = $this->data();

        $this->post(route('clients.store'), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('clients', $data);
    }

    /** @test */
    public function logged_in_user_can_store_clients()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('clients.store'), $data);
        $response->assertRedirect();
    }

    /** @test */
    public function when_stored_a_client_should_redirect_to_his_show_view_without_errors(){
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('clients.store'), $data);
        $response->assertRedirect(route('clients.show', Client::first()));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function a_client_can_be_stored_in_database(){
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->post(route('clients.store'), $data);
        $this->assertDatabaseHas('clients', $data);
    }

    /**
     * Test that a client cannot be stored
     * due to some data was not passed the validation rules
     *
     * @param array $clientData
     * @param string $field field that has failed
     * @param string $message error message
     * @return       void
     * @test
     * @dataProvider storeTestDataProvider
     */
    public function a_client_cannot_be_stored_due_to_validation_errors(
        array $clientData, string $field, string $message
    ) {
        $user = factory(User::class)->create();
        factory(Client::class)->create(["document" => 12345678, "email" => "repeated@email.com"]);
        $response =  $this->actingAs($user)->post(route('clients.store'), $clientData);

        $response->assertSessionHasErrors([$field => $message]);
    }

    /**
     * An array with valid client data
     * @return array
     */
    public function data(){
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
