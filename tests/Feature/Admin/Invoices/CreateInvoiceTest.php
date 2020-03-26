<?php

namespace Tests\Feature\Admin\Invoices;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_to_create_invoices_view()
    {
        $this->get(route('invoices.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_access_to_create_invoices_view()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('invoices.create'))->assertStatus(403);
    }

    /** @test */
    public function user_can_access_to_create_invoices_view()
    {
        $permission = Permission::create(['name' => 'Create invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('invoices.create'));
        $response->assertOk();
        $response->assertViewIs("invoices.create");
        $response->assertSee("Crear Factura");
    }

    /** @test */
    public function create_invoices_view_contains_fields_to_create_an_invoice()
    {
        $permission = Permission::create(['name' => 'Create invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this->actingAs($user)->get(route('invoices.create'));
        $response->assertSee("Fecha de Expedición");
        $response->assertSee("Cliente");
        $response->assertSee("Vendedor");
        $response->assertSee("Descripción");
        $response->assertSee(route('invoices.store'));
    }
}
