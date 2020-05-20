<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Entities\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function guests_can_access_to_login()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function a_user_redirect_to_home_if_access_to_login()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('login'));
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function a_user_can_logout()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('logout');
        $response->assertRedirect('/');
    }
}
