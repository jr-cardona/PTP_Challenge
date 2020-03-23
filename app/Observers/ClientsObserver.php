<?php

namespace App\Observers;

use App\Entities\Client;

class ClientsObserver
{
    public function creating(Client $user)
    {
        $user->created_by = auth()->user()->id ?? 1;
        $user->updated_by = $user->created_by;
    }

    public function updating(Client $user)
    {
        $user->updated_by = auth()->user()->id;
    }
}
