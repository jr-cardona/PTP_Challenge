<?php

namespace Tests\Feature\Admin\Users;

use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_to_edit_password_view(){
        $user = factory(User::class)->create();

        $this->get(route('users.edit-password', $user))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_edit_password_view(){
        $user = factory(User::class)->create();
        $authUser = factory(User::class)->create();

        $this->actingAs($authUser)->get(route('users.edit-password', $user))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_edit_password_view(){
        $permission = Permission::create(['name' => 'Edit profile']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('users.edit-password', $user));
        $response->assertOk();
        $response->assertViewIs('users.edit-password');
        $response->assertSee('Editar contraseña');
    }
}
