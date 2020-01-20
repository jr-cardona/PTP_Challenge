<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\TypeDocument;
use Tests\TestCase;
use App\Seller;
use App\User;

class SellersTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function guest_user_cannot_access_to_sellers_lists()
    {
        $this->get(route('sellers.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_sellers_lists()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));

        $response->assertSuccessful();
        $response->assertViewIs("sellers.index");
        $response->assertSee("Vendedores");
    }



    /** @test */
    public function guest_user_cannot_access_to_create_sellers_view()
    {
        $this->get(route('sellers.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_sellers_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.create'));

        $response->assertSuccessful();
        $response->assertViewIs("sellers.create");
        $response->assertSee("Crear Vendedor");
    }



    /** @test */
    public function guest_user_cannot_store_sellers()
    {
        $type_document = factory(TypeDocument::class)->create();

        $this->post(route('sellers.store'), [
            'document' => '0000000000',
            'type_document_id' => $type_document->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ])
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('sellers', [
            'document' => '0000000000',
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
    }

    /** @test */
    public function logged_in_user_can_store_sellers()
    {
        $user = factory(User::class)->create();
        $type_document = factory(TypeDocument::class)->create();

        $response = $this->actingAs($user)->post(route('sellers.store'), [
            'document' => '0000000000',
            'type_document_id' => $type_document->id,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
        $response->assertRedirect(route('sellers.show', '1'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('sellers', [
            'document' => '0000000000',
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
    }



    /** @test */
    public function guest_user_cannot_access_to_a_specific_seller()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();

        $this->get(route('sellers.show', $seller))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_seller()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.show', $seller));

        $response->assertSuccessful();
        $response->assertViewIs("sellers.show");
        $response->assertSee("Vendedor");
        $response->assertSeeText($seller->name);
    }



    /** @test */
    public function guest_user_cannot_access_to_edit_sellers_view()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();

        $this->get(route('sellers.edit', $seller))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_id_user_can_access_to_edit_sellers_view()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.edit', $seller));

        $response->assertSuccessful();
        $response->assertViewIs("sellers.edit");
        $response->assertSee("Editar");
        $response->assertSeeText($seller->name);
    }



    /** @test */
    public function guest_user_cannot_update_sellers()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();

        $this->put(route('sellers.update', $seller), [
            'document' => '0000000000',
            'type_document_id' => 1,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ])
            ->assertRedirect('login');

        $this->assertDatabaseHas('sellers', [
            'document' => $seller->document,
            'type_document_id' => $seller->type_document_id,
            'name' => $seller->name,
            'surname' => $seller->surname,
            'cell_phone_number' => $seller->cell_phone_number,
            'address' => $seller->address,
            'email' => $seller->email,
        ]);
    }

    /** @test */
    public function logged_in_user_can_update_sellers()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();

        $response = $this->actingAs($user)->put(route('sellers.update', $seller), [
            'document' => '0000000000',
            'type_document_id' => 1,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
        $response->assertRedirect(route('sellers.show', $seller));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('sellers', [
            'document' => '0000000000',
            'type_document_id' => 1,
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'cell_phone_number' => '0000000000',
            'address' => 'Test Address',
            'email' => 'test@test.com'
        ]);
    }



    /** @test */
    public function guest_user_cannot_delete_sellers()
    {
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();

        $this->delete(route('sellers.destroy', $seller))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('sellers', [
            'document' => $seller->document,
            'type_document_id' => $seller->type_document_id,
            'name' => $seller->name,
            'surname' => $seller->surname,
            'cell_phone_number' => $seller->cell_phone_number,
            'address' => $seller->address,
            'email' => $seller->email,
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_sellers()
    {
        $user = factory(User::class)->create();
        $this->seed("TypeDocumentsTableSeeder");
        $seller = factory(Seller::class)->create();

        $response = $this->actingAs($user)->delete(route('sellers.destroy', $seller));
        $response->assertRedirect(route('sellers.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('sellers', [
            'document' => $seller->document,
            'type_document_id' => $seller->type_document_id,
            'name' => $seller->name,
            'surname' => $seller->surname,
            'cell_phone_number' => $seller->cell_phone_number,
            'address' => $seller->address,
            'email' => $seller->email,
        ]);
    }
}
