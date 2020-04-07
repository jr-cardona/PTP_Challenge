<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_update_products()
    {
        $product = factory(Product::class)->create();
        $data = $this->data();

        $this->put(route('products.update', $product), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('products', $data);
    }

    /** @test */
    public function unauthorized_user_cannot_update_products()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($user)->put(route('products.update', $product), $data)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_products()
    {
        $product = factory(Product::class)->create();
        $permission = Permission::create(['name' => 'products.edit.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $data = $this->data();

        $response = $this->actingAs($user)->put(route('products.update', $product), $data);
        $response->assertRedirect(route('products.show', $product));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('products', $data);
    }

    /**
     * An array with valid product data
     * @return array
     */
    public function data()
    {
        return [
            'name' => 'Test Name',
            'cost' => 1000,
        ];
    }
}
