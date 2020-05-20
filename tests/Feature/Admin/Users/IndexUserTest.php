<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_users_index()
    {
        $this->get(route('users.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_users_index()
    {
        $authUser = factory(User::class)->create();

        $this->actingAs($authUser)->get(route('users.index'))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_access_to_users_index()
    {
        $permission = Permission::create(['name' => 'View all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($authUser)->get(route('users.index'));
        $response->assertOk();
        $response->assertViewIs("users.index");
        $response->assertSee("Usuarios");
    }

    /** @test */
    public function the_index_of_users_has_users()
    {
        factory(User::class, 5)->create();
        $permission = Permission::create(['name' => 'View all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($authUser)->get(route('users.index'));

        $response->assertViewHas('users');
    }

    /** @test */
    public function the_index_of_users_has_user_paginated()
    {
        factory(User::class, 5)->create();
        $permission = Permission::create(['name' => 'View all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($authUser)->get(route('users.index'));
        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $response->original->gatherData()['users']
        );
    }

    /** @test */
    public function users_can_be_found_by_id()
    {
        $permission = Permission::create(['name' => 'View all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $response = $this->actingAs($authUser)->get(route('users.index'));
        $response->assertSeeText($user1->fullname);
        $response->assertSeeText($user2->fullname);
        $response->assertSeeText($user3->fullname);

        $response = $this->actingAs($authUser)->get(route('users.index', ['id' => $user3->id]));
        $response->assertDontSeeText($user1->fullname);
        $response->assertDontSeeText($user2->fullname);
        $response->assertSeeText($user3->fullname);
    }

    /** @test */
    public function users_can_be_found_by_email()
    {
        $permission = Permission::create(['name' => 'View all users']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $response = $this->actingAs($authUser)->get(route('users.index'));
        $response->assertSeeText($user1->fullname);
        $response->assertSeeText($user2->fullname);
        $response->assertSeeText($user3->fullname);

        $response = $this->actingAs($authUser)->get(route('users.index', ['email' => $user3->email]));
        $response->assertDontSeeText($user1->fullname);
        $response->assertDontSeeText($user2->fullname);
        $response->assertSeeText($user3->fullname);
    }
}
