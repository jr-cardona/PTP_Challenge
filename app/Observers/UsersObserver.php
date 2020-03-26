<?php

namespace App\Observers;

use App\Entities\User;

class UsersObserver
{
    public function creating(User $user)
    {
        $user->password = 'secret';
    }

    public function created(User $user)
    {
        $user->created_by = auth()->user()->id ?? User::first()->id ?? null;
        $user->updated_by = $user->created_by;
    }

    public function updated(User $user)
    {
        $user->updated_by = auth()->user()->id;
    }
}
