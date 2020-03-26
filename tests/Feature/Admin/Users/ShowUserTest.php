<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_a_specific_user()
    {
        $user = factory(User::class)->create();

        $this->get(route('users.show', $user))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_a_specific_user()
    {
        $user = factory(User::class)->create();
        $authUser = factory(User::class)->create();

        $this->actingAs($authUser)->get(route('users.show', $user))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_a_specific_user()
    {
        $user = factory(User::class)->create();
        $permission = Permission::create(['name' => 'View all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($authUser)->get(route('users.show', $user));
        $response->assertOk();
        $response->assertViewIs("users.show");
        $response->assertSee("Usuarios");
    }

    /** @test */
    public function the_user_show_view_has_a_user()
    {
        $user = factory(User::class)->create();
        $permission = Permission::create(['name' => 'View all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($authUser)->get(route('users.index'));
        $response->assertSeeText($user->fullname);
        $response->assertSeeText($user->document);
    }
}
