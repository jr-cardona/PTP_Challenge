<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Validates that unauthenticated user cannot import users
     * and is redirected to the login page
     *
     * @test
     * @return void
     */
    public function guests_cannot_import_users()
    {
        $this->post(route('import'), [
            'file' => $this->file('Success'),
            'model' => 'App\Entities\User',
            'import_model' => 'App\Imports\UsersImport',
        ])
            ->assertRedirect(route('login'));
    }

    /**
     * Validates that unauthorized user can import users
     *
     * @test
     * @return void
     */
    public function unauthorized_user_cannot_import_users()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('import'), [
            'file' => $this->file('Success'),
            'model' => 'App\Entities\User',
            'import-model' => 'App\Imports\UsersImport',
        ])
            ->assertStatus(403);
    }

    /**
     * Validates that authorized user can import users
     *
     * @test
     * @return void
     */
    public function authorized_user_can_import_users()
    {
        $permission = Permission::create(['name' => 'Import all users']);
        $user = factory(User::class)->create(['id' => 2])->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->from(route('users.index'))
            ->post(route('import'), [
                'file' => $this->file('Success'),
                'model' => 'App\Entities\User',
                'import_model' => 'App\Imports\UsersImport',
            ]);

        //$response->assertRedirect(route('users.index'));
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function users_cannot_be_imported_due_validation_errors()
    {
        $permission = Permission::create(['name' => 'Import all users']);
        $user = factory(User::class)->create()->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->post(route('import'), [
                'file' => $this->file('Error'),
                'model' => 'App\Entities\User',
                'redirect' => 'users.export',
                'import_model' => 'App\Imports\UsersImport',
            ]);

        $response->assertOk();
        $response->assertViewIs('imports.errors');
    }

    public function file($type){
        return UploadedFile::fake()->createWithContent(
            $type . 'UsersList.xlsx',
            file_get_contents(
                base_path('tests/Stubs/Users/' . $type . 'UsersList.xlsx')
            )
        );
    }
}
