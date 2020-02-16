<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use Tests\TestCase;
use App\Exports\SellersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelSellerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_download_sellers_export()
    {
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('export.sellers'));

        Excel::assertDownloaded('sellers-list.xlsx', function(SellersExport $export) {
            return $export->view()->name() == 'exports.sellers';
        });
    }
}
