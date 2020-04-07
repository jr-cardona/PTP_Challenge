<?php

namespace Tests\Feature\Admin\Invoices;

use Tests\TestCase;
use App\Entities\User;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Validates that unauthenticated user cannot import invoices
     * and is redirected to the login page
     *
     * @test
     * @return void
     */
    public function guests_cannot_import_invoices()
    {
        $this->post(route('import'), [
            'file' => $this->file('Success'),
            'model' => 'App\Entities\Invoice',
            'import_model' => 'App\Imports\InvoicesImport',
        ])
            ->assertRedirect(route('login'));
    }

    /**
     * Validates that unauthorized user can import invoices
     *
     * @test
     * @return void
     */
    public function unauthorized_user_cannot_import_invoices()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('import'), [
            'file' => $this->file('Success'),
            'model' => 'App\Entities\Invoice',
            'import-model' => 'App\Imports\InvoicesImport',
        ])
            ->assertStatus(403);
    }

    /**
     * Validates that authorized user can import invoices
     *
     * @test
     * @return void
     */
    public function authorized_user_can_import_invoices()
    {
        $permission = Permission::create(['name' => 'invoices.import.all']);
        $user = factory(User::class)->create(['id' => 2])->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->from(route('invoices.index'))
            ->post(route('import'), [
                'file' => $this->file('Success'),
                'model' => 'App\Entities\Invoice',
                'import_model' => 'App\Imports\InvoicesImport',
            ]);

        //$response->assertRedirect(route('invoices.index'));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function invoices_cannot_be_imported_due_validation_errors()
    {
        $permission = Permission::create(['name' => 'invoices.import.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $this->file('Error'),
                'model' => 'App\Entities\Invoice',
                'redirect' => 'invoices.export',
                'import_model' => 'App\Imports\InvoicesImport',
            ]);

        $response->assertOk();
        $response->assertViewIs('imports.errors');
    }

    public function file($type)
    {
        return UploadedFile::fake()->createWithContent(
            $type . 'InvoicesList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/Invoices/' . $type . 'InvoicesList.xlsx')
            )
        );
    }
}
