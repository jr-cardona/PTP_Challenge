<?php

namespace Tests\Feature\Admin\Invoices;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Invoice;
use App\Exports\InvoicesExport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_download_invoices_export(){
        factory(Invoice::class, 5)->create();
        Excel::fake();

        $this->get(route('invoices.index', ['format' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_download_invoices_export(){
        $user = factory(User::class)->create();
        factory(Invoice::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('invoices.index', ['format' => 'xlsx']))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_download_invoices_export()
    {
        $permission1 = Permission::create(['name' => 'View all invoices']);
        $permission2 = Permission::create(['name' => 'Export all invoices']);
        $user = factory(User::class)->create()->givePermissionTo([$permission1, $permission2]);
        $invoices = factory(Invoice::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('invoices.index', ['format' => 'xlsx']))->assertOk();

        Excel::assertDownloaded('invoices-list.xlsx', function (InvoicesExport $export) use ($invoices) {
            return $export->collection()->contains($invoices->random());
        });
    }

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
            'model' => 'App\Entities\Invoice',
            'redirect' => 'invoices.index',
            'import-model' => 'App\Imports\InvoicesImport',
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
                'model' => 'App\Entities\Invoice',
                'redirect' => 'invoices.index',
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
        $permission = Permission::create(['name' => 'Import all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $file = UploadedFile::fake()->createWithContent(
            'SuccessInvoicesList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/SuccessInvoicesList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $file,
                'model' => 'App\Entities\Invoice',
                'redirect' => 'invoices.index',
                'import-model' => 'App\Imports\InvoicesImport',
            ]);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function invoices_cannot_be_imported_due_validation_errors()
    {
        $permission = Permission::create(['name' => 'Import all invoices']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $file = UploadedFile::fake()->createWithContent(
            'ErrorInvoicesList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/ErrorInvoicesList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $file,
                'model' => 'App\Entities\Invoice',
                'redirect' => 'invoices.index',
                'import-model' => 'App\Imports\InvoicesImport',
            ]);

        $response->assertViewIs('imports.errors');
    }
}
