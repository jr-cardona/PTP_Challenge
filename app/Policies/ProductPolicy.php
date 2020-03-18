<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
     * @param Product $product
     * @return bool
     */
    public function index(User $user, Product $product = null)
    {
        return $user->hasPermissionTo('View any products');
    }

    /**
     * Determine whether the user can view products.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function view(User $user, Product $product)
    {
        if ($user->hasPermissionTo('View any products')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create products.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user, Product $product = null)
    {
        return $user->hasPermissionTo('Create products');
    }

    /**
     * Determine whether the user can update products.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function edit(User $user, Product $product)
    {
        if ($user->hasPermissionTo('Edit any products')) {
            return true;
        } elseif ($user->hasPermissionTo('Edit products')) {
            return $user->id === $product->user->creator_id;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete products.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        if ($user->hasPermissionTo('Delete any products')) {
            return true;
        } elseif ($user->hasPermissionTo('Delete products')) {
            return $user->id === $product->user->creator_id;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can export products.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function export(User $user, Product $product = null)
    {
        return $user->hasPermissionTo('Export any products');
    }

    /**
     * Determine whether the user can import products.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function import(User $user, Product $product = null)
    {
        return $user->hasPermissionTo('Import any products');
    }
}
