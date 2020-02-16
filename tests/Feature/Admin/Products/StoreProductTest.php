<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreProductTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\ProductTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guest_user_cannot_store_products()
    {
        $data = $this->data();

        $this->post(route('products.store'), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('products', $data);
    }

    /** @test */
    public function logged_in_user_can_store_products()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('products.store'), $data);
        $response->assertRedirect(route('products.show', Product::first()));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function a_product_can_be_stored_in_database(){
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->post(route('products.store'), $data);
        $this->assertDatabaseHas('products', $data);
    }

    /**
     * Test that a product cannot be stored
     * due to some data was not passed the validation rules
     *
     * @param array $productData
     * @param string $field field that has failed
     * @param string $message error message
     * @return       void
     * @test
     * @dataProvider storeTestDataProvider
     */
    public function a_product_cannot_be_stored_due_to_validation_errors(
        array $productData, string $field, string $message
    ) {
        $user = factory(User::class)->create();
        factory(Product::class)->create();
        $response =  $this->actingAs($user)->post(route('products.store'), $productData);

        $response->assertSessionHasErrors([$field => $message]);
    }

    /**
     * An array with valid product data
     * @return array
     */
    public function data(){
        return [
            'name' => 'Test Name',
            'unit_price' => 1000,
        ];
    }
}
