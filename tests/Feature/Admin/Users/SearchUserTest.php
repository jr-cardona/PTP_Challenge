<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_be_searched_by_name()
    {
        $permission = Permission::create(['name' => 'users.list.all']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);
        factory(User::class)->create(["name" => "aaa"]);
        factory(User::class)->create(["name" => "bbb"]);
        factory(User::class)->create(["name" => "ccc"]);

        $response = $this->actingAs($authUser)->get(route('search.users'));
        $response->assertSuccessful();
        $response->assertSeeText("aaa");
        $response->assertSeeText("bbb");
        $response->assertSeeText("ccc");

        $response = $this->actingAs($authUser)->get(route('search.users', ['name' => "ccc"]));
        $response->assertSuccessful();
        $response->assertDontSeeText("aaa");
        $response->assertDontSeeText("bbb");
        $response->assertSeeText("ccc");
    }
}
