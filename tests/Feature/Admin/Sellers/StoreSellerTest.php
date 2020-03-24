<?php

namespace Tests\Feature\Admin\Sellers;

use App\Entities\User;
use App\Seller;
use Tests\TestCase;
use App\Entities\TypeDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreSellerTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\SellerTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guest_user_cannot_store_sellers()
    {
        $data = $this->data();

        $this->post(route('users.store'), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('users', $data);
    }

    /** @test */
    public function logged_in_user_can_store_sellers()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('users.store'), $data);
        $response->assertRedirect(route('users.show', Seller::first()));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function a_seller_can_be_stored_in_database()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->post(route('users.store'), $data);
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * Test that a seller cannot be stored
     * due to some data was not passed the validation rules
     *
     * @param array $sellerData
     * @param string $field field that has failed
     * @param string $message error message
     * @return       void
     * @test
     * @dataProvider storeTestDataProvider
     */
    public function a_seller_cannot_be_stored_due_to_validation_errors(
        array $sellerData,
        string $field,
        string $message
    ) {
        $user = factory(User::class)->create();
        factory(Seller::class)->create(["document" => 12345678, "email" => "repeated@email.com"]);
        $response =  $this->actingAs($user)->post(route('users.store'), $sellerData);

        $response->assertSessionHasErrors([$field => $message]);
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
