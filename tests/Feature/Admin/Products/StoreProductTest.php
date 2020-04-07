<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreProductTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\ProductTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guests_cannot_store_products()
    {
        $data = $this->data();

        $this->post(route('products.store'), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('products', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_store_products()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->post(route('products.store'), $data)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_store_products()
    {
        $permission = Permission::create(['name' => 'products.create']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $data = $this->data();

        $response = $this->actingAs($user)->post(route('products.store'), $data);
        $response->assertRedirect(route('products.show', Product::first()));
        $response->assertSessionHasNoErrors();
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
        array $productData,
        string $field,
        string $message
    ) {
        $permission = Permission::create(['name' => 'products.create']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        factory(Product::class)->create();
        $response =  $this->actingAs($user)->post(route('products.store'), $productData);

        $response->assertSessionHasErrors([$field => $message]);
    }

    /**
     * An array with valid product data
     * @return array
     */
    public function data()
    {
        return [
            'name' => 'Test Name',
            'cost' => 1000,
        ];
    }
}
