<?php

namespace App\Actions\Users;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class GetUsersAction extends Action
{
    public function action(Model $user, array $request)
    {
        return $user->with([
            'invoices:id,created_by',
            'client:id',
            'products:id,created_by',
            'users:id,created_by',
            'roles.permissions',
            'permissions'
        ])
            ->select(['users.id', 'users.name', 'users.surname', 'users.email'])
            ->id($request['id'] ?? '')
            ->email($request['email'] ?? '')
            ->whereDoesntHave('client', function ($query) {
                $query->where('id', '!=', 'id');
            })
            ->orderBy('name');
    }
}
