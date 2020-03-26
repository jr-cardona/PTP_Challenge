<?php


namespace App\Actions\Users;

use App\Actions\Action;
use App\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class UpdateUsersAction extends Action
{
    public function action(Model $user, Request $request): Model
    {
        $user->update($request->validated());
        if (auth()->user()->can('syncRoles', User::class)) $user->syncRoles($request->roles);

        return $user;
    }
}
