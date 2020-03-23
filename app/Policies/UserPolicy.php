<?php

namespace App\Policies;

use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $userAuth
     * @param User $user
     * @return bool
     */
    public function viewAny(User $userAuth, User $user = null)
    {
        return $userAuth->can('View any users');
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
        if ($userAuth->can('View any users')) return true;
        if ($userAuth->can('View profile')) return $userAuth->id === $user->id;
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
        return $userAuth->can('Create users');
    }

    /**
     * Determine whether the user can update users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function update(User $userAuth, User $user)
    {
        if ($userAuth->can('Edit any users')) return true;
        if ($userAuth->can('Edit profile')) return $userAuth->id === $user->id;
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
        if (! $user->canBeDeleted()) return false;
        if ($userAuth->can('Delete any users')) return true;
        if ($userAuth->can('Delete user')) return $userAuth->id === $user->created_by;
        return false;
    }

    /**
     * Determine whether the user can export users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function export(User $userAuth, User $user = null)
    {
        return $userAuth->can('Export any users');
    }

    /**
     * Determine whether the user can import users.
     *
     * @param User $userAuth
     * @param User $user
     * @return mixed
     */
    public function import(User $userAuth, User $user = null)
    {
        return $userAuth->can('Import any users');
    }

    public function syncRoles(User $userAuth, User $user = null){
        return $userAuth->can('Sync roles');
    }
}
