<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_edit_users_view()
    {
        $user = factory(User::class)->create();

        $this->get(route('users.edit', $user))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_edit_users_view()
    {
        $user = factory(User::class)->create();
        $authUser = factory(User::class)->create();

        $this->actingAs($authUser)->get(route('users.edit', $user))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_edit_users_view()
    {
        $user = factory(User::class)->create();
        $permission = Permission::create(['name' => 'users.edit.all']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($authUser)->get(route('users.edit', $user));
        $response->assertOk();
        $response->assertViewIs("users.edit");
        $response->assertSee("Editar Usuario");
    }

    /** @test */
    public function the_user_edit_view_has_current_information_of_a_user()
    {
        $user = factory(User::class)->create();
        $permission = Permission::create(['name' => 'users.edit.all']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($authUser)->get(route('users.edit', $user));
        $response->assertSee($user->name);
        $response->assertSee($user->surname);
        $response->assertSee($user->document);
    }
}
