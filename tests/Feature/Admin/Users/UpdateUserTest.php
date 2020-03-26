<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_update_users()
    {
        $user = factory(User::class)->create();
        $data = $this->data();

        $this->put(route('users.update', $user), $data)->assertRedirect('login');
        $this->assertDatabaseMissing('users', $this->data());
    }

    /** @test */
    public function unauthorized_user_cannot_update_users()
    {
        $user = factory(User::class)->create();
        $authUser = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($authUser)->put(route('users.update', $user), $data)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_users()
    {
        $user = factory(User::class)->create();
        $permission = Permission::create(['name' => 'Edit all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);
        $data = $this->data();

        $response = $this->actingAs($authUser)->put(route('users.update', $user), $data);
        $response->assertRedirect(route('users.show', $user));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * An array with valid user data
     * @return array
     */
    public function data()
    {
        return [
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'email' => 'test@test.com',
        ];
    }
}
