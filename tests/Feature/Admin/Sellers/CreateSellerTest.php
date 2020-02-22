<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSellerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_create_sellers_view()
    {
        $this->get(route('sellers.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_sellers_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.create'));
        $response->assertOk();
    }

    /** @test */
    public function the_sellers_create_route_redirect_to_the_correct_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.create'));
        $response->assertViewIs("sellers.create");
        $response->assertSee("Crear Vendedor");
    }

    /** @test */
    public function create_sellers_view_contains_fields_to_create_a_seller()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('sellers.create'));
        $response->assertSee("Nombre");
        $response->assertSee("Apellido");
        $response->assertSee("Tipo de documento");
        $response->assertSee("Número de documento");
        $response->assertSee("Número telefónico");
        $response->assertSee("Número de celular");
        $response->assertSee("Dirección");
        $response->assertSee("Email");
        $response->assertSee(route('sellers.store'));
    }
}
