<?php

namespace Tests\Feature\Admin\Clients;

use App\Entities\User;
use App\Entities\Client;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use App\Entities\TypeDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_update_clients()
    {
        $client = factory(Client::class)->create();
        $data = $this->data();

        $this->put(route('clients.update', $client), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('clients', [
            'document' => $data['document']
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_update_clients()
    {
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->put(route('clients.update', $client), $data)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_clients()
    {
        $client = factory(Client::class)->create();
        $permission = Permission::create(['name' => 'clients.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $data = $this->data();

        $response = $this->actingAs($user)->put(route('clients.update', $client), $data);
        $response->assertRedirect(route('clients.show', $client));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('clients', [
            'document' => $data["document"]
        ]);
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
