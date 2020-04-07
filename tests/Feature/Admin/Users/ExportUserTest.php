<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_cannot_export_users()
    {
        factory(User::class, 5)->create();
        Excel::fake();

        $this->get(route('users.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_export_users()
    {
        $user = factory(User::class)->create();
        factory(User::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->get(route('users.export', ['extension' => 'xlsx']))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_export_users()
    {
        $permission = Permission::create(['name' => 'users.export.all']);
        $user = factory(User::class)->create()->givePermissionTo($permission);
        $users = factory(User::class, 5)->create();
        Excel::fake();

        $this->actingAs($user)->from(route('users.index'))
            ->get(route('users.export', ['extension' => 'xlsx']))
            ->assertRedirect(route('users.index'));

        Excel::matchByRegex();
        Excel::assertQueued(
            '/users_\d{4}\-\d{2}\-\d{2}\_\d{2}\-\d{2}\-\d{2}\.xlsx/',
            function (UsersExport $export) use ($users) {
                return $export->query()->get()->contains($users->random());
            }
        );
    }
}
