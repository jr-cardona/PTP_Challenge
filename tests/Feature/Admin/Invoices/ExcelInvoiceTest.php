<?php

namespace Tests\Feature\Admin\Invoices;

use App\User;
use App\Invoice;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_download_invoices_export()
    {
        $invoices = factory(Invoice::class, 10)->create();
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('invoices.index', ['format' => 'xlsx']));

        Excel::assertDownloaded('invoices-list.xlsx', function (InvoicesExport $export) use ($invoices) {
            return $export->collection()->contains($invoices->random());
        });
    }

    /**
     * Validates that unauthenticated user cannot import products
     * and is redirected to the login page
     *
     * @test
     * @return void
     */
    public function guest_user_cannot_import_invoices()
    {
        $this->post(route('import.invoices'))
            ->assertRedirect(route('login'));
    }

    /**
     * Validates that authorized user can import invoices
     *
     * @test
     * @return void
     */
    public function user_can_import_invoices()
    {
        $user = factory(User::class)->create();

        $file = UploadedFile::fake()->createWithContent(
            'SuccessInvoicesList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/SuccessInvoicesList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import.invoices'), ['file' => $file]);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function invoices_cannot_be_imported_due_validation_errors()
    {
        $user = factory(User::class)->create();

        $file = UploadedFile::fake()->createWithContent(
            'ErrorInvoicesList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/ErrorInvoicesList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import.invoices'), ['file' => $file]);

        $response->assertViewIs('imports.errors');
    }
}
