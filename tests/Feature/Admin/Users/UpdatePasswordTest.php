<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\ChangePasswordProviders;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guests_cannot_change_password()
    {
        $data = $this->data();
        $user = factory(User::class)->create(['password' => 'secret']);

        $this->put(route('users.update-password', $user), $data)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_change_password()
    {
        $data = $this->data();
        $user = factory(User::class)->create(['password' => 'secret']);

        $this->actingAs($user)->put(route('users.update-password', $user), $data)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_change_password()
    {
        $data = $this->data();
        $permission = Permission::create(['name' => 'users.edit.profile']);
        $user = factory(User::class)->create(['password' => 'secret'])
            ->givePermissionTo($permission);

        $response = $this->actingAs($user)->put(route('users.update-password', $user), $data);
        $response->assertRedirect(route('users.show', $user));
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test that a user cannot be stored
     * due to some data was not passed the validation rules
     *
     * @param array $userData
     * @param string $field field that has failed
     * @param string $message error message
     * @return       void
     * @test
     * @dataProvider storeTestDataProvider
     */
    public function a_user_cannot_be_stored_due_to_validation_errors(
        array $userData,
        string $field,
        string $message
    ) {
        $permission = Permission::create(['name' => 'users.edit.profile']);
        $user = factory(User::class)->create(['password' => 'actualsecret'])
            ->givePermissionTo($permission);

        $this->actingAs($user)->put(route('users.update-password', $user), $userData)
            ->assertSessionHasErrors([$field => $message]);
    }

    /**
     * An array with valid user data
     * @return array
     */
    public function data()
    {
        return [
            'current_password' => 'secret',
            'new_password' => 'newsecret',
            'new_password_confirmation' => 'newsecret',
        ];
    }
}
