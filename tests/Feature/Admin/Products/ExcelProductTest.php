<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Exports\ProductsExport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_download_products_export()
    {
        factory(Product::class, 5)->create();
        Excel::fake();

        $this->get(route('products.index', ['format' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_download_products_export()
    {
        $user = factory(User::class)->create();
        factory(Product::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('products.index', ['format' => 'xlsx']))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_download_products_export()
    {
        $permission1 = Permission::create(['name' => 'View all products']);
        $permission2 = Permission::create(['name' => 'Export all products']);
        $user = factory(User::class)->create()->givePermissionTo([$permission1, $permission2]);
        $products = factory(Product::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('products.index', ['format' => 'xlsx']))->assertOk();

        Excel::assertDownloaded('products-list.xlsx', function (ProductsExport $export) use ($products) {
            return $export->collection()->contains($products->random());
        });
    }

    /**
     * Validates that unauthenticated user cannot import products
     * and is redirected to the login page
     *
     * @test
     * @return void
     */
    public function guests_cannot_import_products()
    {
        $this->post(route('import'), [
            'model' => 'App\Entities\Product',
            'redirect' => 'products.index',
            'import-model' => 'App\Imports\ProductsImport',
        ])
            ->assertRedirect(route('login'));
    }

    /**
     * Validates that unauthorized user can import products
     *
     * @test
     * @return void
     */
    public function unauthorized_user_cannot_import_products()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('import'), [
            'model' => 'App\Entities\Product',
            'redirect' => 'products.index',
            'import-model' => 'App\Imports\ProductsImport',
        ])
            ->assertStatus(403);
    }

    /**
     * Validates that authorized user can import products
     *
     * @test
     * @return void
     */
    public function authorized_user_can_import_products()
    {
        $this->withoutExceptionHandling();
        $permission = Permission::create(['name' => 'Import all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $file = UploadedFile::fake()->createWithContent(
            'SuccessProductsList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/SuccessProductsList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $file,
                'model' => 'App\Entities\Product',
                'redirect' => 'products.index',
                'import-model' => 'App\Imports\ProductsImport',
            ]);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function products_cannot_be_imported_due_validation_errors()
    {
        $permission = Permission::create(['name' => 'Import all products']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $file = UploadedFile::fake()->createWithContent(
            'ErrorProductsList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/ErrorProductsList.xlsx')
            )
        );

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $file,
                'model' => 'App\Entities\Product',
                'redirect' => 'products.index',
                'import-model' => 'App\Imports\ProductsImport',
            ]);

        $response->assertViewIs('imports.errors');
    }
}
