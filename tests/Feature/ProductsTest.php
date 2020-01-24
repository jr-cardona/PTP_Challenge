<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\User;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function guest_user_cannot_access_to_products_lists()
    {
        $this->get(route('products.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_products_lists()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertSuccessful();
        $response->assertViewIs("products.index");
        $response->assertSee("Productos");
    }



    /** @test */
    public function guest_user_cannot_access_to_create_products_view()
    {
        $this->get(route('products.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_products_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.create'));

        $response->assertSuccessful();
        $response->assertViewIs("products.create");
        $response->assertSee("Crear Producto");
    }



    /** @test */
    public function guest_user_cannot_store_products()
    {
        $this->post(route('products.store'), [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'unit_price' => '100'
        ])
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('products', [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'unit_price' => '100'
        ]);
    }

    /** @test */
    public function logged_in_user_can_store_products()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'unit_price' => '100'
        ]);
        $response->assertRedirect(route('products.show', Product::first()));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('products', [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'unit_price' => '100'
        ]);
    }



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

        $response->assertSuccessful();
        $response->assertViewIs("products.show");
        $response->assertSee("Producto");
        $response->assertSeeText($product->name);
    }



    /** @test */
    public function guest_user_cannot_access_to_edit_products_view()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.edit', $product))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_id_user_can_access_to_edit_products_view()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.edit', $product));

        $response->assertSuccessful();
        $response->assertViewIs("products.edit");
        $response->assertSee("Editar");
        $response->assertSeeText($product->name);
    }



    /** @test */
    public function guest_user_cannot_update_products()
    {
        $product = factory(Product::class)->create();

        $this->put(route('products.update', $product), [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'unit_price' => '100'
        ])
            ->assertRedirect('login');

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'description' => $product->description,
            'unit_price' => $product->unit_price
        ]);
    }

    /** @test */
    public function logged_in_user_can_update_products()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)->put(route('products.update', $product), [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'unit_price' => '100'
        ]);
        $response->assertRedirect(route('products.show', $product));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('products', [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'unit_price' => '100'
        ]);
    }



    /** @test */
    public function guest_user_cannot_delete_products()
    {
        $product = factory(Product::class)->create();

        $this->delete(route('products.destroy', $product))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'description' => $product->description,
            'unit_price' => $product->unit_price
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_products()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('products', [
            'name' => $product->name,
            'description' => $product->description,
            'unit_price' => $product->unit_price
        ]);
    }
}
