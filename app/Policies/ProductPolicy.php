<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user, Product $invoice = null)
    {
        return $user->can('View all products');
    }

    public function viewAssociated(User $user, Product $invoice = null)
    {
        return $user->can('View products');
    }

    public function viewAny(User $user, Product $product = null)
    {
        return $user->can('View all products') || $user->can('View products');
    }

    public function view(User $user, Product $product)
    {
        if ($user->can('View all products')) {
            return true;
        }
        if ($user->can('View products')) {
            return $user->id === $product->created_by;
        }
        return false;
    }

    public function create(User $user, Product $product = null)
    {
        return $user->can('Create products');
    }

    public function update(User $user, Product $product)
    {
        if ($user->can('Edit all products')) {
            return true;
        }
        if ($user->can('Edit products')) {
            return $user->id === $product->user->created_by;
        }
        return false;
    }

    public function delete(User $user, Product $product)
    {
        if ($product->invoices->count() > 0) {
            return false;
        }
        if ($user->can('Delete all products')) {
            return true;
        }
        if ($user->can('Delete products')) {
            return $user->id === $product->user->created_by;
        }
        return false;
    }

    public function export(User $user, Product $product = null)
    {
        return $user->can('Export all products');
    }

    public function import(User $user, Product $product = null)
    {
        return $user->can('Import all products');
    }
}
