<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_update_products()
    {
        $product = factory(Product::class)->create();
        $data = $this->data();

        $this->put(route('products.update', $product), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('products', $data);
    }

    /** @test */
    public function logged_in_user_can_update_products()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('products.update', $product), $data);
        $response->assertRedirect(route('products.show', $product));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function data_product_can_be_updated_in_database(){
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->put(route('products.update', $product), $data);
        $this->assertDatabaseHas('products', $data);
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
