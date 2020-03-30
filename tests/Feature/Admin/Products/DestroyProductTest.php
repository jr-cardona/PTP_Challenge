<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Invoice;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_delete_products()
    {
        $product = factory(Product::class)->create();

        $this->delete(route('products.destroy', $product))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_delete_products()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)->delete(route('products.destroy', $product))
            ->assertStatus(403);

        $this->assertDatabaseHas('products', [
            'id' => $product->id
        ]);
    }

    /** @test */
    public function authorized_user_cannot_delete_products_with_invoices_assigned()
    {
        $permission = Permission::create(['name' => 'Delete all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();
        factory(Invoice::class)->create()->products()->attach($product, [
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $this->actingAs($user)->delete(route('products.destroy', $product))
            ->assertStatus(403);

        $this->assertDatabaseHas('products', [
            'id' => $product->id
        ]);
    }

    /** @test */
    public function authorized_user_can_delete_products()
    {
        $this->withoutExceptionHandling();
        $permission = Permission::create(['name' => 'Delete all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $product = factory(Product::class)->create();

        $this->actingAs($user)->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}
