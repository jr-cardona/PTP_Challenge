<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\TypeDocument;
use Tests\TestCase;
use App\Client;
use App\User;

class ClientsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function guest_user_cannot_access_to_clients_lists()
    {
        $this->get(route('clients.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_clients_lists()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertSuccessful();
        $response->assertViewIs("clients.index");
        $response->assertSee("Clientes");
    }



    /** @test */
    public function guest_user_cannot_access_to_create_clients_view()
    {
        $this->get(route('clients.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_clients_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.create'));

        $response->assertSuccessful();
        $response->assertViewIs("clients.create");
        $response->assertSee("Crear Cliente");
    }



    /** @test */
    public function guest_user_cannot_store_clients()
    {
        $type_document = factory(TypeDocument::class)->create();

        $this->post(route('clients.store'), [
            'document' => '0000000000',
            'type_document_id' => $type_document->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ])
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('clients', [
            'document' => '0000000000',
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
    }

    /** @test */
    public function logged_in_user_can_store_clients()
    {
        $user = factory(User::class)->create();
        $type_document = factory(TypeDocument::class)->create();

        $response = $this->actingAs($user)->post(route('clients.store'), [
            'document' => '0000000000',
            'type_document_id' => $type_document->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
        $response->assertRedirect(route('clients.show', '1'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'document' => '0000000000',
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
    }



    /** @test */
    public function guest_user_cannot_access_to_a_specific_client()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $client = factory(Client::class)->create();

        $this->get(route('clients.show', $client))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_client()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $documentType = TypeDocument::whereIn('name', ['CC', 'NIT', 'TI', 'PPN', 'CE'])->inRandomOrder()->first()->id;
        $client = factory(Client::class)->create([
            'type_document_id' => $documentType,
        ]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.show', $client));

        $response->assertSuccessful();
        $response->assertViewIs("clients.show");
        $response->assertSee("Cliente");
        $response->assertSeeText($client->name);
    }



    /** @test */
    public function guest_user_cannot_access_to_edit_clients_view()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $client = factory(Client::class)->create();

        $this->get(route('clients.edit', $client))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_id_user_can_access_to_edit_clients_view()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('clients.edit', $client));

        $response->assertSuccessful();
        $response->assertViewIs("clients.edit");
        $response->assertSee("Editar");
        $response->assertSeeText($client->name);
    }



    /** @test */
    public function guest_user_cannot_update_clients()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $client = factory(Client::class)->create();

        $this->put(route('clients.update', $client), [
            'document' => '0000000000',
            'type_document_id' => 1,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ])
        ->assertRedirect('login');

        $this->assertDatabaseHas('clients', [
            'document' => $client->document,
            'type_document_id' => $client->type_document_id,
            'name' => $client->name,
            'surname' => $client->surname,
            'cell_phone_number' => $client->cell_phone_number,
            'address' => $client->address,
            'email' => $client->email,
        ]);
    }

    /** @test */
    public function logged_in_user_can_update_clients()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $client = factory(Client::class)->create();
        $documentType = TypeDocument::inRandomOrder()->first();

        $response = $this->actingAs($user)->put(route('clients.update', $client), [
            'document' => '0000000000',
            'type_document_id' => $documentType->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
        $response->assertRedirect(route('clients.show', $client));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'document' => '0000000000',
            'type_document_id' => $documentType->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
    }



    /** @test */
    public function guest_user_cannot_delete_clients()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $client = factory(Client::class)->create();

        $this->delete(route('clients.destroy', $client))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('clients', [
            'document' => $client->document,
            'type_document_id' => $client->type_document_id,
            'name' => $client->name,
            'surname' => $client->surname,
            'cell_phone_number' => $client->cell_phone_number,
            'address' => $client->address,
            'email' => $client->email,
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_clients()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $client = factory(Client::class)->create();

        $response = $this->actingAs($user)->delete(route('clients.destroy', $client));
        $response->assertRedirect(route('clients.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('clients', [
            'document' => $client->document,
            'type_document_id' => $client->type_document_id,
            'name' => $client->name,
            'surname' => $client->surname,
            'cell_phone_number' => $client->cell_phone_number,
            'address' => $client->address,
            'email' => $client->email,
        ]);
    }
}
