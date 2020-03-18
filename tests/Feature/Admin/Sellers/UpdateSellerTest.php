<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use App\Seller;
use Tests\TestCase;
use App\TypeDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateSellerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_update_sellers()
    {
        $seller = factory(Seller::class)->create();
        $data = $this->data();

        $this->put(route('users.update', $seller), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('users', $this->data());
    }

    /** @test */
    public function logged_in_user_can_update_sellers()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('users.update', $seller), $data);
        $response->assertRedirect(route('users.show', $seller));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function data_seller_can_be_updated_in_database()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->put(route('users.update', $seller), $data);
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * An array with valid seller data
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
