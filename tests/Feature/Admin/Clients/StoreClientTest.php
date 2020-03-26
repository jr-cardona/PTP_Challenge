<?php

namespace Tests\Feature\Admin\Clients;

use App\Entities\User;
use App\Entities\Client;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Entities\TypeDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreClientTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\ClientTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guests_cannot_store_clients()
    {
        $data = $this->data();

        $this->post(route('clients.store'), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('clients', [
            'document' => $data["document"]
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_store_clients()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->post(route('clients.store'), $data)->assertStatus(403);
        $this->assertDatabaseMissing('clients', [
            'document' => $data["document"]
        ]);
    }

    /** @test */
    public function authorized_user_can_store_clients()
    {
        $permission = Permission::create(['name' => 'Create clients']);
        Role::create(['name' => 'Client']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('clients.store'), $data);
        $response->assertRedirect(route('clients.show', Client::first()));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('clients', [
            'document' => $data["document"]
        ]);
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
        array $clientData,
        string $field,
        string $message
    ) {
        $permission = Permission::create(['name' => 'Create clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $client = factory(User::class)->create(['email' => 'repeated@email.com']);
        factory(Client::class)->create(['id' => $client->id, 'document' => 12345678]);

        $response =  $this->actingAs($user)->post(route('clients.store'), $clientData);
        $response->assertSessionHasErrors([$field => $message]);
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
            'cellphone' => '3000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com',
        ];
    }
}
