<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_create_products_view()
    {
        $this->get(route('products.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_create_products_view()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('products.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_create_products_view()
    {
        $permission = Permission::create(['name' => 'Create products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.create'));
        $response->assertOk();
        $response->assertViewIs("products.create");
        $response->assertSee("Crear Producto");
    }

    /** @test */
    public function create_products_view_contains_fields_to_create_a_product()
    {
        $permission = Permission::create(['name' => 'Create products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.create'));
        $response->assertSee("Nombre");
        $response->assertSee("Costo");
        $response->assertSee("Descripción");
        $response->assertSee(route('products.store'));
    }
}
