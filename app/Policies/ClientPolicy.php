<?php

namespace App\Policies;

use App\User;
use App\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @return bool
     */
    public function before($user)
    {
        if ($user->hasRole('Admin'))
        {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function index(User $user, Client $client)
    {
        return $user->hasPermissionTo('View any clients');
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
        if ($user->hasPermissionTo('View any clients')) {
            return true;
        } elseif ($user->hasPermissionTo('View clients')) {
            return $user->id === $client->user->owner_id;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create clients.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('Create clients');
    }

    /**
     * Determine whether the user can update clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
    public function edit(User $user, Client $client)
    {
        if ($user->hasPermissionTo('Edit any clients')) {
            return true;
        } elseif ($user->hasPermissionTo('Edit clients')) {
            return $user->id === $client->user->owner_id;
        } else {
            return false;
        }
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
        if ($user->hasPermissionTo('Delete any clients')) {
            return true;
        } elseif ($user->hasPermissionTo('Delete clients')) {
            return $user->id === $client->user->owner_id;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can export clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
    public function export(User $user, Client $client)
    {
        return $user->hasPermissionTo('Export clients');
    }

    /**
     * Determine whether the user can import clients.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
    public function import(User $user, Client $client)
    {
        if ($user->hasPermissionTo('Import any clients')) {
            return true;
        } elseif ($user->hasPermissionTo('Import clients')) {
            return $user->id === $client->owner_id;
        } else {
            return false;
        }
    }
}
