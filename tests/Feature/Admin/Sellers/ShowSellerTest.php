<?php

namespace Tests\Feature\Admin\Sellers;

use App\Seller;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowSellerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_a_specific_seller()
    {
        $seller = factory(Seller::class)->create();

        $this->get(route('users.show', $seller))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_a_specific_seller()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('users.show', $seller));
        $response->assertOk();
    }

    /** @test */
    public function the_sellers_show_route_redirect_to_the_correct_view()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('users.show', $seller));
        $response->assertViewIs("users.show");
        $response->assertSee("Vendedores");
    }

    /** @test */
    public function the_seller_show_view_has_a_seller()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('users.index'));
        $response->assertSeeText($seller->fullname);
        $response->assertSeeText($seller->document);
    }
}
