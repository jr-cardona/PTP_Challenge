<?php

namespace App\Observers;

use App\Entities\User;

class UsersObserver
{
    public function creating(User $user)
    {
        $user->password = 'secret';
        $user->created_by = auth()->user()->id ?? 1;
        $user->updated_by = $user->created_by;
    }

    public function updating(User $user)
    {
        $user->updated_by = auth()->user()->id;
    }
}
