<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function viewAny(User $user, Client $client = null)
    {
        return $user->can('View all clients');
    }

    /**
     * Determine whether the user can view clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
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

    /**
     * Determine whether the user can create clients.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user, Client $client = null)
    {
        return $user->can('Create clients');
    }

    /**
     * Determine whether the user can update clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
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

    /**
     * Determine whether the user can delete clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
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

    /**
     * Determine whether the user can export clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
    public function export(User $user, Client $client = null)
    {
        return $user->can('Export all clients');
    }

    /**
     * Determine whether the user can import clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
    public function import(User $user, Client $client = null)
    {
        return $user->can('Import all clients')
            || $user->can('Import clients');
    }
}
