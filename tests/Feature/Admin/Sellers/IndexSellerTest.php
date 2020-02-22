<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use App\Seller;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexSellerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_sellers_index()
    {
        $this->get(route('sellers.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_sellers_index()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $response->assertOk();
    }

    /** @test */
    public function the_sellers_index_route_redirect_to_the_correct_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $response->assertViewIs("sellers.index");
        $response->assertSee("Vendedores");
    }

    /** @test */
    public function the_index_of_sellers_has_sellers()
    {
        factory(Seller::class, 5)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));

        $response->assertViewHas('sellers');
    }

    /** @test */
    public function the_index_of_sellers_has_seller_paginated()
    {
        factory(Seller::class, 5)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $response->original->gatherData()['sellers']
        );
    }

    /** @test */
    public function display_message_to_the_user_when_no_sellers_where_found()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $response->assertSee(__('No se encontraron vendedores'));
    }

    /** @test */
    public function sellers_can_be_found_by_id()
    {
        $user = factory(User::class)->create();
        $seller1 = factory(Seller::class)->create();
        $seller2 = factory(Seller::class)->create();
        $seller3 = factory(Seller::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $response->assertSeeText($seller1->fullname);
        $response->assertSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);

        $response = $this->actingAs($user)->get(route('sellers.index', ['id' => $seller3->id]));
        $response->assertDontSeeText($seller1->fullname);
        $response->assertDontSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);
    }

    /** @test */
    public function sellers_can_be_found_by_type_document()
    {
        $user = factory(User::class)->create();
        $seller1 = factory(Seller::class)->create();
        $seller2 = factory(Seller::class)->create();
        $seller3 = factory(Seller::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $response->assertSeeText($seller1->fullname);
        $response->assertSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);

        $response = $this->actingAs($user)->get(route('sellers.index', ['type_document_id' => $seller3->type_document_id]));
        $response->assertDontSeeText($seller1->fullname);
        $response->assertDontSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);
    }

    /** @test */
    public function sellers_can_be_found_by_document()
    {
        $user = factory(User::class)->create();
        $seller1 = factory(Seller::class)->create();
        $seller2 = factory(Seller::class)->create();
        $seller3 = factory(Seller::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $response->assertSeeText($seller1->fullname);
        $response->assertSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);

        $response = $this->actingAs($user)->get(route('sellers.index', ['document' => $seller3->document]));
        $response->assertDontSeeText($seller1->fullname);
        $response->assertDontSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);
    }

    /** @test */
    public function sellers_can_be_found_by_email()
    {
        $user = factory(User::class)->create();
        $seller1 = factory(Seller::class)->create();
        $seller2 = factory(Seller::class)->create();
        $seller3 = factory(Seller::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.index'));
        $response->assertSeeText($seller1->fullname);
        $response->assertSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);

        $response = $this->actingAs($user)->get(route('sellers.index', ['email' => $seller3->email]));
        $response->assertDontSeeText($seller1->fullname);
        $response->assertDontSeeText($seller2->fullname);
        $response->assertSeeText($seller3->fullname);
    }
}
