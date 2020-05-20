<?php

namespace Tests\Feature\Admin\Clients;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\TypeDocument;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportClientTest extends TestCase
{
    use RefreshDatabase;

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
            'file' => $this->file('Success'),
            'model' => 'App\Entities\Client',
            'import_model' => 'App\Imports\ClientsImport',
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
            'file' => $this->file('Success'),
            'model' => 'App\Entities\Client',
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
        factory(TypeDocument::class)->create();
        $permission = Permission::create(['name' => 'Import all clients']);
        $user = factory(User::class)->create(['id' => 2])->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->from(route('clients.index'))
            ->post(route('import'), [
                'file' => $this->file('Success'),
                'model' => 'App\Entities\Client',
                'import_model' => 'App\Imports\ClientsImport',
            ]);

        //$response->assertRedirect(route('clients.index'));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function clients_cannot_be_imported_due_validation_errors()
    {
        $permission = Permission::create(['name' => 'Import all clients']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $this->file('Error'),
                'model' => 'App\Entities\Client',
                'redirect' => 'clients.export',
                'import_model' => 'App\Imports\ClientsImport',
            ]);

        $response->assertOk();
        $response->assertViewIs('imports.errors');
    }

    public function file($type)
    {
        return UploadedFile::fake()->createWithContent(
            $type . 'ClientsList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/Clients/' . $type . 'ClientsList.xlsx')
            )
        );
    }
}
