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
        return $user->can('View all clients');
    }

    public function viewAssociated(User $user, Client $client = null)
    {
        return $user->can('View clients');
    }

    public function viewAny(User $user, Client $client = null)
    {
        return $user->can('View all clients') || $user->can('View clients');
    }

    public function view(User $user, Client $client)
    {
        if ($user->can('View all clients')) {
            return true;
        }
        if ($user->can('View profile')) {
            return $user->id === $client->id;
        }
        return false;
    }

    public function create(User $user, Client $client = null)
    {
        return $user->can('Create clients');
    }

    public function update(User $user, Client $client)
    {
        if ($user->can('Edit all clients')) {
            return true;
        }
        if ($user->can('Edit profile')) {
            return $user->id === $client->id;
        }
        return false;
    }

    public function delete(User $user, Client $client)
    {
        if (! $client->canBeDeleted()) {
            return false;
        }
        if ($user->can('Delete all clients')) {
            return true;
        }
        if ($user->can('Delete clients')) {
            return $user->id === $client->user->created_by;
        }
        return false;
    }

    public function export(User $user, Client $client = null)
    {
        return $user->can('Export all clients');
    }

    public function import(User $user, Client $client = null)
    {
        return $user->can('Import all clients')
            || $user->can('Import clients');
    }
}
