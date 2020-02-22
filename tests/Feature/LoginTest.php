<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function a_guest_user_can_access_to_login()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function a_logged_in_user_redirect_to_home_if_access_to_login()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('login'));
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function a_guest_user_can_access_to_register_view()
    {
        $response = $this->get('register');
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function a_guest_user_can_register()
    {
        $response = $this->post(route('register'), [
            'name' => 'Test name',
            'email' => 'test@email.com',
            'password' => '12345678',
        ]);
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function registered_users_can_login()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post(route('login'));
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function a_logged_in_user_can_logout()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('logout');
        $response->assertRedirect('/');
    }

    /** @test */
    public function an_authenticated_user_can_access_to_confirm_password()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('password.confirm'));
        $response->assertStatus(200);
    }
}
