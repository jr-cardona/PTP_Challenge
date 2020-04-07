<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreUserTest extends TestCase
{
    use RefreshDatabase;
    use Concerns\UserTestHasProviders;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }

    /** @test */
    public function guests_cannot_store_users()
    {
        $data = $this->data();

        $this->post(route('users.store'), $data)->assertRedirect(route('login'));
        $this->assertDatabaseMissing('users', $data);
    }

    /** @test */
    public function unauthorized_user_can_store_users()
    {
        $authUser = factory(User::class)->create();
        $data = $this->data();

        $this->actingAs($authUser)->post(route('users.store'), $data)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_store_users()
    {
        $permission = Permission::create(['name' => 'users.create']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);
        $data = $this->data();

        $response = $this->actingAs($authUser)->post(route('users.store'), $data);
        $response->assertRedirect(route('users.show', User::where('email', $data['email'])->first()));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', $data);
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
        $permission = Permission::create(['name' => 'users.create']);
        $authUser = factory(User::class)->create()->givePermissionTo($permission);
        factory(User::class)->create(['email' => "repeated@email.com"]);
        $response =  $this->actingAs($authUser)->post(route('users.store'), $userData);

        $response->assertSessionHasErrors([$field => $message]);
    }

    /**
     * An array with valid user data
     * @return array
     */
    public function data()
    {
        return [
            'name' => 'Test Name',
            'surname' => 'Test Surname',
            'email' => 'test@test.com',
        ];
    }
}
