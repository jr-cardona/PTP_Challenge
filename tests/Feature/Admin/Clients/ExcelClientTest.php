<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Client;
use App\Exports\ClientsExport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_download_clients_export(){
        factory(Client::class, 5)->create();
        Excel::fake();

        $this->get(route('clients.index', ['format' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_download_clients_export(){
        $user = factory(User::class)->create();
        factory(Client::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('clients.index', ['format' => 'xlsx']))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_download_clients_export()
    {
        $permission1 = Permission::create(['name' => 'View all clients']);
        $permission2 = Permission::create(['name' => 'Export all clients']);
        $user = factory(User::class)->create()->givePermissionTo([$permission1, $permission2]);
        $clients = factory(Client::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('clients.index', ['format' => 'xlsx']))->assertOk();

        Excel::assertDownloaded('clients-list.xlsx', function (ClientsExport $export) use ($clients) {
            return $export->collection()->contains($clients->random());
        });
    }

    /**
     * Validates that unauthenticated user cannot import clients
     * and is redirected to the login page
     *
     * @test
     * @return void
     */
    public function guests_cannot_import_clients()
    {
        $this->post(route('import'), [
            'model' => 'App\Entities\Client',
            'redirect' => 'clients.index',
            'import-model' => 'App\Imports\ClientsImport',
        ])
            ->assertRedirect(route('login'));
    }

    /**
     * Validates that unauthorized user can import clients
     *
     * @test
     * @return void
     */
    public function unauthorized_user_cannot_import_clients()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('import'), [
            'model' => 'App\Entities\Client',
            'redirect' => 'clients.index',
            'import-model' => 'App\Imports\ClientsImport',
        ])
            ->assertStatus(403);
    }

    /**
     * Validates that authorized user can import clients
     *
     * @test
     * @return void
     */
    public function authorized_user_can_import_clients()
    {
        $permission = Permission::create(['name' => 'Import all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $file = UploadedFile::fake()->createWithContent(
            'SuccessClientsList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/SuccessClientsList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $file,
                'model' => 'App\Entities\Client',
                'redirect' => 'clients.index',
                'import-model' => 'App\Imports\ClientsImport',
            ]);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function clients_cannot_be_imported_due_validation_errors()
    {
        $permission = Permission::create(['name' => 'Import all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $file = UploadedFile::fake()->createWithContent(
            'ErrorClientsList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/ErrorClientsList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $file,
                'model' => 'App\Entities\Client',
                'redirect' => 'clients.index',
                'import-model' => 'App\Imports\ClientsImport',
            ]);

        $response->assertViewIs('imports.errors');
    }
}
