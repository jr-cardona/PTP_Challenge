<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_create_users_view()
    {
        $this->get(route('users.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_create_users_view()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('users.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_create_users_view()
    {
        $permission = Permission::create(['name' => 'users.create']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('users.create'));
        $response->assertOk();
        $response->assertViewIs("users.create");
        $response->assertSee("Crear Usuario");
    }

    /** @test */
    public function create_users_view_contains_fields_to_create_a_user()
    {
        $permission = Permission::create(['name' => 'users.create']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('users.create'));
        $response->assertSee("Nombre");
        $response->assertSee("Apellidos");
        $response->assertSee("Email");
        $response->assertSee(route('users.store'));
    }
}
