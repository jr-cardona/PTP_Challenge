<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use App\Product;
use App\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_delete_products()
    {
        $product = factory(Product::class)->create();

        $this->delete(route('products.destroy', $product))->assertRedirect(route('login'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function logged_in_user_cannot_delete_products_with_invoices_assigned()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        factory(Invoice::class)->create()->products()->attach($product, [
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        $response = $this->actingAs($user)
            ->from(route('products.show', $product))
            ->delete(route('products.destroy', $product));
        $response->assertRedirect(route('products.show', $product));

        $this->assertDatabaseHas('products', [
            'id' => $product->id
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_products_without_invoices_assigned()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)
            ->from(route('products.show', $product))
            ->delete(route('products.destroy', $product));
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}
