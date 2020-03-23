<?php

namespace Tests\Feature\Admin\Products;

use App\Entities\User;
use App\Entities\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_a_specific_product()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.show', $product))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_product()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.show', $product));
        $response->assertOk();
    }

    /** @test */
    public function the_products_show_route_redirect_to_the_correct_view()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.show', $product));
        $response->assertViewIs("products.show");
        $response->assertSee("Productos");
    }

    /** @test */
    public function the_product_show_view_has_a_product()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertSeeText($product->fullname);
        $response->assertSeeText($product->document);
    }
}
