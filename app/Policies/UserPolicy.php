<?php

namespace App\Policies;

use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * @param User $userAuthAuth
     * @param User $user
     * @return bool
     */
    public function index(User $userAuth, User $user = null)
    {
        return $userAuth->hasPermissionTo('View any users');
    }

    /**
     * Determine whether the user can view users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function view(User $userAuth, User $user)
    {
        if ($userAuth->hasPermissionTo('View any users')) {
            return true;
        }
        if ($userAuth->hasPermissionTo('View user')) {
            return $userAuth->id === $user->id || $userAuth->id === $user->creator->id;
        }
        return false;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param User $userAuth
     * @return mixed
     */
    public function create(User $userAuth, User $user = null)
    {
        return $userAuth->hasPermissionTo('Create users');
    }

    /**
     * Determine whether the user can update users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function edit(User $userAuth, User $user)
    {
        if ($userAuth->hasPermissionTo('Edit any users')) {
            return true;
        }
        if ($userAuth->hasPermissionTo('Edit user')) {
            return $userAuth->id === $user->id || $userAuth->id === $user->creator->id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function delete(User $userAuth, User $user)
    {
        if ($userAuth->hasPermissionTo('Delete any users')) {
            return true;
        }
        if ($userAuth->hasPermissionTo('Delete user')) {
            return $userAuth->id === $userAuth->user->creator->id;
        }
        return false;
    }

    /**
     * Determine whether the user can export users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function export(User $userAuth, User $user)
    {
        return $userAuth->hasPermissionTo('Export any users');
    }

    /**
     * Determine whether the user can import users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function import(User $userAuth, User $user)
    {
        return $user->hasPermissionTo('Import any users');
    }
}
