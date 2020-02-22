<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_products_index()
    {
        $this->get(route('products.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_products_index()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertOk();
    }

    /** @test */
    public function the_products_index_route_redirect_to_the_correct_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertViewIs("products.index");
        $response->assertSee("Facturas");
    }

    /** @test */
    public function the_index_of_products_has_products()
    {
        factory(Product::class, 5)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertViewHas('products');
    }

    /** @test */
    public function the_index_of_products_has_product_paginated()
    {
        factory(Product::class, 5)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));
        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $response->original->gatherData()['products']
        );
    }

    /** @test */
    public function display_message_to_the_user_when_no_products_where_found()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertSee(__('No se encontraron productos'));
    }

    /** @test */
    public function products_can_be_found_by_id()
    {
        $user = factory(User::class)->create();
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $product3 = factory(Product::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertSeeText($product1->name);
        $response->assertSeeText($product2->name);
        $response->assertSeeText($product3->name);

        $response = $this->actingAs($user)->get(route('products.index', ['id' => $product3->id]));
        $response->assertDontSeeText($product1->name);
        $response->assertDontSeeText($product2->name);
        $response->assertSeeText($product3->name);
    }
}
