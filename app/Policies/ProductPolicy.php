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
        return $user->can('products.list.all');
    }

    public function viewAssociated(User $user, Product $invoice = null)
    {
        return $user->can('products.list.associated');
    }

    public function viewAny(User $user, Product $product = null)
    {
        return $user->can('products.list.all') || $user->can('products.list.associated');
    }

    public function view(User $user, Product $product)
    {
        if ($user->can('products.list.all')) {
            return true;
        }
        if ($user->can('products.list.associated')) {
            return $user->id === $product->created_by;
        }
        return false;
    }

    public function create(User $user, Product $product = null)
    {
        return $user->can('products.create');
    }

    public function update(User $user, Product $product)
    {
        if ($user->can('products.edit.all')) {
            return true;
        }
        if ($user->can('products.edit.associated')) {
            return $user->id === $product->user->created_by;
        }
        return false;
    }

    public function delete(User $user, Product $product)
    {
        if ($product->invoices->count() > 0) {
            return false;
        }
        if ($user->can('products.delete.all')) {
            return true;
        }
        if ($user->can('products.delete.associated')) {
            return $user->id === $product->user->created_by;
        }
        return false;
    }

    public function export(User $user, Product $product = null)
    {
        return $user->can('products.export.all');
    }

    public function import(User $user, Product $product = null)
    {
        return $user->can('products.import.all');
    }
}
