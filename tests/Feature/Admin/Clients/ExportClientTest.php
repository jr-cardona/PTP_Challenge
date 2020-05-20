<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Client;
use App\Exports\ClientsExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_export_clients()
    {
        factory(Client::class, 5)->create();
        Excel::fake();

        $this->get(route('clients.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_export_clients()
    {
        $user = factory(User::class)->create();
        factory(Client::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('clients.export', ['extension' => 'xlsx']))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_export_clients()
    {
        $permission = Permission::create(['name' => 'Export all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $clients = factory(Client::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->from(route('clients.index'))
            ->get(route('clients.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('clients.index'));

        Excel::matchByRegex();
        Excel::assertQueued(
            '/clients_\d{4}\-\d{2}\-\d{2}\_\d{2}\-\d{2}\-\d{2}\.xlsx/',
            function (ClientsExport $export) use ($clients) {
                return $export->query()->get()->contains($clients->random());
            }
        );
    }
}
