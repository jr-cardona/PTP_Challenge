<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function viewAny(User $user, Product $product = null)
    {
        return $user->can('View any products');
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
        if ($user->can('View any products')) {
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
        return $user->can('Create products');
    }

    /**
     * Determine whether the user can update products.
     *
     * @param User $user
     * @param Product $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        if ($user->can('Edit any products')) {
            return true;
        }
        if ($user->can('Edit products')) {
            return $user->id === $product->user->created_by;
        }
        return false;
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
        if ($product->invoices->count() > 0){
            return false;
        }
        if ($user->can('Delete any products')) {
            return true;
        }
        if ($user->can('Delete products')) {
            return $user->id === $product->user->created_by;
        }
        return false;
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
        return $user->can('Export any products');
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
        return $user->can('Import any products');
    }
}
