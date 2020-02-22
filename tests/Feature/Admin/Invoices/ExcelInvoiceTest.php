<?php

namespace Tests\Feature\Admin\Invoices;

use App\User;
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
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('export.invoices'));

        Excel::assertDownloaded('invoices-list.xlsx', function (InvoicesExport $export) {
            return $export->view()->name() == 'exports.invoices';
        });
    }
}
