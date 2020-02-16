<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function product_can_be_searched_by_name(){
        $user = factory(User::class)->create();
        factory(Product::class)->create(["name" => "aaa"]);
        factory(Product::class)->create(["name" => "bbb"]);
        factory(Product::class)->create(["name" => "ccc"]);

        $response = $this->actingAs($user)->get(route('search.products'));
        $response->assertSuccessful();
        $response->assertSeeText("aaa");
        $response->assertSeeText("bbb");
        $response->assertSeeText("ccc");

        $response = $this->actingAs($user)->get(route('search.products', ['name' => "ccc"]));
        $response->assertSuccessful();
        $response->assertDontSeeText("aaa");
        $response->assertDontSeeText("bbb");
        $response->assertSeeText("ccc");
    }
}
