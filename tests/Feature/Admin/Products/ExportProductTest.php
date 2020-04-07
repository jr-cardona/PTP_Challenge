<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_export_products()
    {
        factory(Product::class, 5)->create();
        Excel::fake();

        $this->get(route('products.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_export_products()
    {
        $user = factory(User::class)->create();
        factory(Product::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('products.export', ['extension' => 'xlsx']))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_export_products()
    {
        $permission = Permission::create(['name' => 'products.export.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $products = factory(Product::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->from(route('products.index'))
            ->get(route('products.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('products.index'));

        Excel::matchByRegex();
        Excel::assertQueued(
            '/products_\d{4}\-\d{2}\-\d{2}\_\d{2}\-\d{2}\-\d{2}\.xlsx/',
            function (ProductsExport $export) use ($products) {
                return $export->query()->get()->contains($products->random());
            }
        );
    }
}
