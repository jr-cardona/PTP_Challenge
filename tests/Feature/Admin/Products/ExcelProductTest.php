<?php

namespace Tests\Feature\Admin\Products;

use App\Entities\User;
use App\Entities\Product;
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
        $products = factory(Product::class, 10)->create();
        $user = factory(User::class)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('products.index', ['format' => 'xlsx']));

        Excel::assertDownloaded('products-list.xlsx', function (ProductsExport $export) use ($products) {
            return $export->collection()->contains($products->random());
        });
    }
}
