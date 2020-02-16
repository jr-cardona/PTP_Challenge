<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_delete_products()
    {
        $product = factory(Product::class)->create();

        $this->delete(route('products.destroy', $product))->assertRedirect(route('login'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_products()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));
        $response->assertRedirect();
    }

    /** @test */
    public function when_deleted_a_product_should_redirect_to_products_index_view(){
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));
        $response->assertRedirect(route('products.index'));
    }

    /** @test */
    public function a_product_can_be_deleted_from_database(){
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)->delete(route('products.destroy', $product));
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}
