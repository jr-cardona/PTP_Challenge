<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user, Client $client = null)
    {
        return $user->can('clients.list.all');
    }

    public function viewAssociated(User $user, Client $client = null)
    {
        return $user->can('clients.list.associated');
    }

    public function viewAny(User $user, Client $client = null)
    {
        return $user->can('clients.list.all') || $user->can('clients.list.associated');
    }

    public function view(User $user, Client $client)
    {
        if ($user->can('clients.list.all')) {
            return true;
        }
        if ($user->can('users.view.profile')) {
            return $user->id === $client->id;
        }
        return false;
    }

    public function create(User $user, Client $client = null)
    {
        return $user->can('clients.create');
    }

    public function update(User $user, Client $client)
    {
        if ($user->can('clients.edit.all')) {
            return true;
        }
        if ($user->can('users.edit.profile')) {
            return $user->id === $client->id;
        }
        return false;
    }

    public function delete(User $user, Client $client)
    {
        if (! $client->canBeDeleted()) {
            return false;
        }
        if ($user->can('clients.delete.all')) {
            return true;
        }
        if ($user->can('clients.delete.associated')) {
            return $user->id === $client->user->created_by;
        }
        return false;
    }

    public function export(User $user, Client $client = null)
    {
        return $user->can('clients.export.all');
    }

    public function import(User $user, Client $client = null)
    {
        return $user->can('clients.import.all')
            || $user->can('clients.import.associated');
    }
}
