<?php

namespace Tests\Feature\Admin\Invoices;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_access_to_create_invoices_view()
    {
        $this->get(route('invoices.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_user_can_access_to_create_invoices_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.create'));
        $response->assertOk();
    }

    /** @test */
    public function the_invoices_create_route_redirect_to_the_correct_view()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.create'));
        $response->assertViewIs("invoices.create");
        $response->assertSee("Crear Factura");
    }

    /** @test */
    public function create_invoices_view_contains_fields_to_create_an_invoice()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('invoices.create'));
        $response->assertSee("Fecha de Expedición");
        $response->assertSee("Cliente");
        $response->assertSee("Vendedor");
        $response->assertSee("Descripción");
        $response->assertSee(route('invoices.store'));
    }
}
