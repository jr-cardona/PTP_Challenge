<?php

namespace Tests\Feature\Admin\Sellers;

use App\User;
use App\Seller;
use Tests\TestCase;
use App\Exports\UsersExport;
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

        $this->actingAs($user)->get(route('users.index', ['format' => 'xlsx']));

        Excel::assertDownloaded('users-list.xlsx', function (UsersExport $export) use ($sellers) {
            return $export->collection()->contains($sellers->random());
        });
    }
}
