<?php

namespace Tests\Feature\Admin\Clients;

use App\User;
use App\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function clients_can_be_searched_by_name(){
        $user = factory(User::class)->create();
        factory(Client::class)->create(["name" => "aaa"]);
        factory(Client::class)->create(["name" => "bbb"]);
        factory(Client::class)->create(["name" => "ccc"]);

        $response = $this->actingAs($user)->get(route('search.clients'));
        $response->assertSuccessful();
        $response->assertSeeText("aaa");
        $response->assertSeeText("bbb");
        $response->assertSeeText("ccc");

        $response = $this->actingAs($user)->get(route('search.clients', ['name' => "ccc"]));
        $response->assertSuccessful();
        $response->assertDontSeeText("aaa");
        $response->assertDontSeeText("bbb");
        $response->assertSeeText("ccc");
    }
}
