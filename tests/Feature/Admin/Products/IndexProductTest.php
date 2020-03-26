<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_products_index()
    {
        $this->get(route('products.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_products_index()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('products.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_products_index()
    {
        $permission = Permission::create(['name' => 'View all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertOk();
        $response->assertViewIs("products.index");
        $response->assertSee("Productos");
    }

    /** @test */
    public function the_index_of_products_has_products()
    {
        factory(Product::class, 5)->create();
        $permission = Permission::create(['name' => 'View all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertViewHas('products');
    }

    /** @test */
    public function the_index_of_products_has_product_paginated()
    {
        factory(Product::class, 5)->create();
        $permission = Permission::create(['name' => 'View all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.index'));
        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $response->original->gatherData()['products']
        );
    }

    /** @test */
    public function display_message_to_the_user_when_no_products_where_found()
    {
        $permission = Permission::create(['name' => 'View all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertSee(__('No se encontraron productos'));
    }

    /** @test */
    public function products_can_be_found_by_id()
    {
        $permission = Permission::create(['name' => 'View all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
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
