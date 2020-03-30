<?php

namespace App\Observers;

use App\Entities\User;
use App\Entities\Product;

class ProductsObserver
{
    public function creating(Product $product)
    {
        if (! $product->created_by) {
            $product->created_by = auth()->user()->id;
        }
        $product->updated_by = $product->created_by;
        $product->price = $product->cost * 1.10;
    }

    public function updating(Product $product)
    {
        $product->updated_by = auth()->user()->id;
        $product->price = $product->cost * 1.10;
    }
}
