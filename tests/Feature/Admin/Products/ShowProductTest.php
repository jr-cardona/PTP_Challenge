<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_a_specific_product()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.show', $product))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_a_specific_product()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('products.show', $product))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_a_specific_product()
    {
        $product = factory(Product::class)->create();
        $permission = Permission::create(['name' => 'products.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.show', $product));
        $response->assertOk();
        $response->assertViewIs("products.show");
        $response->assertSee("Productos");
    }

    /** @test */
    public function the_product_show_view_has_a_product()
    {
        $product = factory(Product::class)->create();
        $permission = Permission::create(['name' => 'products.list.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('products.index'));
        $response->assertSeeText($product->fullname);
        $response->assertSeeText($product->document);
    }
}
