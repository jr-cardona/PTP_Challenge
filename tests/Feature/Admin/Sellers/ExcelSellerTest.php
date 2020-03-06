<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use App\Seller;
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
        $sellers = factory(Seller::class, 10)->create();
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('sellers.index', ['format' => 'xlsx']));

        Excel::assertDownloaded('sellers-list.xlsx', function (SellersExport $export) use ($sellers) {
            return $export->collection()->contains($sellers->random());
        });
    }
}
