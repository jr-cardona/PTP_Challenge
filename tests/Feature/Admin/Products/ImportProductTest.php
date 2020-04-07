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

class ImportProductTest extends TestCase
{
    use RefreshDatabase;

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
            'file' => $this->file('Success'),
            'model' => 'App\Entities\Product',
            'import_model' => 'App\Imports\ProductsImport',
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
            'file' => $this->file('Success'),
            'model' => 'App\Entities\Product',
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
        $permission = Permission::create(['name' => 'products.import.all']);
        $user = factory(User::class)->create(['id' => 2])->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->from(route('products.index'))
            ->post(route('import'), [
                'file' => $this->file('Success'),
                'model' => 'App\Entities\Product',
                'import_model' => 'App\Imports\ProductsImport',
            ]);

        //$response->assertRedirect(route('products.index'));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function products_cannot_be_imported_due_validation_errors()
    {
        $permission = Permission::create(['name' => 'products.import.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $this->file('Error'),
                'model' => 'App\Entities\Product',
                'redirect' => 'products.export',
                'import_model' => 'App\Imports\ProductsImport',
            ]);

        $response->assertOk();
        $response->assertViewIs('imports.errors');
    }

    public function file($type)
    {
        return UploadedFile::fake()->createWithContent(
            $type . 'ProductsList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/Products/' . $type . 'ProductsList.xlsx')
            )
        );
    }
}
