<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use App\Seller;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroySellerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_delete_sellers()
    {
        $seller = factory(Seller::class)->create();

        $this->delete(route('sellers.destroy', $seller))->assertRedirect(route('login'));

        $this->assertDatabaseHas('sellers', [
            'id' => $seller->id,
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_sellers()
    {
        $user = factory(User::class)->create();
        $seller = factory(Seller::class)->create();

        $response = $this->actingAs($user)->delete(route('sellers.destroy', $seller));
        $response->assertRedirect();
    }

    /** @test */
    public function when_deleted_a_seller_should_redirect_to_sellers_index_view()
    {
        $user = factory(User::class)->create();
        $seller = factory(Seller::class)->create();

        $response = $this->actingAs($user)->delete(route('sellers.destroy', $seller));
        $response->assertRedirect(route('sellers.index'));
    }

    /** @test */
    public function a_seller_can_be_deleted_from_database()
    {
        $user = factory(User::class)->create();
        $seller = factory(Seller::class)->create();

        $this->actingAs($user)->delete(route('sellers.destroy', $seller));
        $this->assertDatabaseMissing('sellers', [
            'id' => $seller->id
        ]);
    }
}
