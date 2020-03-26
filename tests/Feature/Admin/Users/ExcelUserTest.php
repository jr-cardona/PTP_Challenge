<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExcelUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_download_users_export()
    {
        $users = factory(User::class, 10)->create();
        $permission1 = Permission::create(['name' => 'View all users']);
        $permission2 = Permission::create(['name' => 'Export all users']);
        $authUser = factory(User::class)->create()->givePermissionTo([$permission1, $permission2]);
        Excel::fake();

        $this->actingAs($authUser)->get(route('users.index', ['format' => 'xlsx']));

        Excel::assertDownloaded('users-list.xlsx', function (UsersExport $export) use ($users) {
            return $export->collection()->contains($users->random());
        });
    }
}
