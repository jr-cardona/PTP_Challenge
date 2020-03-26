<?php

namespace App\Observers;

use App\Entities\Client;

class ClientsObserver
{
    public function creating(Client $client)
    {
        if (! $client->created_by) $client->created_by = auth()->user()->id;
        $client->updated_by = $client->created_by;
    }

    public function updating(Client $client)
    {
        $client->updated_by = auth()->user()->id;
    }
}
