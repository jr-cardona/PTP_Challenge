<?php


namespace App\Actions\Users;

use App\Actions\Action;
use App\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class StoreUsersAction extends Action
{
    public function action(Model $user, Request $request): Model
    {
        $user = $user->create($request->validated());
        if (auth()->user()->can('syncRoles', User::class)) $user->syncRoles($request->roles);

        return $user;
    }
}
