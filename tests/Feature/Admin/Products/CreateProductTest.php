<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

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
        $response->assertOk();
    }

    /** @test */
    public function the_products_create_route_redirect_to_the_correct_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.create'));
        $response->assertViewIs("products.create");
        $response->assertSee("Crear Producto");
    }

    /** @test */
    public function create_products_view_contains_fields_to_create_a_product()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('products.create'));
        $response->assertSee("Nombre");
        $response->assertSee("Costo");
        $response->assertSee("Descripción");
        $response->assertSee(route('products.store'));
    }
}
