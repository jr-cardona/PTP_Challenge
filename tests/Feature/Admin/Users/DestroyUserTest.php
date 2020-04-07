<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_delete_users()
    {
        $user = factory(User::class)->create();

        $this->delete(route('users.destroy', $user))->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_delete_users()
    {
        $authUser = factory(User::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($authUser)->delete(route('users.destroy', $user))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_users()
    {
        $permission = Permission::create(['name' => 'users.delete.all']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);
        $user = factory(User::class)->create();

        $response = $this->actingAs($authUser)->delete(route('users.destroy', $user));
        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
