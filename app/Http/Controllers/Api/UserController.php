<?php

namespace App\Http\Controllers\Api;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\Actions\Users\GetUsersAction;
use App\Actions\Users\StoreUsersAction;
use App\Actions\Users\UpdateUsersAction;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(GetUsersAction $action, Request $request)
    {
        $users = $action->execute(new User(), $request);
        return $users->get();
    }

    public function store(StoreUsersAction $action, SaveUserRequest $request)
    {
        return $action->execute(new User(), $request);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(
        UpdateUsersAction $action,
        User $user,
        SaveUserRequest $request
    ) {
        $user = $action->execute($user, $request);

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente',
        ], 200);
    }
}
