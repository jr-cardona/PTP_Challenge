<?php

namespace Tests\Feature\Admin\Products;

use App\Entities\User;
use App\Entities\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_edit_products_view()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.edit', $product))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_edit_products_view()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.edit', $product));
        $response->assertOk();
    }

    /** @test */
    public function the_products_edit_route_redirect_to_the_correct_view()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.edit', $product));
        $response->assertViewIs("products.edit");
        $response->assertSee("Editar Producto");
    }

    /** @test */
    public function the_product_edit_view_has_current_information_of_a_product()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.edit', $product));
        $response->assertSee($product->name);
        $response->assertSee($product->surname);
        $response->assertSee($product->document);
    }
}
