<?php

namespace Tests\Feature\Admin\Products;

use App\User;
use Tests\TestCase;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_download_products_export()
    {
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('export.products'));

        Excel::assertDownloaded('products-list.xlsx', function (ProductsExport $export) {
            return $export->view()->name() == 'exports.products';
        });
    }
}
