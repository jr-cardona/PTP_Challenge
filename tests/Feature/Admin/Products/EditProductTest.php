<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_edit_products_view()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.edit', $product))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_edit_products_view()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('products.edit', $product))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_edit_products_view()
    {
        $product = factory(Product::class)->create();
        $permission = Permission::create(['name' => 'Edit all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.edit', $product));
        $response->assertOk();
        $response->assertViewIs("products.edit");
        $response->assertSee("Editar Producto");
    }

    /** @test */
    public function the_product_edit_view_has_current_information_of_a_product()
    {
        $product = factory(Product::class)->create();
        $permission = Permission::create(['name' => 'Edit all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.edit', $product));
        $response->assertSee($product->name);
        $response->assertSee($product->surname);
        $response->assertSee($product->document);
    }
}
