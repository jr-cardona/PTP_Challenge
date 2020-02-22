<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use App\Seller;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditSellerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_edit_sellers_view()
    {
        $seller = factory(Seller::class)->create();

        $this->get(route('sellers.edit', $seller))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_edit_sellers_view()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.edit', $seller));
        $response->assertOk();
    }

    /** @test */
    public function the_sellers_edit_route_redirect_to_the_correct_view()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.edit', $seller));
        $response->assertViewIs("sellers.edit");
        $response->assertSee("Editar Vendedor");
    }

    /** @test */
    public function the_seller_edit_view_has_current_information_of_a_seller()
    {
        $seller = factory(Seller::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.edit', $seller));
        $response->assertSee($seller->name);
        $response->assertSee($seller->surname);
        $response->assertSee($seller->document);
    }
}
