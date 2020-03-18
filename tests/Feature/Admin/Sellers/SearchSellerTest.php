<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use App\Seller;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchSellerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sellers_can_be_searched_by_name()
    {
        $user = factory(User::class)->create();
        factory(Seller::class)->create(["name" => "aaa"]);
        factory(Seller::class)->create(["name" => "bbb"]);
        factory(Seller::class)->create(["name" => "ccc"]);

        $response = $this->actingAs($user)->get(route('search.users'));
        $response->assertSuccessful();
        $response->assertSeeText("aaa");
        $response->assertSeeText("bbb");
        $response->assertSeeText("ccc");

        $response = $this->actingAs($user)->get(route('search.users', ['name' => "ccc"]));
        $response->assertSuccessful();
        $response->assertDontSeeText("aaa");
        $response->assertDontSeeText("bbb");
        $response->assertSeeText("ccc");
    }
}
